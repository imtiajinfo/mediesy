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
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Create</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ route('admin.products.index') }}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Product List
            </a>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Create New product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.products.store') }}" class="form-horizontal" id="sales-form"
                    enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12 px-4">
                            <div class="row bg-light">

                                <div class="mb-2 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Product Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Product Name" value="{{ old('name') }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="strength">Strength</label>
                                        <input type="text" name="strength"
                                            class="form-control @error('strength') is-invalid @enderror"
                                            id="Reference No" placeholder="Strength" value="{{ old('strength') }}">
                                        @error('strength')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" placeholder="Brand" value="{{ old('brand') }}">
                                        @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">Type</label>
                                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Type" value="{{ old('description') }}">
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="use_for">Use For</label>
                                        <input type="text" name="use_for" class="form-control @error('use_for') is-invalid @enderror" placeholder="Use For" value="{{ old('use_for') }}">
                                        @error('use_for')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="manufacturer">Manufacturer</label>
                                        <input type="text" name="manufacturer" class="form-control @error('manufacturer') is-invalid @enderror" placeholder="Manufacturer" value="{{ old('manufacturer') }}">
                                        @error('manufacturer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="dar">DAR</label>
                                        <input type="text" name="dar" class="form-control @error('dar') is-invalid @enderror" placeholder="dar" value="{{ old('dar') }}">
                                        @error('dar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-3" style="display: none">
                                    <label for="product_type" class="control-label mb-0 pb-0">Product type<label class="text-danger">*</label></label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="product_type"
                                                class="form-select @error('product_type') is-invalid @enderror">
                                                <option value="">Select Product type</option>
                                                <option value="finished_goods" selected>Finished Goods</option>
                                                <option value="raw_materials">Raw Materials</option>
                                            </select>
                                            @error('product_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-4">
                                    <label for=" " class=" mb-2 pb-0">Category</label>
                                    <div class="" style="display: flex">
                                        <select name="category_id" class="select2" id="category" class="form-select @error('category_id') is-invalid @enderror" style="width: 85%">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                                            @endforeach
                                        </select>
                                        <label style="width:15%;" class="input-group-text btn-success bg-success" for="color"
                                            data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            <i class="fa fa-plus"></i>
                                        </label>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-4">
                                    <label for="unit" class="control-label mb-2 pb-0">Unit</label>
                                    <div class=" mr-2">
                                        <div class="" style="display: flex">
                                            <select name="unit" id="unit"
                                                class="form-select select2 @error('unit') is-invalid @enderror" >
                                                <option value="">Select Unit</option>
                                                @foreach ($uoms as $key => $trans_uom)
                                                    <option value="{{ $trans_uom->id }}">
                                                        {{  $trans_uom->uom_short_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label class="input-group-text btn-success bg-success" for="brand"
                                                data-bs-toggle="modal" data-bs-target="#unitModal">
                                                <i class="fa fa-plus"></i>
                                            </label>
                                            @error('trans_uom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-4" style="display: none">
                                    <label for="brand_id" class="control-label mb-0 pb-0">Brand</label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="brand_id" id="brand"
                                                class="form-select select2 @error('brand_id') is-invalid @enderror">
                                                <option value="">Select brand</option>
                                                @if (count($brands) > 0)
                                                @foreach ($brands as $key => $brand_id)
                                                <option class="m-1" value="{{ $brand_id->id }}">
                                                    {{ $brand_id->name_english }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <label class="input-group-text btn-success bg-success" for="brand"
                                                data-bs-toggle="modal" data-bs-target="#brandModal">
                                                <i class="fa fa-plus"></i>
                                            </label>
                                            @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 col-md-6 col-lg-3" style="display: none">
                                    <label>Cover Image</label>
                                    <input class="form-control" type="file" name="thumbnail"
                                        placeholder="Cover Number..." value="">
                                </div>

                                <div class="mb-2 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="min_qty">Quqntity Alert</label>
                                        <input type="text" name="min_qty" class="form-control @error('min_qty') is-invalid @enderror" placeholder="Quqntity Alert" value="{{ old('min_qty') }}">
                                        @error('min_qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2 col-md-12 col-lg-12">
                                    <label for="summary">Description</label>
                                    <textarea rows="4" id="summerote" class="form-control @error('summary') is-invalid @enderror"
                                        value="{{ old('summary') }}" name="summary"
                                        placeholder="write a Description here.." id="summary"></textarea>
                                    @error('summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="my-4 text-right">
                            <button type="submit" class="btn home-details-btn btn-success">Save</button>
                            <button type="reset" class="btn btn-Info bg-info">Reset</button>
                            <a type="button" class="btn btn-danger" href="{{ route('admin.products.index') }}">Cancel</a>
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
                            <input class="form-control" type="text" name="name_english"
                                placeholder="brand Name" value="">
                        </div>

                        <div class="mb-2 col-md-12 col-lg-12">
                            <label>Brand Logo</label>
                            <input class="form-control" type="file" name="logo">
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


{{-- unit modal --}}
<div class="modal fade" id="unitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add New brand</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-md-4">
                <form method="POST" id="unitForm" action="{{ route('admin.uoms.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-2 col-md-12 col-lg-12">
                            <label>Unit Name</label>
                            <input class="form-control" type="text" name="uom_short_code" placeholder="Unit Name" value="">
                        </div>

                    </div>

                    <div class="mb-2 col-12 col-md-12 col-lg-12">
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
                <h1 class="modal-title fs-5" id="addModalLabel">Add New color</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-md-4">
                <form method="POST" id="colorForm" action="{{ route('admin.colors.store') }}"
                    enctype="multipart/form-data"> @csrf @method('POST') <div class="row">
                        <div class="mb-2 col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="name_english">Name_english</label><input type="text" name="name_english"
                                    class="form-control" value="{{ old('name_english') }}"
                                    placeholder="Enter name_english..." required>@error('name_english')<div
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
                defaultOption.text = '-- Select size --';
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

    function loadUnits() {
        axios.get('/admin/load-colors')
            .then(function (response) {
                // var selectedUnitId = $('#unit').val();

                var units = response.data.units;
                var selectElement = document.getElementById('unit');
                // selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = units.id;
                defaultOption.text = units.uom_short_code;
                selectElement.appendChild(defaultOption);

                // units.forEach(function (unit) {
                //     var option = document.createElement('option');
                //     option.value = unit.id;
                //     option.text = unit.uom_short_code;
                //     selectElement.appendChild(option);
                // });
                // if (selectedUnitId) {
                //     $('#unit').val(selectedUnitId);
                // }
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

   

    document.getElementById('unitForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {
                console.log('Unit created successfully:', response.data);
                // Display success message to the user
                toastr.success('Unit created successfully!');
                loadUnits();
                // Reset the form
                document.getElementById('unitForm').reset();
                $('#unitModal').modal('hide');
            })
            .catch(function (error) {
                console.error('Error creating Unit:', error);
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

</script>
@endpush