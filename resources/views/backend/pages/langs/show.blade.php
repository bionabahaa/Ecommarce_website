@extends('backend.layouts.master')

@section('title',transWord('Edit User Data'))

@section('stylesheet')

@endsection

@section('content')

@include('backend.components.errors')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>@lang('tr.User Data')</h2>
                <ul class="header-dropdown dropdown">
                    
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('edit_users',$user->id) }}"><i class="fa fa-edit"></i> {{ transWord('Edit Data') }}</a></li>
                            <li><a href="{{ route('destroy_users',$user->id) }}" onclick="return confirm('{{ transWord('Are You Sure?') }}')"><i class="fa fa-trash"></i> @lang('tr.Delete Data')</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3>@lang('tr.User Data')</h3>
                <hr>
                    <div class="row">
                        <div class="col-lg-9">
                            <label for="name">{{ transWord('Name') }}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-pencil"></i></span>
                                </div>
                                <input type="text" id="name" readonly value="{{ $user->name }}" required class="form-control" placeholder="{{ transWord('Name') }}" aria-label="{{ transWord('Name') }}" name="name" aria-describedby="basic-addon1">
                            </div>

                            <label for="email">{{ transWord('Email Address') }}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                                </div>
                                <input type="email" name="email" readonly value="{{ $user->email }}" required id="email" class="form-control email" placeholder="Ex: example@example.com">
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="multiselect2">{{ transWord('Roles') }}</label><br>
                                    @foreach (getUserRole($user->id) as $item)
                                    <span class="badge badge-primary" style="font-weight: bold;font-size:13px;padding:10px;">{{ $item }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <img src="{{ asset('uploads/backend/users/'.$user->avatar) }}"  style="width: 200px;height: 200px;display: block;margin-left: auto;margin-right: auto;border: 10px solid #22252a;padding: 10px;background: white;">
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection