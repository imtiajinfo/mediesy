<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\ItemInfo;
use App\Models\Sell;
use App\Models\PurchaseOrders;
use App\Models\DailyExpenses;

use Carbon\Carbon;

class AdminController extends Controller
{

    public function dashboard()
    {
        // Determine the user's role and redirect accordingly
        if (auth()->user()->role === 'admin') {
            return view('admin.home'); // View for admin dashboard
        } elseif (auth()->user()->role === 'manager') {
            return view('admin.home'); // View for manager dashboard
        } elseif (auth()->user()->role === 'employee') {
            return view('admin.home'); // View for employee dashboard
        }
        return redirect()->route('admin.home'); // Redirect to home or login page if the role is not recognized
    }



    public function index()
    {
        $data['total_customer'] = Customer::count();
        $data['total_supplier'] = Supplier::count();
        $data['total_product'] = ItemInfo::count();
        $today = Carbon::today();
        $data['sell_count'] = Sell::whereDate('created_at', $today)->count();

        $start = date('Y-m-d h:i:s', strtotime('-31 days'));
        $end = date('Y-m-d h:i:s', strtotime('+1 days'));

        $data['last_month_total_sell'] = Sell::whereBetween('created_at', [$start, $end])->sum('grand_total');
        $data['last_month_total_purchase'] = PurchaseOrders::whereBetween('created_at', [$start, $end])->sum('total_purchase_amount');
        $data['last_month_total_due'] = Sell::sum('due');
        $data['last_month_total_expense'] = DailyExpenses::whereBetween('created_at', [$start, $end])->sum('amount');


        return view('admin.home', $data);
    }
}
