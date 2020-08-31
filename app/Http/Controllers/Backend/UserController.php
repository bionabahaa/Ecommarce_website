<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use File;
use Hash;

class UserController extends Controller
{
    public $path = 'backend.pages.users.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Users');
        $pages = [
            [transWord('Users'),'users']
        ];
        $users = User::whereHas("roles", function($q){ $q->where("name","<>", "Admin"); })->get();
        return view($this->path.'index',compact('users','pages','title'));
    }

    public function create()
    {
        $title = transWord('Create New User');
        $pages = [
            [transWord('Users'),'users'],
            [transWord('Create New User'),'create_users']
        ];
        $roles = Role::all();
        return view($this->path.'create',compact('roles','pages','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $pathImage = public_path().'/uploads/backend/users/';
        File::makeDirectory($pathImage, $mode = 0777, true, true);

        if ($request->hasFile('avatar')){
            $imageName = time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->move($pathImage, $imageName);
            $user->avatar = $imageName;
        }else{
            $user->avatar = 'avatar.png';
        }
        $user->save();
        foreach ($request->roles as $role) {
            $roleName = Role::findOrfail($role);
            $user->assignRole($roleName->name);
        }
        return redirect()->route('users')->with('success','');
    }

    public function show($id)
    {
        $title =transWord('Show User Data');
        $user = User::findOrfail($id);
        $pages = [
            [transWord('Users'),'users'],
            [$user->name,'']
        ];
        return view($this->path.'show',compact('user','pages','title'));
    }

    public function edit($id)
    {
        $title =transWord('Edit User Data');
        $user = User::findOrfail($id);
        $showUrl = route('show_users', ['id'=>$user->id]);
        $pages = [
            [transWord('Users'),'users'],
            [$user->name,['show_users',$user->id]]
        ];
        $roles = Role::all();
        return view($this->path.'edit',compact('user','roles','pages','title'));
    }
    
    public function profile()
    {
        $title =transWord('Edit My Profile');
        $user = Auth::user();
        $pages = [
            [transWord('My Profile'),''],
        ];
        $roles = Role::all();
        return view($this->path.'profile',compact('user','roles','pages','title'));
    }

    public function update($id,Request $request)
    {
        $user = User::findOrfail($id);

        if ($request->password) {
            $request->validate([
                'name' => 'required|min:2|max:255',
                'email' => 'unique:users,email,'.$user->id,
                'password' => 'confirmed|min:6|max:255',
            ]);
        }else{
            $request->validate([
                'name' => 'required|min:2|max:255',
                'email' => 'unique:users,email,'.$user->id,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $pathImage = public_path().'/uploads/backend/users/';
        File::makeDirectory($pathImage, $mode = 0777, true, true);

        if ($request->hasFile('avatar')){
            if($user->avatar != 'avatar'){
                $image_path = public_path($user->avatar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->move($pathImage, $imageName);
            $user->avatar = $imageName;
        }

        $user->save();

        if (isset($request->roles)) {
            foreach ($request->roles as $role) {
                $roleName = Role::findOrfail($role);
                $user->syncRoles($roleName->name);
            }
        }
        
        return redirect()->route('users')->with('success','');
    }

    public function destroy($id)
    {
        $user = User::findOrfail($id);
        if($user->avatar != 'avatar'){
            $image_path = public_path($user->avatar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $user->delete();
        return redirect()->route('users')->with('success','');
    }
}
