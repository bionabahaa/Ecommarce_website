<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ModelsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($model,$name)
    {
        $name = $name.'.xlsx';
        return Excel::download(new ModelsExport($model), $name);
    }
}
