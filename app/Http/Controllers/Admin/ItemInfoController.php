<?php

namespace App\Http\Controllers\Admin;

use item;
use Carbon\Carbon;
use App\Models\Uom;
use App\Models\Size;
use App\Models\User;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Store;
use App\Models\Uomset;
use App\Models\Category;
use App\Models\ItemInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreItemInfoRequest;
use App\Http\Requests\UpdateItemInfoRequest;

class ItemInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        // try {
        // $items = ItemInfo::query();
        // $items = storItem($items); 


        $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
        $search = $request->input('search');
        $status = $request->input('status');
        $query = ItemInfo::query()->with(['category', 'sales_uom', 'brands'])
            ->whereIn('item_infos.status', [0, 1])
            ->latest('item_infos.id');
        // Apply status filter
        if ($status) {
            $query->where('status' === $status);
        }
        // Apply search filter 
        if ($search) {
            $query->where(function ($query) use ($search) {
                // $fillableColumns = (new ItemInfo())->getFillable(); // Fetch all fillable columns
                // $fillableColumns = array_diff($fillableColumns, ['name', 'sub_title']);
                // foreach ($fillableColumns as $column) {
                //     $query->orWhere($column, 'like', '%' . $search . '%');
                // }
                $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('sub_title', 'like', '%' . $search . '%');
            });
        }


        $query = $query->paginate($perPage);

        return view('admin.item.index', with(['products' => $query,'search'=>$search]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        $uoms = Uom::get();
        return view('admin.item.create', compact('brands','categories', 'uoms', ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemInfoRequest $request)
    {
        DB::beginTransaction();

        try {

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $thumbnail_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $thumbnail->getClientOriginalExtension();
                // if (!file_exists('uploads/products')) {
                //     mkdir('uploads/products', 077, true);
                // }
                if (!File::exists(public_path('uploads/products'))) {
                    File::makeDirectory(public_path('uploads/products'), 0777, true, true);
                }
                $thumbnail->move('uploads/products', $thumbnail_name);
                // $thumbnail = $thumbnail->store('public/uploads/products');
            } else {
                $thumbnail_name = 'default.png';
            }

            $attachmentNames = [];

            // Handle attachment uploads
            if ($request->hasFile('attachment')) {
                // Get the array of uploaded files
                $attachments = $request->file('attachment');

                foreach ($attachments as $attachment) {
                    // Generate unique filename for each attachment
                    $slug = Str::slug($request->name);
                    $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                    $attachmentName = $slug . '-' . $currentDate . rand(100, 999) . '.' . $attachment->getClientOriginalExtension();

                    // Ensure the directory exists
                    if (!File::exists(public_path('uploads/attachments'))) {
                        File::makeDirectory(public_path('uploads/attachments'), 0777, true, true);
                    }

                    // Move the uploaded file to the destination directory
                    $attachment->move(public_path('uploads/attachments'), $attachmentName);

                    // Store the filename in the array
                    $attachmentNames[] = $attachmentName;
                }
            }

            // Convert the array of attachment filenames to JSON
            $attachmentJson = json_encode($attachmentNames);

            // Set default value for attachment if no files uploaded
            if (empty($attachmentNames)) {
                $attachmentJson = json_encode(['default.png']);
            }

            $validatedData = $request->all();
            $colorIds = $request->input('color_id', 0);


            $itemInfo = ItemInfo::create($validatedData);
            $itemInfo->color_id = $colorIds;
            $slug = Str::slug($itemInfo->name);
            $uniqueSlug = $this->makeUniqueSlug($slug);
            $itemInfo->slug = $uniqueSlug;
            $itemInfo->thumbnail = $thumbnail_name;

            $itemInfo->attachment = $attachmentJson;

            $itemInfo->min_qty = isset($itemInfo->min_qty) ? $itemInfo->min_qty : 1;
            $itemInfo->current_stock = 0;
            $itemInfo->stock_status = 0;
            $itemInfo->trans_uom = $request->unit;
            $itemInfo->approved_status = true;
            $itemInfo->status = true;

            // Generate 'code' based on item ID and a random 5-digit number
            $code = isset($itemInfo->id) ? $itemInfo->id : 'unknown_id';
            $itemInfo->code = $code . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $itemInfo->save();

            DB::commit();
            return redirect()->back()->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            // Handle exceptions, rollback the transaction, and return an error response
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating Product: ' . $e->getMessage());
        }
    }


    private function makeUniqueSlug($originalSlug)
    {
        $count = 1;
        $slug = $originalSlug;

        // Keep incrementing the count until a unique slug is found
        while (ItemInfo::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {

        $itemInfo = ItemInfo::with(['category', 'sizes', 'colors', 'brands'])
            ->where('id', $id)->first();
        // dd($itemInfo);
        return view('admin.item.show', with(['itemInfo' => $itemInfo]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        $uoms = Uom::get();
        $itemInfo = ItemInfo::where('id', $id)->first();

        return view('admin.item.edit', with(['itemInfo' => $itemInfo, 'brands' => $brands, 'categories' => $categories, 'uoms' => $uoms]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $itemInfo = ItemInfo::findOrFail($id);
            $itemInfo->update($request->all());
            if ($request->hasFile('thumbnail')) {
                $thumbnail_name = $this->uploadThumbnail($request);
                $itemInfo->thumbnail = $thumbnail_name;
            }            
            $itemInfo->min_qty = $itemInfo->min_qty ?? 1;
            $slug = Str::slug($itemInfo->name);
            $itemInfo->slug = $this->makeUniqueSlug($slug);
            $itemInfo->code = $this->generateItemCode($itemInfo->id);

            $itemInfo->save();

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating Product: ' . $e->getMessage());
        }
    }

    private function uploadThumbnail($request)
    {
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $slug = Str::slug($request->name);
            $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
            $thumbnail_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $thumbnail->getClientOriginalExtension();

            if (!File::exists(public_path('uploads/products'))) {
                File::makeDirectory(public_path('uploads/products'), 0777, true, true);
            }
            $thumbnail->move('uploads/products', $thumbnail_name);
        } else {
            $thumbnail_name = 'default.png';
        }

        return $thumbnail_name;
    }

    private function uploadAttachments($request)
    {
        $attachmentNames = [];

        if ($request->hasFile('attachment')) {
            $attachments = $request->file('attachment');

            foreach ($attachments as $attachment) {
                $slug = Str::slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $attachmentName = $slug . '-' . $currentDate . rand(100, 999) . '.' . $attachment->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/attachments'))) {
                    File::makeDirectory(public_path('uploads/attachments'), 0777, true, true);
                }

                $attachment->move(public_path('uploads/attachments'), $attachmentName);

                $attachmentNames[] = $attachmentName;
            }
        }

        return empty($attachmentNames) ? json_encode(['default.png']) : json_encode($attachmentNames);
    }

    private function generateItemCode($itemId)
    {
        return $itemId ? $itemId . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT) : 'unknown_id';
    }










    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ItemInfo::findOrFail($id);
        ItemInfo::find($id)->delete();

        return redirect()->back()->with('success', 'Product Deleted successfully');
    }

    public function loadProduct()
    {
        $items = ItemInfo::latest()->paginate(10);

        // if ($request->expectsJson()) {
        return response()->json([
            'message' => 'success',
            'items' => $items,
        ]);
    }

    public function getProduct($productId)
    {
        $itemInfo = ItemInfo::where('id', $productId)->first();

        return response()->json([
            'message' => 'success',
            'items' => $itemInfo,
        ]);
    }


    public function findSetPrice(Request $request)
    {
        $itemInfo = ItemInfo::where('id', $request->id)->first();

        return view('admin.item.setPrice', with(['itemInfo' => $itemInfo]));
    }



    public function setPrice(Request $request)
    {
        // DB::beginTransaction();

        // try {

        // dd($request->all());

        // "weight" => "69"
        // "published_price" => "139"
        // "purchase_price" => "689"
        // "discount_type" => "Maiores quis ut qui"
        // "discount_amount" => "86"
        // "sell_price" => "325"

        $itemInfo = ItemInfo::where('id', $request->id)->first();


        $itemInfo->update($request->all());

        $itemInfo->published_price = $request->published_price;
        $itemInfo->min_qty = $itemInfo->min_qty ?? 1;
        $itemInfo->current_stock = 0;
        $itemInfo->stock_status = 0;
        $itemInfo->approved_status = true;
        $itemInfo->status = true;


        $itemInfo->save();

        // DB::commit();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
        // } catch (\Exception $e) {

        //     DB::rollBack();
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('error', 'Error updating ItemInfo: ' . $e->getMessage());
        // }
    }

    public function product_api(Request $request){
        $search = $request->input('search');
        $products = ItemInfo::where('name', 'LIKE', '%' . $search . '%')->limit(200)->get();

        return response()->json($products);
    }
}
