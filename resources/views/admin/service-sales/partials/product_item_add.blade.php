{{-- add modal --}}
<div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-md-4">
                <form method="POST" id="productFrom" action="{{ route('admin.saleItemAdd') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-12 px-4">
                            <div class="row bg-light">

                                <div class="mb-3 col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Product Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Product Name" required>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sub_title">Product Code</label>
                                        <input type="text" name="sub_title" class="form-control" id="Reference No" placeholder="Product Code">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3" style="display: none">
                                    <label for="product_type" class="control-label mb-0 pb-0">Product type<label class="text-danger">*</label></label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="product_type"
                                                class="form-select">
                                                <option value="">Select Product type</option>
                                                <option value="finished_goods" selected>Finished Goods</option>
                                                <option value="raw_materials">Raw Materials</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for=" " class=" mb-2 pb-0">Category</label>
                                    <div class="input-group">
                                        <select name="category_id" class="form-control" id="category" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for="unit" class="control-label mb-0 pb-0">Unit</label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="unit" id="unit"
                                                class="form-select" >
                                                <option value="">Select Unit</option>
                                                @foreach ($uoms as $key => $trans_uom)
                                                    <option value="{{ $trans_uom->id }}">{{  $trans_uom->uom_short_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for="brand_id" class="control-label mb-0 pb-0">Brand</label>
                                    <div class="input-group mr-2">
                                        <div class="input-group">
                                            <select name="brand_id" id="brand"
                                                class="form-select">
                                                <option value="">Select brand</option>
                                                @if (count($brands) > 0)
                                                @foreach ($brands as $key => $brand_id)
                                                <option class="m-1" value="{{ $brand_id->id }}">
                                                    {{ $brand_id->name_english }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price<span class="text-danger">*</span></label>
                                        <input type="text" name="purchase_price" class="form-control" placeholder="Purchase Price">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="retail_price">Retail Price<span class="text-danger">*</span></label>
                                        <input type="text" required name="retail_price" class="form-control" placeholder="Retail Price">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="whole_sale_price">Whole Sell Price</label>
                                        <input type="text" name="whole_sale_price" class="form-control" placeholder="Whole Sell Price">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3" >
                                    <div class="form-group">
                                        <label for="whole_sale_price">Whole Sell Quantity</label>
                                        <input type="text" name="whole_sale_qty" class="form-control" placeholder="Whole Sell Qty">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="purchase_qty">Purchase Quantity <span class="text-danger">*</span></label>
                                        <input type="text" name="purchase_qty" class="form-control" placeholder="Purchase Quantity" required>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label>Cover Image</label>
                                    <input type="file" name="thumbnail">
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 text-right">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-Info bg-info">Reset</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
