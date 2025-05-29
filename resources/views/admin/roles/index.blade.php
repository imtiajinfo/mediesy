@extends('layouts.admin')
@section('title', 'Admin | purchase_orders')

@section('page-headder')
@endsection

@section('styles')
<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-store"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i> </a></li>
            <li class="breadcrumb-store text-dark px-2"><a href="#"> Roles</a>
            </li>
        </ol>
    </div>
</div>

<div class="m-0 p-0">
    <div class="row">
        <!-- data table start -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Roles List</h4>
                    <p class="float-right mb-2">
                        {{-- @if (Auth::guard('sanctum')->user()->can('role.create')) --}}
                        <a class="btn btn-primary text-white" href="{{ route('admin.roles.create') }}">Create New Role</a>
                        {{-- @endif --}}
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="60%">Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr class="border">
                                    <td>{{ $loop->index+1 }}</td>
                                    <td class="text-start">{{ $role->name }}</td>
                                    <td class="text-start border">
                                        @foreach ($role->permissions as $perm)
                                        {{-- <td widtd="5%"> --}}
                                        <span class="badge badge-info mr-1">{{ $perm->name }} </span>
                                        {{-- </td> --}}


                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- @if (Auth::guard('sanctum')->user()->can('admin.edit')) --}}
                                        <a class="btn btn-success text-white" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                        {{-- @endif --}}

                                        {{-- @if (Auth::guard('sanctum')->user()->can('admin.edit')) --}}
                                        <a class="btn btn-danger text-white" href="{{ route('admin.roles.destroy', $role->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                            Delete
                                            {{-- </a> --}}

                                            <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            {{-- @endif --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection


@section('scripts')
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
    /*================================
        datatable active
        ==================================*/
    if ($('#dataTable').length) {
        $('#dataTable').DataTable({
            responsive: true
        });
    }

</script>
@endsection
