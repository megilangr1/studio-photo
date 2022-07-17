<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
