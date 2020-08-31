@extends('backend.layouts.master')

@section('title',transWord('Assign Permissions'))

@section('stylesheet')

@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>{{ transWord('Assign Permissions') }}</h2>
            </div>
            <div class="body">
                <h3>{{ $role->name.' '.transWord('Role') }}</h3>
                <hr>
                
                
                    @foreach ($permissionsName as $permissionName)
                
                        <ul class="accordion2" style="border:0;">
                            <li class="accordion-item">
                                <p>
                                    <a style="width: 100%;border-radius: 0;background: #1e1e20;border: 1px solid #1e1e20;padding: 10px;font-size: 16px;" class="btn btn-primary" data-toggle="collapse" href="#collapseExample{{ $permissionName }}" role="button" aria-expanded="true" aria-controls="collapseExample">
                                        {{ ucfirst($permissionName).' ('.__("tr.Permissions").')' }}
                                    </a>
                                </p>
                                <div class="collapse show" id="collapseExample{{ $permissionName }}" style="border: 1px solid #1e1e20;padding: 10px;">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            @if (explode('_',$permission->name)[1] == $permissionName)
                                                <div class="fancy-checkbox col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    @if (in_array($permission->id,$assignedPermissions))
                                                    <label><input class="permissionCheck" value="{{ $permission->id }}" type="checkbox" checked><span>{{ ucwords(str_replace('_',' ',$permission->name)) }}</span></label>
                                                    @else
                                                    <label><input class="permissionCheck" value="{{ $permission->id }}" type="checkbox"><span>{{ ucwords(str_replace('_',' ',$permission->name)) }}</span></label>
                                                    @endif
                                                </div>    
                                            @endif    
                                        @endforeach
                                    </div>
                                </div>
                            </li> 
                        </ul>
                        
                        <hr>
                @endforeach
                                           
               
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')


<script>
    $(function() {
        // (Optional) Active an item if it has the class "is-active"	
        $(".accordion2 > .accordion-item.is-active").children(".accordion-panel").slideDown();
        
        $(".accordion2 > .accordion-item").click(function() {
            // Cancel the siblings
            $(this).siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
            // Toggle the item
            $(this).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
        });
    });

    $(document).ready(function(){
        var checkedVals = null;
        var allPermissionsCheck = [];
        var checkedVals = $('.permissionCheck:checkbox:checked').map(function() {
                allPermissionsCheck.push(this.value);
            }).get();

        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                if (!allPermissionsCheck.includes($(this).val())) {
                    allPermissionsCheck.push($(this).val());
                }
            }
            else if($(this).prop("checked") == false){
                var index = allPermissionsCheck.indexOf($(this).val());
                if (index !== -1) allPermissionsCheck.splice(index, 1);
            }
            var roleId = '{{ $role->id }}';
            var assignPermissionUrl = '{{ route("assign_permissions_roles",["id"=>"#id"]) }}';
            assignPermissionUrl = assignPermissionUrl.replace('#id',roleId);

            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
            jQuery.ajax({
                url: assignPermissionUrl,
                method: 'get',
                data: {
                    permissions: allPermissionsCheck,
                    role_id:roleId
                },
                success: function(result){
                    if (result.done == "200") {
                        swal("{{ transWord('Success') }}", "{{ transWord('Process is done') }}", "success");
                    }else{
                        swal("{{ transWord('Failed') }}", "{{ transWord('Process is failed') }}", "error");
                    }
                }
            });
        });
        
    }); 
    
    
</script>
@endsection