@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>Update Profile</h1>
    &nbsp;
    {!! Form::model('user', [
        'method' => 'put',
        'route' => ['save_profile', $user->id],
    ]) !!}
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" />
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}" disabled="disabled" />
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" />
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password" id="password" />
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
    </div>
    
    <div class="form-group col-lg-12">
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('dashboard') }}">Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection