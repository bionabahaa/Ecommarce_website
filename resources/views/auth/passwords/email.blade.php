@extends('backend.layouts.auth')

@section('title',transWord('Forget Password'))

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
        <div class="card forgot-pass">
            <div class="body">
                <p class="lead mb-3"><strong>{{ transWord('Oops') }}</strong>,<br> {{ transWord('forgot something?') }}</p>
                <p>{{ transWord('Type email to recover password') }}.</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-auth-small" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">                                    
                        <input type="email" class="form-control round @error('email') is-invalid @enderror" name="email" id="signup-password" placeholder="{{ transWord('Email Address') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">{{ transWord('Reset Password') }}</button>
                    <div class="bottom">
                        <span class="helper-text">{{ transWord('Know Password') }} <a href="/login">{{ transWord('Login') }}</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>

@endsection
