<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice</title>
    <style>
/* body{
    font-family: "siliguri";
} */
        table td {
            /* font-size: 14px; */
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: rgb(63, 62, 62)
        }

        .border_bottom {
            border-bottom: 1px solid rgb(78, 77, 77);
        }

        table th {
            padding: 10px 0;
        }

        table thead th {
            border-top: 1px solid #dedede;
            text-transform: uppercase;
            color: rgb(255, 255, 255);
            font-family: "-apple-system, BlinkMacSystemFont, 'Segoe UI', , Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif";
            font-weight: 500;
            text-align: left;
        }

        .theme-text {
            color: rgb(142, 45, 211) !important;
        }

        .theme-half {
            background: rgba(205, 147, 247, 0.164)
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center;
        }

        p {
            margin-bottom: 0px;
        }

        .line_height {
            font-size: 13px !important;
            line-height: 1.8;

        }

        body, p, .line_height, b{
            /* font-family: 'HindSiliguriRegular', sans-serif !important; */
            /* font-family: 'Hind Siliguri', sans-serif; */
        }
        body, p, .line_height, b{
            /* font-family: 'HindSiliguriRegular'; */
        }



        .barcode {
	padding: 0;
	margin: 0;
	vertical-align: middle;
	color: #230032;
}
.barcodecell {
	text-align: center;
	vertical-align: middle;
	padding: 0;
    border: 0;
}

    </style>
</head>

<body>
    <div style="margin-bottom: 30px;">
        <div style="float: left; width:50%">
            <b style="font-size:25px;" class="theme-text ">Invoice</b><br>
            <b style="color: #666">Invoice no #{{ $order->id }}</b><br>
            <b style="color:#666">Invoice date
                #{{ \Carbon\Carbon::now()->format('F d, Y') }}</b><br>
        </div>

        <div class="text-right" style="width:50%; float:right">
            <img width="33%" src="http://188.166.182.136/booksbd/public/books_bd_logo.png" alt="BooksBD.com"><br>
            <b class="line_height ">55/1/A, Shah Shaheb Lane,Narinda, Dhaka-1100</b> <br>
            <span class="line_height " style="font-size: 14px;">Phone: +8801713 138707, Email: info@booksbd.net</span>
        </div>
    </div>



    <div style="width: 100%" style=" display: grid; grid-template-columns: 1fr 1fr 1fr;">
        <div class="theme-half" style="width:37%; float: left; padding:10px; border-radius:10px">
            <b class="line_height theme-text h4" style="font-size: 16px;">Order Details</b><br>
            <span class="line_height"><b>Order ID: #</b>{{ $order->id }}</span><br>
            <span class="line_height"><b>Order Placed:</b>
                {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</span><br>
            <span class="line_height"><b>Payment Method:</b> COD ({{{ $order->payable }}} TK.)</span><br>
            @if ($order->courier)
            <span class="line_height"><b>Courier Service:</b>{{ $order->courier }}</span>
            @endif
        </div>

        <div class="qrcode" style="width:24px;padding:0px;float: left; text-align:center">
            <barcode code="Order ID: #</b>{{ $order->id }}; Customer Name:{{ $order->customer_name }};
                Order Placed:{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                Payment Method: COD ({{{ $order->payable }}} TK.);
                @if ($order->courier)
                Courier Service:</b>{{ $order->courier }};
                @endif
                " size="0.9" type="QR" error="M" class="barcode"/>
        </div>


        <div class="theme-half" style="width:37%; float:right; padding:10px;border-radius:10px">
            <b class="theme-text line_height " style="font-size: 16px">Customer Information</b><br>
            <span class="line_height">{{ $order->customer_name }} </span><br>
            <span class="line_height">{{ $order->shipping_address }}</span><br>
            <span class="line_height"><b>Email:</b> {{ $order->customer_email ?? '' }}</span><br>
            <span class="line_height"><b>Phone:</b> {{ $order->customer_phone }}</span><br>
        </div>

    </div>
    <div class="card-body" style="background: #f9f9f9; margin-top:20px; padding-bottom:10px; border-radius: 10px">
        <table style="width: 100%;" cellspacing="0" cellpadding="0">
            <thead>
                <tr style="background: rgb(122, 17, 197); border-radius:20px !important;">
                    <th>
                        <center>SL</center>
                    </th>
                    <th style="padding: 7px">Book Name</th>
                    <th style="padding: 7px">Publisher</th>
                    <th style="padding: 7px">
                        Quantity
                    </th>
                    <th style="text-align: center">Unit Price</th>
                    <th class="text-right" style="text-align: right; padding-right: 10px">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr class="{{ $loop->even ? 'theme-half' : '' }}">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->book_name }}</td>
                        <td>{{ $item->publisher_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">
                            <span> <small><strike>{{ $item->published_price }} TK.</strike></small>
                                {{ $item->unit_price }} TK.</span><br>

                        </td>
                        <td class="text-right ">{{ $item->unit_price * $item->quantity }} TK.</td>
                    </tr>
                @endforeach
            </tbody>
            {{-- <tfoot> --}}
                <tr>
                    <th></th>
                    <th colspan="3">
                        <span class="" style="margin-top: 15px; color:rgb(94, 94, 94)"> Total
                            {{ collect($order->items)->sum('quantity') }} Books</span>
                    </th>

                    <td class="text-left border_bottom ">Total Price</td>
                    <td class="text-right border_bottom ">
                        {{ $order->sub_total }} TK.
                    </td>
                </tr>
                <tr>

                    <td colspan="4" style="font-size:13px">
                        <b style="color:rgb(75, 75, 75); text-transform: uppercase; word-spacing: 4px;">
                            Total(In words): {{ $numberTransformer->toWords($order->payable_number) }} TAKA Only</b>
                    </td>


                    <td class="text-left border_bottom ">Delivery Charge</td>
                    <td class="text-right border_bottom ">{{ $order->shipping_cost }} TK.</td>
                </tr>
                @if ($order->gift_wrap > 0)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td class="text-left border_bottom ">Gift Wrap</td>
                        <td class="text-right border_bottom ">{{ $order->gift_wrap }} TK.</td>
                    </tr>
                @endif

                @if ($order->coupon > 0)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td class="text-left border_bottom">Coupon Discount</td>
                        <td class="text-right border_bottom"> {{ $order->coupon }} TK.</td>
                    </tr>
                @endif

                @if ($order->offer)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td class="border_bottom ">Discount Offer</td>
                        <td class="text-right border_bottom"> {{ $order->offer }} TK.</td>
                    </tr>
                @endif

                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="text-left" style="margin-bottom: 15px;">Total Payable</td>
                    <td class="text-right" style="margin-bottom: 15px">
                        {{ $order->payable }}
                        TK.</td>
                </tr> <br>
            {{-- </tfoot> --}}
        </table>
    </div>


    <div style="margin-top: 10px" class="text-center">
        <h3
            style="color:rgb(75, 75, 75);font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', , Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
            TERMS & CONDITIONS GOES HERE</h3>
    </div>
    <p style="border-top: 1px dashed #555; height: 15px"></p>
    <div class=" footer text-muted" style="text-align: center; text: muted; margin-top:20px">
        <p>This is an electronic generated document, no signature is required.</p>
    </div>

</body>

</html>
