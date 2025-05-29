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
    <h4>Permissions</h4>
    <div class="lead mb-2">
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm float-right">Add permissions</a>
    </div>



    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col" width="15%">Name</th>
                <th scope="col">Guard</th>
                <th scope="col" colspan="3" width="1%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->guard_name }}</td>
                <td><a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                <td>
                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
