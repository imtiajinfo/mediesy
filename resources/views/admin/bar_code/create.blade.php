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
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.categories.index') }}">Barcode Generateo</a></li>
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
        <div class="card-header bg-light">
            <form action="{{ route('admin.barcode.store') }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="product_id">Product <span class="d-inline text-danger">*</span></label>
                        <div class="input-group">
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" id="product_id" required>
                                <option value="">-- Select product --</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="quantity d-inline">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" placeholder="Quantity.." value="{{ old('quantity') }}" required>
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-12 col-md-3 float-end my-auto">
                        <button type="submit" id="generate" class="btn btn-md bg-warning payments_modal" title="Generate Barcode">Find</button>
                    </div>
                </div>
            </form>

        </div>

        <div class="container p-4">
            @if (isset($barcodes))
            <h4>Product Information</h4>
            @if ($barcodeproduct->name && $barcodeproduct->code)
            <a href="{{ url('/admin/BarcodePdf') }}?product_id={{ $barcodeproduct->id }} & quantity={{ $qty }}" target="_blank" class="btn btn-success float-md-right mr-4">
                Generate PDF
            </a>
            @endif
            <p class="pb-0 mb-0"><strong>Product Name:</strong> {{ $barcodeproduct->name }}</p>
            <span><strong>Product Code:</strong> {{ $barcodeproduct->code }}; </span>
            <span><strong> Quantity:</strong> {{ $qty }}</span>
            @endif

            <p>Barcodes:</p>
            @if (isset($barcodes) && count($barcodes) > 0)
            <div class="barcode-container">
                <div class="row">
                    @foreach ($barcodes as $barcode)
                    <div class="col-auto">
                        <div class="barcode-item pt-3 my-2">
                            <span> {!! $barcode !!}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p>No barcodes available.</p>
            @endif
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
