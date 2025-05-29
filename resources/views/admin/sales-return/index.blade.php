@extends('layouts.admin')
@section('title', 'Admin | Sells Return')

@section('page-headder')
{{-- items --}}
@endsection


@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-purchaseOrder"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i> </a></li>
            <li class="breadcrumb-purchaseOrder text-dark px-2"><a href="{{ route('admin.purchase-orders.index') }}">Sells Return</a> </li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ route('admin.sales-return.create') }}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Add New Return
            </a>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Sells Return List</h4>

                <div class="float-right d-flex my-auto gap-3">

                    <form class="mb-0 pb-0" id="sort_purchaseOrders" action="" method="GET">
                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search by Invoice No" value="{{@$search}}">
                            <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body p-0 table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Ression</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        @forelse ($purchase_returns as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ date('d M, Y', strtotime($item->return_date)) }}</td>
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ @$item->customer->name }}</td>
                            <td>{{ $item->return_amount }}</td>
                            <td>{{ $item->ression->category_name }}</td>
                            <td>
                                {{-- <a href="{{ route('admin.purchase-return.edit', $item->id) }}" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a> --}}
                                <a href="{{ route('admin.sales-return.show', $item->id) }}" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="h-50">
                            <td colspan="8">
                                <h4 class="fs-4">No data found</h4>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pt-4 pb-2 px-4">
                    <div class="pagination d-flex justify-content-between">
                        <div class="d-flex">
                            <label for="per_page">Entries per Page:</label>
                            <select name="per_page" id="per_page" onchange="updateQueryString()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>

                            <script>
                                function updateQueryString() {
                                    var perPage = document.getElementById('per_page').value;
                                    var currentUrl = window.location.href;
                                    var url = new URL(currentUrl);
                                    var searchParams = new URLSearchParams(url.search);
                                    searchParams.set('per_page', perPage);
                                    // Redirect to the updated URL
                                    window.location.href = url.pathname + '?' + searchParams.toString();
                                }


                                // Function to fetch data and update the table body
                                function fetchDataAndPopulateTable() {
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const table = document.getElementById('datatable');
                                        const tableRow = table.querySelector('tr');

                                        // Display loading animation
                                        if (tableRow) {
                                            const loadingDiv =
                                                '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                            tableRow.appendChild(loadingDiv);
                                            setTimeout(function() {

                                            }, 2000); // Adjust the time according to your needs
                                        }
                                    });


                                }

                                // Call the function when the page loads
                                fetchDataAndPopulateTable();

                            </script>

                            <!-- Information about displayed entries -->
                            <div class="dataTables_info pl-2">
                                Showing
                                <span id="showing-entries-from">{{ $purchase_returns->firstItem() }}</span>
                                to
                                <span id="showing-entries-to">{{ $purchase_returns->lastItem() }}</span>
                                of
                                <span id="total-entries">{{ $purchase_returns->total() }}</span>
                                entries
                            </div>
                        </div>
                        {{ $purchase_returns->links('components.pagination.default') }}
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </div>
    <!-- /.col -->

</div>
<!-- /.content -->
@endsection
