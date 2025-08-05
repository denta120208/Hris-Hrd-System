@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>User {!! $user->name !!}</h1>
    <div class="col-md-12">&nbsp;</div>
    <div class="col-md-6">
        {!! Form::open(['method' => 'delete', 'route' => ['users.destroy', $user->id] ]) !!}
        <input type="hidden" name="ip" id="ip" />
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" disabled="disabled" />
        </div>
        <div class="form-group">
            <label for="perms_name">Access Level</label>
            <input class="form-control" type="text" name="perms_name" id="perms_name" value="{{ $user->perms_name }}" disabled="disabled" />
        </div>
        <input type="submit" value="Delete" class="btn btn-danger" />
        <a class="btn btn-success" href="{{ route('users.index') }}">Back</a>
        {!! Form::close() !!}
    </div>
</div>
@endsection