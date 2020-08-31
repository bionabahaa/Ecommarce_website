@extends('backend.layouts.auth')
@section('title',transWord('Login'))
@section('content')
<div class="auth-main particles_js">
    <div class="auth_div vivify popIn">
        <div class="auth_brand">
        @if(mainSettingsData() != null)
        <a class="navbar-brand" href="javascript:void(0);"><img src="{{ asset('uploads/backend/settings/'.mainSettingsData()['logo']) }}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">{{ mainSettingsData()['title'] }}</a>
        @else
        <a class="navbar-brand" href="javascript:void(0);"><img src="{{ asset('dashboard/assets/images/icon.svg') }}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">{{ transWord('Dashboard') }}</a>
        @endif
        </div>
        <div class="card">
            <div class="body">
                <p class="lead">{{ transWord('Login') }}</p>
                <form class="form-auth-small m-t-20" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="signin-email" class="control-label sr-only">{{ transWord('Email Address') }}</label>
                        <input type="email" class="form-control round @error('email') is-invalid @enderror" name="email" id="signin-email"  placeholder="{{ transWord('Email Address') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="signin-password" class="control-label sr-only">{{ transWord('Password') }}</label>
                        <input type="password" class="form-control round @error('password') is-invalid @enderror" name="password" id="signin-password"  placeholder="{{ transWord('Password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group clearfix">
                        <label class="fancy-checkbox element-left">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ transWord('Remeber me') }}</span>
                        </label>								
                    </div>
                    <button type="submit" class="btn btn-primary btn-round btn-block">{{ transWord('Login') }}</button>
                    <div class="bottom">
                        <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">{{ transWord('Forgot password?') }}</a></span>
                        {{-- <span>Don't have an account? <a href="page-register.html">Register</a></span> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>

@endsection
