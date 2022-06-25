<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function main()
    {
        return view('backend.main');
    }
}
