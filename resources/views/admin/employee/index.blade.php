@extends('backend.layouts.app')
@section('title', 'employee')
@section('content')
<div class="px-2 mt-2 mb-3 text-left aiz-titlebar">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3">{{ __('All employees') }}</h1>
        @can('add_employee')
        <div><a class="btn btn-primary btn-sm" href="{{ route('admin.employees.create') }}">Add New</a></div>
        @endcan
    </div>
</div>
<div class="mb-3 card">
    <div class="mb-3 card-body">
        <form action="{{ url()->current() }}" method="get">
            <div class="row">
                <div class="col-md-3">
                    <input type="search" placeholder="search" name="search" value="{{ @request('search') }}"
                        class="form-control form-control-sm">
                </div>
                <div class="col-md-2" style="margin-left: -20px;">
                        <button type=" submit" class="btn btn-sm btn-primary">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-3 mb-0 table-sm">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Photo</th>
                    <th class="text-left">Branch</th>
                    <th class="text-left">Role</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees->data as $employee)
                <tr>
                    <td class="text-center">{{ serial_no($loop->iteration, $employees) }}</td>
                    <td class="text-center"><img width="40px" src="{{ asset($employee->upload->file_name ?? 'avatar.jpeg') }}" alt=""></td>
                    <td class="text-left">{{ $employee->branch_name ?? '' }}</td>
                    <td class="text-left">
                        @foreach ($employee->roles as $role)
                        <span class="my-2 border rounded alert-success d-inline">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-left">{{ $employee->name_bangla }}</td>
                    <td class="text-left">{{ $employee->email }}</td>
                    <td class="text-center"><label class="mb-0 aiz-switch aiz-switch-success">
                            <input class="active_status" value="{{ $employee->id }}" {{ $employee->is_active == 1 ?
                            'checked' : '' }} type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </td>

                    <td class="text-center">

                        @can('view_employee')
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                            href="{{ route('admin.employees.show', $employee->id) }}" title="{{ __('View') }}">
                            <i class="las la-eye"></i>
                        </a>
                        @endcan

                        @can('edit_employee')
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                            href="{{ route('admin.employees.edit', $employee->id) }}" title="{{ __('Edit') }}">
                            <i class="las la-edit"></i>
                        </a>
                        @endcan

                        {{-- @can('delete_employee')
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                            data-href="{{ route('admin.employees.destroy', $employee->id) }}"
                            title="{{ __('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan --}}

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <x-pagination :pagination="$employees" />
        </div>
    </div>
    {{-- hello --}}
</div>

@push('script')
<script>
    $(document).on('change', '.active_status', function() {
                var url = "{{ api()->admin()->uri('employees.active_status') }}";
                axios.post(url, {
                        id: this.value
                    })
                    .then((response) => {
                        AIZ.plugins.notify('success', response.data);
                    }).catch((error) => {
                        AIZ.plugins.notify('danger', error.response.data);
                    })
            })
</script>
@endpush
@endsection
