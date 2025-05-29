@extends('layouts.admin')
@section('title', 'Admin | Sales')

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.service-sales.index') }}">Sell Orders</a>
            </li>
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
    }
    .barcode-item {
        border: 1px solid #888;
        padding: 0 6px;
        margin: 4px;
    }
    input[type="file"],
    [class~="input-group"],
    select,
    input[type="text"] {
        font-size: small !important;
    }
    input {
        padding: 2px !important;
        margin: 0px !important
    }
    tr,
    td {
        padding: 3px !important;
        margin: 0px !important
    }
    [class~="input-group"],
    input[type="file"] {
        border: 0px solid !important;
    }
</style>

<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">Create New Sell Order</h4>
        </div>
        <div class="container p-4 pt-0 pb-0">
            <form method="POST" action="{{ route('admin.service-sales.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="card mt-2 pt-1 mb-3 pb-3">

                        <div class="row">

                            <div class="col-md-6">
                                <label for="customer_id">Customer Name</label>
                                <div class="input-group mr-2">
                                    <select name="customer_id"
                                        class="form-control select2 @error('customer_id') is-invalid @enderror"
                                        id="customer" data-live-search="true" required>
                                        <option value="0">Select Customer</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label class="input-group-text" for="customer_id" data-bs-toggle="modal"
                                        data-bs-target="#addModal">
                                        <i class="fa fa-plus"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="">Sell Order Date</label>
                                <input type="date" class="form-control" id="po_date" name="sell_date" required>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="purchased_by">Sales By</label>
                                    <select name="sell_by" class="form-control @error('sell_by') is-invalid @enderror"
                                        required readonly>
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}
                                        </option>
                                    </select>
                                    @error('sell_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="mb-3 col-md-10">
                                <label for="product_id">Select Product</label>
                                <select name="" class="form-control" id="product-ajax-select2" onchange="addProduct()">
                                    <option value="">Select Product</option>
                                    {{-- @foreach ($products as $product)
                                    <option qty={{$product->current_stock}} value="{{ $product->id }}">{{ $product->name }} [{{ $product->sub_title }}] - Stock: {{$product->current_stock}} - Cost: {{$product->purchase_price}} - Sell: {{$product->sell_price}}</option>
                                    @endforeach --}}
                                </select>
                                @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-2" style="cursor: pointer">
                                <div class="col-md-12 align-self-end mt-2 ml-0 pl-0">
                                    <span data-bs-toggle="modal" data-bs-target="#addProductModal" class="btn btn-primary text-sm mt-4" disabled>
                                        Quick Add
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div id="tableContainer" style="max-height: 490px;overflow-y:scroll">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Sl</th>
                                        <th>product Name</th>
                                        {{-- <th class="text-start">Product Code</th> --}}
                                        <th class="text-start">Sell Price</th>
                                        <th class="text-start">Discount%</th>
                                        <th class="text-start">Quantity</th>
                                        <th class="text-start">Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseBody">

                                </tbody>
                            </table>
                        </div>

                        <div class="card-body mt-5 p-2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-6 mt-2">
                                        <label for="total_purchase_qty">Remarks : </label>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <textarea name="remarks" class="form-control" placeholder="Enter Rremarks..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 text-right d-none">
                                            <label for="total_purchase_qty">Total Quantity : </label>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <input disabled type="number"  name="total_purchase_qty" placeholder="0" class="form-control form-control-sm" id="total_purchase_qty">
                                        </div>

                                        <div class="col-md-6 text-right mt-2">
                                            <label for="total_purchase_qty">Total : </label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <input disabled type="number" class="form-control form-control-sm" id="total_price" placeholder="0.00"  name="total_price">
                                        </div>

                                        <div class="col-md-6 text-right mt-2">
                                            <label for="total_purchase_qty">Collect Amount : </label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <input onkeypress="return /[0-9.]/i.test(event.key)" type="text" class="form-control form-control-sm" id="collect_amount" placeholder="0.00" name="collect_amount">
                                        </div>

                                        <div class="col-md-6 text-right mt-2">
                                            <label for="total_purchase_qty">Due Amount : </label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <input disabled type="text" class="form-control form-control-sm" id="due-total_price" placeholder="0.00">
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="save_purchase_container" class="text-right mt-4 mb-3">
                            <button id="save_purchase" disabled class="btn btn-md btn-success">Save Sell</button>
                            <a href="/admin/service-sales" class="btn btn-md btn-primary">Back To List</a>
                        </div>

                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
<!-- /.content -->

@include('admin.service-sales.partials.product_item_add')
@include('admin.service-sales.partials.addcustomemodal')

@endsection
@push('.js')

<script>
    var productSl = 0;
    podate();

    function podate(){
        document.getElementById('po_date').valueAsDate = new Date();
    }

    function addProduct() {
        productId = $("#product-ajax-select2").val();
        productSl++;        
        if(productId && CheckDoublicateProduct(productId)){

            axios.get('/admin/get-Product/'+productId)
                .then(function (response) {

                    let product = response.data.items;
    
                    $("#purchaseBody").prepend(`<tr>
                        <td>
                            <span class="productSl">${productSl}</span> 
                            <input type="hidden" name="product_id[]" id="product_id" value="${response.data.items.id}" required>
                            <input type="hidden" name="available_qty[]" value="${response.data.items.current_stock}">
                            <input type="hidden" name="whole_sale_price[]" value="${response.data.items.whole_sale_price}">
                            <input type="hidden" name="whole_sale_qty[]" value="${response.data.items.whole_sale_qty}">
                            <input type="hidden" name="sell_price1[]" value="${response.data.items.sell_price}">
                        </td> 
                        <td style="width:47%">
                            <input type="text" name="sub_title[]" value="${product.name + ' ' + product.strength + ' ' + product.description + ' ' + product.brand + ' ' + product.manufacturer}" class="form-control" disabled>
                        </td> 
                        <td>
                            <input type="text" name="sell_price[]" value=" ${response.data.items.sell_price==null?'':response.data.items.sell_price}" class="form-control sell_price" onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td style="width:8%"> 
                            <input type="text" name="discount[]" value="0" class="form-control discount" onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td style="width:8%" class="item_qty">
                            ${response.data.items.current_stock == 0 ? '<span class="current-stock-err"><span class="text-danger"><b>Out of Stock</b></span><input type="hidden" name="qty_issue[]" value="1"></span>':''}
                            <input type="text" name="sell_qty[]" onkeyup="updateTotalPurchaseQty()" onkeypress="return /[0-9.]/i.test(event.key)" class="form-control" ${response.data.items.current_stock == 0 ? 'style="border: 1px solid #f00 !important;color: #f00 !important;"':''} required value="1">
                        </td>  
                        <td class="sub_total">
                            <input type="text" name="sub_total[]" value=" ${response.data.items.sell_price==null?'':response.data.items.sell_price}" class="form-control" onkeyup="updateTotalPurchaseQty()" disabled>
                        </td>
                        <td>
                            <div class="btn btn-sm btn-danger deleteRow">
                                <i class="fas fa-trash-can"></i>
                            </div>
                        </td>
                    </tr>`);
    
                    updateTotalPurchaseQty();
                    updateTotalPurchasePrice();
                    
                    $("#product").val('').trigger('change');
    
                    toastr.success('Add for Purchase Order.', response.data.items.name);
                })
                .catch(function (error) {
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

    function updateTotalPurchaseQty() {

        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="sell_qty[]"]');
        var totalPurchaseQtyInput = document.getElementById('total_purchase_qty');
        var totalQty = 0;

        purchaseQtyInputs.forEach(function (input) {
            totalQty += parseInt(input.value) || 0;
        });
        totalPurchaseQtyInput.value = totalQty;

        updateTotalPurchasePrice();
        checkAvailbleQty();
        serialRow();

    }

    function checkAvailbleQty() {
        // var issue_qty = document.querySelectorAll('.item_qty input[name="qty_issue[]"]');
        // var product_id = document.querySelectorAll('input[name="product_id[]"]');
        // var totalQty = 0;
        // issue_qty.forEach(function (input) {
        //     totalQty += parseInt(input.value) || 0;
        // });
        
        // var product_idQty = 0;
        // product_id.forEach(function (input) {
        //     product_idQty += parseInt(input.value) || 0;
        // });
        // if (totalQty != 0 || product_idQty == 0) {
        //     $("#save_purchase").attr('disabled', true);
        // } else {
        //     $("#save_purchase").attr('disabled', false);
        // }
        var pro_qty = document.querySelectorAll('input[name="sell_qty[]"]');
        var totalProQty = 0;
        pro_qty.forEach(function (input) {
            totalProQty += parseInt(input.value) || 0;
        });
        if (totalProQty == 0) {
            $("#save_purchase").attr('disabled', true);
        } else {
            $("#save_purchase").attr('disabled', false);
        }

    }

    function updateTotalPurchasePrice() {
        var purchasePriceElements = document.querySelectorAll('.sub_total [name="sub_total[]"]');
        var totalPriceInput = document.getElementById('total_price');
        var total = 0;
        purchasePriceElements.forEach(function (priceElement, index) {
            var purchasePrice = parseFloat(priceElement.value || 0); // Get purchase price
            var subtotal = purchasePrice; // Calculate subtotal for the current row
            total += subtotal; // Add subtotal to total
        });

        totalPriceInput.value = total.toFixed(2); // Update total purchase price input field
        let collect_amount = Number($("#collect_amount").val());
        $("#due-total_price").val(Number(total - collect_amount).toFixed(2));
    }

    $(document).on('keyup', '#collect_amount', function (e) {
        updateTotalPurchasePrice();
    });

    $(document).on('keyup', '.discount', function (e) {

        let discount = ($(this).val()) ?? 0;
        let qty = ($(this).parent().parent().find('[name="sell_qty[]').val()) ?? 0;
        let price = ($(this).parent().parent().find('[name="sell_price[]').val()) ?? 0;

        let sub_total = 0;

        if (discount == null || discount == 0) {
            sub_total = price * qty;
        } else {
            sub_total = ((price - (discount/100) * price) * qty);
        }
        $(this).parent().parent().find('.sub_total input').val(sub_total.toFixed(2));

        updateTotalPurchaseQty();
        updateTotalPurchasePrice();

    });

    $(document).on('keyup', '.sell_price', function (e) {
        e.preventDefault();

        let price = ($(this).val()) ?? 0;
        let qty = ($(this).parent().parent().find('[name="sell_qty[]').val()) ?? 0;
        let discount = ($(this).parent().parent().find('[name="discount[]').val()) ?? 0;

        let sub_total = 0;
        if (discount == null || discount == 0) {
            sub_total = price * qty;
        } else {
            sub_total = ((price - (discount/100) * price) * qty);
        }
        $(this).parent().parent().find('.sub_total input').val(sub_total.toFixed(2));

        updateTotalPurchaseQty();
        updateTotalPurchasePrice();

    });

    $(document).on('keyup', '.item_qty input', function (e) {
        
        let qty = $(this).val()??0;
        let sub_total = 0;
        let discount = $(this).parent().parent().find('[name="discount[]"').val()??0;
        let price = $(this).parent().parent().find('[name="sell_price1[]"').val()??0;
        let available_qty = $(this).parent().parent().find('[name="available_qty[]"').val()??0;
        let whole_sale_price = $(this).parent().parent().find('[name="whole_sale_price[]"').val()??0;
        let whole_sale_qty = $(this).parent().parent().find('[name="whole_sale_qty[]"').val()??0;

        if((qty > 1) && (qty >= Number(whole_sale_qty)) && (whole_sale_qty > 0)){
            price = whole_sale_price;
        }
        $(this).parent().parent().find('[name="sell_price[]"').val(price);

        if (discount == null || discount == 0) {
            sub_total = price * qty;
        } else {
            sub_total = (price - (discount / 100) * price) * qty;
        }
        $(this).parent().parent().find('.sub_total input').val(sub_total.toFixed(2));

        // if (Number(available_qty) >= Number(qty)) {
        //     $(this).parent().parent().find('.current-stock-err').remove();
        // } else {
        //     $(this).parent().parent().find('.current-stock-err').remove();
        //     $(this).parent().parent().find('.item_qty').prepend(
        //         '<span class="current-stock-err"><span class="text-danger"><b>Out of Stock</b></span><input type="hidden" name="qty_issue[]" value="1"></span>'
        //     );
        //     $(this).parent().parent().find('[name="sell_qty[]"]').css('border', '1px solid #f00');
        // }

        updateTotalPurchaseQty();
        updateTotalPurchasePrice();

    })

    $(document).on('click', '.deleteRow', function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        serialRow();
    })

    function enableFields(element) {
        // Find the row of the changed input
        var row = element.closest("tr");
        // Find the corresponding fields
        var publishedPriceField = row.querySelector(".published_price input");
        var purchasePriceField = row.querySelector(".purchase_price input");
        var sellPriceField = row.querySelector(".sell-price input");

        // Enable the fields
        publishedPriceField.disabled = false;
        purchasePriceField.disabled = false;
        sellPriceField.disabled = false;
    }

    function serialRow(){   
        $sl = 1; 
        $(".productSl").each(function() {
            $(this).text($sl);
            $sl++;
        });
    }

    document.getElementById('productFrom').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this); // Get form data
        axios.post(this.action, formData)
            .then(function (response) {

                console.log(response.data);

                // axios.get('/admin/get-Product/'+response1.data.id)
                // .then(function (response) {
    
                    $("#purchaseBody").prepend(`<tr>
                        <td>
                            <span class="productSl">0</span> 
                            <input type="hidden" name="product_id[]" id="product_id" value="${response.data.id}" required>
                            <input type="hidden" name="available_qty[]" value="${response.data.current_stock}">
                            <input type="hidden" name="whole_sale_price[]" value="${response.data.whole_sale_price}">
                            <input type="hidden" name="whole_sale_qty[]" value="${response.data.whole_sale_qty}">
                            <input type="hidden" name="sell_price1[]" value="${response.data.sell_price}">

                        </td> 
                        <td style="width:27%">
                            <input type="text" name="sub_title[]" value="${response.data.name}" class="form-control" disabled></td> 
                        <td>
                            <input type="text" name="sub_title[]" value=" ${response.data.sub_title==null?'':response.data.sub_title}" class="form-control sub_title" disabled>
                        </td>
                        <td>
                            <input type="text" name="sell_price[]" value=" ${response.data.sell_price==null?'':response.data.sell_price}" class="form-control sell_price" onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td style="width:8%"> 
                            <input type="text" name="discount[]" value="0" class="form-control discount" onkeypress="return /[0-9.]/i.test(event.key)">
                        </td> 
                        <td style="width:8%" class="item_qty">
                            <input type="text" name="sell_qty[]" onkeyup="updateTotalPurchaseQty()" onkeypress="return /[0-9.]/i.test(event.key)" class="form-control" required value="1">
                        </td>  
                        <td class="sub_total">
                            <input type="text" name="sub_total[]" value=" ${response.data.sell_price==null?'':response.data.sell_price}" class="form-control" onkeyup="updateTotalPurchaseQty()" disabled>
                        </td>
                        <td>
                            <div class="btn btn-sm btn-danger deleteRow">
                                <i class="fas fa-trash-can"></i>
                            </div>
                        </td>
                    </tr>`);
    
                    updateTotalPurchaseQty();
                    updateTotalPurchasePrice();

                    document.getElementById("productFrom").reset();
                    
                    $("#product").val('').trigger('change');
    
                    // toastr.success('Add for Purchase Order.', response.data.items.name);
                // })
                // .catch(function (error1) {
                //     console.error('Failed to fetch products:', error1);
                // });

                toastr.success('Product created successfully!');
                document.getElementById('productFrom').reset();
                $('#addProductModal').modal('hide');

            })
            .catch(function (error) {

                console.log(error);

                if (error.response && error.response.data && error.response.data.errors) {
                    var errorMessage = '';
                    for (var key in error.response.data.errors) {
                        if (error.response.data.errors.hasOwnProperty(key)) {
                            errorMessage += error.response.data.errors[key][0] + '<br>';
                        }
                    }
                    toastr.error(errorMessage);
                } else {
                    toastr.error('An unexpected error occurred');
                }
            });
    });

    document.getElementById('customerForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        axios.post(this.action, formData)
            .then(function(response) {

                toastr.success('customer created successfully!');
                document.getElementById('customerForm').reset();
                $('#customer').append('<option selected value="'+response.data.customers.id+'">'+response.data.customers.name+'</option>');
                $('#customer').val(response.data.customers.id).trigger('change');
                
                $('#addModal').modal('hide');
            })
            .catch(function(error) {
                console.error('Error creating customer:', error);
            });
    });


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
                        return { id: product.id, text: product.name + ' ' + product.strength + ' ' + product.description + ' ' + product.brand + ' ' + product.manufacturer + ' Qty : ' + product.current_stock };
                    })
                };
            }
        }
    });

</script>

@endpush