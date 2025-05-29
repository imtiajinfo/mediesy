@extends('layouts.admin')
@section('title', 'Admin | Edit Purchase')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                        class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a
                    href="{{ route('admin.purchase-orders.index') }}">purchase</a></li>
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
        /* Adjust the margin as needed */
    }

    .barcode-item {
        border: 1px solid #888;
        padding: 0 6px;
        margin: 4px;
        /* Adjust the margin as needed */
    }
    input[type="file"], [class~="input-group"], select, input[type="text"] {
        font-size: small !important;
    }
    input{
        padding: 2px !important;
        margin: 0px !important
    }
    tr,td{
        padding: 3px !important;
        margin: 0px !important
    }
    [class~="input-group"], input[type="file"] {
        border:0px solid !important;
    }
</style>


<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Edit Purchase</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.purchase-orders.update', $purchaseOrder->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Invoice No</label>
                                    <input name="" class="form-control" value="#{{$purchaseOrder->id}}" disabled />
                                </div>
                            </div>



                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name</label>
                                    <select name="supplier_id" class="form-control" disabled>
                                        @if ($purchaseOrder->supplier_id)
                                        <option value="{{ $purchaseOrder->supplier_id }}">
                                            {{ $purchaseOrder->supplier->name }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="">Purchase Date</label>
                                <input type="date" class="form-control" id="po_date" value="{{ date('Y-m-d', strtotime($purchaseOrder->po_date)) }}" disabled>
                            </div>


                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="purchased_by">Purchased By</label>
                                    <select name="purchased_by"
                                        class="form-control @error('purchased_by') is-invalid @enderror" required
                                        readonly>
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}
                                        </option>
                                    </select>
                                    @error('purchased_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="total_purchase_qty">Total Purchase  Quantity</label>
                                    <input disabled type="number" name="total_purchase_qty" min="1" max="5000"
                                        value="{{$purchaseOrder->total_purchase_qty}}"
                                        class="form-control @error('total_purchase_qty') is-invalid @enderror"
                                        id="total_purchase_qty" required>
                                    @error('total_purchase_qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col-md-3">
                                <label for="">Total Purchase Price</label>
                                <input disabled type="number" class="form-control"
                                    value="{{$purchaseOrder->total_purchase_amount}}" placeholder="0.00"
                                    name="total_price">
                            </div>

                            <div class="mb-3 col-md-3" id="challan_number_field" style="display: none;">
                                <div class="form-group">
                                    <label for="challan_number">challan Number</label>
                                    <input type="number" value="{{$purchaseOrder->challan_number}}" min="1" placeholder="Challan number..." class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=" bordered">
                        <h4>Purchase Items</h4>
                    </div>
                    <div class="card-body">
                        <div id="tableContainer">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>product Name</th>
                                        {{-- <th>product Code</th> --}}
                                        {{-- <th>Brand</th> --}}
                                        {{-- <th>Category</th> --}}
                                        {{-- <th>Published Price</th> --}}
                                        <th>Purchase Qty</th>
                                        <th>Purchase Price</th>
                                        <th>Retail Price</th>
                                        <th>Whole Sell Price</th>
                                        <th>Min Whole Sell Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="productTableBody">
                                    @foreach ($purchaseOrder->purchaseOrderChildren as $child)

                                    <input name="product_ids[]" value="{{ $child->itemInfo->id}}" type="hidden">
                                    <input name="purchase_qty[]" value="{{ $child->purchase_qty}}" type="hidden">

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $child->itemInfo->name.' '.$child->itemInfo->strength.' '.$child->itemInfo->description.' '.$child->itemInfo->brand.' '.$child->itemInfo->manufacturer }}" disabled>
                                        </td>
                                        {{-- <td style="width: 14%">
                                            <input type="text" class="form-control" value="{{ $child->itemInfo->sub_title ?? 'N/A' }}" disabled>
                                        </td> --}}
                                        <td style="width: 10%">
                                            <input type="text" class="form-control" value="{{ $child->purchase_qty }}" disabled>
                                        </td>
                                        <td style="width: 13%"><input name="purchase_price[]" type="text" class="form-control" value="{{ $child->purchase_price }}">
                                        <td style="width: 13%"><input name="sell_price[]" type="text" class="form-control" value="{{ $child->sell_price }}">
                                        </td>
                                        <td style="width: 10%"><input name="whole_sale_price[]" type="text" class="form-control" value="{{ $child->whole_sale_price }}"></td>
                                        <td style="width: 10%"><input name="whole_sale_qty[]" type="text" class="form-control" value="{{ $child->whole_sale_qty }}"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="save_purchase_container" class="text-right">

                            <button type="submit" class="btn bg-success">Update</button>
                            <a type="button" class="btn bg-danger" href="{{ route('admin.purchase-orders.index') }}">Close</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.content -->


@endsection