<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sell;
use App\Models\User;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Uom;
use App\Models\Customer;
use App\Models\ItemInfo;
use App\Models\SellsItem;
use App\Models\ItemStockChild;
use App\Models\ItemStockMaster;
use App\Models\PurchaseOrders;
use App\Models\PurchaseOrdersChild;
use Illuminate\Http\Request;
use App\Services\PrintService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreSellRequest;
use App\Http\Requests\UpdateSellRequest;
use App\Http\Requests\StoreServiceSellRequest;
use Carbon\Carbon;
use Str;

class ServiceSellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $filters = $request->only(['search', 'per_page']);

        $customers = Customer::get();
        $users = User::latest();

        $query = Sell::with(['payments'])->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('sells.sale_code', 'like', '%' . $search . '%');
            });
        }
        if ($request->customer_id) {
            $query->where(function ($query) use ($request) {
                $query->where('sells.customer_id', $request->customer_id);
            });
        }
        if ($request->from_date && $request->to_date) {
            $query->where(function ($query) use ($request) {
                $query->whereBetween('sells.created_at', [($request->from_date), ($request->to_date)]);
            });
        }

        $data = $query->paginate($perPage);

        return view('admin.service-sales.index', [
            'customers' => $customers, 'users' => $users, 'sells' => $data,'search'=>$search
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $products = [];

            $customers = Customer::all();

            $categories = Category::where('status', 1)->get();
            $brands = Brand::all();
            $uoms = Uom::get();

            return view('admin.service-sales.create', compact('customers' , 'products', 'categories', 'brands', 'uoms'));

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error occurred while processing search request: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while processing the request'], 500);
        }
    }


    public function newsale(Request $request)
    {
        $customers = Customer::all();
        $users = User::all();
        $categories = Category::all();
        return view('admin.service-sales.new-sales', [
            'customers' => $customers, 'users' => $users, 'categories' => $categories,
        ]);
    }

    public function getItem(Request $request)
    {
        if ($request->has('barcode')) {
            $barcode = $request->input('barcode');

            $query = ItemInfo::where('product_type', 'raw_materials')
                ->where('status', 1)
                ->where('approved_status', 1)
                ->where('code', $barcode)
                ->with('brands')
                ->first();

            if ($query) {
                if ($query->current_stock > 0) {
                    return response()->json(['data' => $query, 'message' => 'Item found.', 200]);
                } else {
                    return response()->json(['data' => null, 'message' => 'Item is out of stock.'], 200);
                }
            } else {
                return response()->json(['data' => null, 'message' => 'Item not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Barcode not provided.'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceSellRequest $request)
    {
        try {
            DB::beginTransaction();
            $attribute = $request->all();
            // dd($attribute);

            $customer_id =  $attribute['customer_id'];
            $product_id =  $attribute['product_id'];

            $totalsellQty = array_sum($attribute['sell_qty']);
            $totalsellAmount = 0;
            $totalSaleAmount = 0;

            foreach ($attribute['product_id'] as $key => $productId) {

                $newItem = ItemInfo::find($productId);
                $newItem->current_stock  = $newItem->current_stock - ($attribute['sell_qty'][$key]??0);
                $newItem->save();
                if(@$attribute['discount'][$key] != 0 && @$attribute['discount'][$key] != null){
                    $totalsellAmount += ($attribute['sell_price'][$key] - ((@$attribute['discount'][$key]??0)/100)*$attribute['sell_price'][$key]??0)*($attribute['sell_qty'][$key]??0);
                }else{
                    $totalsellAmount += ($attribute['sell_price'][$key]??0) * ($attribute['sell_qty'][$key]??0);
                }
            }

            $sell = Sell::create([
                'sells_type'       => "sell",
                'customer_id'      => $attribute['customer_id'],
                'shipping_address' => '-',
                'phone'            => '-',
                'sells_status'     => 1,
                'ref_no'           => '-',
                'payment_type'     => '-',
                'grand_total'      => $totalsellAmount,
                'payment_details'  => $attribute['remarks'],
                'service_charge'   => 0,
                'payable'          => $totalsellAmount,
                'paid'             => $attribute['collect_amount']??0,
                'due'              => $totalsellAmount - $attribute['collect_amount']??0,
                'payment_status'   => 1,
                'sent_sms'         => 0,
                'sell_date'         => date('Y-m-d h:i:s', strtotime($request->sell_date)),
                'created_by'       => Auth::user()->id,
            ]);

            $sell->update([
                'sale_code' => 'SC-' . ($sell->id + 1),
            ]);

            $itemStockMaster = DB::table('item_stock_masters')->insert([
                'status'                  => 2, //sell
                'stock_out'               => $totalsellQty,
                'receive_Issue_master_id' => $sell->id,
                'supplier_id'             => 0,
                'customer_id'             => $attribute['customer_id'],
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
                'prod_process'            => "sell",
                'payment_method_id'       => 1,
                'item_cat_id'             => 1,
                'challan_number'          => 0,
                'challan_date'            => Carbon::now(),
                'remarks'                 => $attribute['remarks']??'n/a',
            ]);

            $itemStockMasterId = DB::getPdo()->lastInsertId();

            foreach ($attribute['product_id'] as $index => $productId) {

                $product = ItemInfo::find($productId);
                $quantity = $attribute['sell_qty'][$index]??0;
                $sell_price = $attribute['sell_price'][$index]??0;
                $discount = $attribute['discount'][$index]??0;
                $discount_amount = ((@$attribute['discount'][$key]??0)/100)*$attribute['sell_price'][$key]??0;

                $sellitem = SellsItem::create([
                    'store_id'        => '1',
                    'sell_id'         => $sell->id,
                    'product_id'      => $productId,
                    'published_price' => $sell_price,
                    'bar_code'        => $productId,
                    'quantity'        => $quantity,
                    'sell_price'      => $sell_price,
                    'discount'        => $discount,
                    'discount_amount' => $discount_amount,
                    'published_price' => $sell_price,
                    'sub_total'       => $quantity * ($sell_price-$discount_amount),
                ]);

                $itemStockChild = ItemStockChild::create([
                    'itemstock_master_id'    => $itemStockMasterId,
                    'receive_issue_child_id' => 1,
                    'product_id'             => $productId,
                    'store_id'               => Auth::user()->store_id,
                    'opening_bal_qty'        => 0,
                    'opening_bal_rate'       => 0,
                    'opening_bal_amount'     => 0.00,
                    'receive_qty'            => $quantity,
                    'stock_out'              => $quantity,
                    'receive_rate'           => 0,
                    'receive_amount'         => $quantity * ($sell_price-$discount_amount),
                    'issue_qty'              => 0,
                    'issue_rate'             => 0,
                    'issue_amount'           => $discount_amount,
                    'closing_bal_qty'        => 1,
                    'closing_bal_rate'       => 1,
                    'closing_bal_amount'     => 1,
                    'created_by'             => Auth::user()->id,
                    'updated_by'             => Auth::user()->id,
                ]);
            }


            $payment = Payment::create([
                'sell_id'              => $sell->id,
                'customer_id'          => $attribute['customer_id'],
                'payment_type'         => 'sale',
                'payment_note'         => 'sale',
                'total_payable_amount' => $totalsellAmount,
                'total_paid_amount'    => $attribute['collect_amount']??0,
                'total_due_amount'     => $totalsellAmount - $attribute['collect_amount']??0,
                'payment_details'      => '-',
                'txn_code'             => 'TX-'.$sell->id . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8),
            ]);

            DB::commit();

            return redirect()->route('admin.service-sales.index');
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // Fetch only the necessary data
        $customers = Customer::all();  // Update this to fetch relevant customers
        $users = User::all();          // Update this to fetch relevant users
        $categories = Category::all(); // Update this to fetch relevant categories

        // Fetch the specific sell along with its sells_items and payments
        $sell = Sell::select([
            'sells.*',
            'customers.name as customername',
            'customers.email as customeremail',
            'customers.phone as customerphone',
            'customers.address as customeraddress',
        ])
            ->leftjoin('customers', 'sells.customer_id', 'customers.id')
            ->where('sells.id', $id)
            ->first();

        $sellItem = SellsItem::select([
            'sells_items.*',
            'item_infos.name as itemname',
            'item_infos.sub_title as sub_title',
            'item_infos.thumbnail as itemthumbnail',
        ])
            ->where('sells_items.sell_id', $id)
            ->leftjoin('item_infos', 'sells_items.product_id', 'item_infos.id')
            ->get();

        $payments = Payment::select([
            'payments.*',
        ])
            ->where('payments.sell_id', $id)
            ->get();

        return view('admin.service-sales.sales_details', [
            'customers' => $customers,
            'sell' => $sell,
            'sellItem' => $sellItem,
            'payments' => $payments,
        ]);
    }

    public function salesInvoice(Sell $sell)
    {
        // Fetch the specific sell along with its sells_items and payments
        // $sell = Sell::with(['sells_items', 'payments'])->find($sell->id);
        return view('admin.service-sales.pdf_print');
    }



    public function printPosInvoice(Sell $sell, $id)
    {

        $customers = Customer::all();  // Update this to fetch relevant customers
        $users = User::all();          // Update this to fetch relevant users
        $categories = Category::all(); // Update this to fetch relevant categories

        // Fetch the specific sell along with its sells_items and payments
        $sell = Sell::select([
            'sells.*',
            // 'sells_items.*',
            'customers.name as customername',
            'customers.email as customeremail',
            'customers.phone as customerphone',
            'customers.address as customeraddress',
        ])
            ->leftjoin('customers', 'sells.customer_id', 'customers.id')
            ->where('sells.id', $id)
            ->first();
        $sellItem = SellsItem::select([
            'sells_items.*',
            'item_infos.name as itemname',
            'item_infos.sub_title as sub_title',
            'item_infos.thumbnail as itemthumbnail',
        ])
            ->where('sells_items.sell_id', $id)
            ->leftjoin('item_infos', 'sells_items.product_id', 'item_infos.id')
            ->get();

        $payments = Payment::select([
            'payments.*',
        ])
            ->where('payments.sell_id', $id)
            ->get();


        return view('admin.service-sales.invoice', with([
            'customers' => $customers,
            'sell' => $sell,
            'sellItem' => $sellItem,
            'payments' => $payments,

        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sell = Sell::findOrFail($id);
        // dd($sell);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        $uoms = Uom::get();

        $products = [];

        $customers = Customer::all();


        $sellItems = SellsItem::select([
                'sells_items.*',
                'item_infos.current_stock as current_stock',
                'item_infos.name as itemname',
                'item_infos.sub_title as sub_title',
                'item_infos.sub_title as sub_title',
                'item_infos.thumbnail as itemthumbnail',
                'item_infos.whole_sale_price as whole_sale_price',
                'item_infos.whole_sale_qty as whole_sale_qty',
                'item_infos.sell_price as sell_price1',
            ])
            ->where('sells_items.sell_id', $id)
            ->leftjoin('item_infos', 'sells_items.product_id', 'item_infos.id')
            ->get();

        $payments = Payment::select([
                'payments.*',
            ])
            ->where('payments.sell_id', $id)
            ->get();

        return view('admin.service-sales.edit', compact('customers','products', 'sell', 'sellItems', 'payments', 'categories', 'brands', 'uoms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreServiceSellRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $attribute = $request->all();
            $customer_id =  $attribute['customer_id'];
            $product_id =  $attribute['product_id'];
            
            $sellItems = SellsItem::where('sell_id', $id)->get();
            $itemstock_master = ItemStockMaster::where('status', 2)->where('receive_Issue_master_id', $id)->first();
            $stockItems = ItemStockChild::where('itemstock_master_id', $itemstock_master->id)->get();

            SellsItem::where('sell_id', $id)->delete();
            ItemStockChild::where('itemstock_master_id', $itemstock_master->id)->delete();

            if(!empty($sellItems)){
                foreach ($sellItems as $key => $value) {
                    $delItem = ItemInfo::find($value->product_id);
                    $delItem->current_stock  = $delItem->current_stock + ($value->quantity - $value->return_qty);
                    $delItem->save();
                }
            }
            
            $totalsellQty = array_sum($attribute['sell_qty']);
            $totalsellAmount = 0;
            $totalSaleAmount = 0;

            foreach ($attribute['product_id'] as $key => $productId) {

                $newItem = ItemInfo::find($productId);
                $newItem->current_stock  = $newItem->current_stock - ($attribute['sell_qty'][$key]??0);
                $newItem->save();
                if(@$attribute['discount'][$key] != 0 && @$attribute['discount'][$key] != null){
                    $totalsellAmount += ($attribute['sell_price'][$key] - ((@$attribute['discount'][$key]??0)/100)*$attribute['sell_price'][$key]??0)*($attribute['sell_qty'][$key]??0);
                }else{
                    $totalsellAmount += ($attribute['sell_price'][$key]??0) * ($attribute['sell_qty'][$key]??0);
                }
            }

            $sell = Sell::find($id)->update([
                'sells_type'       => "sell",
                'customer_id'      => $attribute['customer_id'],
                'sells_status'     => 1,
                'grand_total'      => $totalsellAmount,
                'payment_details'  => $attribute['remarks'],
                'payable'          => $totalsellAmount,
                'paid'             => $attribute['collect_amount']??0,
                'due'              => $totalsellAmount - $attribute['collect_amount']??0,
                'payment_status'   => 1,
                'sell_date'         => date('Y-m-d h:i:s', strtotime($request->sell_date)),
                'created_by'       => Auth::user()->id,
            ]);

            $itemStockMaster = DB::table('item_stock_masters')->where('status', 2)->where('receive_Issue_master_id', $id)->update([
                'status'                  => 2, //sell
                'stock_out'               => $totalsellQty,
                'receive_Issue_master_id' => $id,
                'customer_id'             => $attribute['customer_id'],
                'opening_bal_date'        => Carbon::now(),
                'receive_issue_date'      => Carbon::now(),
                'uom_id'                  => 1,
                'issue_for'               => "Main Branch",
                'prod_process'            => "sell",
                'payment_method_id'       => 1,
                'challan_date'            => Carbon::now(),
                'remarks'                 => $attribute['remarks']??'n/a',
            ]);

            $itemStockMasterId = DB::table('item_stock_masters')->where('status', 2)->where('receive_Issue_master_id', $id)->first()->id;

            foreach ($attribute['product_id'] as $index => $productId) {

                $product = ItemInfo::find($productId);
                $quantity = $attribute['sell_qty'][$index]??0;
                $sell_price = $attribute['sell_price'][$index]??0;
                $discount = $attribute['discount'][$index]??0;
                $discount_amount = ((@$attribute['discount'][$key]??0)/100)*$attribute['sell_price'][$key]??0;

                $sellitem = SellsItem::create([
                    'store_id'        => '1',
                    'sell_id'         => $id,
                    'product_id'      => $productId,
                    'published_price' => $sell_price,
                    'bar_code'        => $productId,
                    'quantity'        => $quantity,
                    'sell_price'      => $sell_price,
                    'discount'        => $discount,
                    'discount_amount' => $discount_amount,
                    'published_price' => $sell_price,
                    'sub_total'       => $quantity * ($sell_price-$discount_amount),
                ]);

                $itemStockChild = ItemStockChild::create([
                    'itemstock_master_id'    => $itemStockMasterId,
                    'receive_issue_child_id' => 1,
                    'product_id'             => $productId,
                    'store_id'               => Auth::user()->store_id,
                    'opening_bal_qty'        => 0,
                    'opening_bal_rate'       => 0,
                    'opening_bal_amount'     => 0.00,
                    'receive_qty'            => $quantity,
                    'stock_out'              => $quantity,
                    'receive_rate'           => 0,
                    'receive_amount'         => $quantity * ($sell_price-$discount_amount),
                    'issue_qty'              => 0,
                    'issue_rate'             => 0,
                    'issue_amount'           => $discount_amount,
                    'closing_bal_qty'        => 1,
                    'closing_bal_rate'       => 1,
                    'closing_bal_amount'     => 1,
                    'created_by'             => Auth::user()->id,
                    'updated_by'             => Auth::user()->id,
                ]);
            }


            $payment = Payment::where('sell_id', $id)->update([
                'customer_id'          => $attribute['customer_id'],
                'payment_type'         => 'sale',
                'payment_note'         => 'sale',
                'total_payable_amount' => $totalsellAmount,
                'total_paid_amount'    => $attribute['collect_amount']??0,
                'total_due_amount'     => $totalsellAmount - $attribute['collect_amount']??0,
                'payment_details'      => '-',
            ]);


            DB::commit();

            return redirect()->route('admin.service-sales.index');
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sell $sell)
    {
        //
    }






    //composer require laravel/cashier

    // Sign Up for bKash Account:

    //     Before integrating bKash, make sure you have a bKash account and have access to their developer portal.
    //     Obtain API Credentials:

    //     Log in to the bKash developer portal and obtain the API credentials (merchant ID, username, password, API key, etc.) necessary for integration.


    // routes/web.php or routes/api.php

    //Route::post('/bkash/callback', 'BkashController@handleCallback');


    // use Illuminate\Support\Facades\Log;

    public function handleCallback(Request $request)
    {
        try {
            // Validate the bKash callback data
            $this->validateBkashCallback($request);

            // Extract relevant data from the callback
            $sellId = $request->input('sell_id');
            $bKashTransactionId = $request->input('bKash_transaction_id');
            $bKashStatus = $request->input('bKash_status');

            // Update the database based on the callback data
            $sell = Sell::find($sellId);

            if ($sell) {
                $sell->update([
                    'bkash_transaction_id' => $bKashTransactionId,
                    'bkash_status' => $bKashStatus,
                    // Add other relevant fields as needed
                ]);

                // Perform additional business logic based on the bKash status
                if ($bKashStatus === 'Completed') {
                    // Payment was successful
                    // Perform any actions needed for a successful payment
                } else {
                    // Payment was not successful
                    // Handle accordingly (e.g., cancel the order, update status, etc.)
                }

                // Respond to bKash with a success message
                return response()->json(['status' => 'success']);
            } else {
                // Sell not found in the database
                throw new \Exception('Sell not found for ID: ' . $sellId);
            }
        } catch (\Exception $exception) {
            // Log the error
            Log::error('Error handling bKash callback: ' . $exception->getMessage());

            // Respond to bKash with an error message
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error']);
        }
    }

    private function validateBkashCallback(Request $request)
    {
        // Perform validation on the incoming bKash callback data
        // Example: Check if required fields are present, validate signatures, etc.

        // Example validation:
        $request->validate([
            'sell_id' => 'required|numeric',
            'bKash_transaction_id' => 'required|string',
            'bKash_status' => 'required|in:Completed,Failed',
            // Add other required fields and validation rules
        ]);
    }

    public function ajax_product_add(Request $request)
    {
       $request->validate([
            'name'     => 'required|string',
            // 'sub_title'        => 'string',
            // 'purchase_price'   => 'required',
            'retail_price'     => 'required',
            // 'whole_sale_price' => 'required',
            // 'whole_sale_qty'   => 'required',
            'purchase_qty'     => 'required',
        ]);

        try {

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $thumbnail_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $thumbnail->getClientOriginalExtension();
                if (!File::exists(public_path('uploads/products'))) {
                    File::makeDirectory(public_path('uploads/products'), 0777, true, true);
                }
                $thumbnail->move('uploads/products', $thumbnail_name);
            } else {
                $thumbnail_name = 'default.png';
            }
            
            // $thumbnail_name = 'default.png';
            $attachmentNames = [];
            if ($request->hasFile('attachment')) {
                $attachments = $request->file('attachment');

                foreach ($attachments as $attachment) {
                    $slug = Str::slug($request->name);
                    $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                    $attachmentName = $slug . '-' . $currentDate . rand(100, 999) . '.' . $attachment->getClientOriginalExtension();
                    if (!File::exists(public_path('uploads/attachments'))) {
                        File::makeDirectory(public_path('uploads/attachments'), 0777, true, true);
                    }
                    $attachment->move(public_path('uploads/attachments'), $attachmentName);
                    $attachmentNames[] = $attachmentName;
                }
            }

            $attachmentJson = json_encode($attachmentNames);

            if (empty($attachmentNames)) {
                $attachmentJson = json_encode(['default.png']);
            }

            $validatedData = $request->all();

            $validatedData['purchase_price']   = $request['purchase_price']??00.00;
            $validatedData['sell_price']       = $request['retail_price']??00.00;
            $validatedData['whole_sale_price'] = $request['whole_sale_price']??00.00;
            $validatedData['whole_sale_qty']   = $request['whole_sale_qty']??0;
            $validatedData['current_stock']    = $request['purchase_qty']??0;

            $validatedData['slug'] = Str::slug($request->name);

            // dd($request['retail_price']);

            $itemInfo = ItemInfo::create($validatedData);
            $slug                = Str::slug($itemInfo->name);
            $itemInfo->slug      = $slug.rand(1,100);
            $itemInfo->thumbnail = $thumbnail_name;

            

            $itemInfo->attachment = $attachmentJson;

            $itemInfo->min_qty = 1;
            $itemInfo->stock_status    = 0;
            // $itemInfo->trans_uom       = $request->unit;
            $itemInfo->approved_status = true;
            $itemInfo->status          = true;

            $code = isset($itemInfo->id) ? $itemInfo->id : 'unknown_id';
            $itemInfo->code = $code . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $itemInfo->save();

            // purchase section 
            $purchaseOrder = PurchaseOrders::create([
                'store_id'              => Auth::user()->id,
                'supplier_id'           => 0,
                'po_date'               => Carbon::now(),
                'total_purchase_qty'    => $request['purchase_qty']??0,
                'total_received_qty'    => $request['purchase_qty']??0,
                'total_purchase_amount' => ($request['purchase_qty']??0)*($request['purchase_price']??0),
                'is_purchased'          => 1,
                'is_received'           => 1,
                'is_closed'             => 1,
                'purchased_by'          => Auth::user()->id,
                'remarks'               => 'n/a',
            ]);

            $itemStockMaster = ItemStockMaster::create([
                'status'                  => 1, //purchase
                'stock_in'                => $request['purchase_qty']??0,
                'receive_Issue_master_id' => $purchaseOrder->id,
                'supplier_id'             => 0,
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
                'remarks'                 => 'n/a',
            ]);

            PurchaseOrdersChild::create([
                'po_id'            => $purchaseOrder->id,
                'product_id'       => $itemInfo->id,
                'purchase_qty'     => ($request['purchase_qty']??0),
                'purchase_price'   => ($request['purchase_price']??00.00),
                'sell_price'       => ($request['sell_price']??00.00),
                'whole_sale_price' => ($request['whole_sale_price']??00.00),
                'whole_sale_qty'   => ($request['whole_sale_qty']??0),
                'total_amount'     => ($request['purchase_qty']??0)*($request['purchase_price']??0),
                'is_received'      => 1,
            ]); 

            $itemStockChild = ItemStockChild::create([
                'itemstock_master_id'    => $itemStockMaster->id,
                'receive_issue_child_id' => 1,
                'product_id'             => $itemInfo->id,
                'store_id'               => Auth::user()->store_id,
                'opening_bal_qty'        => 0,
                'opening_bal_rate'       => 0,
                'opening_bal_amount'     => 0.00,
                'receive_qty'            => ($request['purchase_qty']??0),
                'stock_in'               => ($request['purchase_qty']??0),
                'receive_rate'           => ($request['purchase_price']??00.00),
                'receive_amount'         => ($request['purchase_qty']??0)*($request['purchase_price']??0),
                'issue_qty'              => 0,
                'issue_rate'             => 0,
                'issue_amount'           => 0,
                'closing_bal_qty'        => 1,
                'closing_bal_rate'       => 1,
                'closing_bal_amount'     => 1,
                'created_by'             => Auth::user()->id,
                'updated_by'             => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json($itemInfo);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error', 'Error creating Product: ' . $e->getMessage()]);
        }
    }
}
