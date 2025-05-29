@extends('layouts.admin')
@section('title', 'Admin | Brand')

@section('page-headder')
{{-- brands --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.brands.index') }}">Brand</a></li>

        </ol>
    </div>
</div>


<div class="row">
    <div class="card p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Add New Brand</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-reHIDnsive p-4">

            {{-- <div class="row"> --}}
            <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="mb-3 col-md-5 col-lg-5">
                        <label>Brand Name</label>
                        <input class="form-control" type="text" name="name_english" placeholder="brand Name English..." value="">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="mb-3 col-md-5 col-lg-5">
                        <label>Brand Logo</label>
                        <input class="form-control" type="file" name="logo" placeholder="brand Name bangla..." value="">
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-lg-5 col-md-5">
                        <button type="submit" class="btn btn-warning">Save</button>
                        <button type="reset" class="btn btn-Info bg-info">Reset</button>
                        <a type="button" class="btn bg-danger" href="{{ route('admin.brands.index') }}">Cancel</a>
                    </div>
                </div>
            </form>
            {{-- </div> --}}


        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
</div>
<!-- /.content -->
@endsection
