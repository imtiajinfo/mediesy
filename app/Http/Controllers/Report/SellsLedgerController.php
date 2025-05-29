<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sell;
use App\Models\SellsItem;
use App\Models\ItemInfo;
use DB;

class SellsLedgerController extends Controller
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

        // $data['salesLedger'] = Sell::whereBetween('created_at', [
        //         date("Y-m-d H:i:s", $from_date), 
        //         date("Y-m-d H:i:s", $to_date)
        //     ])
        //     ->with(['sellsItems' => function($query) {
        //         $query->select('sell_id', 'product_id', DB::raw('SUM(sub_total) as sub_total'))
        //             ->groupBy('product_id', 'sell_id');
        //     }, 'sellsItems.itemInfo'])
        //     ->get()
        //     ->flatMap(function($sell) {
        //         return $sell->sellsItems->map(function($sellsItem) {
        //             return [
        //                 'product_id' => $sellsItem->product_id,
        //                 'name' => $sellsItem->itemInfo->name,
        //                 'sub_total' => $sellsItem->sub_total,
        //             ];
        //         });
        //     })
        //     ->groupBy('product_id')
        //     ->map(function($items) {
        //         return [
        //             'product_id' => $items->first()['product_id'],
        //             'name' => $items->first()['name'],
        //             'sub_total' => $items->sum('sub_total')
        //         ];
        //     })
        //     ->values();
        if ( !empty($from_date) && !empty($to_date) ) {

            $data['salesLedger'] = Sell::join('sells_items', 'sells_items.sell_id', '=', 'sells.id')
                ->join('item_infos', 'item_infos.id', 'sells_items.product_id')
                ->whereDate('sells.sell_date', '>=', date("Y-m-d H:i:s", $from_date))
                ->whereDate('sells.sell_date', '<=', date("Y-m-d H:i:s", $to_date))
                ->where(function($q) use($request){
                    if($request->categoryId && $request->categoryId != 'all'){
                        $q->where('item_infos.category_id', $request->categoryId);
                    }
                })
                ->groupBy('sells_items.product_id', 'item_infos.name')
                ->select(
                    'sells_items.product_id', 
                    'item_infos.name',
                    DB::raw('SUM(sells_items.sub_total) as sub_total'),
                    DB::raw('SUM(sells_items.quantity) as quantity'),
                    DB::raw('SUM(sells_items.return_qty) as return_qty'),
                    DB::raw('SUM(sells_items.return_qty*sells_items.sell_price) as return_amount'),
                )
                ->get();
    
            // dd($data['salesLedger']);
        }

        return view('admin.reports.sells.ledger', $data);
    }
}
