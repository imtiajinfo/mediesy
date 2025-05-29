@extends('layouts.admin')
@section('title', 'Admin | sales')

@section('page-headder')
{{-- sales --}}
@endsection

@section('content')
<style>
    .invoice-info {
        font-size: 13px;
    }
    
</style>
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sales.index') }}">sales</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ url('admin/service-sales') }}" class="btn btn-info">
                Back
            </a>
            <a href="{{ route('admin.printServiceInvoice', $sell->id) }}" target="_blank" class="btn btn-warning">
                <i class="fa fa-print"></i>
                Print
            </a>
        </ol>
    </div>
</div>




<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable text-center" style="display: none;">
                        <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Success!! Record Saved Successfully! SMS Has been Sent!</strong>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="invoice p-4">
                <!-- Title row -->
                <div class="printableArea">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="page-header fw-bold mb-4">
                                <span style="color:darkorange">Spa</span> Superette
                            </h4>
                        </div>
                    </div>

                    <!-- Info row -->
                    <div class="row invoice-info">

                        <!-- Invoice Details -->
                        <div class="col-sm-5 invoice-info" style="line-height:1">
                            <p><b>Invoice:</b> #{{$sell->sale_code}}</p>
                            <p> <b>Date:</b> {{ date('d M, Y', strtotime($sell->sell_date)) }}</p>

                            <p><b>Sales Status:</b> {{$sell->sells_status == 1 ? 'Sells' : 'Processing';}} </p>
                            <p><b>Reference No.:</b> {{$sell->ref_no}}</p>
                        </div>

                        <!-- From -->
                        {{-- <div class="col-sm-3 invoice-col">
                            <p> <i>From</i></p>

                            <address style="line-height:.6">
                                <p>Khush Fashion Palace</p>
                                <p>AP: Ankali,</p>
                                <p>City: Belgaum</p>
                                <p>Phone: 8888888888,</p>
                                <p>Mobile: 9999999999</p>
                                <p>Email: admin@example.com</p>
                                <p>VAT Number: VAT123</p>
                            </address>
                        </div> --}}

                        <!-- Customer Details -->
                        <div class="col-sm-7 invoice-col text-right">
                            {{-- <div class="mb-3 d-print-none">
                                <select onchange="assignCourier(this)" class="form-control" style="width:100%">
                                    <option value="">--select courier--</option>

                                    <option value="1">
                                        Beer Inc</option>
                                    <option value="2">
                                        Bayer PLC</option>
                                    <option value="3">
                                        Corwin, Schmeler and Hilpert</option>
                                </select>
                            </div> --}}

                            <h5>Customer Details</h5>
                            <address style="line-height:1.5">
                                <strong>Customer Name: {{$sell->customername}}</strong><br>
                                Mobile: {{$sell->customerphone}}<br>
                                Email: {{ $sell->customeremail ? $sell->customeremail : 'No email available' }}

                                <br>Address: {{$sell->customeraddress}}
                            </address>
                        </div>

                    </div>
                    <!-- /.row -->

                    <div class="row mt-4 mb-0">
                        <div class="table-responsive">
                            <table class="table table-striped records_table table-bordered pb-0 mb-0">
                                <thead class="bg-gray-active">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th class="text-start">Product Name</th>
                                        <th class="text-start">Product Code</th>
                                        <th>Amount</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        {{-- <th>Sell Price (BDT)</th> --}}
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellItem as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td> <img src="{{ asset('uploads/products/'.$item->itemthumbnail) }}" alt="{{$item->itemthumbnail}}" width="30"></td>

                                        <td class="product-name text-start">
                                            <p>{{$item->itemname}}</p>
                                        </td>
                                        <td>{{$item->sub_title}}</td>
                                        <td>{{$item->sell_price}}</td>
                                        <td>{{$item->quantity}}</td>
                                        {{-- <td>{{$item->published_price}} TK.</td> --}}
                                        <td>{{$item->discount}}%</td>
                                        <td>{{$item->sub_total}}</td>
                                    </tr>
                                    @endforeach
                                <tfoot class="col-md-12 tfoot table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">Subtotal</td>
                                            <td class="text-right" style="font-size: 13px;">
                                                <h6><b id="subtotal_amt" name="subtotal_amt">{{$sell->grand_total}}</b></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">Collect Amount</td>
                                            <td class="text-right" style="font-size: 13px;">
                                                <h6><b id="otder_charges_amt" name="otder_charges_amt">{{$sell->paid}}</b></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">Due Amount</td>
                                            <td class="text-right" style="font-size: 13px;">
                                                <h6><b id="total_amt" name="total_amt">{{$sell->due}}</b></h6>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                            </tbody>
                            </table>

                            
                        </div>
                        <!-- /.col -->
                    </div>
                    {{-- <div class="row pt-0">
                        <div class="col-md-12 pt-4">
                            <div class="form-group">
                                <h6 class="box-title text-info fw-bold">Payments Information : </h6>
                                <table class="table table-hover table-bordered" style="width:100%" id="">
                                    <thead>
                                        <tr class="bg-purple">
                                            <th>#</th>
                                            <th>Transaction ID</th>
                                            <th>Payment Date</th>
                                            <th>Payment Type</th>
                                            <th>Payment Note</th>
                                            <th>total_payable_amount</th>
                                            <th>total_due_amount</th>
                                            <th>total_paid_amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $payment)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td class="">{{ $payment->txn_code }}</td>
                                            <td class="">{{ $payment->created_at->format('M d, Y h:i:s A') }}</td>
                                            <td class="">{{ $payment->payment_type }}</td>
                                            <td class="">{{ $payment->payment_note }}</td>
                                            <td class="">{{ $payment->total_payable_amount }}</td>
                                            <td class="">{{ $payment->total_due_amount }}</td>
                                            <td class="">{{ $payment->total_paid_amount }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- /.col -->
                    </div> --}}
                    <div class="row no-print py-3">
                        <div class="col-xs-12">


                            {{-- <a target="_blank" class="btn btn-info pointer" onclick="print_invoice(41)">
                                <i class="fa fa-file-text"></i>
                                POS Invoice
                            </a>

                            <a href="{{ route('admin.salesInvoice') }}" target="_blank" class="btn btn-info">
                            <i class="fa fa-file-pdf-o"></i>
                            Download PDF
                            </a> --}}

                        </div>
                    </div>
            </section>
            <!-- /.content -->
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- /.content -->
@endsection
