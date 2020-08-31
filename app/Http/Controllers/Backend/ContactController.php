<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public $path = 'backend.pages.contacts.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = transWord('Contact Us');
        $pages = [
            [transWord('Contact Us'),'contacts']
        ];
        $contacts = Contact::all();
        return view($this->path.'index',compact('contacts','pages','title'));
    }
}
