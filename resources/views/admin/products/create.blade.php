@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.brand')}}">product Create</a></li>
@endsection

@section('button')
<a href="{{route('admin.products')}}" class="btn btn-primary btn-sm text-light border-0" rel="tooltip" title="back">
    Back
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Create New product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <div class="row">
                    <div class="col-md-9 px-4">
                        <div class="row bg-white">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Product Name English</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="product Name English..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Product Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="product Name Bangla..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Sub-Title</label>
                                <input class="form-control" type="text" name="sub-title" placeholder="sub-title..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Unit-Group</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Unit-Group</option>
                                    <option>Small</option>
                                    <option>Large</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Unit</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Unit</option>
                                    <option>Small</option>
                                    <option>Large</option>
                                </select>
                            </div>


                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Color</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Color</option>
                                    <option>Red</option>
                                    <option>Blue</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Brand</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Brand</option>
                                    <option>Pure</option>
                                    <option>Fresh</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Size</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Size</option>
                                    <option>Small</option>
                                    <option>Large</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>HS-Code</label>
                                <input class="form-control" type="text" name="HS-Code" placeholder="HS-Code..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Published Price</label>
                                <input class="form-control" type="number" name="Published Price" placeholder="Published Price..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Purchase Price</label>
                                <input class="form-control" type="number" name="Purchase Price" placeholder="Purchase Price..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Sells Price</label>
                                <input class="form-control" type="number" name="Sells Price" placeholder="Sells Price..." value="">
                            </div>


                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Discount Type</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Discount Type</option>
                                    <option>Percent</option>
                                    <option>Amount</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label> Discount</label>
                                <input class="form-control" type="number" name="Discount" placeholder="Discount..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="floatingTextareadesc">Title</label>
                                <textarea class="form-control" placeholder="Leave a  Title here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="floatingTextareadesc">Sub-Title</label>
                                <textarea class="form-control" placeholder="Leave a  Sub-Title here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="floatingTextareadesc">Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a  Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc">Meta Title</label>
                                <textarea class="form-control" placeholder="Leave a  Title here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc">Meta Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a  Meta Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 px-4">
                        <div class="row bg-white">

                            <div class="mb-3 col-md-12">
                                <label>Category</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Category</option>
                                    <option>Water</option>
                                    <option>Frouits</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>Sub-Category</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Sub-Category</option>
                                    <option>Fresh Water</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>Child-Category</label>
                                <select id="mySelect" class="selectpicker  w-100" data-live-search="true">
                                    <option>Select Child-Category</option>
                                    <option>Fresh Water</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="qrcode"> Generate QR Code</label>
                                <input class="form-check-input" type="checkbox" id="switchButton" name="Generate QR Code">
                            </div>
                            <div class="qrcode border" style="height:100px;">Select Chechbox and generate</div>

                            <div class="mb-3 col-md-12">
                                <label>Cover Image</label>
                                <input class="form-control" type="file" name="Cover Image" placeholder="Cover Number..." value="">
                            </div>
                            <div class="Cover border" style="height:100px;">Select Cover Image</div>

                            <div class="mb-3 col-md-12">
                                <label>Look Inside Image</label>
                                <input class="form-control" type="file" name="Look Inside Image" placeholder="Look Inside Number..." value="">
                            </div>
                            <div class="Look border" style="height:100px;">Select Look Inside Image</div>



                        </div>
                    </div>
                </div>

                <div class="mb-3 text-right">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning">Save</button>
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
