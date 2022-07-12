<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function frontEnd()
    {
        $pakets = Paket::orderBy('created_at', 'ASC')->get();
        return view('frontend.main', compact('pakets'));
    }
}
