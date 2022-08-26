<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('login', 'logout');
    }

    public function login()
    {
        if (Auth::check()) {
            $user = User::where('id', '=', Auth::user()->id)->first();
            if ($user != null) {
                $checkRoles = $user->getRoleNames()->toArray();
                if (in_array('Owner', $checkRoles) || in_array('Administrator', $checkRoles) || in_array('Photography', $checkRoles)) {
                    return redirect()->route('backend.main');
                } else {
                    return redirect(route('frontend'));
                }
            }
        }

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

        $user = User::with('pelanggan')->where('email',$request->email)->first();
        if ($user->pelanggan != null) {
            if ($user->pelanggan->deleted_at != null) {
                session()->flash('error-login', 'Invalid credentials');
                return redirect()->back();
            }
        }

        if (auth()->attempt($credentials)) {
            $checkRoles = $user->getRoleNames()->toArray();
            if (in_array('Owner', $checkRoles) || in_array('Administrator', $checkRoles) || in_array('Photography', $checkRoles)) {
                return redirect()->route('backend.main');
            } else {
                return redirect(route('frontend'));
            }
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
            $token = md5($request->email);
            $createUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => $token,
            ]);

            $createPelanggan = Pelanggan::create([
                'user_id' => $createUser->id,
                'nama_lengkap' => $request->name,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => null,
            ]);

            $createUser->assignRole(3);
            DB::commit();

            $email = $request->email;
            $data = [
                'title' => 'Selamat datang!',
                'url' => env('APP_URL') . '/verify-email/' . $token,
                'token' => $token,
                'user' => $createUser->toArray(),
                'pelanggan' => $createPelanggan->toArray(),
            ];
            Mail::to($email)->send(new VerifyEmail($data));

            session()->flash('must-verify', 'OK');
            return redirect(route('login'));

            // if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            //     return redirect()->route('frontend');
            // }

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput($request->all());
        }
    }
}
