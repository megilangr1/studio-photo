<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        // return view('auth.login');
        return view('frontend.login');
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

    public function register()
    {
        return view('frontend.register');
    }

    public function registration(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string', 
            'nomor_hp' => 'required|string', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|confirmed', 
        ]);

        DB::beginTransaction();
        try {
            $createUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $createPelanggan = Pelanggan::create([
                'user_id' => $createUser->id,
                'nama_lengkap' => $request->name,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => null,
            ]);
            DB::commit();

            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('frontend');
            }


        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput($request->all());
        }
    }
}
