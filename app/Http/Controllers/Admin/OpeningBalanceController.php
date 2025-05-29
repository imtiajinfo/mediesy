<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\ItemInfo;
use App\Models\Supplier;
use App\Models\ReceiveChild;
use Illuminate\Http\Request;
use App\Models\ReceiveMaster;
use App\Models\ItemStockChild;
use App\Models\ItemStockMaster;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOpeningBalanceRequest;

class OpeningBalanceController extends Controller
{
    public function index(Request $request)
    {

        // try {
        //     DB::beginTransaction();

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $status = $request->input('status');

        $fields = [
            'receive_masters.id',
            'receive_masters.spo_id',
            'receive_masters.tran_type_id',
            'receive_masters.tran_source_type_id',
            'receive_masters.prod_type_id',
            'receive_masters.company_id',
            'receive_masters.branch_id',
            'receive_masters.store_id',
            'receive_masters.supplier_id',
            'receive_masters.receive_date',
            'receive_masters.total_amt_local_curr',
            'receive_masters.is_paid',
            'receive_masters.remarks',
            'tran_type.tran_type_name',
            'product_type.prod_type_name',
            DB::raw('SUM(receive_children.recv_quantity) as total_recv_quantity')
        ];

        $query = ReceiveMaster::query()
            ->select($fields)
            ->leftJoin('receive_children', 'receive_masters.id', '=', 'receive_children.receive_master_id')
            ->leftJoin('tran_type', 'receive_masters.tran_type_id', '=', 'tran_type.id')
            ->leftJoin('product_type', 'receive_masters.prod_type_id', '=', 'product_type.id')
            ->groupBy(
                'receive_masters.id',
                'receive_masters.spo_id',
                'receive_masters.tran_type_id',
                'receive_masters.tran_source_type_id',
                'receive_masters.prod_type_id',
                'receive_masters.company_id',
                'receive_masters.branch_id',
                'receive_masters.store_id',
                'receive_masters.supplier_id',
                'receive_masters.receive_date',
                'receive_masters.total_amt_local_curr',
                'receive_masters.is_paid',
                'receive_masters.remarks',
                'tran_type.tran_type_name',
                'product_type.prod_type_name'
            )
            ->whereNull('issue_master_id')
            ->where('tran_type_id', 12)
            ->latest('receive_masters.id');

        // Apply search filter
        if ($search) {
            $query->where(function ($query) use ($search) {
                // Dynamically search across all columns
                $fillableColumns = (new ReceiveMaster())->getFillable(); // Fetch all fillable columns
                foreach ($fillableColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $openingBalance = $query->paginate($perPage);

        // DB::commit();
        // dd($openingBalance);
        return view('admin.opening-balance.index', compact('openingBalance'));
    }





    public function create()
    {
        // Fetch data needed for dropdowns, e.g., suppliers and products
        $suppliers = Supplier::all(); // Replace with your actual Supplier model
        $products = ItemInfo::where('approved_status', true)
            ->whereNotNull('purchase_price')
            ->get();

        return view('admin.opening-balance.create', compact('suppliers', 'products'));
    }



    public function store(StoreOpeningBalanceRequest $request)
    {
        // dd($request->all());
        // try {

        $requestData = $request->validated();

        $totalPurchaseQty = array_sum($requestData['purchase_qty']);

        $totalPurchaseAmount = 0;

        // Calculate total purchase amount
        foreach ($requestData['product_id'] as $key => $productId) {
            $itemInfo = ItemInfo::find($productId);
            if ($itemInfo) {
                $totalPurchaseAmount += $itemInfo->purchase_price * $requestData['purchase_qty'][$key];
            }
        }

        DB::beginTransaction();
        $totalPurchaseQty = $totalPurchaseQty;
        $totalReceivedQty = $totalPurchaseQty;

        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Get the store ID of the logged-in user
            $storeId = $user->store_id;
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Generate a unique 6-digit random number
        $randomGrnNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        while (ReceiveMaster::where('grn_number', $randomGrnNumber)->exists()) {
            $randomGrnNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        }

        $receiveMaster = ReceiveMaster::create([
            'issue_master_id' => null,
            'spo_id' =>  null,
            'tran_type_id' => 12,
            'tran_source_type_id' => 3,
            'prod_type_id' => 1,
            'company_id' => 1,
            'branch_id' => 1,
            'store_id' => $storeId,
            'currency_id' => 1,
            'excg_rate' => 1,
            'supplier_id' =>  $requestData['supplier_id'] ?? null,
            'receive_date' => Carbon::now(),
            'grn_number' => $randomGrnNumber,
            'grn_date' => Carbon::now(),
            'chalan_number' => $requestData['challan_number'] ?? null,
            'chalan_date' => Carbon::now(),
            'total_amt_trans_curr' =>  $totalPurchaseAmount,
            'total_amt_local_curr' =>  $totalPurchaseAmount,
            'is_paid' => 1,
            'remarks' => $requestData['remarks'],
            'created_by' => Auth::user()->id,
        ]);


        $itemStockMaster = ItemStockMaster::create([
            'receive_Issue_master_id' => $receiveMaster->id,
            'supplier_id' => null,
            'customer_id' => null,
            'tran_type_id' => 12,
            'tran_source_type_id' => 3,
            'prod_type_id' => 1,
            'company_id' => 1,
            'branch_id' => 1,
            'currency_id' => 1,
            'opening_bal_date' => Carbon::now(),
            'receive_issue_date' => Carbon::now(),
            'uom_id' => 1,
            'issue_for' => "Main Branch",
            'prod_process' => "Transferred",
            'payment_method_id' => 1,
            'item_cat_id' => 1,
            'challan_number' => $requestData['challan_number'] ?? null,
            'challan_date' => Carbon::now(),
            'remarks' => $requestData['remarks'],
        ]);

        if (isset($requestData['product_id'])) {
            foreach ($requestData['product_id'] as $key => $productId) {

                $purchase_price = 0;
                $total_amount = 0;
                $itemInfo = ItemInfo::find($productId);
                if ($itemInfo) {
                    $purchase_price = $itemInfo->purchase_price;
                    $total_amount = $purchase_price * $requestData['purchase_qty'][$key];
                }

                // Create ReceiveChild
                $receiveChild = ReceiveChild::create([
                    'receive_master_id' => $receiveMaster->id,
                    'item_info_id' => $productId,
                    'uom_id' => 1,
                    'payment_method_id' => 1,
                    'item_cat_id' => 1,
                    'recv_quantity' =>  $requestData['purchase_qty'][$key],
                    'itm_receive_rate' =>  $purchase_price,
                    'item_value_trans_curr' =>  $purchase_price,
                    'item_value_local_curr' =>  $purchase_price,
                    'fixed_rate' => 1,
                    'total_amt_trans_curr' => $total_amount,
                    'total_amt_local_curr' => $total_amount,
                    'gate_entry_at' => Carbon::now(),
                    'gate_entry_by' => Auth::user()->id,
                    'opening_stock_remarks' =>  $requestData['remarks'] ?? null,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                //create Iitem Stock
                $itemStockChild = ItemStockChild::create([
                    'itemstock_master_id' => $itemStockMaster->id,
                    'receive_issue_child_id' => $receiveChild->id,
                    'store_id' => $storeId,
                    'opening_bal_qty' => $requestData['purchase_qty'][$key],
                    'opening_bal_rate' => $purchase_price,
                    'opening_bal_amount' => $total_amount,
                    'receive_qty' => $requestData['purchase_qty'][$key],
                    'receive_rate' =>  $purchase_price,
                    'receive_amount' => $total_amount,
                    'issue_qty' => $requestData['purchase_qty'][$key],
                    'issue_rate' => $purchase_price,
                    'issue_amount' => $total_amount,
                    'closing_bal_qty' => 1,
                    'closing_bal_rate' => 1,
                    'closing_bal_amount' => 1,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                // Update item information
                if ($itemInfo) {
                    $currentStock = $itemInfo->current_stock + $requestData['purchase_qty'][$key];
                    $stockStatus = ($currentStock > 0) ? true : false; // Assuming stock_status is boolean type
                    $itemInfo->update([
                        'current_stock' => $currentStock,
                        'stock_status' => $stockStatus,
                    ]);
                }
            }
        }



        DB::commit();
        return redirect()
            ->route('admin.opening-balance.index')
            ->with('success', "Opening Stock added successfully. Product In-Stock & Your Stock Is Updated.");
        // } catch (\Exception $error) {
        //     DB::rollBack();

        //     return redirect()->route('admin.purchase-orders.index')->with('error', 'An error occurred while adding the purchase order.');
        // }
    }


    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $data = ReceiveMaster::with(['ReceiveChild', 'itemInfo'])
            ->where('id', $id)
            ->first();

        if (!$data) {
            abort(404);
        }

        $totalRecvQuantity = $data->ReceiveChild->sum('recv_quantity');

        // $data = ReceiveMaster::where('receive_masters.id', $receiveMaster->id)
        // ->whereNull('receive_masters.issue_master_id')

        // ->leftJoin('receive_children', 'receive_masters.id', '=', 'receive_children.receive_master_id')
        // ->leftJoin('item_infos', 'receive_children.item_info_id', '=', 'item_infos.id')
        // ->first();

        return view('admin.opening-balance.show', compact('data', 'totalRecvQuantity'));
    }
}
