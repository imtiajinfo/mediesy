@extends('layouts.admin')
@section('title', 'Admin | Category')

@section('page-headder')
{{-- customers --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.customers.index') }}">customers</a></li>
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
            <h4 class="card-title float-left pt-2">Update Customer</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Customer Name..." id="name" value="{{ $customer->name }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ $customer->phone }}" >
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ $customer->email }}" >
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
<div class="mb-3 col-md-4 col-lg-3">
    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address..." id="address">{{ $customer->address }}</textarea>
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="mb-3 text-right">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
</div>
</form>


</div>

</div>
</div>

<!-- /.content -->
@endsection
@push('.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to load product names and images
        async function loadProducts() {
            // Show loader spinner
            showLoader();

            // Set a timeout for the loader spinner
            const loaderTimeout = setTimeout(() => {
                hideLoader();
                console.error('Timeout: Products loading took too long.');
            }, 10000); // Adjust the timeout duration (in milliseconds) as needed

            try {
                const response = await axios.get(
                    '/admin/loadProduct'); // Replace with your actual API endpoint
                const products = response.data.items.data;

                // Check if products is an array
                if (!Array.isArray(products)) {
                    console.error('Error: Products is not an array:', products);
                    return;
                }

                console.log('Products:', products);

                const select = document.getElementById('product_id');
                select.innerHTML = '';

                // Add actual product options
                products.forEach((product) => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.text = product.name;
                    select.appendChild(option);
                });

                // Hide loader spinner after products are loaded
                hideLoader();

                // Clear the timeout as the products are loaded successfully
                clearTimeout(loaderTimeout);

            } catch (error) {
                console.error('Error loading products:', error);
                // Hide loader spinner on error
                hideLoader();
            }
        }

        // Show loader spinner
        function showLoader() {
            const loader = document.getElementById('loader');
            loader.style.display = 'block'; // Adjust the styling as needed
        }

        // Hide loader spinner
        function hideLoader() {
            const loader = document.getElementById('loader');
            loader.style.display = 'none';
        }

        // Event listener for product focus
        const productSelect = document.getElementById('product_id');
        if (productSelect) {
            productSelect.addEventListener('focus', loadProducts);
        }

        // Initial load of products
        loadProducts();
    });

</script>
@endpush
