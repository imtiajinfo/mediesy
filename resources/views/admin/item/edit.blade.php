@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
@endsection
@section('content')

<link rel="stylesheet" href=link rel="stylesheet" href="{{asset('backend/dist/css/bootstrap-multiselect.css')}}">


<div class="row my-auto align-items-center bg-white shadow-md border mb-2 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Update</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            {{-- <span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span> --}}
            <a href="{{ route('admin.products.index') }}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Products
            </a>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Update product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.products.update', $itemInfo->id) }}" class="form-horizontal"
                    id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 px-4">
                            <div class="row bg-light">

                                <div class="mb-2 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Product Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Product Name" value="{{ old('name', $itemInfo->name) }}"
                                            required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-5 col-lg-3 d-none">
                                    <div class="form-group">
                                        <label for="sub_title">Product Code</label>
                                        <input type="text" name="sub_title"
                                            class="form-control @error('sub_title') is-invalid @enderror"
                                            id="Reference No" placeholder="Reference No.."
                                            value="{{ old('sub_title', $itemInfo->sub_title) }}">
                                        @error('sub_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-4" style="display: none">
                                    <label for="product_type" class="control-label mb-0 pb-0">Product type<label
                                            class="text-danger">*</label></label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="product_type"
                                                class="form-select select2 @error('product_type') is-invalid @enderror">
                                                <option value="finished_goods" @if($itemInfo->product_type ==
                                                    "finished_goods") selected @endif>finished_goods</option>
                                                <option value="raw_materials" @if($itemInfo->product_type ==
                                                    "raw_materials") selected @endif>raw_materials</option>
                                            </select>
                                            @error('product_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="strength">Strength</label>
                                        <input type="text" name="strength"
                                            class="form-control @error('strength') is-invalid @enderror"
                                            id="Reference No" placeholder="Strength" value="{{ $itemInfo->strength }}">
                                        @error('strength')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" placeholder="Brand" value="{{ $itemInfo->brand }}">
                                        @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">Type</label>
                                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Type" value="{{ $itemInfo->description }}">
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="use_for">Use For</label>
                                        <input type="text" name="use_for" class="form-control @error('use_for') is-invalid @enderror" placeholder="Use For" value="{{ $itemInfo->use_for }}">
                                        @error('use_for')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="manufacturer">Manufacturer</label>
                                        <input type="text" name="manufacturer" class="form-control @error('manufacturer') is-invalid @enderror" placeholder="Manufacturer" value="{{ $itemInfo->manufacturer }}">
                                        @error('manufacturer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="dar">DAR</label>
                                        <input type="text" name="dar" class="form-control @error('dar') is-invalid @enderror" placeholder="dar" value="{{ $itemInfo->dar }}">
                                        @error('dar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-2 col-md-6 col-lg-4">
                                    <label for=" " class=" mb-2 pb-0">Category</label>
                                    <div class="">
                                        <select name="category_id" id="category"
                                            class="form-select select2 @error('size_id') is-invalid @enderror">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option @if($itemInfo->category_id == $item->id)
                                                    selected
                                                    @endif value="{{$item->id}}">{{$item->name_english}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <label class="input-group-text btn-success bg-success" for="color"
                                            data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            <i class="fa fa-plus"></i>
                                        </label> --}}
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-4">
                                    <label for="trans_uom" class=" mb-2 pb-0">Unit</label>
                                    <div class=" mr-2">
                                        <div class="">
                                            <select name="trans_uom"
                                                class="form-select select2 @error('trans_uom') is-invalid @enderror">
                                                <option value="">Select Unit</option>
                                                @foreach ($uoms as $key => $trans_uom)
                                                <option value="{{ $trans_uom->id }}" @if($itemInfo->trans_uom ==
                                                    $trans_uom->id)
                                                    selected @endif>
                                                    {{ $trans_uom->uom_short_code }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('trans_uom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="min_qty">Quqntity Alert</label>
                                        <input type="text" name="min_qty" class="form-control @error('min_qty') is-invalid @enderror" placeholder="Quqntity Alert" value="{{ $itemInfo->min_qty }}">
                                        @error('min_qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                               
                                {{-- <div class="mb-2 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sub_title">Sell Price</label>
                                        <input type="text" name="sell_price"
                                            class="form-control @error('sell_price') is-invalid @enderror"
                                            id="Sell Price" placeholder="Sell Price.."
                                            value="{{ $itemInfo->sell_price }}">
                                        @error('sell_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="mb-2 col-md-6 col-lg-4 d-none">
                                    <label>Cover Image</label>
                                    <div>
                                        @if($itemInfo->thumbnail != 'default.png')
                                        <img src="{{ asset('uploads/products/'.$itemInfo->thumbnail) }}" alt="{{$itemInfo->thumbnail}}" width="30">
                                        @endif
                                    </div>
                                    <input class="form-control" type="file" name="thumbnail" placeholder="Cover Number..." value="">
                                </div>

                                <div class="mb-2 col-md-12 col-lg-12">
                                    <label for="summary">Description</label>
                                    <textarea rows="4" id="summerote" class="form-control @error('summary') is-invalid @enderror"
                                        name="summary" placeholder="Leave a  summarys here.."
                                        id="summary">{{$itemInfo->summary}}</textarea>
                                    @error('summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="my-4 text-right">
                            <button type="submit" class="btn home-details-btn btn-success">Update</button>
                            <button type="reset" class="btn btn-Info bg-info">Reset</button>
                            <a type="button" class="btn btn-danger"
                                href="{{ route('admin.products.index') }}">Cancel</a>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->


        {{-- add category modal --}}
        <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="addModalLabelcategory" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabelcategory">Add New Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <form method="POST" action="{{ route('admin.categories.store') }}" id="categoryForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="name_english">English Name</label>
                                        <input type="text" name="name_english"
                                            class="form-control @error('name_english') is-invalid @enderror"
                                            id="name_english" placeholder="Enter Name English..."
                                            value="{{ old('name_english') }}">
                                        @error('name_english')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <input type="checkbox" name="status" id="status" value="1" @if(old('status'))
                                            checked @endif>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-warning">Save</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- size modal --}}
        <div class="modal fade" id="sizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="sizeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Size</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">

                        <form method="POST" id="sizeForm" action="{{ route('admin.sizes.store') }}"
                            enctype="multipart/form-data"> @csrf @method('POST')
                            <div class="row">
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Name</label><input type="text" name="name"
                                            class="form-control" value="{{ old('name') }}" placeholder="Enter name..."
                                            required>@error('name')<div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name_bangla">Name_bangla</label><input type="text"
                                            name="name_bangla" class="form-control" value="{{ old('name_bangla') }}"
                                            placeholder="Enter name_bangla..." required>@error('name_bangla')<div
                                            class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="size">Size</label><input type="number" step="any" name="size"
                                            class="form-control" value="{{ old('size') }}" placeholder="Enter size..."
                                            required>@error('size')<div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label><textarea name="description"
                                            class="form-control"
                                            required>Enter Descriptions... {{ old('description') }}</textarea>@error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-2 text-right">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- brand modal --}}
        <div class="modal fade" id="brandModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="brandModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <form method="POST" id="brandForm" action="{{ route('admin.brands.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-2 col-md-12 col-lg-12">
                                    <label>Brand Name</label>
                                    <input class="form-control" type="text" name="name_english">
                                </div>

                                <div class="mb-2 col-md-12 col-lg-12">
                                    <label>Brand Logo</label>
                                    <input class="form-control" type="file" name="logo" placeholder="brand Name">
                                </div>

                            </div>

                            <div class="mb-2 col-12 col-md-4 col-lg-4">
                                <button type="submit" class="btn btn-warning">Save</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

        {{-- color modal --}}
        <div class="modal fade" id="colorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="colorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <form method="POST" id="colorForm" action="{{ route('admin.colors.store') }}"
                            enctype="multipart/form-data"> @csrf @method('POST') <div class="row">
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name_english">Name_english</label><input type="text"
                                            name="name_english" class="form-control" value="{{ old('name_english') }}"
                                            placeholder="Enter name_english..." required>@error('name_english')<div
                                            class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name_bangla">Name_bangla</label><input type="text"
                                            name="name_bangla" class="form-control" value="{{ old('name_bangla') }}"
                                            placeholder="Enter name_bangla..." required>@error('name_bangla')<div
                                            class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="color">Code</label><input type="color" name="code"
                                            class="form-control" value="{{ old('code',) }}" placeholder="Enter code..."
                                            required>@error('code')<div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-12 col-md-4 col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label><textarea name="description"
                                            class="form-control" placeholder="Enter Descriptions..."
                                            required> {{ old('description') }}</textarea>@error('description')<div
                                            class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-12 text-right">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Save</button>
                                </div>
                        </form>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function () {

        // $('#category').click(function () {
        //     loadCategories();
        // });
        // $('#size').click(function () {
        //     loadSizes();
        // });
        // $('#brand').click(function () {
        //     loadBrands();
        // });
        // $('#color').click(function () {
        //     loadColors();
        // });


        $('#filterBehavior').multiselect({
            //  enableFiltering: true
            // , includeResetOption: true
            // , includeResetDivider: true
            // , includeSelectAllOption: true
            // , enableHTML: true
            // , filterPlaceholder: 'Search'


        });
    });


    function loadCategories() {
        axios.get('/admin/load-categories')
            .then(function (response) {
                var selectedCategoryId = $('#category').val();
                console.log('Categories loaded:', response.data.categories);
                var categories = response.data.categories;
                var selectElement = document.getElementById('category');
                selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Select Category';
                selectElement.appendChild(defaultOption);

                categories.forEach(function (category) {
                    var option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.name_english;
                    selectElement.appendChild(option);
                });
                if (selectedCategoryId) {
                    $('#category').val(selectedCategoryId);
                }
            })
            .catch(function (error) {
                console.error('Failed to fetch categories:', error);
                toastr.error(error.message);
            });
    }

    function loadSizes() {
        axios.get('/admin/load-sizes')
            .then(function (response) {
                var selectedSizeId = $('#size').val();
                console.log('sizes loaded:', response.data.sizes);
                var sizes = response.data.sizes;
                var selectElement = document.getElementById('size');
                selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Select size';
                selectElement.appendChild(defaultOption);

                sizes.forEach(function (size) {
                    var option = document.createElement('option');
                    option.value = size.id;
                    option.text = size.name;
                    selectElement.appendChild(option);
                });
                if (selectedSizeId) {
                    $('#size').val(selectedSizeId);
                }
            })
            .catch(function (error) {
                console.error('Failed to fetch sizes:', error);
                toastr.error(error.message);
            });
    }

    function loadBrands() {
        axios.get('/admin/load-brands')
            .then(function (response) {
                var selectedBrandId = $('#brand').val();
                console.log('brands loaded:', response.data.brands);

                var brands = response.data.brands;
                var selectElement = document.getElementById('brand');
                selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Select brand';
                selectElement.appendChild(defaultOption);

                brands.forEach(function (brand) {
                    var option = document.createElement('option');
                    option.value = brand.id;
                    option.text = brand.name_english;
                    selectElement.appendChild(option);
                });
                if (selectedBrandId) {
                    $('#brand').val(selectedBrandId);
                }
            })
            .catch(function (error) {
                console.error('Failed to fetch brands:', error);
                toastr.error(error.message);
            });
    }

    function loadColors() {
        axios.get('/admin/load-colors')
            .then(function (response) {
                var selectedColorId = $('#color').val();
                console.log('colors loaded:', response.data.colors);

                var colors = response.data.colors;
                var selectElement = document.getElementById('color');
                selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = '-- Select color --';
                selectElement.appendChild(defaultOption);

                colors.forEach(function (color) {
                    var option = document.createElement('option');
                    option.value = color.id;
                    option.text = color.name_english;
                    selectElement.appendChild(option);
                });
                if (selectedColorId) {
                    $('#color').val(selectedColorId);
                }
            })
            .catch(function (error) {
                console.error('Failed to fetch colors:', error);
                toastr.error(error.message);
            });
    }


    document.getElementById('categoryForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {
                console.log('Category created successfully:', response.data);
                // Display success message to the user
                toastr.success('Category created successfully!');
                // Reset the form
                loadCategories();
                document.getElementById('categoryForm').reset();
                $('#addCategoryModal').modal('hide');
            })
            .catch(function (error) {
                console.error('Error creating category:', error);
                // Display error message to the user (optional)
                //toastr.error('Failed to create category. Please try again later.', error.message);
                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] +
                                '<br>'; // Assuming the first error message is the relevant one
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });



    document.getElementById('sizeForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {
                console.log('size created successfully:', response.data);
                // Display success message to the user
                toastr.success('size created successfully!');
                // Reset the form
                document.getElementById('sizeForm').reset();
                $('#sizeModal').modal('hide');
            })
            .catch(function (error) {
                console.error('Error creating size:', error);
                //toastr.error('Failed to create size. Please try again later.', error.message);
                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] +
                                '<br>'; // Assuming the first error message is the relevant one
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });


    document.getElementById('brandForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {
                console.log('brand created successfully:', response.data);
                // Display success message to the user
                toastr.success('brand created successfully!');
                // Reset the form
                loadBrands();
                document.getElementById('brandForm').reset();
                $('#brandModal').modal('hide');
            })
            .catch(function (error) {
                console.error('Error creating brand:', error);
                //toastr.error('Failed to create brand. Please try again later.', error.message);
                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] +
                                '<br>'; // Assuming the first error message is the relevant one
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });

    document.getElementById('colorForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {
                console.log('color created successfully:', response.data);
                // Display success message to the user
                toastr.success('color created successfully!');
                // Reset the form
                document.getElementById('colorForm').reset();
                $('#colorModal').modal('hide');
            })
            .catch(function (error) {
                console.error('Error creating color:', error);
                //toastr.error('Failed to create color. Please try again later.', error.message);
                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] +
                                '<br>'; // Assuming the first error message is the relevant one
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });




    $('#category').change(function () {
        var categoryId = $(this).val();
        if (categoryId) {
            // Load subcategories based on the selected category
            $.ajax({
                url: '/admin/load-subcategories/' + categoryId,
                type: 'GET',
                success: function (data) {
                    // Enable or disable the subcategory dropdown based on the presence of subcategories
                    if (data.subcategories && data.subcategories.length > 0) {
                        $('#subcategory').prop('disabled', false);
                    } else {
                        $('#subcategory').prop('disabled', true);
                    }

                    // Populate subcategories dropdown
                    $('#subcategory').empty().append($('<option>', {
                        value: '',
                        text: '-- Select Subcategory --'
                    }));
                    $.each(data.subcategories, function (index, subcategory) {
                        $('#subcategory').append($('<option>', {
                            value: subcategory.id,
                            text: subcategory.name_english
                        }));
                    });
                }
            });
        } else {
            // If no category is selected, disable and empty the subcategory and child category dropdowns
            $('#subcategory').prop('disabled', true).empty();
            $('#childcategory').prop('disabled', true).empty();
        }
    });

    $('#subcategory').change(function () {
        var subcategoryId = $(this).val();
        if (subcategoryId) {
            // Load child categories based on the selected subcategory
            $.ajax({
                url: '/admin/load-childcategories/' + subcategoryId,
                type: 'GET',
                success: function (data) {
                    // Enable or disable the child category dropdown based on the presence of child categories
                    if (data.childcategories && data.childcategories.length > 0) {
                        $('#childcategory').prop('disabled', false);
                    } else {
                        $('#childcategory').prop('disabled', true);
                    }

                    // Populate child categories dropdown
                    $('#childcategory').empty().append($('<option>', {
                        value: '',
                        text: '-- Select Child Category --'
                    }));
                    $.each(data.childcategories, function (index, childcategory) {
                        $('#childcategory').append($('<option>', {
                            value: childcategory.id,
                            text: childcategory.name_english
                        }));
                    });
                }
            });
        } else {
            // If no subcategory is selected, disable and empty the child category dropdown
            $('#childcategory').prop('disabled', true).empty();
        }
    });
</script>
@endpush