@extends('layouts.admin')
@section('title', 'Admin | Transaction')

@section('content')
    <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
        <div class="col-sm-6">
            <span class="my-auto h6 page-headder">@yield('page-headder')</span>
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                            class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.suppliers.index') }}">Suppliers</a>
                </li>
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
    </style>


    <div class="row">
        <div class="card bg-white p-0">
            <div class="card-header bg-light">
                <form action="{{ route('admin.mothlyProfitLoss.find') }}" class="form-horizontal" id="sales-form"
                    method="POST" accept-charset="utf-8">
                    @csrf
                    @method('POST')

                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="to_date d-inline">To date</label>
                                <input type="date" name="to_date"
                                    class="form-control @error('to_date') is-invalid @enderror" id="to_date"
                                    placeholder="to_date.." value="{{ old('to_date') }}" required>
                                @error('to_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="from_date d-inline">From Date</label>
                                <input type="date" name="from_date"
                                    class="form-control @error('from_date') is-invalid @enderror" id="from_date"
                                    placeholder="from_date.." value="{{ old('from_date') }}" required>
                                @error('from_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12 col-md-3 float-end my-auto">
                            <button type="submit" id="generate" class="btn btn-md bg-warning payments_modal"
                                title="Generate Barcode">Find</button>
                        </div>
                    </div>
                </form>

            </div>




            <div class="container p-4">
                @if (isset($totalIncome) || isset($totalExpense) || isset($netProfitLoss))

                    <h6><b>Total Income:</b> {{ number_format($totalIncome, 2, '.', ',') }} TK.</h6>
                    <h6><b>Total Purchase:</b> {{ number_format($purchaseOrders, 2, '.', ',') }} TK.</h6>
                    <h6><b>Total Expense:</b> {{ number_format($totalExpense, 2, '.', ',') }} TK.</h6>
                    <h6><b>Net Profit Loss:</b> {{ number_format($netProfitLoss, 2, '.', ',') }} TK.</h6>
                    @if ($from_date && $to_date)
                        <a href="{{ url('/admin/mothlyProfitLoss-find-report') }}?from_date={{ $from_date }}&to_date={{ $to_date }}"
                            target="_blank" class="btn btn-success float-md-right mr-4">
                            Generate PDF
                        </a>
                    @endif
                @endif
                <br>
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
                                        <tfoot>
                                            <td style="text-align: right;" colspan="5"><strong>Total: </strong></td>
                                            <td style="text-align: right;">
                                                <strong>{{ number_format($DailyExpenses->sum('amount'), 2, '.', ',') }}
                                                    TK.</strong>
                                            </td>
                                        </tfoot>
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
                                        <tfoot>
                                            <td style="text-align: right;" colspan="4"><strong>Total: </strong></td>
                                            <td style="text-align: right;">
                                                <strong>{{ number_format($AllpurchaseOrders->sum('total_purchase_amount'), 2, '.', ',') }}
                                                    TK.</strong>
                                            </td>
                                        </tfoot>
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
                                                    <td>{{ @$sale->customer->name }}</td>
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
                                        <tfoot>
                                            <td style="text-align: right;" colspan="6"><strong>Total: </strong></td>
                                            <td style="text-align: right;">
                                                <strong>{{ number_format($Allsales->sum('payable'), 2, '.', ',') }}
                                                    TK.</strong>
                                            </td>
                                        </tfoot>
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

        </div>
    </div>

    <!-- /.content -->
@endsection
