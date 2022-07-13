<?php

namespace App\Http\Livewire\Booking;

use App\Models\Booking;
use App\Models\Paket;
use Livewire\Component;

class MainForm extends Component
{
    public $jam = [
        "10:00",
        "10:30",
        "11:00",
        "11:30",
        "12:00",
        "12:30",
        "13:00",
        "13:30",
        "14:00",
        "14:30",
        "15:00",
        "15:30",
        "16:00",
        "16:30",
        "17:00",
        "17:30",
        "18:00",
        "18:30",
        "19:00",
        "19:30",
        "20:00",
        "20:30",
    ];
    public $dataPaket = [];

    public $pemesanan = [];
    public $paket = [];

    public $reservedJam = [];

    public $params = [
        'nama_pemesan',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'id_paket',
        'id_studio',
        'jumlah_orang',
        'nominal_booking',
        'rekening_transfer',
        'nominal_dp',
        'status_bayar',
        'file_bukti_pembayaran',
        'file_path'
    ];

    protected $listeners = [
        'setJam',
        'setPaket',
    ];

    public function mount()
    {
        $this->pemesanan = $this->params;
        $this->getPaket();
    }

    public function updatedPemesanan($value, $key)
    {
        if ($key == 'tanggal_booking') {
            $this->paket['jam_mulai'] = null;
            $this->paket['jam_selesai'] = null;
            $this->emit('resetJam');

            $this->getFreeTime($value);
        }
    }

    public function getFreeTime($date)
    {
        $booking = Booking::select('jam_mulai', 'durasi', 'jam_selesai')->where('tanggal_booking', '=', $date)->get();
        if (count($booking) > 0) {
            $reserved = [];

            foreach ($booking as $key => $value) {
                $detail = $value->toArray();
                $jam = explode(":", $detail['jam_mulai']);
                array_push($reserved, $detail['jam_mulai']);

                // $durasi = (double) $detail['durasi'] / 60;
                $durasi = 45 / 60;
                dd([$durasi, $durasi * 60]);

                switch ($durasi) {
                    case $durasi <= 30:
                        $res = $jam[0] . ':30';
                        array_push($reserved, $res);
                        break;
                    case $durasi > 30 && $durasi < 60:

                        break;
                    default:

                        break;
                }
            }
            dd($booking->toArray());

            $this->reservedJam = $booking->toArray();
        }
    }

    public function getPaket()
    {
        $dataPaket = Paket::get()->toArray();
        $this->dataPaket = $dataPaket;
    }

    public function render()
    {
        return view('livewire.booking.main-form');
    }

    public function setJam($value)
    {
        // dd($value);
    }

    public function setPaket($value)
    {
        $getPaket = Paket::where('id', '=', $value)->first();
        if ($getPaket == null) {
            $this->getPaket();
            $this->emit('error', 'Paket Tidak Dapat di-Pilih !');
        } else {
            $this->paket = $getPaket->toArray();
        }
    }
}
