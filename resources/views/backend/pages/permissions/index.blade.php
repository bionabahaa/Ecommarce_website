@extends('backend.layouts.master')

@section('title',transWord('Permissions'))

@section('stylesheet')

@include('backend.components.datatablecss')

@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Create New Permission') }}</h2>
            </div>
            <div class="body">
                
                <form action="{{ route('store_permissions') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-edit"></i></span>
                        </div>
                        <input type="text" class="form-control" required placeholder="{{ transWord('Permission Name') }}" id="permission_name" aria-label="{{ transWord('Permission Name') }}" name="name" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button type="submit" id="saveBtn" class="btn btn-outline-primary"><i class="fa fa-save"></i>&nbsp;{{ transWord('Save') }}</button>
                        </div>
                    </div>
                </form>
                 
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('All Permissions') }}</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table id="example" class="display table table-hover js-basic-example dataTable table-custom spacing5" style="width:100%">
                        <thead>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Name') }}</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Actions') }}</th>
                            </tr>
                        </thead>
                        
                        <tbody id="permissionTable">
                            @foreach ($permissions as $index => $permission)
                            <tr>
                                <td style="background: #595f66;color:white;">{{ $index + 1 }}</td>
                                <td style="background: #595f66;color:white;">
                                    <span style="display: none;">{{ $permission->name }}</span>
                                    <input type="text" name="edit_name" id="edit_name" data-id="{{ $permission->id }}" class="form-control" value="{{ $permission->name }}" style="background:#282b2f;color: white;">
                                </td>
                                <td style="background: #595f66;color:white;">
                                    <li class="dropdown language-menu" style="list-style: none">
                                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="color: white;">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item pt-2 pb-2" id="deleteBtn" href="{{ route('delete_permissions',$permission->id) }}" onclick="return confirm('{{ transWord('Are You Sure?') }}')"><i class="fa fa-trash"></i> @lang('tr.Delete')</a>
                                        </div>
                                    </li>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Roles') }}</th>
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

    $('#saveBtn').click(function(e){
        e.preventDefault();
        var permission_name = $('#permission_name').val();
        
        if (permission_name == '') {
            alert('@lang("tr.Please fill data")');
        }else{
            var storeUrl = '{{ route("store_permissions") }}';
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            jQuery.ajax({
                url: storeUrl,
                method: 'get',
                data: {
                    permission_name: permission_name,
                },
                success: function(result){
                    if (result.done == "200") {
                        swal("{{ transWord('Success') }}", "{{ transWord('Process is done') }}", "success");
                        var deleteUrl = '{{ route("delete_permissions",["id"=>"#id"]) }}';
                        var permissionData = '';
                        permissionData += '<tr>';
                        permissionData += '<td style="background: #595f66;color:white;">'+result.permissioncount+'</td>';
                        permissionData += '<td style="background: #595f66;color:white;">';
                        permissionData += '<span style="display: none;">'+result.permission.name+'</span>';
                        permissionData += '<input type="text" name="edit_name" id="edit_name" data-id="'+result.permission.id+'" class="form-control" value="'+result.permission.name+'" style="background:#282b2f;color: white;">';
                        permissionData += '</td>';
                        permissionData += '<td style="background: #595f66;color:white;">';
                        permissionData += '<li class="dropdown language-menu" style="list-style: none">';
                        permissionData += '<a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="color: white;">';
                        permissionData += '<i class="fa fa-bars"></i>';
                        permissionData += '</a>';
                        permissionData += '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        permissionData += '<a class="dropdown-item pt-2 pb-2" onclick="return confirm(\'Are You Sure?\')" href="'+deleteUrl.replace('#id',result.permission.id)+'"><i class="fa fa-trash"></i> @lang("tr.Delete")</a>';
                        permissionData += '</div>';
                        permissionData += '</li>';
                        permissionData += '</td>';
                        permissionData += '</tr>';
                        $('#permissionTable').append(permissionData);
                        $('.dataTables_empty').css('display','none');
                    }else{
                        swal("{{ transWord('Failed') }}", "{{ transWord('permission is already exists') }}", "error");
                    }
                }
            });
        }
    });

    $('#edit_name').change(function(){
        if ($(this).val() == '') {
            alert('@lang("tr.Please fill data")');
        }else{
            var permissionName = $(this).val();
            var permissionId = $(this).data('id');
            var editUrl = '{{ route("update_permissions",["id"=>"#id"]) }}';
            editUrl = editUrl.replace('#id',permissionId);

            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            jQuery.ajax({
                url: editUrl,
                method: 'get',
                data: {
                    permission_id: permissionId,
                    permission_name: permissionName,
                },
                success: function(result){
                    if (result.done == "200") {
                        swal("{{ transWord('Success') }}", "{{ transWord('Process is done') }}", "success");
                    }else{
                        swal("{{ transWord('Failed') }}", "{{ transWord('Process is failed') }}", "error");
                    }
                }
            });
        }
    });
    
</script>
@endsection