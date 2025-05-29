@extends('layouts.admin')
@section('title', 'Admin | Supplier')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.suppliers.index') }}">suppliers</a></li>
        </ol>
    </div>
</div>
<style>
    .book-img img {
        width: 100px;
        height: 120px
    }

    .book-text-area p {
        font-size: 13px;
    }

    .book-list-wrapper {
        text-align: center
    }

    .book-info__content .fs-6 {
        font-size: 13px;
    }

    .bookListContainer .col-4:hover {
        border: 1px solid #999;

    }

    #loader {
        display: none;

    }


    /* styles.css */

    .barcode-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 20px;
        /* Adjust the margin as needed */
    }

    .barcode-item {
        border: 1px solid #888;
        padding: 0 6px;
        margin: 4px;
        /* Adjust the margin as needed */
    }

</style>


<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Update Supplier</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.suppliers.update', $supplier->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="company_name">Company Name <span class="required">*</span></label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Enter Compnay Name" id="company_name" value="{{ $supplier->company_name }}" required>
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">Company Owner</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Company Owner" id="name" value="{{ $supplier->name }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ $supplier->phone }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ $supplier->email }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="company_tin_number"> Tax No</label>
                            <input type="number" name="company_tin_number" class="form-control @error('company_tin_number') is-invalid @enderror" placeholder="Enter Tax No" id="company_tin_number" value="{{ $supplier->company_tin_number }}">
                            @error('company_tin_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="supplier_destination">Supplier Address</label>
                            <input type="text" name="supplier_destination" class="form-control @error('supplier_destination') is-invalid @enderror" placeholder="Enter Supplier Address..." id="supplier_destination" value="{{ $supplier->supplier_destination }}">
                            @error('supplier_destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="brand"> Brand</label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" placeholder="Enter brand..." id="brand" value="{{ $supplier->brand }}">
                            @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                <div class="mb-3 text-right">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a type="button" class="btn btn-primary" href="{{ route('admin.suppliers.index') }}">Cancel</a>
                </div>
        </div>
    </form>

</div>

</div>
</div>
<!-- /.content -->
@endsection
