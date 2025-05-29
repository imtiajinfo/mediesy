@extends('layouts.admin')
@section('title', 'Admin | Category')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.categories.index') }}">New Sales</a></li>

        </ol>
    </div>
</div>
<style>
    .book-img img {
        width: 100px;
        height: 120px
    }

    .book-text-area p {
        font-size: 13px;
    }

    .book-list-wrapper {
        text-align: center
    }

    .book-info__content .fs-6 {
        font-size: 13px;
    }

    .bookListContainer .col-4:hover {
        border: 1px solid #999;

    }

    #loader {
        display: none;

    }

</style>


<div class="row">

    <div class="col-md-12 p-0">
        <div class="card bg-white">
            <div class="p-0">
                <div class="card border-0 p-3">
                    <div class="col-md-12">
                        <div class="box box-info ">
                            <form action="{{ route('admin.sales.store') }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                                @csrf
                                @method('POST')
                                <div class="box-body">
                                    <div class="form-group row">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label for="customer_id" class="control-label mb-0 pb-0">Customer<label class="text-danger">*</label></label>
                                            <div class="input-group mr-2">
                                                <div class="input-group">
                                                    <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" id="customer_id">
                                                        <option value="">Select Customer</option>
                                                        @foreach ($customers as $key => $customer)
                                                        <option value="{{ $customer->id }}">
                                                            {{ $customer->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('customer_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <label class="input-group-text" for="customer_id" data-bs-toggle="modal" data-bs-target="#addModal">
                                                        <i class="fa fa-plus"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="sell_date" class="control-label mb-0 pb-0">Sells Date<label class="text-danger">*</label></label>
                                                <input type="date" name="sell_date" class="form-control @error('sell_date') is-invalid @enderror" id="sell_date" placeholder="sell_date" value="{{ old('sell_date') }}">
                                                @error('sell_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="sell_status">Sells Status</label>
                                                <select name="sell_status" class="form-control @error('sell_status') is-invalid @enderror" id="sell_status">
                                                    <option value="">Select Sells Status</option>
                                                    <option value="1" {{ old('sell_status') == '1' ? 'selected' : '' }}>Final</option>
                                                    <option value="0">Quotation</option>
                                                </select>
                                                @error('sell_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label for="reference_no">Reference No.</label>
                                                <input type="text" name="reference_no" class="form-control @error('reference_no') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('reference_no') }}">
                                                @error('reference_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 float-end mx-auto">
                                            <div class="form-group">
                                                <label for="BarCodeFormInputGroup" onclick="scan()">Scan Bar-code: </label>
                                                <div class="input-group">
                                                    <label class="input-group-text" for="BarCodeFormInputGroup"><i class="fa fa-barcode"></i></label>
                                                    <input type="search" name="bar_code" value="" placeholder="Item name/Barcode/Itemcode" class="form-control" id="BarCodeFormInputGroup">
                                                </div>
                                                <span id="nfp"></span>
                                                <div class="spinner-border" role="status" id="loader">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card p-0">
                                            <div class="card-body">
                                                <table class="table table-hover shadow-none" id="itemTable">
                                                    <thead class="thead">
                                                        <tr class="bg-primary">
                                                            <th>SL</th>
                                                            <th style="min-width:35%">Item Name</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Discount(₹)</th>
                                                            <th>Tax Amount</th>
                                                            <th>Tax</th>
                                                            <th>Total Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="itemTableBody">
                                                        <tr class="bg-primary">
                                                            <td colspan="9" id="default">
                                                                <h4>Scan QR Code </h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-md-9 px-5">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 pr-5">
                                                <label for="">Other Charges </label>
                                                <div class="row">
                                                    <div class="col-5 pr-1">
                                                        <select name="other_charges" id="other_charges" class="form-control @error('other_charges') is-invalid @enderror">
                                                            <option>None</option>
                                                            <option data-tax="5.00" value="4" {{ old('other_charges') == 4 ? 'selected' : '' }}>Vat
                                                                5%</option>
                                                            <option data-tax="10.00" value="5">Tax 10%</option>
                                                            <option data-tax="18.00" value="6">Tax 18%</option>
                                                            <option data-tax="4.50" value="7">IGST 4.5%</option>
                                                            <option data-tax="4.50" value="8">SGST 4.5%</option>
                                                            <option data-tax="9.00" value="9">GST 9%</option>
                                                            <option data-tax="9.00" value="10">ISGT 9%</option>
                                                            <option data-tax="9.00" value="11">SGST 9%</option>
                                                            <option data-tax="18.00" value="12">GST 18%</option>
                                                            <option data-tax="0.00" value="13">None</option>
                                                        </select>
                                                        @error('other_charges')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-7 p-0">
                                                        <input type="number" class="form-control @error('others_charge_amount') is-invalid @enderror" id="others_charge_amount" value="{{ old('others_charge_amount') }}" name="others_charge_amount">
                                                    </div>
                                                    @error('others_charge_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 pl-5">
                                                <label for="">Discount On All </label>
                                                <div class="row">
                                                    <div class="col-4 pr-1">
                                                        <select name="discount_type_all" id="discount_type_all" class="form-control" onchange="updateDiscountToAllAmt()">
                                                            <option value="1">Percentage</option>
                                                            <option value="0">Amount</option>
                                                        </select>
                                                        @error('discount_type_all')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-8 p-0">
                                                        <input type="number" class="form-control" id="discount_all" value="0" name="discount" onchange="updateDiscountToAllAmt()">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="sales_note" class="col-sm-4 control-label">Note</label>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control text-left" id="sales_note" name="sales_note" value="{{ old('sales_note') }}"></textarea>
                                                        <span id="sales_note" style="display:none" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 p-4">
                                        <div class="row">
                                            <table class="col-md-12">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-right" style="font-size: 14px;">Total Product
                                                            Quantity: </th>
                                                        <th class="text-right" style="padding-left:10%;font-size: 14px;">
                                                            <b id="total_product_qty" class="total_product_qty" name="total_product_qty">0</b>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" style="font-size: 14px;">Subtotal:</th>
                                                        <th class="text-right" style="padding-left:10%;font-size: 14px;">
                                                            <b id="subtotal_amt" name="subtotal_amt" class="subtotal_amt">0.00</b>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" style="font-size: 14px;">Other Charges:
                                                        </th>
                                                        <th class="text-right" style="padding-left:10%;font-size: 14px;">
                                                            <b id="other_charges_amt" name="other_charges_amt">0.00</b>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" style="font-size: 14px;">Discount on
                                                            All:</th>
                                                        <!-- Display the calculated discount_to_all_amt -->
                                                        <th class="text-right" style="padding-left:10%;font-size: 14px;">
                                                            <b id="discount_to_all_amt" name="discount_to_all_amt">0.00</b>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" style="font-size: 14px;">Grand Total:
                                                        </th>
                                                        <th class="text-right" style="padding-left:10%;font-size: 14px;">
                                                            <b id="grand_total">0.00</b>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 ">
                                        <div class="col-sm-12">
                                            <div class="box-body ">
                                                <div class="col-md-12">
                                                    <h5 class="box-title text-warning">Previous Payments Information :
                                                    </h5>
                                                    <table class="table table-hover table-bordered" style="width:100%" id="payments_table">
                                                        <thead>
                                                            <tr class="bg-gray ">
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Payment Type</th>
                                                                <th>Payment Note</th>
                                                                <th>Payment</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="6" class="text-center text-bold">
                                                                    Payments Pending!!</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>

                                    <div class="col-xs-12 ">
                                        <div class="col-sm-12">
                                            <div class="box-body ">
                                                <div class="col-md-12 payments_div payments_div_">
                                                    <h5 class="box-title">Subtotal : </h5>
                                                    <div class="box box-solid border-top pt-3">
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-3 float-end">
                                                                    <div class="form-group">
                                                                        <label for="amount">Total Payable
                                                                            Amount</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="total_payable_amount" placeholder="total_payable_amount" class="form-control @error('total_payable_amount') is-invalid @enderror" id="total_payable_amount" readonly>
                                                                        </div>
                                                                        @error('total_payable_amount')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-3 float-end">
                                                                    <div class="form-group">
                                                                        <label for="paid_amount"> Paid
                                                                            Amount</label>
                                                                        <div class="input-group">
                                                                            <input type="number" name="paid_amount" placeholder="paid_amount" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount">
                                                                        </div>
                                                                        @error('paid_amount')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-3 col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="payment_type">Payment Type</label>
                                                                        <select name="payment_type" class="form-control @error('payment_type') is-invalid @enderror" id="payment_type">
                                                                            <option value="">--Select-Payment
                                                                                Type--</option>
                                                                            <option value="Cash" {{ old('payment_type') == 'Cash' ? 'selected' : '' }}>
                                                                                Cash</option>
                                                                            <option value="Card">Card</option>
                                                                            <option value="Paytm">Paytm</option>
                                                                            <option value="Finance">Finance</option>
                                                                        </select>
                                                                        @error('payment_type')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <label for="payment_note">Payment Note</label>
                                                                        <textarea type="text" class="form-control" id="payment_note" name="payment_note" placeholder="Payment note"></textarea>
                                                                        <span id="payment_note_msg" style="display:none" class="text-danger"></span>
                                                                    </div>
                                                                </div>
                                                                <!-- SMS Sender while saving -->
                                                                <div class="col-12 col-md-6 col-lg-3 mt-3">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="sent_sms" id="sent_sms" value="1" @if(old('sent_sms')) checked @endif>
                                                                        <label for="sent_sms">Send SMS To Customer</label>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- col-md-12 -->
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>


                                </div>

                                <!-- /.box-body -->
                                <div class="footer col-md-12 float-right text-right">
                                    <a href="{{ route('admin.sales.index') }}"> <button type="button" class="btn btn-lg bg-gray" title="Go back">Close</button>
                                        <button type="submit" id="save" class="btn btn-lg bg-warning payments_modal" title="Save Data">Save</button></a>
                                </div>


                            </form> <!-- OK END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- add modal --}}
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Add New Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-md-4">

                    <form method="POST" action="{{ route('admin.customers.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Customer Name..." id="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="prev_due">Previous Due</label>
                                    <input type="number" name="prev_due" class="form-control @error('prev_due') is-invalid @enderror" placeholder="Previous Due..." id="prev_due" value="{{ old('prev_due') }}" required>
                                    @error('prev_due')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="gst_number">GST Number</label>
                                    <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" placeholder="Enter GST Number" id="gst_number" value="{{ old('gst_number') }}" required>
                                    @error('gst_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="tax_number">TAX Number</label>
                                    <input type="text" name="tax_number" class="form-control @error('tax_number') is-invalid @enderror" placeholder="Enter TAX Number..." id="tax_number" value="{{ old('tax_number') }}" required>
                                    @error('tax_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="country" class="form-control @error('country') is-invalid @enderror" placeholder="" id="country">
                                        <option value="">Select Country</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('country') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_english }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select name="state" class="form-control @error('state') is-invalid @enderror" placeholder="Enter State.." id="state">
                                        <option value="">Select State</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('state') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_english }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City..." id="city" value="{{ old('city') }}" required>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input postcode="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror" placeholder="Enter Postcode..." id="postcode" value="{{ old('postcode') }}">
                                    @error('postcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- 'previous_due' => $request->previous_due, --}}

                            <div class="mb-3 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address..." id="address">{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="status">Status</label>
                                <input type="checkbox" name="status" id="status" value="1" @if (old('status')) checked @endif>
                            </div> --}}
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>



                    {{-- <div class="mb-3 text-right">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-warning">Save</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- add modal --}}
    <div class="modal fade p--4" id="taxModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="taxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="taxModalLabel">Discout & TAX Setup</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-md-4">

                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <label for="">Item Name : Redmi Pro 7 Mobile</label>
                            <div class="col-md-12">
                                <label for="">Other Charges </label>
                                <div class="row">
                                    <div class="col-4 pr-1">
                                        <select name="other_charges" id="other_charge" class="form-control">
                                            <option>None</option>
                                            <option data-tax="5.00" value="4">Vat 5%</option>
                                            <option data-tax="10.00" value="5">Tax 10%</option>
                                            <option data-tax="18.00" value="6">Tax 18%</option>
                                            <option data-tax="4.50" value="7">IGST 4.5%</option>
                                            <option data-tax="4.50" value="8">SGST 4.5%</option>
                                            <option data-tax="9.00" value="9">GST 9%</option>
                                            <option data-tax="9.00" value="10">ISGT 9%</option>
                                            <option data-tax="9.00" value="11">SGST 9%</option>
                                            <option data-tax="18.00" value="12">GST 18%</option>
                                            <option data-tax="0.00" value="13">None</option>
                                        </select>
                                    </div>
                                    <div class="col-8 p-0">
                                        <input type="number" class="form-control" id="item_discount" value="0" name="discount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="">Discount On All </label>
                                <div class="row">
                                    <div class="col-4 pr-1">
                                        <select name="discount_type_all_row" id="discount_type_all_row" class="form-control">
                                            <option value="1">Percentage</option>
                                            <option value="0">Amount</option>
                                        </select>
                                        @error('discount_type_all_row')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-8 p-0">
                                        <input type="number" class="form-control" id="discount" value="0" name="discount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sales_note" class="col-sm-4 control-label">descriptionn</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control text-left" id="sales_note" name="sales_note"></textarea>
                                        <span id="sales_note_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 text-right">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.content -->
@endsection
@push('.js')
<!-- Include Axios library if not already included -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentDate = new Date().toISOString().split('T')[0];
        // Set the value of the input field to the current date
        document.getElementById('sell_date').value = currentDate;

        const searchInput = document.querySelector('#BarCodeFormInputGroup');
        const apiUrl = '/admin/newsales/getItemByBarcode'; // Change the URL to match your route
        const itemTableBody = document.querySelector('#itemTableBody');
        const loader = document.querySelector('#loader'); // Add loader element
        let itemCounter = 1; // Counter to keep track of item number
        var defaultRow = document.getElementById("default").parentElement;

        searchInput.addEventListener('input', function() {
            const barcode = searchInput.value;
            // Show loader
            loader.style.display = 'block';
            console.log('Barcode input:', barcode);
            axios.post(apiUrl, {
                    barcode
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    , }
                , })
                .then(async response => {
                    const data = await response;

                    setTimeout(() => {
                        loader.style.display = 'none';

                        // Hide the element with ID 'notfound'
                        nfp.style.display = 'none';

                        // Handle the response data here
                        const item = response.data;
                        // Clear existing rows 
                        // Check if an item is found
                        if (item && item.data) {
                            //defaultRow.style = "display:none";
                            defaultRow.remove();
                            //console.log(item.data.id);
                            // console.log(item);
                            // console.log(item.messsage);
                            const existingRow = findExistingRow(item.data.id);
                            console.log(existingRow);
                            if (existingRow) {
                                // Increment the quantity of the existing row
                                const quantityInput = existingRow.querySelector('[name="product_qty[]"]');
                                const quantityValue = parseInt(quantityInput.value);
                                const newQuantity = quantityValue + parseInt(item.data.min_qty);

                                // Update the quantity in the existing row
                                quantityInput.value = newQuantity;
                                updateTotalAmount(existingRow);
                            } else {
                                // Append a new row with item data
                                const newRow = document.createElement('tr');
                                newRow.innerHTML = `
                                <td>${itemCounter}</td>
                                <td><input type="hidden" name="product_id[]" value="${item.data.id}"><input type="text" name="product_name" value="${item.data.name}" placeholder="name" class="form-control"></td>
                                <td><input type="number" name="product_qty[]" value="${item.data.min_qty}" min="${item.data.min_qty}" max="200" placeholder="Quantity" class="form-control qty" onchange="updateTotalAmount(this.parentElement.parentElement)"></td>
                                <td><input type="number" name="product_sell_price" value="${item.data.sell_price}" placeholder="sell_price" class="form-control sell_price" disabled=""></td>
                                <td><input type="number" name="product_discount" value="${item.data.discount}" placeholder="discount" class="form-control btn product_discount" data-bs-toggle="modal" data-bs-target="#taxModal" onchange="updateTotalAmount(this.parentElement)"></td>
                                <td> <input type="number" name="product_tax_amount" value="${item.data.tax_amount !== null ? item.data.tax_amount : "0.00"}" placeholder="tax_amount" class="form-control product_tax_amount" disabled></td>
                                <td> <input type="number" name="product_tax" value="${item.data.tax}" class="form-control btn" data-bs-toggle="modal" data-bs-target="#taxModal"></td> 
                                <td> <input type="number" class="form-control total_amount" name="product_total_amount" value="${(item.data.min_qty * item.data.sell_price)}"></td> 
                                <td><button type="button" class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash-can"></i></button></td>`;
                                itemTableBody.appendChild(newRow);
                                itemCounter++; // Increment the item counter

                                updateTotalAmount(newRow);
                                // Reset the input box value 
                            }
                            searchInput.value = '';

                        } else {
                            if (barcode != ' ') {
                                document.querySelector('#nfp').style.display = 'block';
                                const nfp = document.querySelector('#nfp')
                                nfp.innerHTML =
                                    `<span id="notfound"><h6> <span class="text-danger">${barcode}</span> Not found !</h6></span> `;
                                nfp.append(nfp);
                            }
                        }
                    }, 200);
                })
                .catch(error => {
                    console.error(error);
                });
        });

        function findExistingRow(productId) {
            // Find and return the existing row with the specified product ID
            const rows = itemTableBody.querySelectorAll('tr');
            for (const row of rows) {
                const productIdInput = row.querySelector('[name="product_id[]"]');
                console.log(`Row: ${row.outerHTML}, ProductID: ${productIdInput ? productIdInput.value : 'Not found'}`);
                if (productIdInput && productIdInput.value === String(productId)) {
                    return row;
                }
            }
            return null;
        }

        function getQuantityFromRow(row) {
            // Create a temporary element to parse the HTML content
            const tempElement = document.createElement('div');
            tempElement.innerHTML = row.outerHTML;

            // Query the temporary element for the product_qty value
            const quantityInput = tempElement.querySelector('[name="product_qty[]"]');
            return quantityInput ? quantityInput.value : null;
        }

    });


    document.addEventListener("DOMContentLoaded", function() {
        const otherChargesDropdown = document.querySelector('#other_charges');
        const otherChargesAmt = document.getElementById('other_charges_amt');

        otherChargesDropdown.addEventListener('change', function() {
            const selectedOption = otherChargesDropdown.options[otherChargesDropdown.selectedIndex];
            const taxRate = parseFloat(selectedOption.getAttribute('data-tax')) || 0;

            const otherChargesValue = parseFloat(otherChargesDropdown.value) || 0;
            const calculatedAmount = (otherChargesValue * taxRate) / 100;

            // Update the other_charges_amt value
            otherChargesAmt.innerHTML = calculatedAmount.toFixed(2);
        });
    });

    function updateDiscountToAllAmt() {
        var discountType = document.getElementById('discount_type_all').value;
        var discountValue = parseFloat(document.getElementById('discount').value) || 0;

        var subtotalAmt = parseFloat(document.getElementById('subtotal_amt').textContent) || 0;
        var discountToAllAmtElement = document.getElementById('discount_to_all_amt');

        if (discountType == 1) {
            // Percentage discount
            var calculatedDiscount = (subtotalAmt * discountValue) / 100;
            discountToAllAmtElement.textContent = calculatedDiscount.toFixed(2);
        } else {
            // Amount discount
            discountToAllAmtElement.textContent = discountValue.toFixed(2);
        }
    }



    function deleteRow(button) {
        // Get the row that contains the clicked button
        var row = button.parentNode.parentNode;
        // Get the reference to the table
        var table = document.getElementById("itemTable");

        // Delete the row
        table.deleteRow(row.rowIndex);
        updateSummary();
    }


    document.addEventListener('DOMContentLoaded', function() {
        const showEntriesDropdown = document.getElementById('show-entries');
        const showingEntries = document.querySelectorAll('#showing-entries');
        const totalEntries = document.getElementById('total-entries');

        showEntriesDropdown.addEventListener('change', function() {
            const selectedValue = this.value;
            axios.get(`/admin/categories?show=${selectedValue}`)
                .then(response => {
                    // Update the number of displayed entries
                    showingEntries.forEach(span => {
                        span.textContent = response.data.showing;
                        //   console.log(response.data);
                    });
                    // Update the total number of entries
                    totalEntries.textContent = response.data.total;
                })
                .catch(error => {
                    console.error(error);

                });
        });
    });


    //set qty
    // Function to update the total amount for a row
    function updateTotalAmount(row) {
        var qty = parseFloat(row.querySelector('.qty').value);
        var sellPrice = parseFloat(row.querySelector('.sell_price').value);
        var discount = parseFloat(row.querySelector('.product_discount').value);
        var tax_amount = parseFloat(row.querySelector('.product_tax_amount').value);

        // Calculate the total amount for the row
        var total_discout = qty * discount; // qty icrement then 
        var total_tax_amount = qty * tax_amount; // qty icrement then 
        var totalAmount = (qty * sellPrice) - total_discout + total_tax_amount;
        //alert(totalAmount);
        // Update the total amount input field in the row
        row.querySelector('.total_amount').value = totalAmount.toFixed(2);
        row.querySelector('.qty').value = qty.toFixed(2);

        // Trigger a recalculation of the summary table
        updateSummary();
        //updateQuantity();
    }

    // Function to update the summary table
    function updateSummary() {
        var subtotal = 0;
        var total_qty = 0;
        var gradtotal = 0;

        // Loop through each row in the item table
        document.querySelectorAll('#itemTableBody tr').forEach(function(row, index) {
            //  console.log(row);
            //  console.log(index);

            const totalAmount = parseFloat(row.querySelector('.total_amount').value) || 0;
            //console.log(totalAmount);
            subtotal += totalAmount;


            const totalProductQty = parseFloat(row.querySelector('.qty').value) || 0;
            // console.log(totalProductQty);
            total_qty += totalProductQty;

            const other_crg_amt = parseFloat(document.getElementById('other_charges_amt').value) || 0;
            const discount_all_amt = parseFloat(document.getElementById('discount_to_all_amt').value) || 0;
            var gradtotalAmount = (subtotal + other_crg_amt) - discount_all_amt;
            //  console.log(gradtotalAmount);
            gradtotal = gradtotalAmount;
        });
        // Update the subtotal in the summary table
        document.getElementById('subtotal_amt').textContent = subtotal.toFixed(2);
        // Update the subtotal in the qty table
        document.getElementById('total_product_qty').textContent = total_qty.toFixed(2);

        document.getElementById('grand_total').textContent = gradtotal.toFixed(2);
        document.getElementById('total_payable_amount').value = gradtotal.toFixed(2);
        document.getElementById('paid_amount').value = gradtotal.toFixed(2);
        // ... Add logic to update other fields in the summary table as needed
    }


    //scan bar code demo
    function scan() {
        var demoBarcode = 'ITM10004';
        // Update the subtotal in the summary table
        document.getElementById('BarCodeFormInputGroup').value = demoBarcode;
        // console.log(demoBarcode);
    }

    // body.addclass('sidebar-collapse');

</script>
{{-- জক্সিং --}}

{{-- composer require ibra/motion-barcode-scanner    laravel   --}}
<script src="https://cdn.rawgit.com/zxing-js/library/gh-pages/0.17.1/dist/zxing.min.js"></script>

<script>
    function startBarcodeScanner() {
        const codeReader = new ZXing.BrowserBarcodeReader();

        codeReader.decodeFromInputVideoDevice(undefined, 'video').then((result) => {
            document.getElementById('BarCodeFormInputGroup').value = result.text;
            codeReader.reset();
            startBarcodeScanner(); // Continue scanning for the next barcode
        }).catch((err) => {
            console.error(err);
        });
    }

    // Start the barcode scanner when the page loads
    document.addEventListener('DOMContentLoaded', startBarcodeScanner);

</script>
@endpush
