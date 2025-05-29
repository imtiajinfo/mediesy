@extends('layouts.admin')
@section('title', 'Admin | Purchase Order')

@section('page-headder')
{{-- purchaseOrders --}}
@endsection


@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2 m-1">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-store"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i> </a></li>
            <li class="breadcrumb-store text-dark px-2"><a href="#"> Permissions</a>
            </li>
        </ol>
    </div>
</div>
<div class="bg-light p-4">
    <h2>Edit permission</h2>
    <div class="lead">
        Editing permission.
    </div>

    <div class="container mt-4">

        <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
            @method('patch')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input value="{{ $permission->name }}" type="text" class="form-control" name="name" placeholder="Name" required>

                @if ($errors->has('name'))
                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save permission</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-default">Back</a>
        </form>
    </div>

</div>
@endsection
