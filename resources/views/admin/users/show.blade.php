@extends('layouts.admin')
@section('title', 'Admin | purchase_orders')

@section('page-headder')
@endsection

@section('content')
<div class="bg-light p-4 rounded">
    <h1>Show user</h1>
    <div class="lead">

    </div>

    <div class="container mt-4">
        <div>
            Name: {{ $user->name }}
        </div>
        <div>
            Email: {{ $user->email }}
        </div>
        <div>
            Username: {{ $user->role }}
        </div>
    </div>

</div>
<div class="mt-4">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info">Edit</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Back</a>
</div>
@endsection
