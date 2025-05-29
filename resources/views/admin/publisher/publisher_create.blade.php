@extends('backend.layouts.app')
@section('title', 'Publisher Create')
@section('content')


<div class="mx-auto col-lg-8">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Publisher Information') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.publishers.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{ __('Name') }}" id="name" name="name" class="form-control"
                            required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name_bangla">{{ translate('Bangla Name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{ __('Bangla Name') }}" id="name_bangla" name="name_bangla"
                            class="form-control" required>
                        @error('name_bangla')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="collection_hub_id">{{ translate('Book Collection Hub')
                        }}</label>
                    <div class="col-sm-9">
                        <select id="collection_hub_id" name="collection_hub_id" class="form-control select2" required>
                            <option value="">--select option--</option>
                            @foreach ($collectionHub as $hub)
                            <option value="{{ $hub->id }}">{{ $hub->name_bangla }}</option>
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
                        <input type="email" placeholder="{{ __('Email Address') }}" id="email" name="email"
                            class="form-control" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="phone_number">{{ translate('Phone') }}</label>
                    <div class="col-sm-9">
                        <input type="number" placeholder="{{ __('Phone Number') }}" id="phone_number"
                            name="phone_number" class="form-control" required>
                        @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="password">{{ __('Password') }}</label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{ __('Password') }}" id="password" name="password"
                            class="form-control" required>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="description">{{ __('Description') }}</label>
                    <div class="col-sm-9">
                        <textarea placeholder="{{ __('description') }}" id="description" name="description"
                            class="form-control" rows="3"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">{{ __('Logo') }}
                    </label>
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
                        </div>
                    </div>
                </div>
                <div class="mb-0 text-right form-group">
                    <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection