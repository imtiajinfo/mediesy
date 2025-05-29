@extends('layouts.admin')
@section('title', 'Admin | permissions')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.brands.index')}}">permissions Create</a></li>
@endsection

@section('button')
<a href="{{route('admin.permissions')}}" class="btn btn-primary btn-sm text-light border-0" rel="tooltip" title="back">
    Back
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Permissions</h4>
            </div>
            <div class="card-body card-body">
                <div class="row bg-white px-4">
                    <div class="mb-3 col-md-12 px-0">
                        <h4>Role Privilege</h4>
                        <h5>Role : <span class="badge bg-warning text-white">Manager</span></h5>
                        <hr>
                        <h6>Permissions</h6>
                    </div>
                    <table id="example1" class="table table-hover">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Menu Name</th>
                                <th>List</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>View</th>
                                <th>Delete</th>
                                <th>Status (On/Off)</th>
                            </tr>
                        </thead>
                        <tbody id="datatable">
                            <tr>
                                <td>01</td>
                                <td> Category</td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td> Size</td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td> Brand</td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td> Pproducts</td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                                <td>
                                    <div class="form-check"> <input class="form-check-input" type="checkbox" checked></div>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                    <div class="mb-3 text-right">
                        <button type="button" class="btn btn-lg btn-warning">Save</button>
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
