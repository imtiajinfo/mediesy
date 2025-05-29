{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add New supplier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-md-4">
                <form method="POST" id="supplierFrom" action="{{ route('admin.suppliers.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="company_name">Supplier Company Name</label>
                                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Enter company_name..." id="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="name">Supplier Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Supplier Name..." id="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone..." id="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." id="email" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        

                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="company_tin_number"> Company TIN Number</label>
                                <input type="number" name="company_tin_number" class="form-control @error('company_tin_number') is-invalid @enderror" placeholder="Enter company_tin_number..." id="company_tin_number" value="{{ old('company_tin_number') }}">
                                @error('company_tin_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="supplier_destination">Supplier Destination</label>
                                <input type="text" name="supplier_destination" class="form-control @error('supplier_destination') is-invalid @enderror" placeholder="Enter supplier_destination..." id="supplier_destination" value="{{ old('supplier_destination') }}">
                                @error('supplier_destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="brand"> Brand</label>
                                <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" placeholder="Enter brand..." id="brand" value="{{ old('brand') }}">
                                @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 text-right">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
