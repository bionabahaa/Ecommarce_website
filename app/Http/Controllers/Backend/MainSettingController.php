<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSetting;
use File;

class MainSettingController extends Controller
{
    public $path = 'backend.pages.settings.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Main Settings');
        $pages = [
            [transWord('Main Settings'),'mainsettings']
        ];
        $settings = MainSetting::findOrfail(1);
        return view($this->path.'index',compact('settings','pages','title'));
    }

    public function save(Request $request)
    {
        // dd($request->soicalmedia);
        $logos = [];
        $title = json_encode($request->title);
        $content = json_encode($request->content);
        $mobile = ($request->mobile) ? $request->mobile :  null;
        $email = ($request->email) ? $request->email :  null;
        $address = ($request->address) ? $request->address :  null;
        $meta_title = ($request->meta_title) ? json_encode($request->meta_title) :  null;
        $meta_desc = ($request->meta_desc) ? json_encode($request->meta_desc) :  null;
        $meta_keywords = ($request->meta_keywords) ? json_encode($request->meta_keywords) :  null;
        $socialmedia = ($request->soicalmedia) ? json_encode($request->soicalmedia) :  null;

        
        $mainsettings = MainSetting::findOrfail(1);

        $pathImage = public_path().'/uploads/backend/settings/';
        File::makeDirectory($pathImage, $mode = 0777, true, true);
        
        if ($request->logo) {
            foreach ($request->logo as $key => $value) {
                $imageName = $key.'_logo.'.$value->getClientOriginalExtension();
                $value->move($pathImage, $imageName);
                $logos[$key] = $imageName;
            }
            $logo = json_encode($logos);
            $mainsettings->logo = $logo;
        }

        
        $mainsettings->title = $title;
        $mainsettings->content = $content;
        $mainsettings->mobile = $mobile;
        $mainsettings->email = $email;
        $mainsettings->address = $address;
        
        $mainsettings->meta_title = $meta_title;
        $mainsettings->meta_desc = $meta_desc;
        $mainsettings->meta_keywords = $meta_keywords;
        $mainsettings->socialmedia = $socialmedia;
        $mainsettings->save();

        return back()->with('success','');
    }
}
