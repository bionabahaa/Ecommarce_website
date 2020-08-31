@extends('backend.layouts.master')

@section('title',transWord('Create New User'))

@section('stylesheet')

<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/multi-select/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/nouislider/nouislider.min.css') }}">

<style>
    .dropify-wrapper{
        height: 90%;
    }
</style>
@endsection

@section('content')

@include('backend.components.errors')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Create New User') }}</h2>
                <ul class="header-dropdown dropdown">
                    
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users') }}"><i class="icon-users"></i> {{ transWord('All Users') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3>{{ transWord('Fill User Data') }}</h3>
                <hr>
                <form action="{{ route('store_users') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <label for="name">{{ transWord('Name') }}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-pencil"></i></span>
                                </div>
                                <input type="text" id="name" required class="form-control" placeholder="{{ transWord('Name') }}" aria-label="{{ transWord('Name') }}" name="name" aria-describedby="basic-addon1">
                            </div>

                            <label for="email">{{ transWord('Email Address') }}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                                </div>
                                <input type="email" name="email" required id="email" class="form-control email" placeholder="Ex: example@example.com">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="password">{{ transWord('Password') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-key"></i></span>
                                        </div>
                                        <input type="password" required name="password" id="password" class="form-control email" placeholder="{{ transWord('Password') }}">
                                    </div>
                                </div>
        
                                <div class="col-lg-6">
                                    <label for="confirmpass">{{ transWord('Confirm Password') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-key"></i></span>
                                        </div>
                                        <input type="password" required name="password_confirmation" id="confirmpass" class="form-control email" placeholder="{{ transWord('Confirm Password') }}">
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="multiselect2">{{ transWord('Select Role') }}</label>
                                    <div class="multiselect_div">
                                        <select id="multiselect2" required name="roles[]" class="multiselect multiselect-custom" multiple="multiple">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <label for="avatar">{{ transWord('Profile Image') }}</label>
                            <input type="file" name="avatar" height="100%" id="avatar" class="dropify">
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary"><i class="icon-plus"></i>&nbsp;{{ transWord('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('dashboard/assets/vendor/dropify/js/dropify.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/pages/forms/dropify.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script><!-- Bootstrap Colorpicker Js --> 
<script src="{{ asset('dashboard/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script><!-- Input Mask Plugin Js --> 
<script src="{{ asset('dashboard/assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script><!-- Multi Select Plugin Js -->
<script src="{{ asset('dashboard/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script><!-- Bootstrap Tags Input Plugin Js --> 
<script src="{{ asset('dashboard/assets/vendor/nouislider/nouislider.js') }}"></script><!-- noUISlider Plugin Js -->
<script src="{{ asset('dashboard/assets/js/pages/forms/advanced-form-elements.js') }}"></script>

@endsection