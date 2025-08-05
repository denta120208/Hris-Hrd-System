@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>User {!! $user->name !!}</h1>
    <div class="col-md-12">&nbsp;</div>
    <div class="col-md-6">
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
        <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
    </div>
</div>
@endsection