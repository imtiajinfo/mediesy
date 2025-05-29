@extends('layouts.admin')
@section('title', 'Admin | assign-product-to-sales-man')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.brand')}}">Product Assign</a></li>
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
                <h4 class="card-title float-left pt-2"> List Of Product for Assignee Sales Man</h4>

                <div class="float-right d-flex my-auto gap-3">
                    <div class="form-group mb-0">
                        <label for="mySelect p">Sort By:</label>
                        <select id="mySelect" class="selectpicker" data-live-search="true">
                            <option selected>Sales Man</option>
                            <option>Sakibul Hasan</option>
                            <option>Atikur Rahman</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <div class="form-group mb-0" style="width:240px">
                        <input type="date" class="form-control" id="datepicker" name="datepicker">
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
                            <th>Sales Man Name</th>
                            <th>Assignee Date</th>
                            <th>Total Product Qty</th>
                            <th>Total Sales Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        <tr>
                            <td>01</td>
                            <td>Sakibul Hasan</td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>Ariful islam</td>
                            <td>20-July-2023</td>
                            <td>40 PCS</td>
                            <td>6300 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>Atikur Rrahman</td>
                            <td>20-July-2023</td>
                            <td>30 PCS</td>
                            <td>8763 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>04</td>
                            <td>Md Murad Mia</td>
                            <td>23-July-2023</td>
                            <td>20 PCS</td>
                            <td>8373 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>05</td>
                            <td>Amin Hasan</td>
                            <td>20-July-2023</td>
                            <td>100 PCS</td>
                            <td>8200 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>06</td>
                            <td>Suhag</td>
                            <td>20-July-2023</td>
                            <td>350 PCS</td>
                            <td>98700 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>07</td>
                            <td>Alom Mia </td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>08</td>
                            <td>Anisul Hasan</td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>09</td>
                            <td>Rahman Hasan</td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Simin Ali</td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view" data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>01</td>
                            <td>Sakibul Hasan</td>
                            <td>20-July-2023</td>
                            <td>50 PCS</td>
                            <td>5000 TK</td>
                            <td>
                                <a link="#" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
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


        <!--Add Modal -->
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Product Assign to Sales Man</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="branch">Select Branch</label>
                                <select id="branch" class="selectpicker w-100">
                                    <option>Select Branch</option>
                                    <option selected>Gulsan Branch</option>
                                    <option>Uttara Branch</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="store">Select Store</label>
                                <select id="store" class="selectpicker w-100">
                                    <option>Select Store</option>
                                    <option selected>Modina Store</option>
                                    <option>Mokka Store</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="">Select Sales Man</label>
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option selected>Select Sales Man</option>
                                        <option>Amin Khan</option>
                                        <option>Atikuk Rahman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Assign Date</label>
                                <input class="form-control" type="date" name="date">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Product</label>
                                <input class="form-control" type="text" name="total_product" value="36" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Price </label>
                                <input class="form-control" type="number" value="3046" disabled>
                            </div>
                        </div>
                        <h6 class="py-2 mt-4 mb-4 border-bottom">Assign Product </h6>

                        <div class="row justify-content-center my-auto">
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option selected>Select Category</option>
                                        <option>Water</option>
                                        <option>Oil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option selected>Select Product</option>
                                        <option>Pure water</option>
                                        <option>Rupcada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100">
                                        <option selected>Unit</option>
                                        <option>PCS</option>
                                        <option>KG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-auto">
                                <div class="form-group mb-0">
                                    <button onclick="add()" id="add" class="btn btn-sm btn-primary ml-2">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <table class="table mt-4 aiz-table table-bordered">
                                <thead>
                                    <tr class="bg-light my-auto">
                                        <th class="text-center">SL</th>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-center">Published Price</th>
                                        <th class="text-center">Sell Price</th>
                                        <th class="text-center">Purchase Price</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Product Qty</th>
                                        <th class="text-left">Remarks</th>
                                        <th class="text-left">Action</th>
                                        {{-- <th class="text-right">
                                                    <div class="form-group">
                                                        <div class="aiz-checkbox-inline">
                                                            <label class="aiz-checkbox">
                                                                <input type="checkbox" class="check-all">
                                                                <span class="aiz-square-check"></span></label>
                                                        </div>
                                                    </div>
                                                </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-left">Rupcada Oil</td>
                                        <td class="text-center">9373 TK</td>
                                        <td class="text-center">8763 TK</td>
                                        <td class="text-center">6733 TK</td>
                                        <td class="text-center">PCS</td>
                                        <td class="text-center"><input type="number" class="form-control" value="1" min="1" max="1000" placeholder="Qty"></td>
                                        <td class="text-left"><input type="text" class="form-control" placeholder="Remarks"></td>
                                        {{-- <td class="text-right">
                                                    <div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-one" value="20"><span class="aiz-square-check"></span></label></div>
                                                </td> --}}
                                        <td class="text-center">
                                            <button onclick="add()" id="add" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                            <button type="button" class="btn btn-warning">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit modal --}}
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Product Assign to Sales Man</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="branch">Select Branch</label>
                                <select id="branch" class="selectpicker w-100">
                                    <option>Select Branch</option>
                                    <option selected>Gulsan Branch</option>
                                    <option>Uttara Branch</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="store">Select Store</label>
                                <select id="store" class="selectpicker w-100">
                                    <option>Select Store</option>
                                    <option selected>Modina Store</option>
                                    <option>Mokka Store</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="">Select Sales Man</label>
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option>Select Sales Man</option>
                                        <option selected>Amin Khan</option>
                                        <option>Atikuk Rahman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Assign Date</label>
                                <input class="form-control" type="date" name="date" value="2022-01-25">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Product</label>
                                <input class="form-control" type="text" name="total_product" value="36" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Price </label>
                                <input class="form-control" type="number" value="3046" disabled>
                            </div>
                        </div>
                        <h6 class="py-2 mt-4 mb-4 border-bottom">Assign Product </h6>

                        <div class="row justify-content-center my-auto">
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option selected>Select Category</option>
                                        <option>Water</option>
                                        <option>Oil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" data-live-search="true">
                                        <option selected>Select Product</option>
                                        <option>Pure water</option>
                                        <option>Rupcada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100">
                                        <option selected>Unit</option>
                                        <option>PCS</option>
                                        <option>KG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-auto">
                                <div class="form-group mb-0">
                                    <button onclick="add()" id="add" class="btn btn-sm btn-primary ml-2">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <table class="table mt-4 aiz-table table-bordered">
                                <thead>
                                    <tr class="bg-light my-auto">
                                        <th class="text-center">SL</th>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-center">Published Price</th>
                                        <th class="text-center">Sell Price</th>
                                        <th class="text-center">Purchase Price</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Product Qty</th>
                                        <th class="text-left">Remarks</th>
                                        <th class="text-left">Action</th>
                                        {{-- <th class="text-right">
                                                    <div class="form-group">
                                                        <div class="aiz-checkbox-inline">
                                                            <label class="aiz-checkbox">
                                                                <input type="checkbox" class="check-all">
                                                                <span class="aiz-square-check"></span></label>
                                                        </div>
                                                    </div>
                                                </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-left">Rupcada Oil</td>
                                        <td class="text-center">9373 TK</td>
                                        <td class="text-center">8763 TK</td>
                                        <td class="text-center">6733 TK</td>
                                        <td class="text-center">PCS</td>
                                        <td class="text-center">
                                            <input type="number" class="form-control" value="1" min="1" max="1000" placeholder="Qty">
                                        </td>
                                        <td class="text-left">
                                            <input type="text" class="form-control" placeholder="Remarks">
                                        </td>
                                        {{-- <td class="text-right">
                                                    <div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-one" value="20"><span class="aiz-square-check"></span></label></div>
                                                </td> --}}
                                        <td class="text-center">
                                            <button onclick="add()" id="add" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewModalLabel">Product Assign to Sales Man</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="branch">Select Branch</label>
                                <select id="branch" class="selectpicker w-100" disabled>
                                    <option>Select Branch</option>
                                    <option selected>Gulsan Branch</option>
                                    <option>Uttara Branch</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="store">Select Store</label>
                                <select id="store" class="selectpicker w-100" disabled>
                                    <option>Select Store</option>
                                    <option selected>Modina Store</option>
                                    <option>Mokka Store</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label for="">Select Sales Man</label>
                                <div class="form-group mb-0">
                                    <select id="mySelect" class="selectpicker w-100" disabled>
                                        <option>Select Sales Man</option>
                                        <option selected>Amin Khan</option>
                                        <option>Atikuk Rahman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Assign Date</label>
                                <input class="form-control" type="date" name="date" value="2022-01-25" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Product</label>
                                <input class="form-control" type="text" name="total_product" value="36" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Total Price </label>
                                <input class="form-control" type="number" value="3046" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row justify-content-center">
                            <table class="table mt-4 aiz-table table-bordered">
                                <thead>
                                    <tr class="bg-light my-auto">
                                        <th class="text-center">SL</th>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-center">Published Price</th>
                                        <th class="text-center">Sell Price</th>
                                        <th class="text-center">Purchase Price</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Product Qty</th>
                                        <th class="text-left">Remarks</th>
                                        {{-- <th class="text-right">
                                                    <div class="form-group">
                                                        <div class="aiz-checkbox-inline">
                                                            <label class="aiz-checkbox">
                                                                <input type="checkbox" class="check-all">
                                                                <span class="aiz-square-check"></span></label>
                                                        </div>
                                                    </div>
                                                </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-left">Rupcada Oil</td>
                                        <td class="text-center">9373 TK</td>
                                        <td class="text-center">8763 TK</td>
                                        <td class="text-center">6733 TK</td>
                                        <td class="text-center">PCS</td>
                                        <td class="text-center"><input type="number" class="form-control" value="1" min="1" max="1000" placeholder="Qty" disabled></td>
                                        <td class="text-left"><input type="text" class="form-control" value="" placeholder="Remarks" disabled></td>
                                        {{-- <td class="text-right">
                                                    <div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-one" value="20"><span class="aiz-square-check"></span></label></div>
                                                </td> --}}
                                    </tr>
                                </tbody>
                            </table>
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
