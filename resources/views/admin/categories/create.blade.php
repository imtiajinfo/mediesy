@extends('layouts.admin')
@section('title', 'Admin | Category')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i
                        class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{route('admin.categories.index')}}">Category</a></li>

        </ol>
    </div>
</div>


<div class="row">
    <div class="card p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Add New Category</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-reHIDnsive p-4">

            {{-- <div class="row"> --}}
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label for="name_english">Name</label>
                            <input type="text" name="name_english"
                                class="form-control @error('name_english') is-invalid @enderror" id="name_english"
                                placeholder="Enter Name English..." value="{{ old('name_english') }}">
                            @error('name_english')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status"
                                @if(old('status')) checked @endif value="1">
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3 row justify-content-center">
                    <div class="col-12 col-lg-5 col-md-5">
                        <button type="submit" class="btn btn-warning">Save</button>
                        <button type="reset" class="btn btn-Info bg-info">Reset</button>
                        <a type="button" class="btn bg-danger" href="{{route('admin.categories.index')}}">Cancel</a>
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
@push('.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('.selectpicker').selectpicker();

        //$('#datepicker').datepicker();
        // $('#datepicker').datepicker({
        //    format: 'yyyy-mm-dd'
        //    , language: 'en'
        //    , autoclose: true
        //});
    });
    // categories.js

    document.addEventListener('DOMContentLoaded', function () {
        const showEntriesDropdown = document.getElementById('show-entries');
        const showingEntries = document.querySelectorAll('#showing-entries');
        const totalEntries = document.getElementById('total-entries');

        showEntriesDropdown.addEventListener('change', function () {
            const selectedValue = this.value;
            axios.get(`/admin/categories?show=${selectedValue}`)
                .then(response => {
                    // Update the number of displayed entries
                    showingEntries.forEach(span => {
                        span.textContent = response.data.showing;
                        console.log(response.data);
                    });
                    // Update the total number of entries
                    totalEntries.textContent = response.data.total;
                })
                .catch(error => {
                    console.error(error);

                });
        });
    });
</script>

@endpush