<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        $credentials = $request->except(['_token']);

        $user = User::where('email',$request->email)->first();
        if (auth()->attempt($credentials)) {
            return redirect()->route('backend.main');
        }else{
            session()->flash('error-login', 'Invalid credentials');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $authCheck = Auth::check();
        if ($authCheck) {
            $logout = Auth::logout();

            return redirect(route('frontend'));
        }
    }
}
