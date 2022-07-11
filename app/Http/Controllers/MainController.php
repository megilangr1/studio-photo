<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function frontEnd()
    {
        return view('frontend.main');
    }
}
