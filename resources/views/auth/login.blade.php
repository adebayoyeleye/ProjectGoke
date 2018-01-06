@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                   
                   
                   
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="{{ url('/auth/facebook') }}" class="btn btn-block btn-lg btn-social btn-facebook">
                                <span class="fa fa-facebook"></span>
                                <strong>Facebook</strong> login
                            </a>
                        </div>
                        <div class="col-xs-4">
                            <a href="{{ url('/auth/twitter') }}" class="btn btn-lg btn-block btn-social btn-twitter">
                                <i class="fa fa-twitter"></i>
                                <strong>Twitter</strong> login
                            </a>
                        </div>	
                        <div class="col-xs-4">
                            <a href="{{ url('/auth/google') }}" class="btn btn-lg btn-block btn-social btn-google">
                                <i class="fa fa-google-plus"></i>
                                <strong>Google+</strong> login
                            </a>
                        </div>	
                    </div>

                    <div class="row omb_row-sm-offset-3 omb_loginOr">
                        <div class="col-xs-12 col-sm-6">
                            <hr class="omb_hrOr">
                            <span class="omb_spanOr">or</span>
                        </div>
                    </div>
                   
                   
                   
                   
                   
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
