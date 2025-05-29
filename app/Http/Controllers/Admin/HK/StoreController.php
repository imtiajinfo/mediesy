<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Area;
use App\Models\Store;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;

class StoreController extends Controller
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
            $query = Store::leftJoin('countries', 'stores.country', '=', 'countries.id')
                ->leftJoin('districts', 'stores.district', '=', 'districts.id')
                ->leftJoin('upazilas', 'stores.upazila', '=', 'upazilas.id')
                ->select(
                    'stores.id',
                    'stores.slug',
                    'stores.name as store_name',
                    'stores.email',
                    'stores.phone',
                    // 'countries.name as country',
                    // 'districts.name as district',
                    // 'upazilas.name as upazila',
                    'stores.postcode',
                    'stores.address',
                    'stores.status'
                )
                ->offset(0)
                ->whereIn('status', [0, 1])
                ->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new Store())->getFillable(); // Fetch all fillable columns
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
        return view('admin.stores.index', with(['stores' => $query,]));
    }


    public function create()
    {
        $countries = Country::with('districts', 'upazilas')->get();
        $districts = District::get();
        return view('admin.stores.create', with(['countries' => $countries, 'districts', $districts]));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        // Generate slug from the store's name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        // Create the store record
        Store::create($requestData);

        // Flash success message and redirect
        session()->flash('success', 'store added successfully.');
        return redirect()->route('admin.stores.index')->with('success', 'Inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        $storeData = Store::select([
            'stores.*',
            // 'countries.name as country_name',
            // 'countries.id as country_id',
            // 'districts.name as district_name',
            // 'districts.id as district_id',
            // 'upazilas.name as upazila_name',
            // 'upazilas.id as upazila_id',
        ])
            // ->leftJoin('countries', 'stores.country', 'countries.id')
            // ->leftJoin('districts', 'stores.district', 'districts.id')
            // ->leftJoin('upazilas', 'stores.upazila', 'upazilas.id')
            ->where('stores.id', $store->id)
            ->first();

        if (!$storeData) {
            return redirect()->route('admin.stores.index', with('Data not found'));
        }

        return view('admin.stores.show', compact('storeData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        $countries = Country::with('districts', 'upazilas')->get();
        $districts = District::get();
        $upazilas = Upazila::get();

        $storeData = Store::select([
            'stores.*',
            // 'countries.name as country_name',
            // 'countries.id as country_id',
            // 'districts.name as district_name',
            // 'districts.id as district_id',
            // 'upazilas.name as upazila_name',
            // 'upazilas.id as upazila_id',
        ])
            // ->leftJoin('countries', 'stores.country', 'countries.id')
            // ->leftJoin('districts', 'stores.district', 'districts.id')
            // ->leftJoin('upazilas', 'stores.upazila', 'upazilas.id')
            ->where('stores.id', $store->id)
            ->first();

        if (!$storeData) {
            return redirect()->route('admin.stores.index', with('Data not found'));
        }

        return view('admin.stores.edit', compact('countries', 'districts', 'storeData', 'upazilas'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->validated());
        return redirect()->route('admin.stores.index')->with('success', 'store updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'store deleted successfully.');
    }
}
