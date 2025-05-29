@extends('layouts.admin')
@section('title', 'Admin | Customer')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.money-lending.index') }}">money-lending</a></li>
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
            <h4 class="card-title float-left pt-2">Create New Customer</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.money-lending.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name..." id="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="name_bangla">Bangla Name</label>
                            <input type="text" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" placeholder="Enter Bangla Name..." id="name_bangla" value="{{ old('name_bangla') }}">
                            @error('name_bangla')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone..." id="phone" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="nid">NID</label>
                            <input type="number" name="nid" class="form-control @error('nid') is-invalid @enderror" placeholder="Enter NID..." id="nid" value="{{ old('nid') }}">
                            @error('nid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" placeholder="Enter Country..." id="country" value="{{ old('country') }}">
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="division">Division</label>
                            <input type="text" name="division" class="form-control @error('division') is-invalid @enderror" placeholder="Enter Division..." id="division" value="{{ old('division') }}">
                            @error('division')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="district">District</label>
                            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" placeholder="Enter District..." id="district" value="{{ old('district') }}">
                            @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City..." id="city" value="{{ old('city') }}">
                            @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="Area">Area</label>
                            <input type="text" name="Area" class="form-control @error('Area') is-invalid @enderror" placeholder="Enter Area..." id="Area" value="{{ old('Area') }}">
                            @error('Area')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="number" name="postcode" class="form-control @error('postcode') is-invalid @enderror" placeholder="Enter Postcode..." id="postcode" value="{{ old('postcode') }}">
                            @error('postcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="parent_address">Parent Address</label>
                            <input type="text" name="parent_address" class="form-control @error('parent_address') is-invalid @enderror" placeholder="Enter Parent Address..." id="parent_address" value="{{ old('parent_address') }}">
                            @error('parent_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <input type="text" name="permanent_address" class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Enter Permanent Address..." id="permanent_address" value="{{ old('permanent_address') }}">
                            @error('permanent_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" name="from_date" class="form-control @error('from_date') is-invalid @enderror" placeholder="Enter From Date..." id="from_date" value="{{ old('from_date') }}">
                            @error('from_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" class="form-control @error('to_date') is-invalid @enderror" placeholder="Enter To Date..." id="to_date" value="{{ old('to_date') }}">
                            @error('to_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="to_amount">To Amount</label>
                            <input type="number" name="to_amount" class="form-control @error('to_amount') is-invalid @enderror" placeholder="Enter To Amount..." id="to_amount" value="{{ old('to_amount') }}">
                            @error('to_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="recv_amount">Received Amount</label>
                            <input type="number" name="recv_amount" class="form-control @error('recv_amount') is-invalid @enderror" placeholder="Enter Received Amount..." id="recv_amount" value="{{ old('recv_amount') }}">
                            @error('recv_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="due_amount">Due Amount</label>
                            <input type="number" name="due_amount" class="form-control @error('due_amount') is-invalid @enderror" placeholder="Enter Due Amount..." id="due_amount" value="{{ old('due_amount') }}">
                            @error('due_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="monthly_profit">Monthly Profit</label>
                            <input type="number" name="monthly_profit" class="form-control @error('monthly_profit') is-invalid @enderror" placeholder="Enter Monthly Profit..." id="monthly_profit" value="{{ old('monthly_profit') }}">
                            @error('monthly_profit')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 text-right">
                        <a type="button" class="btn btn-primary" href="{{ route('admin.money-lending.index') }}">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>
<!-- /.content -->
@endsection
