@extends('layouts.admin')
@section('title', 'Admin | brands')

@section('page-headder')
{{-- brands --}}
@endsection

@section('content')
<style>
    th,
    td {
        text-align: left !important;
        vertical-align: middle !important;
        padding: 10px !important;
    }

</style>
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.brands.index') }}">brands</a></li>
        </ol>
    </div>
    <div class="col-sm-6">
        <ol class="float-right button">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-success">Add brands</a>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">All Brands</h4>

                <div class="float-right d-flex">
                    <form action="{{ route('admin.brands.index') }}" method="GET" class="float-right d-flex my-auto gap-3">
                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search by name..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body table-reHIDnsive p-0">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th class="image text-start" style="width=100px">Image</th>
                            <th>brand Name</th>
                            {{-- <th>brand Name Bangla</th>
                            <th class="descriptions">Descriptions</th> --}}
                            <th class="status">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        @if (count($brands) > 0)
                        @foreach ($brands as $key => $brand)
                        <tr>
                            <td>{{ $brands->firstItem() + $loop->index }}</td>
                            {{-- <td>{{ $brands->total() - $brands->perPage() * ($brands->currentPage() - 1) - $loop->index }}</td> --}}
                            <td>
                                <img src="{{ $brand->logo ? asset('uploads/brand/' . $brand->logo) : asset('uploads/brand/default.png') }}" alt="default.jpg" width="60px">
                            </td>

                            <td>{{ $brand->name_english }}</td>
                            {{-- <td>{{ $brand->name_bangla }}</td>
                            <td>
                                <p class="text-start" style="max-width:250px"> {{ $brand->description }}
                                </p>
                            </td> --}}
                            <td>
                                {{ $brand->status ? 'Active' : 'Inactive' }}
                                {{-- <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchButton" checked>
                                </div> --}}
                            </td>
                            <td>
                                <a link="{{ route('admin.brands.edit', $brand->id) }}" href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete" onclick="return confirm('Are you sure?')"> <i class="fas fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="h-50">
                            <td colspan="13">
                                <h4 class="fs-4">No Record Found</h4>
                            </td>
                        </tr>
                        @endif
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
                                <span id="showing-entries-from">{{ $brands->firstItem() }}</span>
                                to
                                <span id="showing-entries-to">{{ $brands->lastItem() }}</span>
                                of
                                <span id="total-entries">{{ $brands->total() }}</span>
                                entries
                            </div>
                        </div>
                        <!-- ... (remaining content) -->
                        {{ $brands->links('components.pagination.default') }}
                        {{-- {{ $brands->appends(request()->except('page'))->links() }} --}}


                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->



        {{-- add modal --}}
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Name</label>
                                <input class="form-control" type="text" name="name_english" placeholder="brand Name English..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Name Bangla</label>
                                <input class="form-control" type="text" name="name_bangla" placeholder="brand Name bangla..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Logo</label>
                                <input class="form-control" type="file" name="logo" placeholder="brand Name bangla..." value="">
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" name="description" placeholder="Leave a Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- edit modal --}}
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Edit brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Name</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="brand Name English..." value="Fresh Fresh">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="brand Name bangla..." value="Fresh Fresh">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand Logo</label>
                                <input class="form-control" type="file" name="logo" placeholder="brand Name bangla..." value="">
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- view modal --}}
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">View brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>brand Name</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="brand Name English..." value="Fresh Fresh" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>brand Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="brand Name bangla..." value="Fresh Fresh" disabled>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a Descriptions here.." id="floatingTextareadesc" disabled></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        //$('#datepicker').datepicker();
        // $('#datepicker').datepicker({
        //    format: 'yyyy-mm-dd'
        //    , language: 'en'
        //    , autoclose: true
        //});
    });

</script>



{{-- <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/dataTables.reHIDnsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/reHIDnsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $("#example1").DataTable({
                "reHIDnsive": true
                , "lengthChange": false
                , "autoWidth": false
                , "searching": true
                , "ordering": true
                , "paging": true
                , "info": true
                , "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    });

</script> --}}
@endpush
