<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\KasBesar;
use App\Models\PembelianProperti;
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

    public function dataKas(Request $request)
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
            $data = KasBesar::orderBy('tanggal_data', 'ASC');

            if ($end != null) {
                $data->whereBetween('tanggal_data', [$start, $end]);
            } else {
                $data->where('tanggal_data', $start);
            }

            $data = $data->get();

            $total = $data->sum('nominal');
            $data = $data->toArray();
            $report = Pdf::loadview('backend.print.kas', [
                'data' => $data, 
                'start' => $start,
                'end' => $end,
                'total' => $total,
            ]);

            return $report->stream('LaporanKas.pdf');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function dataPembelianProperti(Request $request)
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
            $data = PembelianProperti::with('detail', 'kas')->orderBy('tanggal_pembelian', 'ASC');

            if ($end != null) {
                $data->whereBetween('tanggal_pembelian', [$start, $end]);
            } else {
                $data->where('tanggal_pembelian', $start);
            }

            $data = $data->get();
            $total = 0;
            foreach ($data as $key => $value) {
                foreach ($value->detail as $key => $detail) {
                    $total = $total + ( (double) $detail->jumlah * (double) $detail->harga );
                }
            }

            $report = Pdf::loadview('backend.print.pembelian-properti', [
                'data' => $data, 
                'start' => $start,
                'end' => $end,
                'total' => $total,
            ]);

            return $report->stream('LaporanKas.pdf');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
