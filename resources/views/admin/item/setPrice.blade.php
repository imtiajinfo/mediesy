@extends('layouts.admin')
@section('title', 'Admin | Set Price')

@section('page-headder')
@endsection
@section('content')


<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Set Price</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
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
                <h4 class="card-title float-left pt-2"> Product Set Price</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.setPriceDeclear') }}" class="form-horizontal" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12 px-4">
                            <div class="row bg-light">
                                <input type="hidden" name="id" value="{{$itemInfo->id}}">

                                <div class="mb-3 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="weight">Weight</label>
                                        <input type="number" name="weight" step="any" class="form-control @error('weight') is-invalid @enderror" id="weight" placeholder="weight.." value="{{$itemInfo->weight}}" required>
                                        @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="published_price">Published Price</label>
                                        <input type="number" name="published_price" class="form-control @error('published_price') is-invalid @enderror" id="published_price" placeholder="published_price.." value="{{$itemInfo->published_price}}" required>
                                        @error('published_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" placeholder="purchase_price.." value="{{$itemInfo->purchase_price}}" required>
                                        @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-4">
                                    <label for="published_price">Discount Type<span class="text-danger">*</span></label>
                                    <div class="flex-wrap d-flex">
                                        <div style="flex-basis:45%">
                                            <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" id="discount_type">
                                                <option value="1" {{ old('discount_type', $itemInfo->discount_type) == 1 ? 'selected' : '' }}> Amount </option>
                                                <option value="0" {{ old('discount_type', $itemInfo->discount_type) == 0 ? 'selected' : '' }}> Percent </option>

                                            </select>

                                            @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div style="flex-basis:55%">
                                            <input name="discount_amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" placeholder="Discount Amount.." value="{{ $itemInfo->discount_amount }}" required>
                                            @error('discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>








                                <div class="mb-3 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="sell_price">Sales Price</label>
                                        <input type="number" name="sell_price" class="form-control @error('sell_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->sell_price}}" required>
                                        @error('sell_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="my-4 text-right">
                        <a type="button" class="btn btn-danger" href="{{ route('admin.products.index') }}">Cancel</a>
                        <button type="submit" class="btn home-details-btn btn-success">Save</button>
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
