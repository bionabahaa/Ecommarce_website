@extends('backend.layouts.master')

@section('title',transWord('Edit Blog Data'))

@section('stylesheet')

@endsection

@section('content')

@include('backend.components.errors')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Edit Blog Data') }}</h2>
                <ul class="header-dropdown dropdown">
                    
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('create_blogs') }}"><i class="icon-book-open"></i> {{ transWord('Create New Blog') }}</a></li>
                            <li><a href="{{ route('blogs') }}"><i class="icon-book-open"></i> {{ transWord('All Blogs') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3>{{ transWord('Fill Blog Data') }}</h3>
                <hr>
                <form action="{{ route('update_blogs',$blog->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                        <div class="row">
                        {!! BuildFields('title' , getDataFromJson($blog->title) , 'text' ,['required' => 'required']) !!}
                        </div>
                        <hr>
    
                        <div class="row">
                        {!! BuildFields('tags' , getDataFromJson($blog->tags) , 'text' ,['required' => 'required']) !!}
                        </div>
    
                        <hr>
                        <div class="row">
                        {!! BuildFields('meta_title' , getDataFromJson($blog->meta_title) , 'text') !!}
                        </div>
                        
                        <hr>
                        <div class="row">
                        {!! BuildFields('meta_desc' , getDataFromJson($blog->meta_desc) , 'text') !!}
                        </div>
                        
                        <hr>
                        <div class="row">
                        {!! BuildFields('meta_keywords' , getDataFromJson($blog->meta_keywords) , 'text') !!}
                        </div>
    
                        <hr>
                        <div class="row">
                        {!! BuildFields('content' , getDataFromJson($blog->content) , 'textarea' , ['required' => 'required']) !!}
                        </div>
                        <hr>
                    
                    <label for="publish">{{ transWord('Publish') }}</label>
                    <select name="publish" id="publish" class="form-control" required>
                        @if ($blog->publish == 1)
                        <option value="1">{{ transWord('Publish') }}</option>
                        <option value="2">{{ transWord('Unpublish') }}</option>
                        @else
                        <option value="2">{{ transWord('Unpublish') }}</option>
                        <option value="1">{{ transWord('Publish') }}</option>
                        @endif
                    </select>
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