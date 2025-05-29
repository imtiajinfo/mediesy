<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ItemStockMaster;
use App\Models\ItemStockChild;
use App\Models\ItemInfo;
use DB;

class StockLedgerController extends Controller
{
    public function index(Request $request){

        $data['from_date'] = $from_date = strtotime($request['from_date']);
        $data['to_date'] = $to_date = strtotime($request['to_date']);
        $data['categoryId'] = $request->categoryId;
        $data['categories'] = Category::all();
        $data['stockLedger'] = [];

        if (!empty($from_date) && !empty($to_date) && $from_date > $to_date) {
            return redirect()->back()->withErrors(['error' => 'Invalid Date!']);
        }

        if ( !empty($from_date) && !empty($to_date) ) {

            $data['stockLedger'] = ItemStockMaster::join('item_stock_children', 'item_stock_children.itemstock_master_id', '=', 'item_stock_masters.id')
                ->join('item_infos', 'item_infos.id', 'item_stock_children.product_id')
                ->whereDate('item_stock_masters.challan_date', '>=', date("Y-m-d H:i:s", $from_date))
                ->whereDate('item_stock_masters.challan_date', '<=', date("Y-m-d H:i:s", $to_date))
                ->where(function($q) use($request){
                    if($request->categoryId && $request->categoryId != 'all'){
                        $q->where('item_infos.category_id', $request->categoryId);
                    }
                })
                ->groupBy('item_stock_children.product_id', 'item_infos.name')
                ->select(
                    'item_stock_children.product_id', 
                    'item_infos.name',
                    DB::raw('SUM(CASE WHEN item_stock_masters.status=1 THEN item_stock_children.stock_in ELSE 0 END) as stock_in'),
                    DB::raw('(SUM(item_stock_children.stock_in) - SUM(item_stock_children.stock_out)) as current_stock'),
                    DB::raw('SUM(CASE WHEN item_stock_masters.status=1 THEN item_stock_children.receive_amount ELSE 0 END) as purchase_amount'),
                    DB::raw('((SUM(CASE WHEN item_stock_masters.status=2 THEN item_stock_children.stock_out END)) - (SUM(CASE WHEN item_stock_masters.status=4 THEN item_stock_children.stock_in END))) as stock_out'),
                    DB::raw('((SUM(CASE WHEN item_stock_masters.status=2 THEN item_stock_children.receive_amount END)) - (SUM(CASE WHEN item_stock_masters.status=4 THEN item_stock_children.receive_amount END))) as sell_amount'),
                )
                ->get();
    
            // dd($data['salesLedger']);
        }

        return view('admin.reports.stockLedger.index', $data);
    }
}
