@extends('backend.layouts.master')

@section('title',transWord('Main Settings'))

@section('stylesheet')

@endsection

@section('content')

@include('backend.components.errors')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Main Settings') }}</h2>
            </div>
            <div class="body">
                <h3>{{ transWord('Main Settings') }}</h3>
                <hr>
                <form action="{{ route('save_mainsettings') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                    {!! BuildFields('title' , getDataFromJson($settings->title) , 'text' ,['required' => 'required']) !!}
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="email">@lang('tr.Email')</label>
                            <input type="email" name="email" id="email" value="{{ checkHasValue($settings->email) }}" class="form-control" placeholder="@lang('tr.Email Address')">
                        </div>
                        <div class="col-lg-6">
                            <label for="mobile">@lang('tr.Mobile')</label>
                            <input type="text" name="mobile" id="mobile" value="{{ checkHasValue($settings->mobile) }}" class="form-control" placeholder="@lang('tr.Mobile Number')">
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                    {!! BuildFields('address' , getDataFromJson($settings->address) , 'text') !!}
                    </div>

                    <hr>
                    <div class="row">
                    {!! BuildFields('meta_title' , getDataFromJson($settings->meta_title) , 'text') !!}
                    </div>
                    
                    <hr>
                    <div class="row">
                    {!! BuildFields('meta_desc' , getDataFromJson($settings->meta_desc) , 'text') !!}
                    </div>
                    
                    <hr>
                    <div class="row">
                    {!! BuildFields('meta_keywords' , getDataFromJson($settings->meta_keywords) , 'text') !!}
                    </div>

                    <hr>
                    <div class="row">
                    {!! BuildFields('content' , getDataFromJson($settings->content) , 'textarea' , ['required' => 'required']) !!}
                    </div>
                    <hr>

                    <div class="row">
                        @foreach (getDataFromJson($settings->logo) as $key => $value)
                            <div class="col-lg-6">
                                <img src="{{ asset('uploads/backend/settings/'.$value) }}" style="width:70px;height70px;display:block;margin-left:auto;margin-right:auto;" class="img-thumbnail img-responsive" alt="">
                                <p style="display:block;margin-left:auto;margin-right:auto;width:15%;margin-top:10px;" class="badge badge-primary">{{ $key.' '.transWord('Logo') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                    {!! BuildFields('logo' , null , 'file' ) !!}
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="socialmedia">{{ transWord('Social Media') }}</label>
                        </div>
                        {!! socialMediaInputs($settings->socialmedia) !!}

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
<script>
var languages = [];

<?php foreach(getLang() as $key => $val){ ?>
    languages.push('<?php echo $val; ?>');
<?php } ?>

var i = 0;
for (i; i < languages.length; i++) {
    CKEDITOR.replace( 'content['+languages[i]+']', {
        height: 300,
        filebrowserUploadUrl: "{{route('upload_pages', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
} 

</script>
@endsection