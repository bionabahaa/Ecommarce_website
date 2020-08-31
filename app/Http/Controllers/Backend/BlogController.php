<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public $path = 'backend.pages.blogs.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Blogs');
        $pages = [
            [transWord('Blogs'),'blogs']
        ];
        $blogs = Blog::all();
        return view($this->path.'index',compact('blogs','pages','title'));
    }

    public function create()
    {
        $title = transWord('Create New Blog');
        $pages = [
            [transWord('Blogs'),'blogs'],
            [transWord('Create Blog'),'create_blogs']
        ];
        return view($this->path.'create',compact('pages','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:255',
            'tags' => 'required',
            'content' => 'required|max:255',
        ]);

        $blog = new Blog();
        $blog->title = json_encode($request->title);
        $blog->tags = json_encode($request->tags);
        $blog->content = json_encode($request->content);
        $blog->publish = $request->publish;        
        if(isset($request->meta_title))
            $blog->meta_title = json_encode($request->meta_title);
        if(isset($request->meta_desc))
            $blog->meta_desc = json_encode($request->meta_desc);
        if(isset($request->meta_keywords))
            $blog->meta_keywords = json_encode($request->meta_keywords);
        $blog->save();
        return redirect()->route('blogs')->with('success','');
    }

    public function show($id)
    {
        $title = transWord('Show Blog Data');
        $blog = Blog::findOrfail($id);
        $pages = [
            [transWord('Blogs'),'blogs'],
            [getDataFromJsonByLanguage($blog->title),'']
        ];
        return view($this->path.'show',compact('blog','pages','title'));
    }

    public function edit($id)
    {
        $title = transWord('Edit Blog Data');
        $blog = Blog::findOrfail($id);
        $showUrl = route('show_blogs', ['id'=>$blog->id]);
        $pages = [
            [transWord('Blogs'),'blogs'],
            [getDataFromJsonByLanguage($blog->title),['show_blogs',$blog->id]]
        ];
        return view($this->path.'edit',compact('blog','pages','title'));
    }

    public function update($id,Request $request)
    {
        $blog = Blog::findOrfail($id);
        $request->validate([
            'title' => 'required|min:2|max:255',
            'tags' => 'required',
            'content' => 'required|max:255',
        ]);

        $blog->title = json_encode($request->title);
        $blog->tags = json_encode($request->tags);
        $blog->content = json_encode($request->content);
        $blog->publish = $request->publish;
        if(isset($request->meta_title))
            $blog->meta_title = json_encode($request->meta_title);
        if(isset($request->meta_desc))
            $blog->meta_desc = json_encode($request->meta_desc);
        if(isset($request->meta_keywords))
            $blog->meta_keywords = json_encode($request->meta_keywords);
        $blog->save();
        return redirect()->route('blogs')->with('success','');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrfail($id)->delete();
        return redirect()->route('blogs')->with('success','');
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
