@extends('layouts.admin')
@section('title', 'Admin | bankInfo')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.bankInfo.index') }}">bankInfo</a></li>
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
            <h4 class="card-title float-left pt-2">Create New bankInfo</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.bankInfo.update', $bankInfo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">Bank Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter bankInfo Name..." id="name" value="{{ old('name', $bankInfo->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name_bangla">Bank Name bangla</label>
                            <input type="name_bangla" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" placeholder="Enter name_bangla..." id="name_bangla" value="{{ old('name_bangla', $bankInfo->name_bangla) }}" required>
                            @error('name_bangla')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="origin">Bank Origin</label>
                            <select name="origin" class="form-control @error('origin') is-invalid @enderror" placeholder="" id="origin">
                                <option value="">Select Bank Origin</option>
                                <option value="Local" {{ old('origin') == 'Local'  || $bankInfo->origin == "Local" ? 'selected' : '' }}>Local</option>
                    <option value="Foregin" {{ old('origin') == 'Foregin'  || $bankInfo->origin == 'Foregin' ? 'selected' : '' }}>Foregin</option>
                    </select>
                    @error('origin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div> --}}

        <div class="mb-3 col-md-4 col-lg-3">
            <div class="form-group">
                <label for="account_type">Bank Account Type</label>
                <select name="account_type" class="form-control @error('account_type') is-invalid @enderror" placeholder="" id="account_type">
                    <option value="">Select Account Type</option>
                    <option value="Saving-Account" {{ old('account_type') == 'Saving-Account' || $bankInfo->account_type == "Saving-Account" ? 'selected' : '' }}>Saving-Account</option>
                    <option value="Selary-Account" {{ old('account_type') == 'Selary-Account' || $bankInfo->account_type == "Selary-Account" ? 'selected' : '' }}>Selary-Account</option>
                </select>
                @error('account_type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 col-md-4 col-lg-3">
            <div class="form-group">
                <label for="branch">Bank Branch</label>
                <input type="text" name="branch" class="form-control @error('branch') is-invalid @enderror" placeholder="Enter branch..." id="branch" value="{{ $bankInfo->branch }}" required>
                @error('branch')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 col-md-4 col-lg-3">
            <div class="form-group">
                <label for="descriptions">Descriptions</label>
                <textarea name="descriptions" class="form-control @error('descriptions') is-invalid @enderror" placeholder="Enter descriptions..." id="descriptions">{{ old('descriptions', $bankInfo->descriptions) }}</textarea>
                @error('descriptions')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 text-right">
            <a type="button" class="btn bg-danger" href="{{ route('admin.bankInfo.index') }}">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
    </form>


</div>

</div>
</div>

<!-- /.content -->
@endsection
