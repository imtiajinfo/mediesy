<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\DailyExpenses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDailyExpensesRequest;
use App\Http\Requests\UpdateDailyExpensesRequest;

class DailyExpensesController extends Controller
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
            $query = DailyExpenses::with('expenses', 'store')->select(
                'daily_expenses.id',
                'daily_expenses.expense_name',
                'expenses.name as expensesName',
                'daily_expenses.company',
                'daily_expenses.store',
                'daily_expenses.expense_date',
                'daily_expenses.approved_status',
                'daily_expenses.amount'
            )
                ->leftJoin('expenses', 'daily_expenses.expense_group', 'expenses.id')
                ->latest('daily_expenses.id');

            // $query = storeDailyExpense($query);

            // Apply status filter
            if ($status !== null) {
                $query->where('approved_status', $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new DailyExpenses())->getFillable(); // Fetch all fillable columns
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $expenses = $query->paginate($perPage);
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
        return view('admin.daily-expenses.index', compact('expenses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenses = Expense::all();
        $stores = Store::all();
        return view('admin.daily-expenses.create', compact('expenses', 'stores'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDailyExpensesRequest $request)
    {
        $request->validate([
            // Add your validation rules here
        ]);
        $data = $request->all();
        $data['company'] = 'na';
        $data['store'] = 1;
        $data['approved_status'] = 1;

        DailyExpenses::create($data);

        return redirect()->route('admin.daily-expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyExpenses $dailyExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = DailyExpenses::find($id);
        $expenses = Expense::all();
        return view('admin.daily-expenses.edit', compact('expenses', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        DailyExpenses::find($id)->update($data);

        return redirect()->route('admin.daily-expenses.index')
            ->with('success', 'Expense Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // try {
        //     DB::beginTransaction();

        // Log the ID before deletion

        DailyExpenses::find($id)->delete();


        return redirect()->route('admin.daily-expenses.index')->with('success', 'Expense deleted successfully.');
        // } catch (\Exception $error) {
        //     DB::rollBack();

        //     // Log the error
        //     Log::error("Error deleting expense ID: {$request->id}. Error message: {$error->getMessage()}");

        //     return redirect()->route('admin.daily-expenses.index')->with('error', 'An error occurred while deleting the expense.');
        // }
    }
}
