<?php

namespace App\Http\Controllers\Admin;

use App\Models\ItemInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class itemStoreController extends Controller
{


    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $status = $request->input('status');
            $query = ItemInfo::query()->with(['category', 'sales_uom', 'colors', 'brands'])
                ->whereIn('item_infos.status', [0, 1])
                ->latest('item_infos.id')
                ->select(['item_infos.*', 'stores.name as storeName']);
            $query = storItem($query);

            // dd($query);

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter 
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $fillableColumns = (new ItemInfo())->getFillable(); // Fetch all fillable columns
                    $fillableColumns = array_diff($fillableColumns, ['published', 'request_status', 'approved']); // Exclude 'published' column
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }


            $query = $query->paginate($perPage);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
        return view('admin.item-store.index', with(['products' => $query,]));
    }



    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {

        $itemInfo = ItemInfo::with(['category', 'sizes', 'colors', 'brands'])
            ->where('id', $id)->first();
        // dd($itemInfo);
        return view('admin.item-store.show', with(['itemInfo' => $itemInfo]));
    }
}
