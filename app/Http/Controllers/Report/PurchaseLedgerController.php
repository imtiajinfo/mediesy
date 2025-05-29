<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\PurchaseOrders;
use App\Models\PurchaseOrdersChild;
use App\Models\ItemInfo;
use DB;

class PurchaseLedgerController extends Controller
{
    public function index(Request $request){

        $data['from_date'] = $from_date = strtotime($request['from_date']);
        $data['to_date'] = $to_date = strtotime($request['to_date']);
        $data['categoryId'] = $request->categoryId;
        $data['categories'] = Category::all();
        $data['salesLedger'] = [];

        if (!empty($from_date) && !empty($to_date) && $from_date > $to_date) {
            return redirect()->back()->withErrors(['error' => 'Invalid Date!']);
        }

        if ( !empty($from_date) && !empty($to_date) ) {

            $data['salesLedger'] = PurchaseOrders::join('purchase_orders_children', 'purchase_orders_children.po_id', '=', 'purchase_orders.id')
                ->join('item_infos', 'item_infos.id', 'purchase_orders_children.product_id')
                ->whereDate('purchase_orders.po_date', '>=', date("Y-m-d H:i:s", $from_date))
                ->whereDate('purchase_orders.po_date', '<=', date("Y-m-d H:i:s", $to_date))
                ->where(function($q) use($request){
                    if($request->categoryId && $request->categoryId != 'all'){
                        $q->where('item_infos.category_id', $request->categoryId);
                    }
                })
                ->groupBy('purchase_orders_children.product_id', 'item_infos.name')
                ->select(
                    'purchase_orders_children.product_id', 
                    'item_infos.name',
                    DB::raw('SUM(purchase_orders_children.total_amount) as sub_total'),
                    DB::raw('SUM(purchase_orders_children.purchase_qty) as quantity'),
                    DB::raw('SUM(purchase_orders_children.return_qty) as return_qty'),
                    DB::raw('SUM(purchase_orders_children.return_qty*purchase_orders_children.purchase_price) as return_amount'),
                )
                ->get();
    
            // dd($data['salesLedger']);
        }

        return view('admin.reports.purchase.ledger', $data);
    }
}
