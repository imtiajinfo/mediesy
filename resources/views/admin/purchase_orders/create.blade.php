@extends('layouts.admin')
@section('title', 'Admin | purchase list')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.purchase-orders.index') }}">Purchase List</a></li>
        </ol>
    </div>
</div>
<style>
    .product-img img {
        width: 100px;
        height: 120px
    }

    .product-text-area p {
        font-size: 13px;
    }

    .product-list-wrapper {
        text-align: center
    }

    .product-info__content .fs-6 {
        font-size: 13px;
    }

    .productListContainer .col-4:hover {
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
    input[type="file"], [class~="input-group"], select, input[type="text"] {
        font-size: small !important;
    }
    input{
        padding: 2px !important;
        margin: 0px !important
    }
    tr,td{
        padding: 3px !important;
        margin: 0px !important
    }
    [class~="input-group"], input[type="file"] {
        border:0px solid !important;
    }

</style>


<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Create New Purchase</h4>
        </div>
        <div class="container p-4 pt-0 pb-0">
            <form method="POST" action="{{ route('admin.purchase-orders.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="card mt-2 pt-1 mb-3 pb-3">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="supplier_id">Supplier Name</label>
                                <div class="input-group mr-2">
                                    <select name="supplier_id" class="form-control select2 @error('supplier_id') is-invalid @enderror" id="supplier" data-live-search="true" required>
                                        <option value="0">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}-[{{ $supplier->company_name }}]
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label class="input-group-text" for="customer_id" data-bs-toggle="modal" data-bs-target="#addModal">
                                        <i class="fa fa-plus"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="">Purchase Date</label>
                                <input type="date" class="form-control" id="po_date" name="po_date" required>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="purchased_by">Purchased By</label>
                                    <select name="purchased_by" class="form-control @error('purchased_by') is-invalid @enderror" required readonly>
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}</option>
                                    </select>
                                    @error('purchased_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label for="">Select Product</label>
                                <select class="form-control" id="product-ajax-select2" onchange="addProduct()">
                                    <option value="">Select Product</option>
                                    {{-- @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ Str::limit($product->name, 80) }} - [{{ $product->sub_title }}]</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            {{-- <div class="mb-3 col-md-1" onclick="addProduct()" style="cursor: pointer">
                                <div id="add_product_button_container" class=" col-md-3 align-self-end mt-2 ml-0 pl-0">
                                    <span id="addProduct" class="btn btn-primary mt-4" disabled>
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                            </div> --}}

                        </div>

                        <div id="tableContainer">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Sl</th>
                                        <th>product Name</th>
                                        {{-- <th class="text-start">Product Code</th> --}}
                                        {{-- <th class="text-start">Published Price</th> --}}
                                        <th class="text-start">Purchase Price</th>
                                        <th class="text-start">Retail Price</th>
                                        <th class="text-start">Whole Sell Price</th>
                                        <th class="text-start">Whole Sell Qty</th>
                                        <th class="text-start">Purchase Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseBody"></tbody>
                            </table>
                        </div>

                        <div class="card-body mt-5 p-2">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="row">

                                        <div class="col-md-6 text-right">
                                            <label for="total_purchase_qty">Total Quantity : </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input disabled type="number" name="total_purchase_qty" min="1" max="5000" placeholder="0" class="form-control form-control-sm @error('total_purchase_qty') is-invalid @enderror" id="total_purchase_qty" required>
                                            @error('total_purchase_qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 text-right mt-2">
                                            <label for="total_purchase_qty">Total Purchase Price : </label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <input disabled type="number" class="form-control form-control-sm" id="total_price" placeholder="0.00" name="total_price">
                                        </div>

                                        <div class="col-md-6 text-right mt-2">
                                            <label for="total_purchase_qty">Remarks : </label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <textarea name="remarks" class="form-control" placeholder="Enter Rremarks...">{{old('remarks')}}</textarea>
                                        </div>

                                    </div>
                                </div>
        
                            </div>

                        </div>

                        <div id="save_purchase_container">
                            <button id="save_purchase" class="btn btn-md btn-success">Save purchase</button>
                            <a href="/admin/purchase-orders" class="btn btn-md btn-primary">Back To List</a>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.content -->

@include('admin.purchase_orders.partials.addsuppliermodal')

@endsection
@push('.js')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<script>

    podate();

    function podate(){
        document.getElementById('po_date').valueAsDate = new Date();
    }

    function addProduct() {
        productId = $("#product-ajax-select2").val();
        
        if(productId && CheckDoublicateProduct(productId)){

            axios.get('/admin/get-Product/'+productId)
                .then(function (response) {
    
                    let product = response.data.items;
                    
                    $("#purchaseBody").prepend(`<tr>
                        <td>
                            <span class="productSl"></span>
                            <input type="hidden" name="product_id[]" id="product_id" value="${response.data.items.id}" required>
                        </td> 
                        <td>
                            <input type="text" value="${product.name + ' ' + product.strength + ' ' + product.description + ' ' + product.brand + ' ' + product.manufacturer}" disabled class="form-control">
                        </td> 
                        
                        <td class="purchase_price" style="width:12%">
                            <input type="text" name="purchase_price[]" value=" ${response.data.items.purchase_price==null?'00.00':response.data.items.purchase_price}" class="form-control purchase_price @error('purchase_price') is-invalid @enderror" onkeyup="updateTotalPurchaseQty()" required onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td class="sell-price" style="width:12%"> 
                            <input type="text" name="sell_price[]" value=" ${response.data.items.sell_price==null?'00.00':response.data.items.sell_price}" class="form-control @error('sell_price') is-invalid @enderror" onkeyup="updateTotalPurchaseQty()" required onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td class="whole_sell-price" style="width:12%"> 
                            <input type="text" name="whole_sale_price[]" value="${response.data.items.whole_sale_price??'00.00'}" class="form-control" required onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td class="whole_sell-qty" style="width:8%"> 
                            <input type="text" name="whole_sale_qty[]" value="${response.data.items.whole_sale_qty??'0'}" class="form-control" required onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td class="item_qty" style="width:5%">
                            <input type="text" name="purchase_qty[]" onkeyup="updateTotalPurchaseQty()" class="form-control @error('purchase_qty') is-invalid @enderror" required value="1" onkeypress="return /[0-9.]/i.test(event.key)"></td>  
                        <td>
                            <div style="cursor:pointer" class="btn btn-sm btn-danger deleteRow"><i class="fas fa-trash-can"></i></div>
                        </td>
                    </tr>`);

                    
                updateTotalPurchaseQty();
                updateTotalPurchasePrice();

                $("#product-ajax-select2").val('').trigger('change');

                toastr.success('Added Product :', response.data.items.name);
            })
            .catch(function(error) {
                console.error('Failed to fetch products:', error);
            });
        }

        if(!CheckDoublicateProduct(productId)){
            alert("Product Already Added!");
        }
    }

    function CheckDoublicateProduct(productId){
        var productIds = document.querySelectorAll('input[name="product_id[]"]');
        let productIdArr = [];
        productIds.forEach(function (input) {
            productIdArr.push(input.value);
        });

        if(productIdArr.includes(productId)){
            return false;
        }
        return true;
    }

    document.getElementById('supplierFrom').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function(response) {
                // Display success message to the user
                toastr.success('supplier created successfully!');
                // Reset the form
                document.getElementById('supplierFrom').reset();
                $('#addModal').modal('hide');
                // location.reload();
                var suppliers = response.data.suppliers;
                console.log(suppliers);
                var selectElement = document.getElementById('supplier');
                // selectElement.innerHTML = '';
                var defaultOption = document.createElement('option');
                defaultOption.value = suppliers.id;
                defaultOption.text = suppliers.name;
                selectElement.appendChild(defaultOption);
            })
            .catch(function(error) {
                console.error('Error creating supplier:', error);
                //toastr.error('Failed to create supplier. Please try again later.', error.message);
                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] + '<br>'; // Assuming the first error message is the relevant one
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });


    // Define updateTotalPurchaseQty function in the global scope
    function updateTotalPurchaseQty() {
        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="purchase_qty[]"]');
        var totalPurchaseQtyInput = document.getElementById('total_purchase_qty');
        var totalQty = 0;
        purchaseQtyInputs.forEach(function(input) {
            totalQty += parseInt(input.value) || 0;
        });
        totalPurchaseQtyInput.value = totalQty;
        updateTotalPurchasePrice();
        serialRow();

    }

    function updateTotalPurchasePrice() {
        // var purchasePriceElements = document.querySelectorAll('.purchase_price');
        var purchasePriceElements = document.querySelectorAll('.purchase_price input[name="purchase_price[]"]');
        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="purchase_qty[]"]');
        var totalPriceInput = document.getElementById('total_price');
        var total = 0;

        // Iterate over each item row
        purchasePriceElements.forEach(function(priceElement, index) {
            var purchasePrice = parseFloat(priceElement.value || 0); // Get purchase price
            var purchaseQty = parseInt(purchaseQtyInputs[index].value) || 0; // Get purchase quantity
            var subtotal = purchasePrice * purchaseQty; // Calculate subtotal for the current row
            total += subtotal; // Add subtotal to total
        });

        totalPriceInput.value = total.toFixed(2); // Update total purchase price input field
    }

    $(document).on('click', '.deleteRow', function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        serialRow();
    })
    
    function serialRow(){   
        $sl = 1; 
        $(".productSl").each(function() {
            $(this).text($sl);
            $sl++;
        });
    }

    $('#product-ajax-select2').select2({
        ajax: {
            url: '/api/products',
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.map(function (product) {
                        return { id: product.id, text: product.name + ' ' + product.strength + ' ' + product.description + ' ' + product.brand + ' ' + product.manufacturer };
                    })
                };
            }
        }
    });


</script>

@endpush
