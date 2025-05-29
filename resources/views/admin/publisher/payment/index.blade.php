@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="mb-0">Payment To Publisher: (BB-13)</h6>
            </div>
            @can('payment_to_publisher')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.publisher_payment.create') }}" class="btn btn-sm btn-primary">
                        <span>+ Add New</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <p class="mb-0">Payment to Publisher</p>
            <div class="col-md-5">
                <input type="search" class="form-control" placeholder="search by id or name">
            </div>
        </div>
        <div class="card-body">
            <table class="table  p-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Publisher/Supplier Name</th>
                        <th>Amount</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key=>$item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->payment_date }}</td>
                        <td>{{ $item->name_bangla }}</td>
                        <td>{{ $item->total_paid_amount }} TK.</td>
                        <td class="text-right">

                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm view_details"
                                href="javascript:void(0)" title="{{ translate('view') }}">
                                <i class="las la-eye"></i>
                            </a>

                            <a href="javascript:void(0)" class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                data-href="" title="{{ translate('Print') }}">
                                <i class="las la-print"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
