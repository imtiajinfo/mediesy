@extends('layouts.admin')
@section('title', 'Admin | Purchase Return')

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.purchase-return.index') }}">Purchase Return</a>
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
            <h4 class="card-title float-left pt-2">Purchase Return</h4>
        </div>
        <div class="container p-4 pt-0 pb-0">
            

            <div class="row">
                <div class="card mt-2 pt-1 mb-3 pb-3">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="invoice-no">Invoice No</label>
                                        <div class="input-group mr-2">
                                            <input type="text" class="form-control" id="invoice-no" value="{{@$invoice_no}}" name="invoice_no" placeholder="Enter Invoice No">
                                            <button id="search-btn" class="btn btn-success" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('admin.purchase-return.store') }}" enctype="multipart/form-data" id="return-form">

                        <div class="row">
                            @csrf

                            
                            @if(!empty($purchase_return))
                            <input type="hidden" name="id" value="{{$purchase_return->id}}">
                            <input type="hidden" name="supplier_id" value="{{@$purchase_return->supplier->id??'0'}}">
                            <input type="hidden" name="invoice_no" value="{{@$invoice_no}}">

                            <div class="col-md-6">
                                <label for="customer_id">Customer Name</label>
                                <div class="input-group mr-2">
                                    <select disabled name="customer_id"
                                        class="form-control"
                                        id="customer" data-live-search="true" required>
                                        <option value="{{@$purchase_return->supplier->id??'0'}}">{{@$purchase_return->supplier->name??"Guest"}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="">Purchase Date</label>
                                <input type="date" class="form-control" id="po_date" value="{{date('Y-m-d', strtotime(($purchase_return->po_date)))}}" name="sell_date" disabled>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="purchased_by">Purchase By</label>
                                    <select name="sell_by" class="form-control" disabled>
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">

                                    <div class="mb-3 col-md-3">
                                        <label for="return-date">Return Date</label>
                                        <input type="date" class="form-control" id="return-date" name="return_date">
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label for="">Return Type</label>
                                        <select name="return_type" required class="form-control select2">
                                            <option value="">Select Type</option>
                                            @foreach ($return_category as $item)
                                                <option value="{{$item->id}}">{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="note">Note</label>
                                        <input type="text" class="form-control" id="note" name="note" placeholder="Note">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div id="tableContainer" style="max-height: 490px;overflow-y:scroll">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Sl</th>
                                        <th>product Name</th>
                                        <th class="text-start">Product Code</th>
                                        <th class="text-start">Amount</th>
                                        <th class="text-start">Av.Purchase Qty</th>
                                        <th class="text-start">Return Qty</th>
                                        <th class="text-start">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($purchase_return->purchaseOrderChildren))
                                        
                                        @foreach ($purchase_return->purchaseOrderChildren as $key => $child)

                                            <input name="product_ids[]" value="{{ $child->itemInfo->id}}" type="hidden">
                                            <input name="child_id[]" value="{{ $child->id}}" type="hidden">
                                            <input name="purchase_price[]" value="{{ $child->purchase_price}}" type="hidden">

                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $child->itemInfo->name ?? 'N/A' }}" disabled>
                                                </td>
                                                <td style="width: 14%">
                                                    <input type="text" class="form-control" value="{{ $child->itemInfo->sub_title ?? 'N/A' }}" disabled>
                                                </td>
                                                <td style="width: 13%"><input name="purchase_price[]" type="text" class="form-control" value="{{ $child->purchase_price }}" disabled>
                                                <td style="width: 13%"><input name="purchase_qty[]" type="text" class="form-control" value="{{ $child->purchase_qty - $child->return_qty}}" disabled>
                                                </td>
                                                <td style="width: 10%" class="return_qty">
                                                    <span style="display: none" class="current-stock-err"><span class="text-danger"><b>Out of Stock</b></span><input type="hidden" value="1"></span>
                                                    <input name="return_qty[]" type="text" class="form-control return-qty" value="0">
                                                </td>
                                                <td style="width: 10%"><input name="sub_total[]" type="text" class="form-control sub_total" value="00.00" disabled></td>
                                            </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                        </div>


                        
                        
                        @if(!empty($purchase_return))

                        <div class="row justify-content-end">
                            <div class="col-md-3">
                                <label for="customer_id">Total Amount</label>
                                <div class="input-group mr-2">
                                    <input type="text" class="form-control" id="total_price" name="total_price" readonly value="00.00">
                                </div>
                            </div>
                        </div>

                        <div id="save_purchase_container" class="text-right mt-4 mb-3">
                            <button id="save_purchase" class="btn btn-md btn-success" disabled>Submit</button>
                            <a href="/admin/purchase-return" class="btn btn-md btn-primary">Back To List</a>
                        </div>
                        @endif

                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- /.content -->

@endsection
@push('.js')

<script>
    @if(!empty($purchase_return))

    var productSl = 0;
    podate();

    function podate(){
        document.getElementById('return-date').valueAsDate = new Date();
    }

    function checkAvailbleQty() {
        var issue_qty = document.querySelectorAll('input[name="return_qty[]"]');

        var totalQty = 0;
        issue_qty.forEach(function (input) {
            totalQty += parseInt(input.value) || 0;
        });

        if (totalQty <= 0) {
            $("#save_purchase").attr('disabled', true);
        } else {
            $("#save_purchase").attr('disabled', false);
        }

    }

    function updateTotalReturnPrice() {
        var purchasePriceElements = document.querySelectorAll('[name="sub_total[]"]');
        var totalPriceInput = document.getElementById('total_price');
        var total = 0;
        purchasePriceElements.forEach(function (priceElement, index) {
            var purchasePrice = parseFloat(priceElement.value || 0); // Get purchase price
            var subtotal = purchasePrice; // Calculate subtotal for the current row
            total += subtotal; // Add subtotal to total
        });

        totalPriceInput.value = total.toFixed(2); // Update total purchase price input field
    }


    $(document).on('keyup', '.return-qty', function (e) {
        let qty = $(this).val()??0;
        let price = ($(this).parent().parent().find('[name="purchase_price[]"').val())??0;
        let available_qty = ($(this).parent().parent().find('[name="purchase_qty[]"').val())??0;
        
        let sub_total = 0;
        sub_total = price * qty;

        $(this).parent().parent().find('.sub_total').val(sub_total.toFixed(2));

        if (Number(available_qty) < Number(qty)) {
            $(this).parent().parent().find('.current-stock-err').show();
            $("#save_purchase").attr('disabled', true);
            return;
        } else {
            $(this).parent().parent().find('.current-stock-err').hide();
            $("#save_purchase").attr('disabled', false);
        }

        updateTotalReturnPrice();
        checkAvailbleQty();

    })


    @endif

</script>

@endpush