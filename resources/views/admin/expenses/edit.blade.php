 @extends('layouts.admin')
 @section('title', 'Admin | Expense')
 @section('page-headder')
 @endsection
 @section('content')
 <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
     <div class="col-sm-6">
         <span class="my-auto h6 page-headder">
             @yield('page-headder')
         </span>
         <ol class="breadcrumb bg-white">
             <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
             <li class="breadcrumb-item text-dark"><a href="{{ route('admin.expenses.index') }}">Expense</a></li>
         </ol>
     </div>
 </div>
 <div class="row">
     <div class="card bg-white p-0">
         <div class="card-header justify-content-between py-3">
             <h4 class="card-title float-left pt-2">Update Expense</h4>
         </div>
         <div class="container p-4">
             <form method="POST" action="{{ route('admin.expenses.update',  $query->id) }}" enctype="multipart/form-data">
                 @csrf
                 @method('PUT')
                 <div class="row justify-content-center">

                     <div class="mb-3 col-12 col-md-4 col-lg-3">
                         <div class="form-group">
                             <label for="name">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', optional($query)->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                         </div>
                     </div>
                </div>
                <div class="row justify-content-center">

                     <div class="mb-3 col-12 col-md-4 col-lg-3">
                         <button type="submit" class="btn btn-primary">Save</button>
                         <a type="button" class="btn bg-danger" href="{{ route('admin.expenses.index') }}">Cancel</a>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div> <!-- /.content -->
 @endsection
