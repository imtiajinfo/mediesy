<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data->name }}</title>
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
                    <p style="font-size: 16pt;">
                        <strong> Warrenty Card</strong>
                    </p>
                </div>
                <div style="text-align: center; padding-top:-35px; font-size: 11pt;">
                    <p>Riyat Automobiles </p>
                </div>
                <div style="text-align: center; padding-top:-32px; font-size: 11pt;">
                    <p>Gulsan, Dhaka </p>
                </div>
            </div>
        </div>
        <div class="columntest">
            <h6 style="text-align: right; font-size:12px; color:#016C62;font-weight: bold;">Warrenty ID: {{$data->id}}</h6>
        </div>
    </div>
    <div style="margin-left:5px; margin-top:20px; display:block;">

        <div class="report_params_areas" style="float:left;height:20px;width:50%">
            <span style="text-align: right; font-size:12px"><b> Start Date:
                </b>{{ date('d-M-Y', strtotime($data->start_date)) }}</span>
        </div>
        <div class="report_params_areas" style="float:right;height:20px;width:45%;text-align:right;margin-right:5px;">
            <span style="text-align: right; font-size:12px"><strong>Print: </strong>{{ Date('d-m-Y h:i:s A') }}</span>
        </div>
        <div class="report_params_areas" style="float:left;height:20px;width:45%">
            <span style="text-align: right; font-size:12px"><b> Expired Date:
                </b>{{ date('d-M-Y', strtotime($data->end_date))  }}</span>
        </div>
        <div class="report_params_areas" style="float:right;height:20px;width:45%;text-align:right;margin-right:5px;">
            <span style="text-align: right; font-size:12px"><strong>Warrenty Status: </strong>
                @php
                $badgeClass = strtotime($data->end_date) >= time() ? 'badge badge-success' : 'badge badge-danger' ; $statusText=strtotime($data->end_date) >= time() ? 'Processing' : 'Expired' ; @endphp <span class="{{ $badgeClass }}">{{ $statusText }}</span>
            </span>
            <br>
        </div>

        <div class="report_params_areas" style="float:left;height:20px;width:100%">
            @if (isset($data))
            <span style="text-align: right; font-size:12px">
                <strong>Customer Name:</strong> {{ $data->customer->name }}</span><br>

            <span style="text-align: right; font-size:12px">
                <strong>Store Name:</strong> {{ $data->store->name }} </span><br>
            <span style="text-align: right; font-size:12px">
                @endif
        </div>
    </div>



    @if (isset($data))
    <div style="display:block; margin-top:10px;">
        <table width="100%">
            <thead>
                <tr>
                    <th style="text-align: center">SL</th>
                    <th style="text-align: left">Sales ID</th>
                    <th style="text-align: left">Item Name</th>
                    <th style="text-align: left">Warrenty Type</th>
                    <th style="text-align: left">Duration</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="text-align: center">{{ 1 }}</td>
                    <td style="text-align: left;">
                        {{ $data->sells_id  }}
                    </td>

                    <td>{{ $data->items ? $data->items->name : 'N/A' }}</td>
                    <td>{{ $data->type }}</td>
                    <td>{{ $data->duration }}</td>
                </tr>
                {{-- <tr>
                    <td style="text-align: right;" colspan="3"><strong>Total: </strong></td>
                    <td style="text-align: right;">
                        <strong>{{ number_format(collect($transaction)->sum('payable'), 2, '.', ',') }} TK</strong>
                </td>
                </tr> --}}
            </tbody>
        </table>
        <p style="font-size:12px">Notes: {{ $data->notes }} </p>
        @else
        <p>No data.</p>
        @endif

        <div class="col-md-5" style="line-height:.1;">
            <p style="text-align: left;font-size: 12px;">----------------</p>
            <p style="text-align: left;font-size: 14px;">Authories</p>
        </div>
        <div class="col-md-6" style="line-height:.1">
            <p style="text-align: right; font-size: 12px;"><span>--------------------</span>
                <p style="text-align: right; font-size: 14px;"><span>Received By</span>
                </p>
        </div>

    </div>
    <htmlpagefooter name="page-footer">
        <div class="col-md-5">
            <p style="text-align: left;font-size: 12px;">{PAGENO} of {nbpg} pages</p>
        </div>
        <div class="col-md-6">
            <p style="text-align: right; font-size: 14px;"><span><strong>Riyat Automobiles </strong><span><br>
                        <span style="font-size: 12px;">A product of</span><span style="font-size:14px; color:rgb(235,31,40); "><strong> Developer Test</strong></span>
            </p>
        </div>
    </htmlpagefooter>

</html>
