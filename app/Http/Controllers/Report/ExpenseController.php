<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\DailyExpenses;

class ExpenseController extends Controller
{
    public function index(Request $request){

        $data['from_date'] = $from_date = strtotime($request['from_date']);
        $data['to_date'] = $to_date = strtotime($request['to_date']);
        $data['categoryId'] = $request->categoryId;
        $data['categories'] = Expense::all();
        $data['salesLedger'] = [];

        if (!empty($from_date) && !empty($to_date) && $from_date > $to_date) {
            return redirect()->back()->withErrors(['error' => 'Invalid Date!']);
        }

        if ( !empty($from_date) && !empty($to_date) ) {

            $data['salesLedger'] = DailyExpenses::join('expenses', 'expenses.id', '=', 'daily_expenses.expense_group')
                ->whereDate('daily_expenses.expense_date', '>=', date("Y-m-d H:i:s", $from_date))
                ->whereDate('daily_expenses.expense_date', '<=', date("Y-m-d H:i:s", $to_date))
                ->where(function($q) use($request){
                    if($request->categoryId && $request->categoryId != 'all'){
                        $q->where('daily_expenses.expense_group', $request->categoryId);
                    }
                })
                ->select(
                    'daily_expenses.*',
                    'expenses.name as categoryName',
                )
                ->get();
    
            // dd($data['salesLedger']);
        }

        return view('admin.reports.expense.index', $data);
    }
}
