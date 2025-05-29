@extends('backend.layouts.app')
@section('title', 'Publisher information')
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3 px-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">All Publisher</h1>
            <div><a class="btn btn-primary btn-sm" href="{{ route('admin.publishers.create') }}">Add New</a></div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_publishers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">Publisher</h5>
                </div>

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker" name="banned" id="approved_status"
                        onchange="sort_publishers()">
                        <option value="">{{ __('Filter by Banned/Unbanned') }}</option>
                        <option value="1"
                            @isset($approved) @if ($approved == 'paid') selected @endif @endisset>
                            {{ __('Banned') }}</option>
                        <option value="0"
                            @isset($approved) @if ($approved == 'unpaid') selected @endif @endisset>
                            {{ __('UnBanned') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"
                            value="{{ @request('search') }}"
                            placeholder="{{ __('Type name or email & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Email Address') }}</th>
                            <th>{{ __('Num. of Book') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Due to publisher') }}</th>
                            <th width="10%">{{ __('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publishers->data as $publisher)
                        {{-- @dd($publishers) --}}
                            <tr>
                                <td>{{ serial_no($loop->iteration, $publishers) }}</td>
                                <td>
                                    <img width="40px"
                                        src="{{ get_correct_path($publisher->image, 'images/publisher', 'avatar.jpeg') }}"
                                        alt="">
                                </td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->phone_number }}</td>
                                <td>{{ $publisher->email }}</td>


                                <td class="text-center">{{ $publisher->products_count ?? 0 }}</td>
                                <td class="text-left">{{ $publisher->banned == 0 ? 'Unbanned':'Banned' }}</td>
                                <td> 0.00 TK</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                            data-toggle="dropdown" href="javascript:void(0);" role="button"
                                            aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            @can('view_publisher_prifile')
                                                <a href="#" onclick="show_publisher_profile('{{ $publisher->id }}');"
                                                    class="dropdown-item">
                                                    {{ __('Profile') }}
                                                </a>
                                            @endcan

                                            @can('login_as_publisher')
                                                <a href="{{ route('admin.publishers.login', encrypt($publisher->id)) }}"
                                                    class="dropdown-item">
                                                    {{ __('Log in as this publisher') }}
                                                </a>
                                            @endcan


                                            @can('publisher_payment')
                                                <a href="#"
                                                    onclick="show_publisher_payment_modal('{{ $publisher->id }}');"
                                                    class="dropdown-item">
                                                    {{ __('Go to Payment') }}
                                                </a>
                                            @endcan

                                            @can('publisher_payment_history')
                                                <a href="#" class="dropdown-item">
                                                    {{ __('Payment History') }}
                                                </a>
                                            @endcan

                                            @can('edit_publishers')
                                                <a href="{{ route('admin.publishers.edit', $publisher->id) }}"
                                                    class="dropdown-item">
                                                    {{ __('Edit') }}
                                                </a>
                                            @endcan


                                            @if ($publisher->banned == 0)
                                                @can('banned_publisher')
                                                    <a href="#"
                                                        onclick="confirm_ban('{{ route('admin.publishers.ban', $publisher->id) }}');"
                                                        class="dropdown-item">
                                                        {{ __('Ban this publisher') }}
                                                        <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('unbanned_publisher')
                                                    <a href="#"
                                                        onclick="confirm_unban('{{ route('admin.publishers.ban', $publisher->id) }}');"
                                                        class="dropdown-item">
                                                        {{ __('Unban this publisher') }}
                                                        <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                            @endif

                                            {{-- @can('delete_publisher')
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('admin.publishers.destroy', $publisher->id) }}"
                                                    class="">
                                                    {{ __('Delete') }}
                                                </a>
                                            @endcan --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination d-flex justify-content-end">
                    <x-pagination :pagination="$publishers" />
                </div>
            </div>
        </form>
    </div>

@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <!-- publisher Profile Modal -->
    <div class="modal fade" id="profile_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="profile-modal-content">

            </div>
        </div>
    </div>

    <!-- publisher Payment Modal -->
    <div class="modal fade" id="payment_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="payment-modal-content">

            </div>
        </div>
    </div>

    <!-- Ban publisher Modal -->
    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ __('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Do you really want to ban this publisher?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-primary" id="confirmation">{{ __('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Unban publisher Modal -->
    <div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ __('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Do you really want to unban this publisher?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-primary" id="confirmationunban">{{ __('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function show_publisher_payment_modal(id) {
            $.post('{{ route('admin.publishers.payment_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {
                    backdrop: 'static'
                });
                $('.demo-select2-placeholder').select2();
            });
        }

        function show_publisher_profile(id) {
            $.post('{{ route('admin.publishers.profile_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }

        function update_approved(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin.publishers.approved') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ __('Approved publishers updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ __('Something went wrong') }}');
                }
            });
        }

        function sort_publishers(el) {
            $('#sort_publishers').submit();
        }

        function confirm_ban(url) {
            $('#confirm-ban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmation').setAttribute('href', url);
        }

        function confirm_unban(url) {
            $('#confirm-unban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmationunban').setAttribute('href', url);
        }
    </script>
@endsection
