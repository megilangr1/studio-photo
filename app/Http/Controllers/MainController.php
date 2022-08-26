<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Booking;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function frontEnd()
    {
        $pakets = Paket::orderBy('created_at', 'ASC')->get();
        return view('frontend.main', compact('pakets'));
    }

    public function booking()
    {
        return view('frontend.booking');
    }

    public function dataBooking()
    {
        $booking = Booking::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        return view('frontend.data-booking', compact('booking'));
    }

    public function cancelBooking(Request $request, $id)
    {
        try {
            $booking = Booking::where('user_id', '=', auth()->user()->id)->where('id', '=', $id)->firstOrFail();

            $updateBooking = $booking->update([
                'status_booking' => 2
            ]);

            return redirect(route('data-booking'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function uploadPembayaran(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:bookings,id',
            'nominal' => 'required|numeric',
            'file' => 'required|image|mimes:jpg,png,jpeg|max:5120'
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->firstOrFail();
            
            $storage_disk_file = 'images';
            // File Pembayaran
            $nama_file = $booking->kode_booking;
            $file_bukti_pembayaran = $nama_file . '-'. time() . '.' . $request->file->getClientOriginalExtension();
            $storage_path_file_paket = $storage_disk_file .'/' . $file_bukti_pembayaran;

            $updateBooking = $booking->update([
                'nominal_dp' => $request->nominal,
                'status_bayar' => 1,
                'file_bukti_pembayaran' => $file_bukti_pembayaran,
                'file_path' => $storage_path_file_paket,
            ]);

            $uploadBuktiBayar = $request->file->storeAs('/', $file_bukti_pembayaran, $storage_disk_file);

            DB::commit();
            session()->flash('success', 'File Bukti Pembayaran Berhasil di-Kirim ! <br>Silahkan Tunggu / Hubungi Admin untuk mempercepat proses !');
            return redirect(route('data-booking'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi Kesalahan Saat Mengupload File Bukti Pembayaran !');
            return redirect()->back();
        }
    }

    public function hasilBooking($kode)
    {
        $booking = Booking::with('hasilFoto')->where('user_id', '=', auth()->user()->id)->where('kode_booking', '=', $kode)->first();
        if ($booking != null) {
            return view('frontend.hasil-foto', compact('booking'));
        } else {
            return redirect(route('data-booking'));
        }
    }

    public function verifyEmail($token)
    {
        try {
            $user = User::where('remember_token', '=', $token)->firstOrFail();
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s'),
                'remember_token' => null,
            ]);

            session()->flash('verified', 'OK');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect(route('frontend'));
        }
    }

    public function resend(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->email_verified_at == null) {
                try {
                    $user = User::with('pelanggan')->where('id', '=', Auth::user()->id)->firstOrFail();
                    $user = $user->toArray();
                    $email = $user['email'];
                    $token = $user['remember_token'];
                    if ($token == null) {
                        $token = md5($email);
                        $updateUser = User::where('id', '=', Auth::user()->id)->update([
                            'remember_token' => $token
                        ]);
                    }
                    $data = [
                        'title' => 'Selamat datang!',
                        'url' => env('APP_URL') . '/verify-email/' . $token,
                        'token' => $token,
                        'user' => $user,
                        'pelanggan' => $user['pelanggan'],
                    ];
                    Mail::to($email)->send(new VerifyEmail($data));
    
                    session()->flash('resend-verify', 'OK');
                    return redirect(route('frontend'));
                } catch (\Exception $e) {
                    return redirect(route('frontend'));
                }
            }
        }
    }
    
    public function paket(Paket $paket)
    {
        return view('frontend.paket', compact('paket'));
    }

    public function faq()
    {
        return view('frontend.faq');
    }
}
