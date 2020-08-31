@extends('backend.layouts.master')

@section('title',transWord('Pages'))

@section('stylesheet')

@include('backend.components.datatablecss')

@endsection

@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>@lang('tr.All Pages')</h2>
                <ul class="header-dropdown dropdown">
                    
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('create_pages') }}"><i class="icon-book-open"></i> @lang('tr.Add New Page')</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table id="example" class="display table table-hover js-basic-example dataTable table-custom spacing5" style="width:100%">
                        <thead>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Title') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Page Tag') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Publish') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Actions') }}</th>
                            </tr>
                        </thead>
                        
                        <tbody id="permissionTable">
                            
                            @foreach ($allpages as $index => $p)
                            <tr>
                                <td style="background: #595f66;color:white;">{{ $index + 1 }}</td>
                                <td style="background: #595f66;color:white;">{{ getDataFromJsonByLanguage($p->title) }}</td>
                                <td style="background: #595f66;color:white;">{{ getDataFromJsonByLanguage($p->slug) }}</td>
                                <td style="background: #595f66;color:white;">
                                @if ($p->publish == 1)
                                <span class="badge badge-primary" style="font-weight: bold;">{{ transWord('Publish') }}</span>
                                @else
                                <span class="badge badge-danger" style="font-weight: bold;">{{ transWord('Un Publish') }}</span>
                                @endif
                                </td>
                                <td style="background: #595f66;color:white;">
                                    <li class="dropdown language-menu" style="list-style: none">
                                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="color: white;">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item pt-2 pb-2" href="{{ route('show_pages',$p->id) }}"><i class="fa fa-eye"></i> @lang('tr.Show')</a>
                                            <a class="dropdown-item pt-2 pb-2" href="{{ route('edit_pages',$p->id) }}"><i class="fa fa-edit"></i> @lang('tr.Edit')</a>
                                            <a class="dropdown-item pt-2 pb-2" id="deleteBtn" href="{{ route('destroy_pages',$p->id) }}" onclick="return confirm('{{ transWord('Are You Sure?') }}')"><i class="fa fa-trash"></i> @lang('tr.Delete')</a>
                                        </div>
                                    </li>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Title') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Page Tag') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Publish') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Actions') }}</th>
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