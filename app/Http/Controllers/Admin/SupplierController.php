<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
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
            $query = supplier::query()->select(
                'id',
                'slug',
                'name',
                'email',
                'phone',
                'company_name',
                'company_tin_number',
                'supplier_destination',
                'brand'
            )
                // ->whereIn('status', [0, 1])
                ->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('company_name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
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
        return view('admin.suppliers.index', with(['suppliers' => $query,'search'=>$search]));
    }


    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreSupplierRequest $request)
    {
        // Generate slug from the supplier's name
        $supplier = Supplier::where('email', $request->email)->first();

        // if($supplier){
        //     return redirect()->back()->with('error', 'Already Added this mail.');
        // }
        $slug = Str::slug($request->input('company_name'));
        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        // dd($requestData);


        // Create the supplier record
        $supplier = Supplier::create($requestData);
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'success',
                'suppliers' => $supplier,
            ]);

        }
        session()->flash('success', 'supplier added successfully.');
        return redirect()->route('admin.suppliers.index')->with('success', 'supplier added successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $slug = Str::slug($request->input('company_name'));
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        $supplier = Supplier::findOrFail($id)->update($requestData);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'success',
                'suppliers' => $supplier,
            ]);
        }
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Product deleted successfully.');
    }
}
