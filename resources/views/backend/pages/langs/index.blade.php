@extends('backend.layouts.master')

@section('title',transWord('Translation'))

@section('stylesheet')

@include('backend.components.datatablecss')

@endsection

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ transWord('Translation').' ('.\Lang::getLocale().')' }}&nbsp;
                    <button type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".new-project-modal"><i class="fa fa-plus-circle"></i>&nbsp;{{ transWord('Add New') }}</button>
                </h2>
            </div>
            <div class="body">
                <form action="{{ route('store_langs') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach ($langs as $index => $lang)
                        <div class="col-lg-3">
                            <h6>{{ $lang->word }}</h6>
                            <input type="hidden" name="ids[]" value="{{ $lang->id }}">
                            <h6><input type="text" name="trans[]" value="{{ $lang->translation }}" style="color: white;font-weight:bold;" id="" class="form-control"></h6>
                        </div>
                        @endforeach  
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;{{ transWord('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Add Trans Modal --}}
<div class="modal fade new-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ transWord('Add New Translation in').' '.\Lang::getLocale() }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('store_new_langs') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="word" placeholder="{{ transWord('Word') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="translation" placeholder="{{ transWord('Translation') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-round btn-default" data-dismiss="modal">{{ transWord('Close') }}</button>
                    <button type="submit" class="btn btn-round btn-success">{{ transWord('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@include('backend.components.datatablejs')

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            "language": {
                "url": "{{ datatableLang() }}"
            },
            buttons: [
            {
                extend: 'copy',
                text: "{{ transWord('Copy') }}",
                key: {
                    key: 'c',
                    altKey: true
                }
            },
            {
                extend: 'print',
                text: "{{ transWord('Print') }}",
                key: {
                    key: 'p',
                    altKey: true
                }
            },
            
        ]
        } );
    } );

    
</script>
@endsection