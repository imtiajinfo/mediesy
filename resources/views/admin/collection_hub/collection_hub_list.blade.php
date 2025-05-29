@extends('backend.layouts.app')
@section('title', 'Collection Hub information')
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3 px-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">{{ __('All Collection Hub') }}</h1>
            <div><a class="btn btn-primary btn-sm" href="{{ route('admin.collection_hubs.create') }}">Add New</a></div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_authors" action="" method="GET">

            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            {{-- <th>{{ __('Name') }}</th> --}}
                            <th>{{ __('Name Bangla') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th width="10%">{{ __('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collectionHubs->data as $key => $hub)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $hub->name }}</td> --}}
                                <td>{{ $hub->name_bangla }}</td>
                                <td>{{ $hub->address ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($hub->created_at)->format('d-M-Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                            data-toggle="dropdown" href="javascript:void(0);" role="button"
                                            aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">

                                            @can('edit_collection_hub')
                                                <a href="{{ route('admin.collection_hubs.edit', $hub->id) }}"
                                                    class="dropdown-item">
                                                    {{ __('Edit') }}
                                                </a>
                                            @endcan

                                            @can('view_collection_hub')
                                                <a href="{{ route('admin.collection_hubs.show', $hub->id) }}"
                                                    class="dropdown-item">
                                                    {{ __('View') }}
                                                </a>
                                            @endcan

                                            @can('delete_collection_hub')
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('admin.collection_hubs.destroy', $hub->id) }}"
                                                    class="">
                                                    {{ __('Delete') }}
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination d-flex justify-content-end">
                    <x-pagination :pagination="$collectionHubs" />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')
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


        function sort_authors(el) {
            $('#sort_authors').submit();
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

        function bulk_delete() {
            var data = new FormData($('#sort_authors')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.bulk-author-delete') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
