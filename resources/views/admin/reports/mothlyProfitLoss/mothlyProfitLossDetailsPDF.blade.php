<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $to_date . $from_date }}</title>
    <style type="text/css">
        @page {
            header: page-header;
            footer: page-footer;
            margin-bottom: 35mm;

        }

        body {
            font-family: 'Nikosh';

        }

        .m-0 {

            margin: 0px;

        }

        .p-0 {

            padding: 20px;

        }

        .pt-5 {

            padding-top: 5px;

        }

        .mt-10 {

            margin-top: 0px;

        }

        .text-center {

            text-align: center !important;

        }

        .w-100 {

            width: 100%;

        }

        .w-50 {

            width: 50%;

        }

        .w-85 {

            width: 85%;

        }

        .w-15 {

            width: 15%;

        }

        .logo2 img {

            width: 75px;

            height: 75px;

            padding-top: 30px;

        }

        .logo span {

            margin-left: 8px;

            top: 19px;

            position: absolute;

            font-weight: bold;

            font-size: 25px;

        }


        .gray-color {

            color: #5D5D5D;

        }

        .text-bold {

            font-weight: bold;

        }

        .border {

            border: 1px solid black;

        }

        table tr,
        th,
        td {

            border: 1px solid rgb(46, 46, 46);

            border-collapse: collapse;

            padding: 7px 8px;

        }

        table tr th {

            background: #027386;

            font-size: 12px;
        }

        table tr td {
            font-size: 11px;
            padding: 3px 3px;
        }

        table {
            border-collapse: collapse;
            float: left;
            margin-right: 5px;
            margin-left: 5px;
            margin-bottom: 5px;
        }

        .box-text p {
            line-height: 10px;
        }

        .float-left {

            float: left;

        }

        .float-left {

            float: right;

        }

        .total-part {

            font-size: 16px;

            line-height: 12px;

        }

        .total-right p {

            padding-right: 20px;

        }

        .head-middle {
            font-size: 10px;
            color: red;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .logo {
            width: 275px;
            /*margin-left: 365px;*/
            margin-top: 10px;
        }

        .logopdf {
            width: 55px;
            /*margin-left: 365px;*/
            /* margin-top: 10px; */
        }

        .column1 {
            float: right;
            width: 20%;
            margin-top: -220px;
        }

        .columne {
            float: right;
            width: 50%;
            margin-top: -100px;
            margin-left: 180px;
        }

        .column5 {
            float: right;
            width: 50%;
            margin-top: -70px;
        }

        .column1 {
            float: left;
            width: 20%;
            padding-top: 10px;
        }

        .column2 {
            float: left;
            width: 66.66%;
        }

        .column3 {
            float: left;
            width: 64%;
            padding-top: 10px;
        }

        .columntest {
            float: left;
            width: 15%;
            padding-top: 10px;
        }

        .column4 {
            float: left;
            width: 80%;
        }

        .columncode {
            float: left;
            width: 20%;
            padding-top: -30px;
        }

        .columncodezit {
            float: left;
            width: 6%;
            padding-bottom: -10px;

        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .right_head {
            text-align: center;
            padding: 5px;
            font-weight: bold;
            margin-top: 75px;
        }

        .sr_no {
            width: 3%;
        }

        .logo {
            width: 275px;
            /*margin-left: 365px;*/
            margin-top: 5px;
            text-align: right;
        }

        .head_font {
            font-size: 13px;
            line-height: 13px;
        }

        .head_middle {
            text-align: center;
        }


        .columnmid {
            float: left;
            width: 20%;
            padding-top: -23px;
        }

        .columnzit {
            float: right;
            width: 15%;
            height: 2rem;
            padding-bottom: 40px;
        }

        .column1 {
            float: left;
            width: 20%;
            height: 2rem;
            padding-top: 10px;
        }

        .col-md-6 {
            padding-bottom: 70px;
        }

        .col-md-5 {
            padding-bottom: -50px;
        }
    </style>
</head>

<body>
    <div class="row" style="none">
        <div class="column1" style="text-align: center; padding-top:25px;">
            <img src="{{ public_path('backend/dist/img/dms.png') }}" alt="Logo">
        </div>
        <div class="column3">
            <div class="head_middle">
                <div style="text-align: center; padding-top:-8px;">
                    <p style="font-size: 13pt;">
                        <strong> Profit/Loss Report</strong>
                    </p>
                </div>
                <div style="text-align: center; padding-top:-35px; font-size: 11pt;">
                    <p><strong>Grocery Shop<strong>
                    </p>
                </div>
                <div style="text-align: center; padding-top:-32px; font-size: 11pt;">
                    <p><strong>Dhaka</strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="columntest">
            <p style="text-align: right; font-size:12px;">9B#B_05E1</p>
        </div>
    </div>
    <div style="margin-left:5px; margin-top:20px; display:block;">

        <div class="report_params_areas" style="float:left;height:20px;width:50%">
            <span style="text-align: right; font-size:12px"><b> From Date:
                </b>{{ Date('d-m-Y', strtotime(request('from_date'))) }}</span>
        </div>
        <div class="report_params_areas" style="float:right;height:20px;width:45%;text-align:right;margin-right:5px;">
            <span style="text-align: right; font-size:12px"><strong>Print: </strong>{{ Date('d-m-Y h:i:s A') }}</span>
        </div>
        <div class="report_params_areas" style="float:left;height:20px;width:100%">
            <span style="text-align: right; font-size:12px"><b> To Date:
                </b>{{ Date('d-m-Y', strtotime(request('to_date'))) }}</span>
            <br>
        </div>

        <div class="report_params_areas" style="float:left;height:20px;width:100%">

            @if (isset($totalIncome) || isset($totalExpense) || isset($netProfitLoss))

                <p style="text-align: left; font-size:12px">
                    <b>Total Income:</b> {{ number_format($totalIncome, 2, '.', ',') }} TK.
                </p>
                <p style="text-align: left; font-size:12px">
                    <b>Total Purchase:</b> {{ number_format($purchaseOrders, 2, '.', ',') }} TK.
                </p>
                <p style="text-align: left; font-size:12px">
                    <b>Total Expense:</b> {{ number_format($totalExpense, 2, '.', ',') }} TK.
                </p>
                <p style="text-align: left; font-size:12px">
                    <b>Net Profit Loss:</b> {{ number_format($netProfitLoss, 2, '.', ',') }} TK.
                </p>
                @if ($from_date && $to_date)
                @endif
            @endif
        </div>
    </div>


    <div style="display:block; margin-top:6;">

        @if (isset($DailyExpenses) || isset($AllpurchaseOrders) || isset($Allsales))


            @if (isset($DailyExpenses))
                <h5>DailyExpenses Information</h5>
                {{-- <p class="pb-0 mb-0"><strong>Supplier Name:</strong> {{ $DailyExpenses->name }}</p> --}}
                @if (isset($DailyExpenses) && count($DailyExpenses) > 0)
                    <div class="card table-responsive border-0 mt-2" style="box-shadow:none !important; ">
                        <div class="row">
                            <table id="example1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Expense Name</th>
                                        <th>Expense Group</th>
                                        <th>Company</th>
                                        <th>Store</th>
                                        <th>Expense Date</th>
                                        <th>Amount</th>
                                        <th>Approved Status</th>
                                    </tr>
                                </thead>
                                <tbody id="datatable">
                                    @foreach ($DailyExpenses as $key => $expense)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $expense->expense_name }}</td>
                                            <td>{{ $expense->expense_group }}</td>
                                            <td>{{ $expense->company }}</td>
                                            <td>{{ $expense->store }}</td>
                                            <td>{{ $expense->expense_date }}</td>
                                            <td>{{ $expense->amount }} </td>
                                            <td>{{ $expense->approved_status }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td style="text-align: right;" colspan="6"><strong>Total: </strong></td>
                                    <td style="text-align: right;">
                                        <strong>{{ number_format($DailyExpenses->sum('amount'), 2, '.', ',') }}
                                            TK.</strong>
                                    </td>
                                    <td style="text-align: right;">
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{-- <x-pagination :pagination="$orders" /> --}}
                            </div>
                        </div>
                    </div>
                @else
                    <h4 class="text-center py-5">No Data available</h4>
                @endif
            @endif


            @if (isset($AllpurchaseOrders))
                <h5>AllpurchaseOrders Information</h5>
                {{-- <p class="pb-0 mb-0"><strong>Supplier Name:</strong> {{ $DailyExpenses->name }}</p> --}}
                @if (isset($AllpurchaseOrders) && count($AllpurchaseOrders) > 0)
                    <div class="card table-responsive border-0 mt-2" style="box-shadow:none !important; ">
                        <div class="row">
                            <table id="example1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Supplier</th>
                                        <th>Total Purchase Quantity</th>
                                        <th>Total Receved Quantity</th>
                                        <th>Total Purchase Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="datatable">
                                    @forelse ($AllpurchaseOrders as $key => $purchaseOrder)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $purchaseOrder->supplier_name ?? 'N/A' }}</td>
                                            <td>{{ $purchaseOrder->total_purchase_qty }}</td>
                                            <td>{{ $purchaseOrder->total_received_qty }}</td>
                                            <td>{{ $purchaseOrder->total_purchase_amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td style="text-align: right;" colspan="4"><strong>Total: </strong></td>
                                    <td style="text-align: right;">
                                        <strong>{{ number_format($AllpurchaseOrders->sum('total_purchase_amount'), 2, '.', ',') }}
                                            TK.</strong>
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{-- <x-pagination :pagination="$orders" /> --}}
                            </div>
                        </div>
                    </div>
                @else
                    <h4 class="text-center py-5">No Data available</h4>
                @endif
            @endif




            @if (isset($Allsales))
                <h5>Allsales Information</h5>
                {{-- <p class="pb-0 mb-0"><strong>Supplier Name:</strong> {{ $Allsales->name }}</p> --}}
                @if (isset($Allsales) && count($Allsales) > 0)
                    <div class="card table-responsive border-0 mt-2" style="box-shadow:none !important; ">
                        <div class="row">
                            <table id="example1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S/L</th>
                                        <th>Sales Code</th>
                                        <th>Sales Date</th>
                                        <th>Customer Name</th>
                                        <th>Reference No.</th>
                                        <th>Total</th>
                                        <th>Paid Payment</th>
                                        <th>Due Payment</th>
                                    </tr>
                                </thead>


                                <tbody id="datatable">
                                    @foreach ($Allsales as $key => $sale)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $sale->sale_code }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y h:i A') }}
                                            </td>
                                            <td>{{ $sale->customer->name }}</td>
                                            <td>{{ $sale->ref_no }}</td>
                                            <td>{{ number_format($sale->payable, 2) }}</td>
                                            @foreach ($sale->payments as $payment)
                                                <td>{{ number_format($payment->total_paid_amount, 2) }}</td>
                                            @endforeach
                                            @foreach ($sale->payments as $payment)
                                                <td>
                                                    @php
                                                        $statusText = $payment->total_due_amount === 0.0 ? 'All Paid' : number_format($payment->total_due_amount, 2);
                                                    @endphp
                                                    <span>{{ $statusText }}</span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td style="text-align: right;" colspan="6"><strong>Total: </strong></td>
                                    <td style="text-align: right;">
                                        <strong>{{ number_format($Allsales->sum('payable'), 2, '.', ',') }}
                                            TK.</strong>
                                    </td>
                                    <td style="text-align: right;">

                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{-- <x-pagination :pagination="$orders" /> --}}
                            </div>
                        </div>
                    </div>
                @else
                    <h4 class="text-center py-5">No Data available</h4>
                @endif
            @endif
        @else
            <h4 class="text-center py-5">Search Your Result.</h4>
        @endif

    </div>
    <htmlpagefooter name="page-footer">
        <div class="col-md-5">
            <p style="text-align: left;font-size: 12px;">{PAGENO} of {nbpg} pages</p>
        </div>
        <div class="col-md-6">
            <p style="text-align: right; font-size: 14px;"><span><strong>Grocery Shop </strong><span><br>
                        <span style="font-size: 12px;">A product of</span><span
                            style="font-size:14px; color:rgb(235,31,40); "><strong> DeveloperTest</strong></span>
            </p>
        </div>
    </htmlpagefooter>

</html>
