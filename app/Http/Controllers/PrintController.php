<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function dataBooking(Request $request)
    {
        set_time_limit(0);

        if ($request->date_start == null && $request->date_end == null) {
            abort(404);
        }

        $start = $request->date_start;
        $end = null;
        if ($request->date_end != null) {
            $end = $request->date_end;
        }

        try {
            $data = Booking::with('paket')->orderBy('tanggal_booking', 'ASC');

            if ($end != null) {
                $data->whereBetween('tanggal_booking', [$start, $end]);
            } else {
                $data->where('tanggal_booking', $start);
            }

            $data = $data->get()->toArray();
            $report = Pdf::loadview('backend.print.booking', [
                'data' => $data, 
                'start' => $start,
                'end' => $end,
            ]);

            return $report->stream('LaporanBooking.pdf');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
