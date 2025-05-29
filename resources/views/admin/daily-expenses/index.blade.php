@extends('layouts.admin')
@section('title', 'Admin | expense')

@section('page-headder')
{{-- expenses --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.daily-expenses.index')}}">Daily-expenses</a></li>
@endsection


@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{route('admin.daily-expenses.index')}}">Daily-expensess</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            {{-- <span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span> --}}
            <a href="{{route('admin.daily-expenses.create')}}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Add New
            </a>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">All Expense</h4>

                <div class="float-right d-flex my-auto gap-3">

                    <form class="mb-0 pb-0" id="sort_expenses" action="" method="GET">
                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search">
                            <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body table-reHIDnsive p-0">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Expense Name</th>
                            <th>Expense Category</th>
                            {{-- <th>Company</th> --}}
                            {{-- <th>Store</th> --}}
                            <th>Expense Date</th>
                            <th>Amount</th>
                            {{-- <th>Approved Status</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        @foreach ($expenses as $key => $expense)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $expense->expense_name }}</td>
                            <td>{{ $expense->expensesName }}</td>
                            {{-- <td>{{ $expense->company }}</td> --}}
                            {{-- <td>{{ $expense->store->name ?? $expense->store }}</td> --}}
                            <td>{{ $expense->expense_date }}</td>
                            <td>{{ $expense->amount }} </td>

                            {{-- <td>
                                @php
                                $badgeClass = $expense->approved_status == 'Approved' ? 'badge badge-success' : 'badge badge-danger';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $expense->approved_status === 'Approved' ? 'Approved' : 'Non-Approved' }}</span>
                            </td> --}}

                            <td>
                                <a href="{{ route('admin.daily-expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm edit text-light border-0 edit"><i class="fa-regular fa-pen-to-square"></i> </a>
                                <form action="{{ route('admin.daily-expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pt-4 pb-2 px-4">
                    <div class="pagination d-flex justify-content-between">
                        <!-- ... (previous content) -->
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
                                    // Update or add the per_page parameter
                                    searchParams.set('per_page', perPage);
                                    // Redirect to the updated URL
                                    window.location.href = url.pathname + '?' + searchParams.toString();
                                }

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
                                <span id="showing-entries-from">{{ $expenses->firstItem() }}</span>
                                to
                                <span id="showing-entries-to">{{ $expenses->lastItem() }}</span>
                                of
                                <span id="total-entries">{{ $expenses->total() }}</span>
                                entries
                            </div>

                        </div>
                        <!-- ... (remaining content) -->
                        {{ $expenses->links('components.pagination.default') }}
                        {{-- {{ $expenses->appends(request()->except('page'))->links() }} --}}


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
@push('.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });

</script>
@endpush
