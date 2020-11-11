<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function faturaGet(Request $request)
    {
        return view('import.importFatura');
    }
}
