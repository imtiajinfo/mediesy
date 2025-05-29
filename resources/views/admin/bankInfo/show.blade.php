@extends('layouts.admin')
@section('title', 'Admin | stores')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
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

    input:disabled {
        background-color: #f2f2f2;
        /* Set the background color */
        color: #888;
        /* Set the text color */
        border: 1px solid #ddd;
        /* Set the border color */
        /* Add any other styles you want for disabled inputs */
    }

</style>


<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">view Store</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="#" enctype="multipart/form-data">

                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">Store Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Store Name..." id="name" value="{{ old('name', $store->name) }}" required disabled>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ old('phone',  $store->phone) }}" required disabled>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email',  $store->email) }}" required disabled>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="store_type">Store Type</label>
                            <select name="store_type" onchange="loadDistrict(this,'#district')" class="form-select @error('store_type') is-invalid @enderror" placeholder="" id="store_type" disabled>
                                <option value="">Select Store Type</option>
                                <option value="1" {{ old('store_type') == 1 ? 'selected' : '' }}>Main Store</option>
                                <option value="0" {{ old('store_type') == 0 ? 'selected' : '' }}>Sub Store</option>
                            </select>
                            @error('store_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" onchange="loadDistrict(this,'#district')" class="form-control @error('country') is-invalid @enderror" placeholder="" id="country" disabled>
                                <option value="">Select Country</option>
                                <option value="{{ $store->id }}" selected>
                                    {{ $store->name }}
                                </option>

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
                                <option value="{{$store->district}}" selected>{{$store->district}}</option>
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
                                <option value="{{$store->upazila}}" selected>{{$store->upazila}} </option>
                            </select>
                            @error('upazila')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="number" name="postcode" class="form-control @error('postcode') is-invalid @enderror" placeholder="Enter Postcode..." id="postcode" value="{{ old('postcode',  $store->postcode) }}" disabled>
                            @error('postcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address..." id="address" disabled>{{ old('address',  $store->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 text-right">
                        <a type="button" class="btn bg-danger" href="{{ route('admin.stores.index') }}">Close</a>
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
    const submit_form = () => {

        let url = "{{url('customers.store') }}"
        const data = {
            'name': $('#name').val()
            , 'email': $('#email').val()
            , 'phone': $('#phone').val()
            , 'country_id': $('#country_id').val()
            , 'district_id': $('#district_id').val()
            , 'upazila_id': $('#upazila_id').val()
            , 'address': $('#address').val()
        };

        axios.post(url, data)
            .then((response) => {
                $('#new_customer').modal('hide');
                toastr.success('Successfully Customer viewd !')
            })
            .catch((error) => {
                const errors = error.response.data.errors || [];

                for (key in errors) {
                    let id = `#${key}`;
                    $(id).addClass('is-invalid');
                    $(id).siblings('.invalid-feedback').show();
                    $(id).siblings('.invalid-feedback').html(errors[key][0]);
                }
            })
    }


    const loadDistrict = (target, targetClass) => {

        const districtSelect = document.getElementById('district');
        const upazilaSelect = document.getElementById('upazila');

        axios.get("{{ url('admin/getDistricts') }}?" + "country_id=" + target.value)

            .then((response) => {
                upazilaSelect.value = '';
                districtSelect.disabled = false;
                upazilaSelect.disabled = true;
                var options = '<option value="">--select district--</option>';
                if (typeof response.data === 'object') {
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

</script>

<script>
    $(function() {
        $("#customers").autocomplete({
            source: "{{ url('/api/customers') }}"
            , select: function(t, n) {
                console.log(n.item);
                if (null != n.item.id) {
                    $("#customer_id").attr("value", n.item.id);
                    $("#customer_name").attr("value", n.item.value);
                    $('#customer_email').val(n.item.email);
                    $('#go_to_cart').attr('href', $('#go_to_cart').attr('href') + n.item.id);
                    $('#country').val(n.item.country);
                    $('#district').val(n.item.district);
                    $('#address').val(n.item.address); // Set the address value in the input field
                }
                return false;
            }
        , });
    });

</script>
@endpush
