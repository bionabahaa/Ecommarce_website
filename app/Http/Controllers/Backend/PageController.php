<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public $path = 'backend.pages.pages.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Pages');
        $pages = [
            [transWord('Pages'),'pages']
        ];
        $allpages = Page::all();
        return view($this->path.'index',compact('allpages','pages','title'));
    }

    public function create()
    {
        $title = transWord('Create New Page');
        $pages = [
            [transWord('Pages'),'pages'],
            [transWord('Create Page'),'create_pages']
        ];
        return view($this->path.'create',compact('pages','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:255',
            'slug' => 'required|unique:pages',
            'content' => 'required|max:255',
        ]);

        $page = new Page();
        $page->title = json_encode($request->title);
        $page->slug = json_encode($request->slug);
        $page->content = json_encode($request->content);
        $page->publish = $request->publish;        
        if(isset($request->meta_title))
            $page->meta_title = json_encode($request->meta_title);
        if(isset($request->meta_desc))
            $page->meta_desc = json_encode($request->meta_desc);
        if(isset($request->meta_keywords))
            $page->meta_keywords = json_encode($request->meta_keywords);
        $page->save();
        return redirect()->route('pages')->with('success','');
    }

    public function show($id)
    {
        $title = transWord('Show Page Data');
        $pagedata = Page::findOrfail($id);
        $pages = [
            [transWord('Pages'),'pages'],
            [getDataFromJsonByLanguage($pagedata->title),'']
        ];
        return view($this->path.'show',compact('pagedata','pages','title'));
    }

    public function edit($id)
    {
        $title = transWord('Edit Page Data');
        $pagedata = Page::findOrfail($id);
        $showUrl = route('show_pages', ['id'=>$pagedata->id]);
        $pages = [
            [transWord('Pages'),'pages'],
            [getDataFromJsonByLanguage($pagedata->title),['show_pages',$pagedata->id]]
        ];
        return view($this->path.'edit',compact('pagedata','pages','title'));
    }

    public function update($id,Request $request)
    {
        $page = Page::findOrfail($id);
        $request->validate([
            'title' => 'required|min:2|max:255',
            'slug' => 'required|unique:pages,slug,'.$page->id,
            'content' => 'required|max:255',
        ]);

        $page->title = json_encode($request->title);
        $page->slug = json_encode($request->slug);
        $page->content = json_encode($request->content);
        $page->publish = $request->publish;
        if(isset($request->meta_title))
            $page->meta_title = json_encode($request->meta_title);
        if(isset($request->meta_desc))
            $page->meta_desc = json_encode($request->meta_desc);
        if(isset($request->meta_keywords))
            $page->meta_keywords = json_encode($request->meta_keywords);
        $page->save();
        return redirect()->route('pages')->with('success','');
    }

    public function destroy($id)
    {
        $page = Page::findOrfail($id)->delete();
        return redirect()->route('pages')->with('success','');
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
