@extends('layouts.admin')
@section('title', 'Admin | Stock Ledger')

@section('content')
    <div class="row my-auto align-items-center bg-white shadow-md border no-print">
        <div class="col-sm-6">
            <span class="my-auto h6 page-headder">@yield('page-headder')</span>
            <ol class="breadcrumb bg-white p-2 m-2">
                <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('admin.reports.stock.ledger') }}">Stock Ledger</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="card bg-white">

            <div class="card-header bg-light no-print">
                <form action="{{ route('admin.reports.stock.ledger') }}" method="get">

                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="from_date d-inline">From Date</label>
                                <input type="text" id="from_date" name="from_date"  class="form-control" value="{{ $from_date ? date('Y-m-d', $from_date) : '' }}" required placeholder="YYYY-MM-DD">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="to_date d-inline">To Date</label>
                                <input id="to_date" type="text" name="to_date"  class="form-control" value="{{ $to_date ? date('Y-m-d', $to_date) : '' }}" required placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="to_date d-inline">To Date</label>
                                <div>
                                    <select name="categoryId" class="select2 w-100 h-100">
                                        <option selected value="all">All Category</option>
                                        @foreach ($categories as $item)
                                            <option {{$categoryId == $item->id?'selected':''}} value="{{$item->id}}">{{$item->name_english}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 float-end my-auto">
                            <button type="submit" class="btn btn-md bg-warning mt-3" >Search</button>
                        </div>
                    </div>
                </form>

            </div>


            @if( $from_date && $from_date )

            <div class="container">

                <div class="row no-print">
                    <div class="col-12 m-2">
                        {{-- <a href="#" class="btn btn-success float-md-right mr-2">
                            PDF
                        </a> --}}
                        <a onclick="window.print();" class="btn btn-success float-md-right mr-2 btn-md">
                            Print
                        </a>
                    </div>
                </div>

                @if (!empty($stockLedger))

                @include('admin.reports.print_header', ['report_name' => 'Stock Ledger'])


                    <div class="card" id="printarea">
                        <div class="row">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>&nbsp;&nbsp;Sl</th>
                                        <th style="width: 30%">Product Name</th>
                                        <th>Stock In</th>
                                        <th>Stock Out</th>
                                        <th>Available Qty</th>
                                        <th>Purchase Total(r)</th>
                                        <th>Sell Total(r)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalstockIn = 0;
                                        $totalstockOut = 0;
                                        $totalSellAmount = 0;
                                        $totalPurchaseAmount = 0;
                                        $totalStock = 0;
                                    @endphp
                                    @foreach ($stockLedger as $key => $data)
                                        @php
                                            $totalstockIn += $data->stock_in;
                                            $totalstockOut += $data->stock_out;
                                            $totalSellAmount += $data->sell_amount;
                                            $totalPurchaseAmount += $data->purchase_amount;
                                            $totalStock += $data->current_stock;
                                        @endphp
                                        <tr>
                                            <td>&nbsp;&nbsp;{{ $key + 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->stock_in }}</td>
                                            <td>{{ $data->stock_out??0 }}</td>
                                            <td>{{ $data->current_stock }}</td>
                                            <td>{{ number_format($data->purchase_amount, 2) }}</td>
                                            <td>{{ number_format($data->sell_amount??0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-sm">
                                        <th class="text-end" colspan="2">Total: </th>
                                        <th>{{$totalstockIn}}</th>
                                        <th>{{$totalstockOut}}</th>
                                        <th>{{$totalStock}}</th>
                                        <th>{{number_format($totalPurchaseAmount, 2)}}</th>
                                        <th>{{number_format($totalSellAmount, 2)}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>

                @else
                    <h5 class="text-center py-5">No Data Found!</h5>
                @endif

            </div>

            @endif

        </div>
    </div>    
    <!-- /.content -->
@endsection

@push('.js')
<script>
    $('#from_date').datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true,
    });
    $('#to_date').datepicker({
        dateFormat:"yy-mm-dd", 
        changeMonth: true,
        changeYear: true,
    });
</script>
@endpush
