<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Sell;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\ItemInfo;
use App\Models\Warranty;
use App\Models\SellsItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreWarrantyRequest;
use App\Http\Requests\UpdateWarrantyRequest;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            $search = $request->input('search');
            $status = $request->input('status'); // 'active', 'inactive', or null
            $query = Warranty::with('items')->select(
                'id',
                'store_id',
                'customer_id',
                'sells_id',
                'item_id',
                'type',
                'duration',
                'start_date',
                'end_date',
                'notes',
                'status'
            )
                // ->whereIn('status', [0, 1])
                ->latest('id');


            $query = storeWarranty($query);


            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new Warranty())->getFillable(); // Fetch all fillable columns
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $query = $query->paginate($perPage);
            // return ($query);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
        return view('admin.warranty.index', with(['warrantys' => $query,]));
    }


    public function create()
    {
        $stores = Store::all();
        $customers = Customer::all();
        $sells = Sell::all();
        $query = SellsItem::latest('id');

        $sells_items = storeSells($query);

        return view('admin.warranty.create', compact('stores', 'customers', 'sells', 'sells_items'));
    }

    public function getItems($sellsId)
    {
        $sellsItems = SellsItem::where('sell_id', $sellsId)
            ->leftJoin('item_infos', 'sells_items.product_id', 'item_infos.id')
            ->select([
                'item_infos.name as item_name',
                'item_infos.id as item_id',
                'sells_items.id as sells_id'
            ])
            ->get();

        return response()->json($sellsItems);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreWarrantyRequest $request)
    {
        // Generate slug from the warranty's name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        // Create the warranty record
        Warranty::create($requestData);

        // Flash success message and redirect
        session()->flash('success', 'warranty added successfully.');
        return redirect()->route('admin.warrantys.index')->with('success', 'Inserted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        $warranty = $warranty;
        $stores = Store::all();
        $customers = Customer::all();
        $sells = Sell::all();

        return view('admin.warranty.show', compact('warranty', 'stores', 'customers', 'sells',));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warranty $warranty)
    {
        $warranty = $warranty;
        $stores = Store::all();
        $customers = Customer::all();
        $sells = Sell::all();
        $sells_items = SellsItem::all();

        return view('admin.warranty.edit', compact('warranty', 'stores', 'customers', 'sells', 'sells_items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarrantyRequest $request, Warranty $warranty)
    {
        $warranty->update($request->validated());
        return redirect()->route('admin.warrantys.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        $warranty->delete();
        return redirect()->route('admin.warrantys.index')->with('success', 'Product deleted successfully.');
    }

    public function GennneratePdf(Warranty $warranty)
    {
        $Warrantydata = Warranty::where('id', $warranty->id)->get();
        // dd($Warrantydata);


        $filename =   $warranty->id . $warranty->item?->name . '.pdf';
        $pdf = PDF::loadView('admin.reports.warrantys.card-pdf', [
            'data' => $warranty,
        ], [], [
            'mode' => '',
            'format' => 'A4-P',
            'default_font_size' => '12',
            'default_font' => 'SutonnyMJRegular',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 2,
            'margin_footer' => 2,
            'orientation' => 'L',
            'title' => 'Laravel mPDF',
            'author' => '',
            'watermark' => 'RIYAT AUTOMOBILES',
            'show_watermark' => true,
            'watermark_font' => 'SutonnyMJRegular',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'custom_font_dir' => '',
            'custom_font_data' => [],
            'auto_language_detection' => false,
            'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            'pdfa' => false,
            'pdfaauto' => false,
            'debug' => true,
        ]);

        return $pdf->stream($filename . '.pdf');
        // } catch (\Exception $e) {
        //     // Handle general exceptions here
        //     dd($e->getMessage());
        //     Log::error('Exception in transaction generation process: ' . $e->getMessage());
        //     abort(500, 'Internal Server Error');
        // }
    }
}
