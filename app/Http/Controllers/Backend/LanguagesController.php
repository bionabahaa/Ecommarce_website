<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LanguageTranslate;

class LanguagesController extends Controller
{
    public $path = 'backend.pages.langs.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Languages');
        $lang = \Lang::getLocale();
        $pages = [
            [transWord('Languages'),'langs'],
            [$lang,'langs'],
        ];
        $langs = LanguageTranslate::where('key',$lang)->get();
        return view($this->path.'index',compact('langs','pages','title'));
    }

    public function save(Request $request)
    {
        $lang = \Lang::getLocale();
        if (isset($request->trans)) {
            for ($i=0; $i < count($request->trans); $i++) { 
                $trans = LanguageTranslate::where('id',$request->ids[$i])->where('key',$lang)->get()->first();
                $trans->translation = $request->trans[$i];
                $trans->save();
            }
        }
        return back()->with('success','');
    }

    public function addNew(Request $request)
    {
        $lang = \Lang::getLocale();
        $trans = new LanguageTranslate();
        $trans->key = $lang;
        $trans->word = $request->word;
        $trans->translation = $request->translation;
        $trans->save();
        return back()->with('success','');
    }
}
