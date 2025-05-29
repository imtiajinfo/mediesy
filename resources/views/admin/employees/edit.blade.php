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
            <form method="POST" action="{{ route('admin.employees.update', $employee->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">employee Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee Name..." id="name" value="{{ old('name', $employee->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ old('phone', $employee->phone) }}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email',$employee->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password..." id="password" value="{{ old('password',$decryptedPassword) }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                </div>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" placeholder="" id="role">
                                <option value="">Select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ (old('role') == $role->name || $role->name == $employee->role) ? 'selected' : '' }}>
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
                            <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" id="store_id">
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
                            <label for="salary">Salary(BDT)</label>
                            <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" placeholder="Enter salary..." id="salary" value="{{ $employee->salary  }}" required>
                            @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Enter image..." id="image" value="{{ old('image') }}">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <img src="{{ asset('uploads/employee/' . $employee->image) }}" alt="{{ $employee->image }}" width="120">

                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="nid_font">NID Doc(Font Side)</label>
                            <input type="file" name="nid_font" class="form-control @error('nid_font') is-invalid @enderror" placeholder="Enter nid_font..." id="nid_font" value="{{ old('nid_font') }}">
                            @error('nid_font')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <img src="{{ asset('uploads/employee/' . $employee->nid_font) }}" alt="{{ $employee->nid_font }}" width="120">

                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="nid_back">NID Doc(Back Side)</label>
                            <input type="file" name="nid_back" class="form-control @error('nid_back') is-invalid @enderror" placeholder="Enter nid_back..." id="nid_back" value="{{ old('nid_back') }}">
                            @error('nid_back')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <img src="{{ asset('uploads/employee/' . $employee->nid_back) }}" alt="{{ $employee->nid_back }}" width="120">

                    </div>





                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address..." id="address">{{ old('address',$employee->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="reference_details">Reference Details(Name, Full reference_details)</label>
                            <textarea name="reference_details" class="form-control @error('reference_details') is-invalid @enderror" placeholder="Enter reference_details..." id="reference_details">{{ $employee->reference_details  }}</textarea>
                            @error('reference_details')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 text-right">
                        <a type="button" class="btn bg-danger" href="{{ route('admin.employees.index') }}">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>


        </div>

    </div>
</div>

<!-- /.content -->
@endsection
@push('.js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const loadDistrict = (target, targetClass) => {

        const districtSelect = document.getElementById('district');
        const upazilaSelect = document.getElementById('upazila');

        axios.get("{{ url('admin/getDistricts') }}?" + "country_id=" + target.value)

            .then((response) => {
                upazilaSelect.value = '';
                districtSelect.disabled = false;
                upazilaSelect.disabled = true;
                var options = '<option value="">--select district--</option>';
                if (response.data && typeof response.data === 'object' && Object.keys(response.data).length > 0) {
                    for (const key in response.data) {
                        if (response.data.hasOwnProperty(key)) {
                            options += `<option value="${key}">${response.data[key]}</option>`;
                        }
                    }
                } else {
                    console.error('Invalid response format for districts:', response.data);
                }
                $(targetClass).html(options);
                toastr.success('Load Data in districts field!')
            })
            .catch((error) => {
                console.error('Error fetching districts:', error);
                toastr.error('Error fetching districts: ', error)
            });
    };

    const loadUpazila = (target, targetClass) => {
        const upazilaSelect = document.getElementById('upazila');

        axios.get("{{ url('admin/getThana') }}?" + "district_id=" + target.value)

            .then((response) => {
                upazilaSelect.disabled = false;
                var options = '<option value="">--select Upazila--</option>';
                if (response.data && typeof response.data === 'object' && Object.keys(response.data).length > 0) {
                    for (const key in response.data) {
                        if (response.data.hasOwnProperty(key)) {
                            options += `<option value="${key}">${response.data[key]}</option>`;
                        }
                    }
                } else {
                    console.error('Invalid response format or no data for Upazilas:', response.data);
                    toastr.error('No data available for Upazilas!');
                    return; // Prevent further execution
                }

                $(targetClass).html(options);
                toastr.success('Load Data in Upazilas field!');
            })
            .catch((error) => {
                console.error('Error fetching Upazilas:', error);
                toastr.error('Error fetching Upazilas: ', error.message || 'Unknown error occurred');
            });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    });

</script>
@endpush
