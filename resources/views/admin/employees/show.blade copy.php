@extends('layouts.admin')
@section('title', 'Admin | employees')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.employees.index') }}">Employees</a></li>
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
            <h4 class="card-title float-left pt-2">Update Employee</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">employee Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee Name..." id="name" value="{{ old('name', $employee->name) }}" disabled>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ old('phone', $employee->phone) }}" <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee Name..." id="name" value="{{ old('name', $employee->name) }}" disabled>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email',$employee->email) }}" <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee Name..." id="name" value="{{ old('name', $employee->name) }}" disabled>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password..." id="password" value="{{ old('password',$employee->password) }}" <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee Name..." id="name" value="{{ old('name', $employee->name) }}" disabled>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" placeholder="" id="role" disabled>
                                <option value="">Select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ (old('role') == $role->name || $role->name == $employee->role) ? 'selected' : '' }} disabled>
                                    {{ $role->name}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="store_id">Store</label>
                            <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" id="store_id" disabled>
                                <option value="">Select store</option>

                                @foreach ($stores as $store)
                                <option value="{{ $store->id }}" {{ (old('store_id') == $store->id || $store->id == $employee->store_id) ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                                @endforeach
                            </select>

                            @error('store_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" onchange="loadDistrict(this,'#district')" class="form-control @error('country') is-invalid @enderror" placeholder="" id="country" disabled>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ (old('country') == $country->id || $country->id == $employee->country) ? 'selected' : '' }}>
                                    {{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="district">district</label>
                            <select name="district" onchange="loadUpazila(this,'#upazila')" class="form-control @error('district') is-invalid @enderror" placeholder="Enter district.." id="district" disabled>
                                <option value="" dissabled>Select district</option>
                                <option value="{{$district->name}}" selected>{{$district->name}}</option>
                            </select>
                            @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="upazila">upazila</label>
                            <select name="upazila" class="form-control @error('upazila') is-invalid @enderror" placeholder="Enter upazila.." id="upazila" disabled>
                                <option value="" dissabled>Select upazila</option>
                                <option value="{{$upazila->name}}" selected>{{$upazila->name}}</option>
                            </select>
                            @error('upazila')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="number" name="postcode" class="form-control @error('postcode') is-invalid @enderror" placeholder="Enter Postcode..." id="postcode" value="{{ old('postcode',$employee->postcode) }}" disabled>
                            @error('postcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address..." id="address" disabled>{{ old('address',$employee->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 text-right">
                        <a type="button" class="btn bg-danger" href="{{ route('admin.employees.index') }}">Cancel</a>
                    </div>
                </div>
            </form>


        </div>

    </div>
</div>

<!-- /.content -->
@endsection


laravel dev
dev station,
