@extends('backend.layouts.master')

@section('title',transWord('Roles'))

@section('stylesheet')

@include('backend.components.datatablecss')

@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Create New Role') }}</h2>
            </div>
            <div class="body">
                
                <form action="{{ route('store_roles') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-edit"></i></span>
                        </div>
                        <input type="text" class="form-control" required placeholder="{{ transWord('Role Name') }}" id="role_name" aria-label="{{ transWord('Role Name') }}" name="name" aria-describedby="basic-addon1">
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
                <h2>{{ transWord('All Roles') }}</h2>
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
                        
                        <tbody id="roleTable">
                            @foreach ($roles as $index => $role)
                            <tr>
                                <td style="background: #595f66;color:white;">{{ $index + 1 }}</td>
                                <td style="background: #595f66;color:white;">
                                    <span style="display: none;">{{ $role->name }}</span>
                                    <input type="text" name="edit_name" id="edit_name" data-id="{{ $role->id }}" class="form-control" value="{{ $role->name }}" style="background:#282b2f;color: white;">
                                </td>
                                <td style="background: #595f66;color:white;">
                                    <li class="dropdown language-menu" style="list-style: none">
                                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="color: white;">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item pt-2 pb-2"  href="{{ route('permissions_roles',$role->id) }}"><i class="icon-shield"></i> @lang('tr.Permissions')</a>
                                            <a class="dropdown-item pt-2 pb-2" id="deleteBtn" href="{{ route('delete_roles',$role->id) }}" onclick="return confirm('{{ transWord('Are You Sure?') }}')"><i class="fa fa-trash"></i> @lang('tr.Delete')</a>
                                        </div>
                                    </li>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th style="background: rgb(60, 64, 68);color:white;">#</th>
                                <th style="background: rgb(60, 64, 68);color:white;">{{ transWord('Name') }}</th>
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
        var role_name = $('#role_name').val();
        
        if (role_name == '') {
            alert('@lang("tr.Please fill data")');
        }else{
            var storeUrl = '{{ route("store_roles") }}';
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            jQuery.ajax({
                url: storeUrl,
                method: 'get',
                data: {
                    role_name: role_name,
                },
                success: function(result){
                    if (result.done == "200") {
                        swal("{{ transWord('Success') }}", "{{ transWord('Process is done') }}", "success");
                        var deleteUrl = '{{ route("delete_roles",["id"=>"#id"]) }}';
                        var permissionsUrl = '{{ route("permissions_roles",["id"=>"#id"]) }}';
                        var roleData = '';
                        roleData += '<tr>';
                        roleData += '<td style="background: #595f66;color:white;">'+result.rolescount+'</td>';
                        roleData += '<td style="background: #595f66;color:white;">';
                        roleData += '<span style="display: none;">'+result.role.name+'</span>';
                        roleData += '<input type="text" name="edit_name" id="edit_name" data-id="'+result.role.id+'" class="form-control" value="'+result.role.name+'" style="background:#282b2f;color: white;">';
                        roleData += '</td>';
                        roleData += '<td style="background: #595f66;color:white;">';
                        roleData += '<li class="dropdown language-menu" style="list-style: none">';
                        roleData += '<a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="color: white;">';
                        roleData += '<i class="fa fa-bars"></i>';
                        roleData += '</a>';
                        roleData += '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        roleData += '<a class="dropdown-item pt-2 pb-2"  href="'+permissionsUrl.replace('#id',result.role.id)+'"><i class="icon-shield"></i> @lang('tr.Permissions')</a>';
                        roleData += '<a class="dropdown-item pt-2 pb-2" onclick="return confirm(\'Are You Sure?\')" href="'+deleteUrl.replace('#id',result.role.id)+'"><i class="fa fa-trash"></i> @lang("tr.Delete")</a>';
                        roleData += '</div>';
                        roleData += '</li>';
                        roleData += '</td>';
                        roleData += '</tr>';
                        $('#roleTable').append(roleData);
                        $('.dataTables_empty').css('display','none');
                    }else{
                        swal("{{ transWord('Failed') }}", "{{ transWord('Role is already exists') }}", "error");
                    }
                }
            });
        }
    });

    $('#edit_name').change(function(){
        if ($(this).val() == '') {
            alert('@lang("tr.Please fill data")');
        }else{
            var roleName = $(this).val();
            var roleId = $(this).data('id');
            var editUrl = '{{ route("update_roles",["id"=>"#id"]) }}';
            editUrl = editUrl.replace('#id',roleId);

            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            jQuery.ajax({
                url: editUrl,
                method: 'get',
                data: {
                    role_id: roleId,
                    role_name: roleName,
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