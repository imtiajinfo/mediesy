@extends('layouts.admin')
@section('title', 'Admin | purchase_orders')

@section('page-headder')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
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
                    <h4 class="header-title">Edit Role</h4>
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
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                            <div class="row">
                                @php
                                $permissions = App\User::getpermissionsByGroupName($group->name);
                                $j = 1;
                                @endphp

                                <div class="col-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                    </div>
                                </div>

                                <div class="col-9 role-{{ $i }}-management-checkbox">

                                    @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @php $j++; @endphp
                                    @endforeach
                                    <br>
                                </div>

                            </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Role</button>
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
