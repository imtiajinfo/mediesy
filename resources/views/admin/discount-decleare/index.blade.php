@extends('layouts.admin')
@section('title', 'Admin | discount-decleare')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.brand')}}">discount-decleare</a></li>
@endsection

@section('button')
{{-- <button type="button" class="btn btn-success swalDefaultSuccess">Success</button>
    <button type="button" class="btn btn-info swalDefaultInfo">Info</button>
    <button type="button" class="btn btn-success toastrDefaultSuccess">Success</button>
    <button type="button" class="btn btn-danger toastrDefaultError">Error</button> --}}
<span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span>
@endsection

@section('content')
<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2"> All discount-decleare List</h4>

                <div class="float-right d-flex my-auto gap-3">

                    <div class="form-group mb-0" style="width:240px">
                        <label>From Date</label>
                        <input type="date" class="form-control" name="from">
                    </div>

                    <div class="form-group mb-0" style="width:240px">
                        <label>To Date</label>
                        <input type="date" class="form-control" name="to">
                    </div>

                    <form class="mb-0 pb-0" id="sort_categories" action="" method="GET">
                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search">
                            <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body table-responsive p-0">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Discount Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Discount Type</th>
                            <th>Discount Amount</th>
                            <th>TO Amount</th>
                            <th>From Amount</th>
                            <th>Descriptions</th>
                            <th class="status">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        <tr>
                            <td>01</td>
                            <td>Daily Sells</td>
                            <td>01-July-2023</td>
                            <td>30-July-2023</td>
                            <td>Purchase Amount</td>
                            <td>50,000 TK</td>
                            <td>100,000 TK</td>
                            <td>5000 TK</td>
                            <td>
                                <p class="text-start" style="max-width:250px">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchButton" checked>
                                </div>
                            </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>01</td>
                            <td>Daily Sells</td>
                            <td>01-July-2023</td>
                            <td>30-July-2023</td>
                            <td>Purchase Amount</td>
                            <td>50,000 TK</td>
                            <td>100,000 TK</td>
                            <td>5000 TK</td>
                            <td>
                                <p class="text-start" style="max-width:250px">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchButton" checked>
                                </div>
                            </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>01</td>
                            <td>Daily Sells</td>
                            <td>01-July-2023</td>
                            <td>30-July-2023</td>
                            <td>Purchase Amount</td>
                            <td>50,000 TK</td>
                            <td>100,000 TK</td>
                            <td>5000 TK</td>
                            <td>
                                <p class="text-start" style="max-width:250px">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchButton" checked>
                                </div>
                            </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>01</td>
                            <td>Daily Sells</td>
                            <td>01-July-2023</td>
                            <td>30-July-2023</td>
                            <td>Purchase Amount</td>
                            <td>50,000 TK</td>
                            <td>100,000 TK</td>
                            <td>5000 TK</td>
                            <td>
                                <p class="text-start" style="max-width:250px">Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchButton" checked>
                                </div>
                            </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="pt-4 pb-2 px-4">
                    <div class="pagination d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="dataTables_length" id="example_length" class="from-group">
                                <label>Show
                                    <select name="example_length" aria-controls="example" class="from-control form-select-sm" aria-label=".form-select-sm example">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    entries
                                </label>
                            </div>
                            <div class="dataTables_info pl-5" id="example_info" role="status" aria-live="polite">
                                Showing 1 to 10 of 57 entries
                            </div>
                        </div>
                        <ul class="pagination">
                            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                <span class="page-link" aria-hidden="true">‹ Previous</span>
                            </li>
                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link" href="#?page=2&amp;">2</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=3&amp;">3</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=4&amp;">4</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=5&amp;">5</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=6&amp;">6</a></li>
                            <li class="page-item"><a class="page-link" href="#&amp;">...</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=14&amp;">10</a></li>
                            <li class="page-item"><a class="page-link" href="#?page=15&amp;">14</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#?page=2&amp;" rel="next" aria-label="Next »">Next ›</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->



        {{-- add modal --}}
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">discount-decleare</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Discount Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Discount Name..">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="Company"> Discount Type</label>
                                <select id="Discount Type" class="selectpicker w-100">
                                    <option> Company</option>
                                    <option selected>Monthly Purchase Discunt</option>
                                    <option>Daily Purchase Discunt</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Start Date</label>
                                <input class="form-control" type="date" name="start-date">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>End Date</label>
                                <input class="form-control" type="date" name="start-date">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>TO Amount</label>
                                <input class="form-control" type="number" name="to-amount-date">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>From Amount</label>
                                <input class="form-control" type="number" name="from-amount" value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Descriptions </label>
                                <input class="form-control" type="text" placeholder="Descriptions...">
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



        {{-- view modal --}}
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">discount-decleare</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Discount Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Discount Name.." disabled>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="Company"> Discount Type</label>
                                <select id="Discount Type" class="selectpicker w-100" disabled>
                                    <option> Company</option>
                                    <option selected>Monthly Purchase Discunt</option>
                                    <option>Daily Purchase Discunt</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Start Date</label>
                                <input class="form-control" type="date" name="start-date" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>End Date</label>
                                <input class="form-control" type="date" name="start-date" disabled>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>TO Amount</label>
                                <input class="form-control" type="number" name="to-amount-date" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>From Amount</label>
                                <input class="form-control" type="number" name="from-amount" value="" disabled>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Descriptions </label>
                                <input class="form-control" type="text" placeholder="Descriptions..." disabled>
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
<script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
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
                "responsive": true
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
