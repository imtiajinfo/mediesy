<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
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
            $query = Customer::query()->select(
                'id',
                'slug',
                'name',
                'email',
                'phone',
                'email_verified_at',
                'password',
                'password_confirmation',
                'gst_number',
                'tax_number',
                'country',
                'state',
                'city',
                'postcode',
                'address',
                'previous_due'
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
        return view('admin.customer.index', with(['customers' => $query,'search'=>$search]));
    }


    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreCustomerRequest $request)
    {
        // Generate slug from the customer's name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        // Create the customer record
        $customer = Customer::create($requestData);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'success',
                'customers' => $customer,
            ]);

            // return redirect()->back()->with('success', 'Created successfully.');
        }

        // Flash success message and redirect
        session()->flash('success', 'Customer added successfully.');
        return redirect()->route('admin.customers.index')->with('success', 'Inserted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer = $customer;
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('admin.customers.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Product deleted successfully.');
    }
}
