<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
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
            $query = Expense::query()->select(
                ['id', 'name', 'name_bangla', 'descriptions', 'status']
            )
                ->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }

            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new Expense())->getFillable(); // Fetch all fillable columns
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $query = $query->paginate($perPage);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
        return view('admin.expenses.index', with(['query' => $query,]));
    }


    public function create()
    {
        $query = "";
        return view('admin.expenses.create', compact('query'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Generate slug from the Expense name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;
        $requestData['name_bangla'] = "N/A";
        $requestData['descriptions'] = "N/A";
        $requestData['status'] = true;

        // Create the customer record
        Expense::create($requestData);

        // Flash success message and redirect
        session()->flash('success', 'Expense added successfully.');
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Inserted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $query = $expense;
        return view('admin.expenses.view', compact('query'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $query = $expense;
        return view('admin.expenses.edit', compact('query'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->all());
        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
