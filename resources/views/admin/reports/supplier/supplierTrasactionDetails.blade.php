@extends('layouts.admin')
@section('title', 'Admin | Transaction')

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
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
            <form action="{{ route('admin.transdetailsbysupplier.find') }}" class="form-horizontal" id="sales-form" method="POST" accept-charset="utf-8">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="supplier_id">Supplier <span class="d-inline text-danger">*</span></label>
                        <div class="input-group">
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" required>
                                <option value="">-- Select supplier --</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->name . '-' . $supplier->phone }}
                                </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="to_date d-inline">To date</label>
                            <input type="date" name="to_date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" placeholder="to_date.." value="{{ old('to_date') }}" required>
                            @error('to_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="from_date d-inline">From Date</label>
                            <input type="date" name="from_date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" placeholder="from_date.." value="{{ old('from_date') }}" required>
                            @error('from_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-12 col-md-3 float-end my-auto">
                        <button type="submit" id="generate" class="btn btn-md bg-warning payments_modal" title="Generate Barcode">Find</button>
                    </div>
                </div>
            </form>

        </div>




        <div class="container p-4">
            @if (isset($tdForSupplier) && count($tdForSupplier) > 0)
            <h4>Supplier Information</h4>
            @if ($id && $from_date && $to_date)
            <a href="{{ url('/admin/transactions-detailed-by-supplier-find-report') }}?supplier_id={{ $id }}&from_date={{ $from_date }}&to_date={{ $to_date }}" target="_blank" class="btn btn-success float-md-right mr-4">
                Generate PDF
            </a>
            @endif
            <p class="pb-0 mb-0"><strong>Supplier Name:</strong> {{ $findSupplier->name }}</p>
            <p class="pb-0 mb-0"><strong>Supplier ID:</strong> {{ $findSupplier->id }}</p>
            <span><strong>Supplier Phone:</strong> {{ $findSupplier->phone }} </span>
            @endif

            @if (isset($tdForSupplier))
            @if (isset($tdForSupplier) && count($tdForSupplier) > 0)
            <div class="card table-responsive border-0 mt-2" style="box-shadow:none !important; ">
                <div class="row">
                    <table id="example1" class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center">SL</th>
                                <th style="text-align: center">Purchase Order No</th>
                                <th style="text-align: center">Total Purchase Quantity</th>
                                <th style="text-align: center">Total Receive Quantity</th>
                                <th style="text-align: center">Total Purchase Amount(BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tdForSupplier as $key => $value)
                            <tr>
                                <td style="text-align: center">{{ (int) $key + 1 }}</td>
                                <td style="text-align: left">
                                    {{ is_object($value) ? (int) $value->id : '' }}</td>
                                <td style="text-align: center">
                                    {{ is_object($value) ? number_format($value->total_purchase_qty) : '' }}</td>
                                <td style="text-align: center">
                                    {{ is_object($value) ? number_format($value->total_received_qty) : '' }}</td>
                                <td style="text-align: center">
                                    {{ is_object($value) ? number_format($value->total_purchase_amount) : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td style="text-align: right;" colspan="2"><strong>Total: </strong></td>
                            <td style="text-align: right;">
                                <strong>{{ number_format($tdForSupplier->sum('total_purchase_qty'),0, '.', ',') }}</strong>
                            </td>
                            <td style="text-align: right;">
                                <strong>{{ number_format($tdForSupplier->sum('total_received_qty'),0, '.', ',') }}</strong>
                            </td>
                            <td style="text-align: right;">
                                <strong>{{ number_format($tdForSupplier->sum('total_purchase_amount'), 2, '.', ',') }} TK.</strong>
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
            @else
            <h4 class="text-center py-5">Search Your Result.</h4>
            @endif

        </div>

    </div>
</div>

<!-- /.content -->
@endsection
