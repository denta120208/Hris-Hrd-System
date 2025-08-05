@extends('_main_layout')

@section('content')
<div class="container">
    <div class="row">
        <br /><br />
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <form action="{{ route('changePass') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <div class="nk-int-st">
                        <label for="old_password">Old Password</label>
                        <input class="form-control" type="password" name="old_password" id="old_password" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="nk-int-st">
                        <label for="password">New Password</label>
                        <input class="form-control" type="password" name="password" id="password" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="nk-int-st">
                        <label for="confirm_pass">Confirm New Password</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
                    </div>
                </div>
                <button class="btn btn-primary pull-right">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection