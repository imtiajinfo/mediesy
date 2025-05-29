<?php

namespace App\Http\Controllers\Admin\api;

use Carbon\Carbon;
use App\Models\ItemInfo;
use App\Models\ReceiveChild;
use Illuminate\Http\Request;
use App\Models\ReceiveMaster;
use App\Models\ItemStockChild;
use App\Models\PurchaseOrders;
use App\Models\ItemStockMaster;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrdersChild;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PurchaseOrderResource;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StorePurchaseOrdersRequest;
use App\Http\Requests\UpdatePurchaseOrdersRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PurchaseOrdersController extends Controller
{

    public function index(Request $request)
    {

        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $status = $request->input('status');

            $cacheKey = 'purchase_orders_' . md5(json_encode([$perPage, $search, $status]));
            $purchaseOrders = Cache::remember($cacheKey, 60, function () use ($perPage, $search, $status) {
                return PurchaseOrders::whereIn('is_closed', [0, 1])
                    ->when($status, function ($query) use ($status) {
                        return $query->where('is_closed', $status);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where(function ($query) use ($search) {
                            $fillableColumns = (new PurchaseOrders())->getFillable();
                            foreach ($fillableColumns as $column) {
                                $query->orWhere($column, 'like', '%' . $search . '%');
                            }
                        });
                    })
                    ->latest('id')
                    ->paginate($perPage);
            });
            // Calculate total count ensuring it's non-negative
            $totalCount = max($purchaseOrders->total(), 0);

            // Return JSON response with appropriate message if no data found
            if ($totalCount === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'No data found.',
                ], 200);
            }

            $purchaseOrdersResource = PurchaseOrderResource::collection($purchaseOrders);

            return $purchaseOrdersResource->response()->setStatusCode(200);

            // return response()->json([
            //     'success' => true,
            //     // 'total' => $totalCount,
            //     'data' => PurchaseOrderResource::collection($purchaseOrders),
            // ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong. Please try again later.',
                'message' => $error->getMessage(),
            ], 500);
        }


        //     try {
        //         DB::beginTransaction();

        //         $perPage = $request->input('per_page', 10);
        //         $search = $request->input('search');
        //         $status = $request->input('status');

        //         $query = PurchaseOrders::whereIn('is_closed', [0, 1])->latest('id');

        //         if ($status) {
        //             $query->where('is_closed', $status);
        //         }

        //         if ($search) {
        //             $query->where(function ($query) use ($search) {
        //                 $fillableColumns = (new PurchaseOrders())->getFillable();
        //                 foreach ($fillableColumns as $column) {
        //                     // Skip the 'supplier_id' column
        //                     if ($column === 'supplier_id') {
        //                         continue;
        //                     }
        //                     $query->orWhere($column, 'like', '%' . $search . '%');
        //                 }
        //             });
        //         }



        //         // $PurchaseOrders = [];
        //         // $query->chunk(500, function ($PurchaseOrdersChunk) use (&$PurchaseOrders) {
        //         //     $PurchaseOrdersChunk = $PurchaseOrdersChunk->map(function ($PurchaseOrders) {
        //         //         return [
        //         //             'id' => $PurchaseOrders->id,
        //         //             'name_english' => $PurchaseOrders->name_english,
        //         //             'name_bangla' => $PurchaseOrders->name_bangla,
        //         //             'status' => $PurchaseOrders->status,
        //         //             'description' => $PurchaseOrders->description,
        //         //         ];
        //         //     });
        //         //     $PurchaseOrders[] = $PurchaseOrdersChunk->toArray();
        //         // });
        //         // $flatPurchaseOrders = collect($PurchaseOrders)->flatten(1);
        //         // $currentPage = $request->input('page', 1);
        //         // $pagedData = $flatPurchaseOrders->slice(($currentPage - 1) * $perPage, $perPage)->all();
        //         // $PurchaseOrders = new LengthAwarePaginator($pagedData, count($flatPurchaseOrders), $perPage, $currentPage);

        //         $purchaseOrders = $query->paginate($perPage);

        //         DB::commit();

        //         $purchaseOrdersResource = PurchaseOrderResource::collection($purchaseOrders);

        //         return $purchaseOrdersResource->response()->setStatusCode(200);

        //         // return response()->json([
        //         //     'success' => true,
        //         //     'data' => $purchaseOrdersResource,
        //         //     'message' => 'Data processing completed'
        //         // ], 200); 
        //     } catch (\Exception $error) {
        //         DB::rollBack();
        //         Log::error($error->getMessage());
        //         return response()->json([
        //             'success' => false,
        //             'error' => 'Something went wrong. Please try again later.',
        //             'message' => $error->getMessage(),
        //         ], 500);
        //     }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrdersRequest $request)
    {
        try {
            DB::beginTransaction();

            // The validated data will be available via the validated() method 

            // The validated data will be available via the validated() method
            $requestData = $request->validated();

            // Calculate total purchase quantity
            $totalPurchaseQty = array_sum($requestData['purchase_qty']);

            // Calculate total purchase amount
            $totalPurchaseAmount = 0;
            foreach ($requestData['product_id'] as $key => $productId) {
                $itemInfo = ItemInfo::find($productId);
                if ($itemInfo) {
                    $totalPurchaseAmount += $itemInfo->purchase_price * $requestData['purchase_qty'][$key];
                }
            }

            DB::beginTransaction();
            $totalReceivedQty = $totalPurchaseQty;
            $isClosed = ($totalPurchaseQty === $totalReceivedQty);

            $purchaseOrder = PurchaseOrders::create([
                'supplier_id' => $requestData['supplier_id'],
                'po_date' => $requestData['po_date'],
                'total_purchase_qty' => $totalPurchaseQty,
                'total_received_qty' => $totalPurchaseQty,
                'total_purchase_amount' => $totalPurchaseAmount,
                'is_purchased' => 1,
                'is_received' => $request->has('is_received'),
                'is_closed' => $isClosed,
                'purchased_by' => $request->input('purchased_by'),
                'remarks' => $request->input('remarks'),
            ]);

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
                'spo_id' =>  $purchaseOrder->id,
                'tran_type_id' => 1,
                'tran_source_type_id' => 1,
                'prod_type_id' => 1,
                'company_id' => 1,
                'branch_id' => 1,
                'store_id' => $storeId,
                'currency_id' => 1,
                'excg_rate' => 1,
                'supplier_id' =>  $requestData['supplier_id'],
                'receive_date' => Carbon::now(),
                'grn_number' => $randomGrnNumber,
                'grn_date' => Carbon::now(),
                'chalan_number' => $requestData['challan_number'],
                'chalan_date' => Carbon::now(),
                'total_amt_trans_curr' =>  $totalPurchaseAmount,
                'total_amt_local_curr' =>  $totalPurchaseAmount,
                'is_paid' => 1,
                'remarks' => $requestData['remarks'],
                'created_by' => Auth::user()->id,
            ]);


            $itemStockMaster = ItemStockMaster::create([
                'receive_Issue_master_id' => 1, //1
                'supplier_id' => $requestData['supplier_id'], //1
                'customer_id' => 1,
                'tran_type_id' => 1,
                'tran_source_type_id' => 1,
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
                'challan_number' => $requestData['challan_number'],
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

                    // Create child purchase order
                    PurchaseOrdersChild::create([
                        'po_id' => $purchaseOrder->id,
                        'product_id' => $productId,
                        'purchase_qty' => $requestData['purchase_qty'][$key],
                        'purchase_price' => $purchase_price,
                        'total_amount' => $total_amount,
                        'is_received' => $request->has('is_received'),
                    ]);

                    // Create ReceiveChild
                    $receiveChild = ReceiveChild::create([
                        'receive_master_id' => $itemStockMaster->id,
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
                        'receive_issue_child_id' => 1,
                        'store_id' => $storeId,
                        'opening_bal_qty' => 0,
                        'opening_bal_rate' => 0,
                        'opening_bal_amount' => 0.00,
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

            // Inside the try block after creating the purchase order
            // $purchaseOrderResource = new PurchaseOrderResource($purchaseOrder);

            // Return the newly created purchase order as a resource
            return response()->json([
                'success' => true,
                'message' => 'Purchase order created successfully',
                'data' => $purchaseOrder,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());

            // Determine the appropriate status code based on the type of error
            $statusCode = $error instanceof \PDOException ? 500 : 400;

            return response()->json([
                'success' => false,
                'error' => 'An error occurred. Please try again later.',
                'message' => $error->getMessage(),
            ], $statusCode);
        }
    }


    public function show(PurchaseOrders $purchaseOrders)
    {
        try {
            if (is_null($purchaseOrders)) {
                // Customize response format when data is not found
                return response()->json([
                    'message' => 'Data not found.',
                    'status' => 'error',
                    'code' => 404,
                ], 404);
            } else {
                // Customize response format when data is found
                return response()->json([
                    'message' => 'Data found.',
                    'status' => 'success',
                    'data' => $purchaseOrders,
                ], 200);

                // Log successful retrieval with additional information
                Log::info('Purchase order retrieved successfully.', [
                    'purchase_order_id' => $purchaseOrders->id,
                    'retrieved_by' => auth()->user()->id ?? null, // Log the ID of the user who retrieved the purchase order, if available
                    'retrieved_at' => now()->toDateTimeString(), // Log the timestamp of when the purchase order was retrieved
                    'purchase_order_details' => $purchaseOrders->toArray(), // Log the details of the retrieved purchase order
                ]);
            }
        } catch (\Exception $error) {
            // Handle any exceptions and return an error response
            Log::error('Error retrieving purchase order: ' . $error->getMessage(), [
                'error_code' => $error->getCode(),
                'stack_trace' => $error->getTrace(),
            ]);

            return response()->json([
                'message' => 'Internal Server Error',
                'status' => 'error',
                'code' => 500,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show1(PurchaseOrders $purchaseOrders)
    {
        if (is_null($purchaseOrders)) {
            $response = [
                'message' => 'Data Data Not Found',
                'status' => 0,
            ];
            $responseCode = 404;
        } else {

            try {

                $response = [
                    'message' => 'Data Found',
                    'status' => 1,
                    'data' => $purchaseOrders,
                ];
                $responseCode = 200;
            } catch (\Exception $error) {

                $response = [
                    'error' => 'Internal Server Error',
                    'message' => 'Internal Server Error',
                    'message' => $error->getMessage(),
                    'success' => false,
                    'status' => 0,
                ];
                $responseCode = 500;
            }
        }

        return response()->json($response, $responseCode)->header('X-My-Header', 'Value');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PurchaseOrders $purchaseOrders)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:purchase_orders,id',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed.',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            // Check if the $purchaseOrders variable contains a valid model instance
            if (!$purchaseOrders) {
                // If the purchase order is not found, return a 404 error page or a JSON response
                return response()->json([
                    'success' => false,
                    'error' => 'Purchase order not found.',
                ], 404);
            }
            // Return the purchase order data as a JSON response
            return response()->json([
                'success' => true,
                'data' => $purchaseOrders,
            ], 200);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while fetching the purchase order.',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePurchaseOrdersRequest $request, PurchaseOrders $purchaseOrders)
    {
        try {
            // Check if the purchase order exists
            if (!$purchaseOrders) {
                return response()->json([
                    'message' => 'Data does not exist for the provided ID.',
                    'error_code' => 'DATA_NOT_FOUND',
                    'success' => false,
                ], 404);
            }

            // Start a database transaction
            DB::beginTransaction();

            // Update the purchase order with the data from the request
            $purchaseOrders->update($request->validated());

            // Additional validation check if the update was successful
            if (!$purchaseOrders->wasChanged()) {
                DB::rollBack();
                return response()->json([
                    'message' => 'No changes detected in the purchase order.',
                    'error_code' => 'NO_CHANGES_DETECTED',
                    'success' => false,
                ], 400);
            }

            // Commit the transaction
            DB::commit();

            // Log successful update with additional information
            Log::info('Purchase order updated successfully.', [
                'purchase_order_id' => $purchaseOrders->id,
                'updated_by' => auth()->user()->id ?? null, // Log the ID of the user who updated the purchase order, if available
                'updated_at' => now()->toDateTimeString(), // Log the timestamp of when the purchase order was updated
                'updated_data' => $request->validated(), // Log the data that was updated
                'updated_columns' => array_keys($request->validated()), // Log the names of the updated columns
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Purchase order updated successfully.',
                'data' => $purchaseOrders,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            // Handle case where the purchase order is not found
            $errorMessage = 'Purchase order not found: ' . $exception->getMessage();
            Log::error($errorMessage);
            return response()->json([
                'message' => 'Purchase order not found.',
                'error_code' => 'PURCHASE_ORDER_NOT_FOUND',
                'error' => $errorMessage,
                'success' => false,
            ], 404);
        } catch (\Exception $error) {
            // Roll back the transaction in case of any exception
            DB::rollBack();

            // Log the error with detailed information
            $errorMessage = 'Error updating purchase order: ' . $error->getMessage();
            Log::error($errorMessage, [
                'purchase_order_id' => $purchaseOrders->id ?? null, // Log the ID of the purchase order being updated, if available
                'error' => $error->getMessage(),
                'timestamp' => now()->toDateTimeString(), // Log the timestamp of when the error occurred
            ]);

            return response()->json([
                'message' => 'Internal Server Error',
                'error_code' => 'INTERNAL_SERVER_ERROR',
                'error' => $errorMessage,
                'success' => false,
            ], 500);
        }
    }


    public function destroy(PurchaseOrders $purchaseOrders)
    {
        try {
            // Check if the purchase order exists
            if (!$purchaseOrders) {
                return response()->json([
                    'message' => 'Purchase order not found.',
                    'error_code' => 'PURCHASE_ORDER_NOT_FOUND',
                ], 404);
            }

            // Start a database transaction
            DB::beginTransaction();

            // Additional validation: Check if the purchase order can be deleted (e.g., based on certain conditions)
            if (!$this->canDeletePurchaseOrder($purchaseOrders)) {
                return response()->json([
                    'message' => 'Cannot delete the purchase order due to certain conditions.',
                    'error_code' => 'CANNOT_DELETE_PURCHASE_ORDER',
                ], 400);
            }


            // Check if the purchase order has already been soft deleted
            if ($purchaseOrders->trashed()) {
                return response()->json([
                    'message' => 'Purchase order has already been deleted.',
                    'error_code' => 'PURCHASE_ORDER_ALREADY_DELETED',
                ], 400);
            }

            // Delete the purchase order
            $purchaseOrders->delete();

            DB::commit();

            // Log deletion success with additional information
            Log::info('Purchase order deleted successfully.', [
                'purchase_order_id' => $purchaseOrders->id,
                'deleted_by' => auth()->user()->id ?? null, // Log the ID of the user who deleted the purchase order, if available
                'deleted_at' => now()->toDateTimeString(), // Log the timestamp of when the purchase order was deleted
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Purchase order deleted successfully.',
                'deleted_purchase_order_id' => $purchaseOrders->id,
                'deleted_by' => auth()->user()->id ?? null, // Include the ID of the user who deleted the purchase order, if available
                'deleted_at' => now()->toDateTimeString(), // Include the timestamp of when the purchase order was deleted
            ], 200);
        } catch (ModelNotFoundException $exception) {
            // Handle case where the purchase order is not found
            $errorMessage = 'Purchase order not found: ' . $exception->getMessage();
            Log::error($errorMessage);
            return response()->json([
                'message' => 'Purchase order not found.',
                'error_code' => 'PURCHASE_ORDER_NOT_FOUND',
                'error' => $errorMessage,
            ], 404);
        } catch (\Exception $error) {
            // Roll back the transaction in case of any exception
            DB::rollBack();

            // Log the error with detailed information
            $errorMessage = 'Error deleting purchase order: ' . $error->getMessage();
            Log::error($errorMessage, [
                'purchase_order_id' => $purchaseOrders->id ?? null, // Log the ID of the purchase order being deleted, if available
                'error' => $error->getMessage(),
                'timestamp' => now()->toDateTimeString(), // Log the timestamp of when the error occurred
            ]);

            return response()->json([
                'message' => 'Internal Server Error',
                'error_code' => 'INTERNAL_SERVER_ERROR',
                'error' => $errorMessage,
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy1(PurchaseOrders $purchaseOrders)
    {

        if (is_null($purchaseOrders)) {

            $response = [
                'message' => 'Data Data Not Found',
                'status' => 0,
            ];
            $responseCode = 404;
        } else {

            DB::beginTransaction();

            try {

                $purchaseOrders->delete();

                DB::commit();

                // return response()->json(['purchaseOrders' => $purchaseOrders, 'message' => 'Data delete completed'], 200);

                $response = [
                    'message' => 'Data Delete Successfully',
                    'status' => 1,
                ];
                $responseCode = 200;
            } catch (\Exception $error) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'error' => 'An error occurred.',
                    'message' => $error->getMessage(),
                ], 500);
                // Handle the exception, log it, and return an appropriate error response

                $response = [
                    'error' => 'Internal Server Error',
                    'message' => 'Internal Server Error',
                    'message' => $error->getMessage(),
                    'success' => false,
                    'status' => 0,
                ];
                $responseCode = 500;
            }
        }

        return response()->json($response, $responseCode);
    }
}
