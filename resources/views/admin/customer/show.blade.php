@extends('backend.layouts.app')
@section('title', 'Customers Details')
@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3 px-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">{{ __('Customers Details') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Customer Order Details</div>
                <div class="card-body">
                    <table class=" table sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order ID</th>
                                <th class="text-center">Payment Status</th>
                                <th>Total Items</th>
                                <th class="text-right">Total Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer->orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>#{{ $order->id }}</td>
                                    <td class="text-center"><span class="alert-info">{{ $order->payment_status }}</span>
                                    </td>
                                    <td>{{ collect($order->items)->sum(fn($item) => $item->quantity) }} pcs</td>
                                    <th class="text-right">{{ $order->payable }}</th>
                                    <td class="text-center">
                                        @can('view_order')
                                            <a target="blank" href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-info"><i class="las la-eye"></i></a>
                                        @endcan

                                        @can('download_invoice_order')
                                            <a target="blank" href="{{ route('admin.orders.download_invoice', $order->id) }}"
                                                class="btn btn-sm btn-success"><i class="las la-download"></i></a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Customer Information
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <p> <b>customer Id :</b> <i>#{{ $customer->id }}</i></p>
                        <p><img class="d-block" width="40px" src="{{ asset('avatar.jpeg') }}" alt=""></p>
                    </div>
                    <p class="mb-1"><b>Name :</b> <i>{{ $customer->name }}</i></p>
                    <p class="mb-1"><b>Email :</b> <i>{{ $customer->email }}</i></p>
                    <p class="mb-1"><b>Phone :</b> <i>{{ $customer->phone }}</i></p>
                    <p class="mb-1"><b>Total Sold :</b> <i>{{ collect($customer->orders)->sum('grand_total') }}</i> TK
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
