@extends('backend.layouts.master')

@section('title',transWord('Contact Us'))

@section('stylesheet')

@include('backend.components.datatablecss')

@endsection

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Contact Us') }}</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table id="example" class="display table table-hover js-basic-example dataTable table-custom spacing5" style="width:100%">
                        <thead>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Name') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Email') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Subject') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Message') }}</th>
                            </tr>
                        </thead>
                        
                        <tbody id="permissionTable">
                            @foreach ($contacts as $index => $contact)
                            <tr>
                                <td style="background: #595f66;color:white;">{{ $index + 1 }}</td>
                                <td style="background: #595f66;color:white;">{{ $contact->name }}</td>
                                <td style="background: #595f66;color:white;">{{ $contact->email }}</td>
                                <td style="background: #595f66;color:white;">{{ $contact->subject }}</td>
                                <td style="background: #595f66;color:white;">{{ $contact->message }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Name') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Email') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Subject') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Message') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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