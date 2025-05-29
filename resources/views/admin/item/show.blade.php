@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
@endsection
@section('content')

<link rel="stylesheet" href=link rel="stylesheet" href="{{asset('backend/dist/css/bootstrap-multiselect.css')}}">


<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
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
                <h4 class="card-title float-left pt-2">Create New product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.products.store') }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-9 px-4">
                            <div class="row bg-light">

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->name}}" disabled>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name_bangla">Name Bangla</label>
                                        <input type="text" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->name_bangla}}" disabled>
                                        @error('name_bangla')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name_bangla">Transaction UOM</label>
                                        <input type="text" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->trans_uom}}" disabled>
                                        @error('name_bangla')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name_bangla">Stock UOM</label>
                                        <input type="text" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->stock_uom}}" disabled>
                                        @error('name_bangla')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sales_uom">Sales UOM</label>
                                        <input type="text" name="sales_uom" class="form-control @error('sales_uom') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->sales_uom}}" disabled>
                                        @error('sales_uom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="brand_id">Brand</label>
                                        <input type="text" name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->brands->name_english}}" disabled>
                                        @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="brand_id">Color</label>
                                        {{-- <input type="text" name="color_id" class="form-control @error('color_id') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->color_id}}" disabled> --}}

                                        @if($itemInfo->color_id)
                                        @foreach($itemInfo->color_id as $colorId)
                                        @php
                                        $color = App\Models\Color::find($colorId);
                                        @endphp

                                        @if($color)
                                        <p class="px-1 py-2 mx-1 color-box" style="background:{{$color->code }};width:auto; line-height:1.0; font-size:11px">
                                            {{$color->name_english}}
                                        </p>
                                        @endif
                                        @endforeach
                                        @else
                                        No color
                                        @endif
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="size_id">Size</label>
                                        <input type="text" name="size_id" class="form-control" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->sizes->name  ?? ""}}" disabled>
                                        @error('size_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="weight">Weight</label>
                                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->weight}}" disabled>
                                        @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="published_price">Published Price</label>
                                        <input type="number" name="published_price" class="form-control @error('published_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->published_price}}" disabled>
                                        @error('published_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->purchase_price}}" disabled>
                                        @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for="published_price">Discount Type<span class="text-danger">*</span></label>
                                    <div class="flex-wrap d-flex">
                                        <div style="flex-basis:45%">
                                            <input name="discount_type" type="text" class="form-control @error('discount_type') is-invalid @enderror" id="discount_type" placeholder="Discount Type.." value="{{ ($itemInfo->discount_type == 1) ? "Amount" : "Percent" }}" disabled>
                                            @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div style="flex-basis:55%">
                                            <input name="discount_amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" placeholder="Discount Amount.." value="{{ $itemInfo->discount_amount }}" disabled>
                                            @error('discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sell_price">Sales Price</label>
                                        <input type="number" name="sell_price" class="form-control @error('sell_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->sell_price}}" disabled>
                                        @error('sell_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="safety_level">Safety Level</label>
                                        <input type="number" name="safety_level" class="form-control @error('safety_level') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->safety_level}}" disabled>
                                        @error('safety_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sub_title">Serial Number</label>
                                        <input type="text" name="sub_title" class="form-control @error('sub_title') is-invalid @enderror" id="sub_title" placeholder="Reference No.." value="{{ old($itemInfo->sub_title ?? "") }}" disabled>
                                        @error('sub_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{--
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="reorder_level">Reorder Level</label>
                                        <input type="number" name="reorder_level" class="form-control @error('reorder_level') is-invalid @enderror" value="{{$itemInfo->reorder_level}}" disabled id="Reference No" placeholder="Reference No..">
                                @error('reorder_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="mb-3 col-md-6">
                                    <label for="sub_title">Sub Title</label>
                                    <textarea id="summerote" class="form-control @error('sub_title') is-invalid @enderror" value="{{ old('sub_title') }}" name="sub_title" placeholder="Leave a sub_titles here.." id="sub_title" disabled> {{$itemInfo->sub_title}} </textarea>
                        @error('sub_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="mb-3 col-md-6">
                        <label for="summary">Remarks</label>
                        <textarea id="summerote" class="form-control @error('summary') is-invalid @enderror" name="summary" placeholder="Leave a  summarys here.." id="summary" disabled> {{$itemInfo->summary}}</textarea>
                        @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
            </div>
        </div>

        <div class="col-md-3 px-4">
            <div class="row bg-white">


                <div class="mb-3 col-md-12">
                    <label for="summary">Category</label>
                    <input id="category_id" class="form-control" name="summary" placeholder="Category.." value="{{$itemInfo->category->name_english }}" disabled>
                    @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>




                <div class="mb-3 col-md-12">
                    <label>Cover Image</label> <br>

                    <img src="{{ asset('uploads/products/'.$itemInfo->thumbnail) }}" alt="{{$itemInfo->thumbnail}}" width="250">

                </div>

            </div>
        </div>
    </div>

    <div class="my-4 text-right">
        <a class="btn btn-lg btn-danger" href="{{ route('admin.products.index') }}">Close</a>
    </div>
    </form>
</div>
<!-- /.card-body -->

</div>
<!-- /.card -->


</div>
<!-- /.col -->

</div>
<!-- /.content -->
@endsection
