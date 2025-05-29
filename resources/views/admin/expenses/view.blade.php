 @extends('layouts.admin') @section('title', 'Admin | Expense') @section('page-headder') @endsection @section('content')
 <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
     <div class="col-sm-6"> <span class="my-auto h6 page-headder">@yield('page-headder')</span>
         <ol class="breadcrumb bg-white">
             <li class="breadcrumb-item">
                 <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>
             </li>
             <li class="breadcrumb-item text-dark"><a href="{{ route('admin.expenses.index') }}">Expense</a></li>
         </ol>
     </div>
 </div>
 <div class="row">
     <div class="card bg-white p-0">
         <div class="card-header justify-content-between py-3">
             <h4 class="card-title float-left pt-2">View Expense</h4>
         </div>
         <div class="container p-4">
             <form>

                 <div class="row">

                     <div class="mb-3 col-12 col-md-4 col-lg-3">
                         <div class="form-group">
                             <label for="name">Name</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name..." id="name" value="{{ old('name', optional($query)->name) }}" required disabled>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                         </div>
                     </div>
                     <div class="mb-3 col-12 col-md-4 col-lg-3">
                         <div class="form-group">
                             <label for="name_bangla">Name_bangla</label><input type="text" name="name_bangla" class="form-control @error('name_bangla') is-invalid @enderror" placeholder="Enter Name_bangla..." id="name_bangla" value="{{ old('name_bangla', optional($query)->name_bangla) }}" required disabled>@error('name_bangla')<div class="invalid-feedback">{{ $message }}</div>@enderror
                         </div>
                     </div>
                     <div class="mb-3 col-12 col-md-4 col-lg-3">
                         <div class="form-group">
                             <label for="descriptions">Descriptions</label><textarea name="descriptions" class="form-control @error('descriptions') is-invalid @enderror" placeholder="Enter Descriptions..." id="descriptions" required disabled>{{ old('descriptions', optional($query)->descriptions) }}</textarea>@error('descriptions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                         </div>
                     </div>

                     <div class="mb-3 text-right">
                         <a type="button" class="btn bg-danger" href="{{ route('admin.expenses.index') }}">Close</a>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div> <!-- /.content -->
 @endsection
