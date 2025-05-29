@extends('backend.layouts.app')
@section('title', 'Branch Details')
@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3 px-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">{{ __('Branch Details') }}</h1>
            <div><a class="btn btn-primary btn-sm" href="{{ route('admin.collection_hubs.create') }}">Add New</a></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6> Branch : <a href="javascript:void(0)">{{ $branch->name ?? '' }}</a></h6>
            <h6>Employee List</h6>
        </div>

        <div class="card-body">
            <table class="table table-sm aiz-table mb-0">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Permanent Address</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees->data as $employee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img width="40px" src="{{ asset($employee->user->upload->file_name ?? 'avatar.jpeg') }}"
                                    alt=""></td>
                            <td>{{ $employee->name }}</td>
                            <td>
                                @foreach ($employee->user->roles as $role)
                                    <span class="alert-success">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->user->email }}</td>
                            <td>{{ $employee->permanent_address }}</td>
                            <td class="d-flex text-center">
                                <a class="btn btn-sm btn-info" href="{{ route('admin.employees.show', $employee->id) }}"><i
                                        class="las la-user"></i></a>
                                <a class="btn btn-sm btn-success"
                                    href="{{ route('admin.employees.edit', $employee->id) }}"><i
                                        class="las la-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <x-pagination :pagination="$employees" />
            </div>
        </div>
    </div>
@endsection
