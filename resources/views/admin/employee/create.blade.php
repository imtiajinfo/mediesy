@extends('backend.layouts.app')
@section('title', 'Employee create')
@section('content')

    <div class="card col-md-8 offset-md-2">
        <div class="card-header">
            <h5>Employee Information</h5>
        </div>
        <form id="formData" action="{{ api()->admin()->uri('employees.store') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">

                    <div class="mb-3 col-md-6">
                        <label for="name">Employee Full Name (English)</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="name_bangla">Employee Full Name (Bangla)</label>
                        <input type="text" class="form-control" id="name_bangla" name="name_bangla" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="branch">Branch</label>
                        <select name="branch" id="branch" class="form-control ">
                            <option value="">--Select Branch--</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->sl_name_bn }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label for="role">Employee Role</label>
                        <select name="role" id="role" class="form-control aiz-selectpicker" multiple>
                            <option value="">--Select Role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3 col-md-6">
                        <label for="present_address">Present Address</label>
                        <input type="text" class="form-control" id="present_address" placeholder="Address"
                            name="present_address">
                    </div>


                    <div class="mb-3 col-md-6">
                        <label for="permanent_address">Permanent Address</label>
                        <input type="text" class="form-control" id="permanent_address" placeholder="Address"
                            name="permanent_address">
                    </div>


                    <div class="mb-3 col-md-6">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" id="nid" name="nid">
                    </div>


                    <div class="mb-3 col-md-6">
                        <div class="form-group">
                            <label for="signinSrEmail">Profile Photo</label>

                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ __('Choose File') }}</div>
                                <input type="hidden" id="avatar" name="avatar" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div>


                    <div class="mb-3 col-md-6">
                        <div class="form-group">
                            <label for="signinSrEmail">Upload NID Docs</label>

                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ __('Choose File') }}</div>
                                <input type="hidden" id="image" name="image" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>

                        </div>
                    </div>


                </div>
            </div>

            <div class="card-header">
                <h6>General Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email" required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation"
                            id="password_confirmation" required>
                    </div>
                </div>

                <div class="text-right">
                    <button type="reset" id="resetButton" class="btn btn-outline-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('script')
        <script>
            const branchUrl = "{{ api()->admin()->uri('collection_hubs.index') }}"

            const getFormData = () => {
                return {
                    name: $('#name').val(),
                    name_bangla: $('#name_bangla').val(),
                    phone: $('#phone').val(),
                    branch: $('#branch').val(),
                    roles: $('#role').val(),
                    present_address: $('#present_address').val(),
                    permanent_address: $('#permanent_address').val(),
                    nid: $('#nid').val(),
                    avatar: $('#avatar').val(),
                    avatar_doc: $('#nid_doc').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                }
            }

            $(document).on('submit', '#formData', function(event) {
                event.preventDefault();
                const data = getFormData();
                const url = "{{ api()->admin()->uri('employees.store') }}";

                axios.post(url, data)
                    .then((response) => {
                        AIZ.plugins.notify('success', response.data.message);
                        window.location.reload();
                        // console.log(data);
                    })
                    .catch((error) => {
                        // console.log(data);
                        const errors = error.response.data.errors ? error.response.data.errors : false;
                        if (errors) {
                            for (let key in errors) {
                                var error = errors[key];
                                $(`#${key}`).addClass('is-invalid');
                                AIZ.plugins.notify('danger', error[0]);
                            }
                        }
                        if (!errors) {
                            AIZ.plugins.notify('danger', error.response.data.message);
                        }
                    })
            })


            $(document).on('input', 'input', function() {
                $(this).removeClass('is-invalid');
            });
            $(document).on('click', '#resetButton', function(event) {
                event.preventDefault();

                // Reset the form
                $('#formData')[0].reset();

                // Clear the role field (if using select2)
                $('#role').val(null).trigger('change');

                // Clear any validation error styles
                $('input').removeClass('is-invalid');

                // Clear the file preview boxes
                $('.file-preview.box').empty();
            });
        </script>
    @endpush
@endsection
