@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Publisher Information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.publishers.update', $publisher->slug) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ __('Name') }}" id="name" name="name"
                                class="form-control" value="{{ $publisher->name }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Bangla Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ __('Bangla Name') }}" id="name" name="name_bangla"
                                class="form-control" value="{{ $publisher->name_bangla }}" required>
                            @error('name_bangla')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label"
                            for="collection_hub_id">{{ translate('Book Collection Hub') }}</label>
                        <div class="col-sm-9">
                            <select id="collection_hub_id" name="collection_hub_id" class="form-control select2" required>
                                <option value="">--select option--</option>
                                @foreach ($collectionHub as $hub)
                                    <option {{ $hub->id == $publisher->collection_hub_id ? 'selected' : '' }}
                                        value="{{ $hub->id }}">{{ $hub->name_bangla }}</option>
                                @endforeach
                            </select>
                            @error('collection_hub_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ __('Email Address') }}" id="email" name="email"
                                class="form-control" value="{{ $publisher->email }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Phone') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ __('Phone') }}" id="phone_number" name="phone_number"
                                class="form-control" value="{{ $publisher->phone_number }}" required>
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{ __('Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{ __('Password') }}" id="password" name="password"
                                class="form-control">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="description">{{ __('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea placeholder="{{ __('description') }}" id="description" name="description" class="form-control"
                                rows="3">{{ $publisher->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{ __('Logo') }}
                            <small>({{ __('32x32') }})</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ __('Choose File') }}</div>
                                <input type="hidden" name="image" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                                <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item"
                                    data-id="299" title="wf.png">
                                    <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                        <img src="{{ asset($publisher->image) }}" class="img-fit">
                                    </div>
                                    <div class="col body">
                                        <h6 class="d-flex"><span class="text-truncate title">wf</span><span
                                                class="flex-shrink-0 ext">.png</span></h6>
                                        <p>162 Bytes</p>
                                    </div>
                                    <div class="remove"><button class="btn btn-sm btn-link remove-attachment"
                                            type="button"><i class="la la-close"></i></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
