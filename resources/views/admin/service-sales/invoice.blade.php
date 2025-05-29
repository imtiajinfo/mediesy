<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $sell->sale_code}}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Poltawski+Nowy:wght@457&family=Roboto:ital,wght@0,100;0,400;0,500;0,900;1,100;1,300;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <style type="text/css">
    .roboto-thin {
    font-family: "Roboto", sans-serif;
    font-weight: 100;
    font-style: normal;
    }

    .roboto-regular {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-style: normal;
    }

    .roboto-medium {
    font-family: "Roboto", sans-serif;
    font-weight: 500;
    font-style: normal;
    }

    .roboto-black {
    font-family: "Roboto", sans-serif;
    font-weight: 900;
    font-style: normal;
    }

    .roboto-thin-italic {
    font-family: "Roboto", sans-serif;
    font-weight: 100;
    font-style: italic;
    }

    .roboto-light-italic {
    font-family: "Roboto", sans-serif;
    font-weight: 300;
    font-style: italic;
    }

    .roboto-medium-italic {
    font-family: "Roboto", sans-serif;
    font-weight: 500;
    font-style: italic;
    }

    .roboto-bold-italic {
    font-family: "Roboto", sans-serif;
    font-weight: 700;
    font-style: italic;
    }

    .roboto-black-italic {
    font-family: "Roboto", sans-serif;
    font-weight: 900;
    font-style: italic;
    }

        body {
            font-family: arial;
            font-size: 12px;
            padding-top: 15px;
        }
        .invoice-info {
            font-size: 13px;
        }

        .text-right {
            text-align: right !important
        }

        @media print {
            body {
                width: 80mm !important;
                height: auto;
                background: none;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
            @page {
                margin: 0;
                size: 80mm auto;
            }
            .print-content {
                width: 80mm;
                height: auto;
                margin: 2;
            }
            header,
            footer {
                display: none;
            }
            .print-w-100 {
                width: 100% !important
            }
            .print-float-left {
                text-align: left !important
            }
            td,
            th {
                /* border-left: none;
                border-right: none; */
                padding: 0px !important;
                margin: 0px !important;
                text-align: center
            }
            .card{
                /* border:none */
            }
            td{
                font-weight: bold
            }
            th{
                font-size: medium
            }
        }
    </style>
</head>



<body onload="window.print();" class="col-lg-8 justify-content-center mx-auto align-items-center print-content">

    <div class="row my-auto align-items-center no-print">

        <div class="col-md-6">
            <ol class="float-right button">
                <a onclick="window.print()" class="btn btn-warning">
                    <i class="fa fa-print"></i>
                    Print
                </a>
                <a href="{{ url('admin/service-sales') }}" class="btn btn-success">
                    Back
                </a>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-12 p-0">
            <div class="card">

                <!-- Main content -->
                <section class="invoice p-2">
                    <div class="printableArea">

                        <div class="row">
                            <div class="col-xs-12">
                                <h5 class="text-center pt-2 mb-1"><span style="color:darkorange">Spa</span> Superette </h5>
                                <p class="text-center text-md mb-2">House:1380, Tlebebe Section<br>Luka, Rustenburg<br> Phone number :0611252082
                                </p>
                                <h6 class="text-center fw-bold mb-3 mt-0"  style="font-size: medium"><u>Sale Invoice</u>
                                </h6>
                            </div>
                        </div>

                        <!-- Info row -->
                        <div class="row invoice-info">

                            <!-- Invoice Details -->
                            <div class="col-sm-6 print-w-100 mb-0 pb-0" style="line-height:.5">
                                <p style="font-size: small;margin-bottom:14px"> <b>Date:</b> {{ date('d M, Y', strtotime($sell->sell_date)) }}</p>
                                <p style="font-size: small;margin-bottom:6px"><b>Invoice:</b><b class="fw-bold" style="font-size: small"> #{{$sell->sale_code}}</b></p>
                            </div>


                            <!-- Customer Details -->
                            <div class="col-sm-6 text-end print-w-100 mt-0 pt-0">
                                <address class="print-float-left" style="line-height:1.8;font-size:small">
                                    <strong>Username: </strong>{{Auth::user()->name}}<br>
                                    <strong>Customer Name: </strong>{{$sell->customername??'Guest'}}<br>
                                    <strong>Mobile:</strong> {{$sell->customerphone}}<br>
                                    <strong>Address:</strong> {{$sell->customeraddress}}
                                </address>
                            </div>

                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-12">
                                <table class="table records_table table-bordered pb-0 mb-0">
                                    <tr>
                                        <th class="product-name">ProductName</th>
                                        {{-- <th class="text-start">Code</th> --}}
                                        <th>Amount</th>
                                        <th>Qty.</th>
                                        {{-- <th>Dis.</th> --}}
                                        <th>SubTotal</th>
                                    </tr>
                                    {{-- <tbody> --}}
                                        @php
                                            $tqty = 0;
                                        @endphp
                                        @foreach ($sellItem as $key => $item)
                                        @php
                                            $tqty += $item->quantity;
                                        @endphp
                                        <tr>
                                            <td style="text-align: left">
                                                {{strtoupper($item->itemname)}}
                                            </td>
                                            {{-- <td>{{$item->sub_title}}</td> --}}
                                            <td>{{number_format($item->sell_price,2)}}</td>
                                            <td>{{$item->quantity}}</td>
                                            {{-- <td>{{$item->discount}}%</td> --}}
                                            <td>{{number_format($item->sub_total,2)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        @endforeach
                                    {{-- </tbody> --}}
                                    {{-- <tfoot class="col-md-12 tfoot table-hover table-bordered mt-2"> --}}

                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>Sub Total:</b>
                                            </td>
                                            <td style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="subtotal_amt"  name="subtotal_amt">{{number_format($sell->grand_total,2)}}&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>Vat:</b></td>
                                            <td class="text-left" style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="otder_charges_amt" name="otder_charges_amt">{{number_format(00.00,2)}}&nbsp;&nbsp;</b>
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>Total:</b>
                                            </td>
                                            <td style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="subtotal_amt"  name="subtotal_amt">{{number_format($sell->grand_total,2)}}&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>Cash
                                                Paid:</b></td>
                                            <td class="text-left" style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="otder_charges_amt" name="otder_charges_amt">{{number_format($sell->paid,2)}}&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>@if ($sell->due < 0){{"Change"}}@else{{"Due"}}@endif Amount:</b>
                                            </td>
                                            <td style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="total_amt"  name="total_amt">@if ($sell->due < 0){{number_format(abs($sell->due),2)}}@else{{number_format($sell->due,2)}}@endif</b>&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="font-size: small;"><b>Total Quantity:</b>
                                            </td>
                                            <td style="font-size: small;">
                                                <h6 style="font-size: small;margin-bottom:0rem"><b id="subtotal_amt"  name="subtotal_amt">{{$tqty}}</b>
                                                </h6>
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                    {{-- </tfoot> --}}

                                </table>
                            </div>
                            <div class="col-12 mt-4">
                                <h6 style="color:black;font-weight:bold;font-weight:500">Thanks for shopping with us</h6>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- /.content -->
                <!-- Info row -->
                <div class="row mx-4 mt-4">
                    <!-- Invoice Details -->
                    <div class="col-6 invoice-info" style="line-height:.6">
                        <p style="font-size: medium">Admin<br> .................</p>
                        <p style="font-size: medium"><b>Authorised By</b> </p>
                    </div>


                    <!-- Customer Details -->
                    <div class="col-6 invoice-col text-end" style="line-height:.6">
                        <p style="font-size: small">
                            {{$sell->customername}} <br> .................
                        </p>
                        <p style="font-size: medium"><b>Customer</b> </p>

                    </div>
                    <div class="col-12">
                        <p>Developed by &nbsp;<b style="position: absolute;"> Lilium Info Tech / +27620078441</b></a>
                    </div>

                </div>
                <!-- /.row -->

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</body>

</html>