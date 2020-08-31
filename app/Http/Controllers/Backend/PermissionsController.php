<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public $path = 'backend.pages.permissions.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Permissions');
        $pages = [
            [transWord('Permissions'),'permissions']
        ];
        $permissions = Permission::all();
        return view($this->path.'index',compact('permissions','pages','title'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if (Permission::where('name',$request->permission_name)->get()->count() == 0) {
                $permission = Permission::create(['name' => $request->permission_name]);
                $permissioncount = Permission::count();
                return response()->json(['done'=>'200','permission'=>$permission,'permissioncount'=>$permissioncount]);
            }else{
                return response()->json(['done'=>'500']);
            }
            
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::findOrfail($request->role_id);
            $permission->name = $request->permission_name;
            $permission->save();
            return response()->json(['done'=>'200']);
        }
    }

    public function destroy($id){
        $permission = Permission::findOrfail($id)->delete();
        return back()->with('success','');
    }
}
