<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\ItemInfo;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\ReceiveChild;
use Illuminate\Http\Request;
use App\Models\DailyExpenses;
use App\Models\ReceiveMaster;
use App\Models\ItemStockChild;
use App\Models\PurchaseOrders;
use App\Models\ItemStockMaster;
use App\Models\PaymentToSupplier;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrdersChild;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePurchaseOrdersRequest;
use App\Http\Requests\UpdatePurchaseOrdersRequest;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $status = $request->input('status');

        $fields = [
            'purchase_orders.id',
            'suppliers.name AS supplier_name',
            'purchase_orders.total_purchase_qty',
            'purchase_orders.total_received_qty',
            'purchase_orders.total_purchase_amount',
            'receive_masters.chalan_number',
            'purchase_orders.po_date',
        ];

        $purchaseOrders = PurchaseOrders::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->leftJoin('receive_masters', 'purchase_orders.id', '=', 'receive_masters.spo_id')
            ->select($fields)
            ->orderBy('purchase_orders.id', 'desc')
            ->where(function ($query) use ($search) {
                if($search){
                    $query->where('purchase_orders.id', 'like', '%' . $search . '%')
                        ->orWhere('suppliers.name', 'like', '%' . $search . '%')
                        ->orWhere('purchase_orders.total_purchase_amount', 'like', '%' . $search . '%');
                }
            })
            ->paginate($perPage);

        return view('admin.purchase_orders.index', compact('purchaseOrders', 'search'));
    }





    public function create()
    {
        $suppliers = Supplier::all();
        // $products = ItemInfo::select('item_infos.*')
        //     ->where('approved_status', true)
        //     ->latest('id')
        //     ->get();

        return view('admin.purchase_orders.create', compact('suppliers'));
    }



    public function store(StorePurchaseOrdersRequest $request)
    {

        if (isset($request['product_id'])) {

            DB::beginTransaction();

            $requestData = $request->all();

            $totalPurchaseQty = array_sum($requestData['purchase_qty']);
            $totalPurchaseAmount = 0;
            $totalSaleAmount = 0;

            foreach (array_filter($requestData['product_id']) as $key => $productId) {
                $newItem = ItemInfo::find($productId);
                $newItem->purchase_price   = $requestData['purchase_price'][$key]??00.00;
                $newItem->sell_price       = $requestData['sell_price'][$key]??00.00;
                $newItem->whole_sale_price = $requestData['whole_sale_price'][$key]??00.00;
                $newItem->whole_sale_qty   = $requestData['whole_sale_qty'][$key]??0;
                $newItem->current_stock    = $newItem->current_stock + ($requestData['purchase_qty'][$key]??0);
                $newItem->save();

                $totalPurchaseAmount += ($requestData['purchase_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);
                $totalSaleAmount += ($requestData['sell_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);
            }

            $purchaseOrder = PurchaseOrders::create([
                'store_id'              => Auth::user()->id,
                'supplier_id'           => $requestData['supplier_id'],
                'po_date'               => $requestData['po_date'],
                'total_purchase_qty'    => $totalPurchaseQty,
                'total_received_qty'    => $totalPurchaseQty,
                'total_purchase_amount' => $totalPurchaseAmount,
                'is_purchased'          => 1,
                'is_received'           => 1,
                'is_closed'             => 1,
                'purchased_by'          => Auth::user()->id,
                'remarks'               => $request->input('remarks')??'n/a',
            ]);

            $itemStockMaster = DB::table('item_stock_masters')->insert([
                'status'                  => 1, //purchase
                'stock_in'                => $totalPurchaseQty,
                'receive_Issue_master_id' => $purchaseOrder->id,
                'supplier_id'             => $requestData['supplier_id'],
                'customer_id'             => 0,
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
                'prod_process'            => "Purchase",
                'payment_method_id'       => 1,
                'item_cat_id'             => 1,
                'challan_number'          => 0,
                'challan_date'            => Carbon::now(),
                'remarks'                 => $requestData['remarks']??'n/a',
            ]);

            $itemStockMasterId = DB::getPdo()->lastInsertId();

            foreach ($requestData['product_id'] as $key => $requestProductId) {

                $product = ItemInfo::find($requestProductId);
                $totalAmount = ($requestData['purchase_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);

                PurchaseOrdersChild::create([
                    'po_id'            => $purchaseOrder->id,
                    'product_id'       => $product->id,
                    'purchase_qty'     => ($requestData['purchase_qty'][$key]??0),
                    'purchase_price'   => ($requestData['purchase_price'][$key]??00.00),
                    'sell_price'       => ($requestData['sell_price'][$key]??00.00),
                    'whole_sale_price' => ($requestData['whole_sale_price'][$key]??00.00),
                    'whole_sale_qty'   => ($requestData['whole_sale_qty'][$key]??0),
                    'total_amount'     => $totalAmount,
                    'is_received'      => 1,
                ]); 

                $itemStockChild = ItemStockChild::create([
                    'itemstock_master_id'    => $itemStockMasterId,
                    'receive_issue_child_id' => 1,
                    'product_id'             => $product->id,
                    'store_id'               => Auth::user()->store_id,
                    'opening_bal_qty'        => 0,
                    'opening_bal_rate'       => 0,
                    'opening_bal_amount'     => 0.00,
                    'receive_qty'            => ($requestData['purchase_qty'][$key]??0),
                    'stock_in'               => ($requestData['purchase_qty'][$key]??0),
                    'receive_rate'           => ($requestData['purchase_price'][$key]??00.00),
                    'receive_amount'         => $totalAmount,
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
            return redirect()->route('admin.purchase-orders.index')->with('success', "Purchase order Added successfully");
        }else{
            return redirect()->route('admin.purchase-orders.index')->with('error', "Something went Wrong!");
        }

    }


    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $purchaseOrder = PurchaseOrders::with(['purchaseOrderChildren', 'supplier', 'itemInfo'])
            ->where('id', $id)
            ->first();

        // $purchaseOrder = PurchaseOrders::where('purchase_orders.id', $id)
        //     ->leftJoin('purchase_orders_children', 'purchase_orders.id', '=', 'purchase_orders_children.po_id')
        //     ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        //     ->leftJoin('item_infos', 'purchase_orders_children.product_id', '=', 'item_infos.id')
        //     ->select([
        //         'purchase_orders.*',
        //         'purchase_orders_children.*',
        //         'item_infos.name as itemName',
        //         'suppliers.name as suppliersName'
        //     ])
        //     ->firs();

        // dd($purchaseOrder);
        if (!$purchaseOrder) {
            abort(404);
        }

        return view('admin.purchase_orders.show', compact('purchaseOrder'));
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $purchaseOrder = PurchaseOrders::with(['purchaseOrderChildren', 'supplier', 'itemInfo'])
        ->where('id', $id)
        ->first();

    if (!$purchaseOrder) {
        abort(404);
    }

    return view('admin.purchase_orders.edit', compact('purchaseOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        if (isset($request['product_ids'])) {
            DB::beginTransaction();

            $requestData = $request->all();

            $totalPurchaseQty = array_sum($requestData['purchase_qty']);
            $totalPurchaseAmount = 0;
            $totalSaleAmount = 0;

            $requestData = $request->all();

            foreach ($requestData['product_ids'] as $key => $productId) {
                $newItem = ItemInfo::find($productId);
                $newItem->purchase_price   = $requestData['purchase_price'][$key]??00.00;
                $newItem->sell_price       = $requestData['sell_price'][$key]??00.00;
                $newItem->whole_sale_price = $requestData['whole_sale_price'][$key]??00.00;
                $newItem->whole_sale_qty   = $requestData['whole_sale_qty'][$key]??0;
                $newItem->current_stock    = $newItem->current_stock + ($requestData['purchase_qty'][$key]??0);
                $newItem->save();

                $totalPurchaseAmount += ($requestData['purchase_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);
                $totalSaleAmount += ($requestData['sell_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);
            }

            $purchaseOrder = PurchaseOrders::find($id)->update([
                'total_purchase_amount' => $totalPurchaseAmount,
            ]);

        
            foreach ($requestData['product_ids'] as $key => $requestProductId) {

                $product = ItemInfo::find($requestProductId);
                $totalAmount = ($requestData['purchase_price'][$key]??00.00) * ($requestData['purchase_qty'][$key]??0);

                PurchaseOrdersChild::where('po_id', $id)->where('product_id', $requestProductId)->update([
                    'purchase_price'   => ($requestData['purchase_price'][$key]??00.00),
                    'sell_price'       => ($requestData['sell_price'][$key]??00.00),
                    'whole_sale_price' => ($requestData['whole_sale_price'][$key]??00.00),
                    'whole_sale_qty'   => ($requestData['whole_sale_qty'][$key]??0),
                    'total_amount'     => $totalAmount,
                ]); 

            } 
            DB::commit();
            return redirect()->route('admin.purchase-orders.index')->with('success', "Purchase order Updated successfully");
        }else{
            return redirect()->back()->with('error', "Something went Wrong!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrders $purchaseOrder)
    {
        $purchaseOrder->delete();

        // Flash success message and redirect
        session()->flash('success', 'Purchase order deleted successfully.');
        return redirect()->route('admin.purchase-orders.index');
    }
}
