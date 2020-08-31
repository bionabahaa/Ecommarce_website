<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Home');
        $pages = [];
        $components = [
            [10,'A','briefcase','azura'],
            [10,'B','users','red'],
            [10,'C','credit-card',''],
            [10,'D','life-ring',''],
        ];
        return view('backend.index',compact('components','pages','title'));
    }
}
