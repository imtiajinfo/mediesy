<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Store;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use App\Models\ItemStoreMapping;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemStoreMappingRequest;
use App\Http\Requests\UpdateItemStoreMappingRequest;

class ItemStoreMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $store_id = $request->input('store_id');
            $item_id = $request->input('item_id');
            $search = $request->input('search');

            $filters = $request->only(['search', 'store_id', 'item_id', 'per_page']);

            $query = ItemStoreMapping::leftJoin('stores', 'item_store_mappings.store_id', 'stores.id')
                ->leftJoin('item_infos', 'item_store_mappings.item_id', 'item_infos.id')
                ->select([
                    'item_store_mappings.id',
                    'item_store_mappings.item_id',
                    'stores.name as store_name',
                    'item_infos.name as item_name',
                    'stores.name as store_name',
                    'item_store_mappings.descriptions',
                    'item_store_mappings.status'
                ])
                ->orderBy('item_store_mappings.id', 'desc')
                ->filter($filters);

            // if ($search) {
            //     $query->where(function ($q) use ($filters) {
            //         $q->whereIn('item_store_mappings.store_id', $filters['search'])
            //             ->orWhereIn('item_store_mappings.item_id', $filters['search']);
            //     });
            // }

            if ($search) {
                $searchArray = is_array($filters['search']) ? $filters['search'] : [$filters['search']];
                $query->where(function ($q) use ($searchArray) {
                    $q->whereIn('stores.name', $searchArray)
                        ->orWhereIn('item_infos.name', $searchArray);
                });
            }


            // if ($store_id) {
            //     $query->whereIn('item_store_mappings.store_id', [$store_id]);
            // }

            // if ($item_id) {
            //     $query->where('item_store_mappings.item_id', $item_id);
            // }


            // if ($search) {
            //     $query->whereIn('store_id', $filters)
            //         ->orWhereIn('item_id', $filters);
            // }

            if ($store_id) {
                $query->whereIn('store_id', [$store_id]);
            }

            if ($item_id) {
                $query->where('item_id', $item_id);
            }

            $data = $query->paginate($perPage);

            return view('admin.itemstore.index', [
                'itemstore' => $data,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Output the error message for debugging
        }
    }

    public function create()
    {
        $itemstore = Store::all();
        $items = ItemInfo::all();
        return view('admin.itemstore.create', compact('itemstore', 'items'));
    }


    public function store(StoreItemStoreMappingRequest $request)
    {
        DB::beginTransaction();
        try {

            $validatedData = $request->validated();

            $store_id = $validatedData['store_id'];
            $item_ids = $validatedData['item_id'];
            $descriptions = $validatedData['descriptions'] ?? null; // Use null if "descriptions" is not provided

            // Check uniqueness for each item_id
            foreach ($item_ids as $item_id) {
                $uniqueCheck = ItemStoreMapping::where('item_id', $item_id)
                    ->where('store_id', $store_id)
                    ->exists();

                if ($uniqueCheck) {
                    DB::rollBack();
                    session()->flash('error', 'Item Store Mapping already exists.');
                    return redirect()->back()->withInput();
                }
            }

            // Iterate through the selected item_ids and insert rows into the database
            foreach ($item_ids as $item_id) {
                ItemStoreMapping::create([
                    'store_id' => $store_id,
                    'item_id' => $item_id,
                    'descriptions' => $descriptions,
                    'status' => true,
                ]);
            }

            // Attach selected items to the mapping using sync
            // $itemStoreMapping->items()->sync($validatedData['item_id']);
            // Commit the transaction
            DB::commit();

            session()->flash('success', 'Item Store Mapping added successfully.');
            return redirect()->route('admin.itemsStoreMapping.index')->with('success', 'Inserted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating ItemStore', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemStoreMapping $itemStoreMapping)
    {
        $itemStoreMapping = $itemStoreMapping;
        return view('admin.itemstore.show', compact('itemStoreMapping'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemStoreMapping $itemsStoreMapping)
    {
        $itemstore = Store::all();
        $items = ItemInfo::all();
        $itemsStoreMapping = $itemsStoreMapping;
        // dd($itemStoreMapping);
        return view('admin.itemstore.edit', with(['itemstore' => $itemstore, 'items' => $items, 'itemsStoreMapping' => $itemsStoreMapping]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemStoreMappingRequest $request, ItemStoreMapping $itemsStoreMapping)
    {
        $itemsStoreMapping->update($request->validated());

        return redirect()->route('admin.itemsStoreMapping.index')->with('success', 'store updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemStoreMapping $itemsStoreMapping)
    {
        $itemsStoreMapping->delete();
        return redirect()->route('admin.itemsStoreMapping.index')->with('success', 'store deleted successfully.');
    }
}
