<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RolesController extends Controller
{
    public $path = 'backend.pages.roles.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Roles');
        $pages = [
            [transWord('Roles'),'roles']
        ];
        $roles = Role::all();
        return view($this->path.'index',compact('roles','pages','title'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if (Role::where('name',$request->role_name)->get()->count() == 0) {
                $role = Role::create(['name' => $request->role_name]);
                $rolescount = Role::count();
                return response()->json(['done'=>'200','role'=>$role,'rolescount'=>$rolescount]);
            }else{
                return response()->json(['done'=>'500']);
            }
            
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $role = Role::findOrfail($request->role_id);
            $role->name = $request->role_name;
            $role->save();
            return response()->json(['done'=>'200']);
        }
    }

    public function destroy($id){
        $role = Role::findOrfail($id)->delete();
        return back()->with('success','');
    }

    public function permissions($id)
    {
        $title = transWord('Assign Permissions');
        $pages = [
            [transWord('Roles'),'roles'],
            [transWord('Permissions'),'permissions']
        ];

        $role = Role::findOrfail($id);
        $permissions = Permission::all();
        $permssionsOfRole = Role::findByName($role->name)->permissions;
        $assignedPermissions = [];
        foreach ($permssionsOfRole as $permssion) {
            array_push($assignedPermissions,$permssion->id);
        }
        $permissionsName = [];
        foreach ($permissions as $p) {
            if (!in_array(explode('_',$p->name)[1],$permissionsName)) {
                array_push($permissionsName,explode('_',$p->name)[1]);
            }
        }
        
        return view($this->path.'permissions',compact('permissionsName','role','permissions','assignedPermissions','pages','title'));
    }

    public function assignPermissions($id,Request $request)
    {
        if ($request->ajax()) {
            // dd($request->permissions);
            if(isset($request->permissions)){
                $role = Role::findOrfail($request->role_id);
                $role->syncPermissions();
                foreach ($request->permissions as $permission) {
                    $role->givePermissionTo(Permission::findOrfail($permission)->name);
                }
            }
            if($request->permissions == null){
                $role = Role::findOrfail($request->role_id);
                $role->syncPermissions();
            }
            return response()->json(['done'=>'200']);
        }
        
    }
}
