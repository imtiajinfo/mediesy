<?php

namespace App\Http\Controllers\Admin;

use Log;
use Illuminate\Support\Str;
use App\Models\MoneyLending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMoneyLendingRequest;
use App\Http\Requests\UpdateMoneyLendingRequest;

class MoneyLendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $status = $request->input('status');

            // Define the fields you want to select
            $fields = [
                'id',
                'name',
                'name_bangla',
                'email',
                'phone',
                'nid',
                'country',
                'division',
                'district',
                'city',
                'Area',
                'postcode',
                'parent_address',
                'permanent_address',
                'from_date',
                'to_date',
                'to_amount',
                'recv_amount',
                'due_amount',
                'monthly_profit',
                'is_closed',
            ];

            $query = MoneyLending::query()->select($fields)->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('is_closed', $status === 'active' ? 1 : 0);
            }

            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new MoneyLending())->getFillable(); // Fetch all fillable columns
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


        return view('admin.money-lending.index', with(['moneyLendings' => $query,]));
    }


    public function create()
    {
        return view('admin.money-lending.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreMoneyLendingRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the money-lending record
            MoneyLending::create($request->validated());

            // Commit the transaction
            DB::commit();

            // Flash success message and redirect
            return redirect()->route('admin.money-lending.index')->with('success', 'Money lending added successfully.');
        } catch (\Exception $error) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            \Log::error($error);

            // Flash error message with details and redirect
            return redirect()->route('admin.money-lending.index')->with('error', 'An error occurred while adding money lending. Details: ' . $error->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(MoneyLending $moneyLending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MoneyLending $moneyLending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMoneyLendingRequest $request, MoneyLending $moneyLending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MoneyLending $moneyLending)
    {
        $moneyLending->delete();
        return redirect()->route('admin.money-lending.index')->with('success', 'money-lendings deleted successfully.');
    }
}
