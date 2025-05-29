@extends('layouts.admin')
@section('title', 'Admin | purchase_orders')

@section('page-headder')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }

    input[type="checkbox"] {
        width: 17px !important;
        height: 17px !important;
    }

</style>
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
                    <h4 class="header-title">Create New Role</h4>
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label ml-3" for="checkPermissionAll">All</label>
                            </div>
                            <hr>

                            <table id="example1" class="table table-hover border text-start">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th colspan="3" style="min-width:150px" class=" text-start">Menu Name</th>
                                        <th class=" text-start">List</th>
                                        <th class=" text-start">Add</th>
                                        <th class=" text-start">Edit</th>
                                        <th class=" text-start">View</th>
                                        <th class=" text-start">Delete</th>
                                        <th class=" text-start">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="datatable">

                                    <style>
                                        label {
                                            color: #444 !important;
                                            font-size: 10px !important;
                                            font-weight: 500 !important;
                                        }

                                        input[type="checkbox"] {
                                            width: 17px !important;
                                            height: 17px !important;
                                        }

                                    </style>

                                    @php $i = 1; @endphp
                                    @foreach ($permission_groups as $group)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td colspan="3">
                                            <div class="form-check text-start">
                                                <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                <label class="form-check-label ml-3" for="checkPermission">{{ $group->name }}</label>
                                            </div>
                                        </td>
                                        <span class="role-{{ $i }}-management-checkbox  text-start">
                                            @php
                                            $permissions = App\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                            @endphp
                                            @foreach($permissions as $permission)
                                            <td class=" text-start">
                                                <div class="form-check mx-2  text-start">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                    <label class="form-check-label ml-3" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            </td>
                                            @php $j++; @endphp
                                            @endforeach

                                            </td>
                                        </span>
                                    </tr>

                                    @php $i++; @endphp
                                    @endforeach

                                </tbody>
                            </table>







                        </div>


                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Role</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection

@push('.js')
@include('admin.roles.partials.scripts')

@endpush
