@extends('backend.layouts.app')
@section('title', 'Employee Details')
@section('content')

    <div class="card col-md-8 offset-md-2">
        <div class="card-header">
            <h5>Employee Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img width="100%"
                        src="{{ asset($employee->upload ? $employee->upload->file_name : 'avatar.jpeg') }}"
                        alt="">
                </div>
                <div class="col-md-8">

                    <h4 class="text-info">{{ $employee->name ?? 'Unnamed' }}</h4>
                    <h5>{{ collect($employee->roles)->first()->name ?? ''}}</h5>
                    <h6>Branch : <a href="#">{{ $employee->branch_name ?? 'Unnamed Branch' }}</a></h6>

                    @can('edit_employee')
                        <a class="btn btn-sm btn-info" href="{{ route('admin.employees.edit', $employee->id) }}">Edit
                            Profile</a>
                    @endcan

                    <hr class="mb-4">

                    <table>
                        <tr>
                            <th>Phone</th>
                            <th>{{ $employee->phone ?? '' }}</th>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <th>{{ $employee->email ?? 'info@mail.com' }}</th>
                        </tr>

                        <tr>
                            <th width="50%">Present Address</th>
                            <th>{{ $employee->present_address ?? 'Zura 123, #House No: 23, Dhaka' }}</th>
                        </tr>

                        <tr>
                            <th width="50%">Permanent Address</th>
                            <th>{{ $employee->permanent_address ?? 'Zura 123, #House No: 23, Dhaka' }}</th>
                        </tr>

                        <tr>
                            <th>NID</th>
                            <th>{{ $employee->nid ?? 'Not Exists' }}</th>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="mt-3">
                <h6>Employee Details : </h6>
                {{-- <p class="fs-5" style="width: 80%">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro velit non doloribus perspiciatis sequi
                    eveniet voluptatibus facilis, quis necessitatibus tenetur cupiditate possimus iure unde consequuntur
                    reiciendis quod! Itaque, reprehenderit expedita.
                </p> --}}
                <h5>NID Docs : </h5>
                {{-- <div>
                    <img width="100px" src="{{ asset('placeholder_book.jpeg') }}" alt="">
                </div> --}}
            </div>
        </div>

    </div>

    @push('script')
        <script></script>
    @endpush
@endsection
