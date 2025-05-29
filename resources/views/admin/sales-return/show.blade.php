@extends('layouts.admin')
@section('title', 'Admin | Sells Return')

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sales-return.index') }}">Sells Return</a>
            </li>
        </ol>
    </div>
</div>
<style>
    .product-img img {
        width: 100px;
        height: 120px
    }
    .product-text-area p {
        font-size: 13px;
    }
    .product-list-wrapper {
        text-align: center
    }
    .product-info__content .fs-6 {
        font-size: 13px;
    }
    .productListContainer .col-4:hover {
        border: 1px solid #999;
    }
    #loader {
        display: none;
    }
    /* styles.css */
    .barcode-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 20px;
    }
    .barcode-item {
        border: 1px solid #888;
        padding: 0 6px;
        margin: 4px;
    }
    input[type="file"],
    [class~="input-group"],
    select,
    input[type="text"] {
        font-size: small !important;
    }
    input {
        padding: 2px !important;
        margin: 0px !important
    }
    tr,
    td {
        padding: 3px !important;
        margin: 0px !important
    }
    [class~="input-group"],
    input[type="file"] {
        border: 0px solid !important;
    }
</style>

<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Sells Return</h4>
        </div>
        <div class="container p-4 pt-0 pb-0">
            

            <div class="row">
                <div class="card mt-2 pt-1 mb-3 pb-3">

                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="invoice-no">Invoice No</label>
                            <div class="input-group mr-2">
                                <input disabled type="text" class="form-control" id="invoice-no" value="{{@$returnMaster->invoice_no}}"  placeholder="Enter Invoice No">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="customer_id">Customer Name</label>
                            <div class="input-group mr-2">
                                <select disabled name="customer_id"
                                    class="form-control"
                                    id="customer" data-live-search="true" required>
                                    <option>{{@$returnMaster->supplier->name??"Guest"}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">

                                <div class="mb-3 col-md-3">
                                    <label for="return-date">Return Date</label>
                                    <input type="date" disabled class="form-control" id="return-date" name="return_date" value="{{@$returnMaster->return_date}}">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="">Return Type</label>
                                    <select disabled name="return_type" required class="form-control select2">
                                        <option {{"selected"}}>{{$returnMaster->ression->category_name}}</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="note">Note</label>
                                    <input disabled type="text" class="form-control" id="note" name="note" placeholder="Note" value="{{$returnMaster->note}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tableContainer" style="max-height: 490px;overflow-y:scroll">
                        <table class="table table-sm">
                            <thead>
                                <tr class="bg-light">
                                    <th>Sl</th>
                                    <th>product Name</th>
                                    <th class="text-start">Product Code</th>
                                    <th class="text-start">Amount</th>
                                    <th class="text-start">Return Qty</th>
                                    <th class="text-start">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($returnDetails))
                                    
                                    @foreach ($returnDetails as $key => $child)

                                        <input name="product_ids[]" value="{{ $child->itemInfo->id}}" type="hidden">
                                        <input name="child_id[]" value="{{ $child->id}}" type="hidden">
                                        <input name="purchase_price[]" value="{{ $child->purchase_price}}" type="hidden">

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <input type="text" value="{{ $child->itemInfo->name ?? 'N/A' }}" disabled class="form-control">
                                            </td>
                                            <td style="width: 17%">
                                                <input type="text" value="{{ $child->itemInfo->sub_title ?? 'N/A' }}" disabled class="form-control">
                                            </td>
                                            <td style="width: 12%">
                                                <input name="purchase_price[]" type="text" class="form-control" disabled value="{{$child->amount}}" disabled>
                                            </td>
                                            <td class="return_qty" style="width: 10%">
                                                <input name="return_qty[]" type="text" class="form-control return-qty" disabled value="{{$child->quantity}}">
                                            </td>
                                            <td style="width: 14%">
                                                <input name="sub_total[]" type="text" class="form-control sub_total" value="{{$child->amount*$child->quantity}}" disabled>
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
 
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <label for="customer_id">Total Amount</label>
                            <div class="input-group mr-2">
                                <input type="text" class="form-control" id="total_price" name="total_price" disabled value="{{$returnMaster->return_amount}}">
                            </div>
                        </div>
                    </div>

                    <div id="save_purchase_container" class="text-right mt-4 mb-3">
                        <a href="/admin/sales-return" class="btn btn-md btn-primary">Back To List</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
<!-- /.content -->

@endsection
