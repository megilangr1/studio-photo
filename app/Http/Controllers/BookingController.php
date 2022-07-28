<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\KasBesar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::orderBy('tanggal_booking', 'DESC')->paginate(25);
        return view('backend.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $booking = Booking::with('addOn', 'hasilFoto')->where('id', '=', $id)->firstOrFail();

            return view('backend.booking.edit', compact('booking'));
        } catch (\Exception $e) {
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $booking = Booking::where('id', '=', $id)->firstOrFail();
            $booking->delete();

            session()->flash('warning', 'Data Reservasi di-Hapus !');
            return redirect(route('backend.booking.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function confirm($id)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::where('id', '=', $id)->firstOrFail();
            $updateBooking = $booking->update([
                'admin_id' => auth()->user()->id,
                'status_booking' => 1
            ]);

            $insertKas = KasBesar::create([
                'tanggal_data' => date('Y-m-d'),
                'transaction_id' => $booking->id,
                'jenis_data' => 1,
                'asal_uang' => 'DP Booking',
                'nominal' => $booking->nominal_dp,
                'keterangan' => null,
            ]);

            DB::commit();
            session()->flash('success', 'Status Booking / Reservasi di-Konfirmasi !');
            return redirect(route('backend.booking.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function reject($id)
    {
        try {
            $booking = Booking::where('id', '=', $id)->firstOrFail();
            $updateBooking = $booking->update([
                'admin_id' => auth()->user()->id,
                'status_booking' => 2
            ]);

            session()->flash('success', 'Status Booking / Reservasi di-Tolak !');
            return redirect(route('backend.booking.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
