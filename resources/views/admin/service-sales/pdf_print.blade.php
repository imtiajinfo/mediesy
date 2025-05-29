<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>

    <style>
        table,
        th,
        td {
            border: 0;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            vertical-align: top
        }

        body {
            word-wrap: break-word;
            font-family: 'sans-serif', 'Arial';
            font-size: 11px;
            width: 8cm !important;
            border: 1px dashed #222;
            overflow: scroll;
            margin: 0 auto;
        }

        .style_hidden {
            border-style: hidden;
        }

        .fixed_table {
            table-layout: fixed;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .bg-sky {
            background-color: #E8F3FD;
        }

        tr {
            border-bottom: 1px dashed #222;
        }

        .border-0 tr {
            border: 0px;
        }

        .sl {
            width: 10px !important;
        }

    </style>
</head>
<body onloa="window.print()">

    <caption>
        <center>
            <p>
                <img src="{{ asset('backend/dist/img/software-development.png') }}" alt="default.png" style="height: 60px; width:auto;">
                <h5 style="font-size: 15px;text-transform: uppercase; margin:0">Khush Fashion Palace</h5>
                <span style="font-size: 11px; line-height:1.4">
                    Address : Sector-4, Uttara, Dhaka<br />
                    Phone: 018756888,<br />
                    Email: admin@example.com<br>
                    GST Number: GSTIN123456780<br>
                </span>
            </p>
        </center>
    </caption>

    <table style="overflow: wrap" id='mytable' width="100%" height='100%' cellpadding="1" cellspacing="1">
        <tbody class="">
            <th>
                <tr style="border-bottom: 1px dashed #222;">
                    <td> Invoice:
                        <span style="font-size: 10px;">
                            <b>SL0040</b>
                        </span>
                    </td>
                    <td>
                        Date:
                        <span style="font-size: 10px;">
                            <b>14-01-2024</b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td> <b>Payment Status : </b>Paid
                    </td>
                </tr>
                <tr>
                    <td> <b>Reference No. : </b>6789
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>
                            <b>Bank Details:</b>
                            SBI </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Customer Address</b><br />
                        <span style="font-size: 10px;">
                            Name: Walk-in customer<br />
                            <br>
                        </span>
                    </td>

                    <td>
                        <span>
                            <b>Shipping Address</b><br />
                        </span>
                        <span style="font-size: 10px;">
                            Name: Walk-in customer<br />
                            <br>
                        </span>
                    </td>
                </tr>
            </th>
        </tbody>
    </table>

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
            @@foreach ($sellItem as $key => $item)
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
                    <td colspan="6" class="text-right" style="font-size: 13px;">Subtotal</td>
                    <td class="text-right" style="font-size: 13px;">
                        <h6><b id="subtotal_amt" name="subtotal_amt">{{$sell->grand_total}} TK.</b></h6>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right" style="font-size: 13px;">Other Charges/Service Charge</td>
                    <td class="text-right" style="font-size: 13px;">
                        <h6><b id="otder_charges_amt" name="otder_charges_amt">{{$sell->service_charge}} TK.</b></h6>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right" style="font-size: 13px;">Payable Amount</td>
                    <td class="text-right" style="font-size: 13px;">
                        <h6><b id="total_amt" name="total_amt">{{$sell->payable}} TK.</b></h6>
                    </td>
                </tr>
            </tbody>
    </table>


    <table class="border-0">
        <tbody>
            <tr>
                <td colspan="2">
                    <span>Note: notes </span>
                </td>
            </tr>
            <!-- T&C & Bank Details -->
            <tr>
                {{-- <td colspan="2">
                    <span><b> Terms & Conditions</b></span>
                    <p style='font-size: 10px;'>
                        1)no warranty for damaged or burnt goods.<br />
                        2) for warranty/repairs/replacement bring invoice copy.<br />
                        3)interest @24% will be charged if bills are not paid within the due date.<br />
                        4)we reserve lien on goods till full payment is made.<br />
                        5)Goods once sold will not be taken back.6)warranty at the sole discretion of the respective service center.<br />
                        7)cheque bouncing attracts an unconditional fine of Rs. 750.00.<br />
                        8)we recommend our customer&amp;#039;s to use legal softwares, we don&amp;#039;t support pirated software in any way.
                    </p>
                </td> --}}
            <tr>
                <td style="height:80px;">
                    <span><b> Customer Signature</b></span>
                </td>
                <td>
                    <span><b> Authorised Signatory</b></span><br>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;font-size: 8px;">
                    This is footer text. You can set it from Site Settings.
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
