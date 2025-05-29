@extends('layouts.admin')
@section('title', 'Admin | uom')

@section('page-headder')
{{-- uoms --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.uoms.index') }}">Unit</a></li>

        </ol>
    </div>
</div>


<div class="row">
    <div class="card p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Add New Unit</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-reHIDnsive p-4">

            {{-- <div class="row"> --}}
            <form method="POST" action="{{ route('admin.uoms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label for="uom_short_code">Unit Name</label>
                            <input type="text" name="uom_short_code" class="form-control @error('uom_short_code') is-invalid @enderror" id="uom_short_code" placeholder="uom_short_code.." value="{{ old('uom_short_code') }}">
                            @error('uom_short_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <button type="submit" class="btn btn-warning">Create</button>
                        <button type="reset" class="btn btn-Info bg-info">Reset</button>
                        <a type="button" class="btn bg-danger" href="{{ route('admin.uoms.index') }}">Cancel</a>
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
