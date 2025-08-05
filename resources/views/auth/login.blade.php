@extends('login_layout')

@section('content')
    <!-- Login Register area Start-->
    <div class="login-content">
        <!-- Login -->
        <div style="margin-top: -500px; margin-bottom: 20px;">
            <img src="{{ asset('images\logo.png') }}" style="border: 0.5px dotted white;" />
        </div>
        <div class="nk-block toggled" id="l-login">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open() !!}
                <div class="nk-form">
                <div class="input-group">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                    <div class="nk-int-st">
                        <input type="text" class="form-control" placeholder="Username" name="username">
                    </div>
                </div>
                <div class="input-group mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                    <div class="nk-int-st">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                </div>
                <button class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow right-arrow-ant"></i></button>
                </div>
            {!! Form::close() !!}

            <div class="nk-navigation nk-lg-ic">
                {{--                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-register"><i class="notika-icon notika-plus-symbol"></i> <span>Register</span></a>--}}
                <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
            </div>
        </div>

        <!-- Forgot Password -->
        <div class="nk-block" id="l-forget-password">
            <div class="nk-form">
                <form action="{{ route('forgotPassword') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="input-group">
                        <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                        <div class="nk-int-st">
                            <input type="text" class="form-control" name="username" placeholder="1101001">
                        </div>
                    </div>
{{--                    <input type="submit" class="btn btn-login btn-success btn-float" />--}}
                    <button class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow"></i></button>
                </form>
            </div>

            <div class="nk-navigation nk-lg-ic rg-ic-stl">
                <a href="" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i class="notika-icon notika-right-arrow"></i> <span>Sign in</span></a>
            </div>
        </div>
    </div>
    <!-- Login Register area End-->
@endsection