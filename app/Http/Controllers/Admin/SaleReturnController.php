<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnMaster;
use App\Models\ReturnDetails;
use App\Models\ItemStockMaster;
use App\Models\ItemStockChild;
use App\Models\Sell;
use App\Models\SellsItem;
use App\Models\ReturnCategory;
use App\Models\ItemInfo;
use DB;
use Auth;
use Carbon\Carbon;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = ReturnMaster::with(['return_details', 'customer', 'ression'])
            ->where('type', 2)
            ->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('invoice_no', 'like', '%' . $search . '%');
                });
            }

        $purchase_returns = $query->paginate($perPage);

        return view('admin.sales-return.index', compact('purchase_returns', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sale_return = Sell::where('sale_code',$request->invoice_no)->with(['sellsItems', 'customer'])->first();
        $return_category = ReturnCategory::all();
        $invoice_no = $request->invoice_no;

        return view('admin.sales-return.create', compact('sale_return', 'invoice_no', 'return_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $return_qty = array_filter($request->return_qty);

        if(!empty($return_qty)){
            DB::beginTransaction();

            $returnMaster = ReturnMaster::create([
                'type'          => 2, //sale
                'master_id'     => $request->id,
                'return_date'   => date('Y-m-d', strtotime($request->return_date)),
                'cus_sup_id'    => $request->customer_id,
                'user_id'       => Auth::id(),
                'invoice_no'    => $request->invoice_no,
                'ression_type'  => $request->return_type,
                'return_amount' => $request->total_price,
                'note'          => $request->note
            ]);

            // $sellMaster = Sell::find($request->id);
            // $total_return_qty = $sellMaster->total_received_qty - array_sum($request->return_qty);
            // $sellMaster->total_received_qty = $total_return_qty;
            // $sellMaster->save();

            DB::table('item_stock_masters')->insert([
                'status'                  => 4, //sale return
                'stock_in'               => array_sum($request->return_qty),
                'receive_Issue_master_id' => $request->id,
                'supplier_id'             => 0,
                'customer_id'             => $request->customer_id,
                'tran_type_id'            => 1,
                'tran_source_type_id'     => 1,
                'prod_type_id'            => 1,
                'company_id'              => 1,
                'branch_id'               => 1,
                'currency_id'             => 1,
                'opening_bal_date'        => Carbon::now(),
                'receive_issue_date'      => Carbon::now(),
                'uom_id'                  => 1,
                'issue_for'               => "Main Branch",
                'prod_process'            => "sale-return",
                'payment_method_id'       => 1,
                'item_cat_id'             => 1,
                'challan_number'          => 0,
                'challan_date'            => Carbon::now(),
                'remarks'                 => $request->note??'n/a',
            ]);

            $itemStockMasterId = DB::getPdo()->lastInsertId();

            // details 

            foreach ($return_qty as $key => $item) {

                $newItem = ItemInfo::find($request->product_ids[$key]);
                $newItem->current_stock  = $newItem->current_stock +  $request->return_qty[$key];
                $newItem->save();

                ReturnDetails::create([
                    'type'                => 1, //purchase
                    'return_id'           => $returnMaster->id,
                    'product_id'          => $request->product_ids[$key],
                    'pur_sale_detials_id' => $request->child_id[$key],
                    'quantity'            => $request->return_qty[$key],
                    'amount'              => $request->purchase_price[$key],
                ]);

                $saleChild = SellsItem::find($request->child_id[$key]);
                $saleChild->update([
                    'return_qty' => $saleChild->return_qty + $request->return_qty[$key]
                ]);

                ItemStockChild::create([
                    'itemstock_master_id'    => $itemStockMasterId,
                    'receive_issue_child_id' => 1,
                    'product_id'             => $request->product_ids[$key],
                    'store_id'               => Auth::user()->store_id,
                    'opening_bal_qty'        => 0,
                    'opening_bal_rate'       => 0,
                    'opening_bal_amount'     => 0.00,
                    'receive_qty'            => $request->return_qty[$key],
                    'stock_in'              => $request->return_qty[$key],
                    'receive_rate'           => 0,
                    'receive_amount'         => $request->return_qty[$key] * $request->purchase_price[$key],
                    'issue_qty'              => 0,
                    'issue_rate'             => 0,
                    'issue_amount'           => 0,
                    'closing_bal_qty'        => 1,
                    'closing_bal_rate'       => 1,
                    'closing_bal_amount'     => 1,
                    'created_by'             => Auth::user()->id,
                    'updated_by'             => Auth::user()->id,
                ]);
            }

            DB::commit();

            // return redirect()->back()->with('success', "Purchase Return Added successfully");
            return redirect()->route('admin.sales-return.index')->with('success', "Sells Return Added successfully");
        }else{
            return redirect()->back()->with('error', "Something went Wrong!");
        }
    }

    public function show($id){
        $returnMaster = ReturnMaster::findOrFail($id);
        $returnDetails = ReturnDetails::where('return_id', $id)->get();

        return view('admin.sales-return.show', compact('returnDetails', 'returnMaster'));
    }


}
