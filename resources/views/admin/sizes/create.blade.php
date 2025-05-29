@extends('layouts.admin') @section('title', 'Admin | Size') @section('page-headder') @endsection @section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6"> <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i
                        class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sizes.index') }}">Size</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Create New Size</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.sizes.store') }}" enctype="multipart/form-data"> @csrf
                @method('POST') 
                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label for="name">Name</label><input type="text" name="name" class="form-control"
                                value="{{ old('name', optional($query)->name) }}" placeholder="Enter name..."
                                required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="size" value="1">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5"> 
                        <button type="submit" class="btn btn-primary">Save</button> 
                        <button type="reset" class="btn btn-Info bg-info">Reset</button>
                        <a type="button" class="btn bg-danger" href="{{ route('admin.sizes.index') }}">Cancel</a> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- /.content --> @endsection