<?php

namespace App\Http\Livewire\Booking;

use App\Models\Booking;
use App\Models\Paket;
use Livewire\Component;

class MainForm extends Component
{
    public $jam = [];
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
    public $defaultJam = [
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
        $this->jam = $this->defaultJam;
        $booking = Booking::select('jam_mulai', 'durasi', 'jam_selesai')->where('tanggal_booking', '=', $date)->whereIn('status_bayar', ['1', '2'])->get();
        $reserved = [];

        // Booking
        if ($date == date('Y-m-d')) {
            $jamSekarang = date('H:i');
            $jamSekarang = explode(':', $jamSekarang);
            $jamS = (int) $jamSekarang[0];
            $menitS = (int) $jamSekarang[1];
    
            if ($menitS <= 30) {
                $jamSekarang = $jamS . ':30';
            } else if ($menitS > 30 && $menitS <= 60) {
                $jamSekarang = ($jamS + 1) . ':00';
            } else {
                $jamSekarang = $jamS . $menitS;
            }
            $jamSekarang = array_search($jamSekarang, $this->jam);
            $reserve = array_slice($this->jam, 0, ($jamSekarang - 0));
            $reserved = array_merge($reserved, $reserve);
        }

        if (count($booking) > 0) {
            $data = $booking->toArray();
            foreach ($data as $key => $value) {
                $jamMulai = array_search($value['jam_mulai'], $this->jam);
                $jamSelesai = explode(':', $value['jam_selesai']);
                $jam = (int) $jamSelesai[0];
                $menit = (int) $jamSelesai[1];

                if ($menit <= 30) {
                    $jamSelesai = $jam . ':30';
                } else if ($menit > 30 && $menit <= 60) {
                    $jamSelesai = ($jam + 1) . ':00';
                } else {
                    $jamSelesai = $jam . $menit;
                }

                $jamSelesai = array_search($jamSelesai, $this->jam);
                $reserve = array_slice($this->jam, $jamMulai, ($jamSelesai - $jamMulai) + 1);
                $reserved = array_merge($reserved, $reserve);
            }
        }
        foreach ($reserved as $key => $value) {
            $check = array_search($value, $this->jam);
            if ($check !== FALSE) {
                unset($this->jam[$check]);
            }
        }

        // dd($this->jam);
        $this->emit('refreshJam', $this->jam);
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
        if ($value != "") {
            $jamMulai = date("H:i", strtotime($value));
            $jamSelesai = date("H:i", strtotime("+".$this->paket['durasi'] ?? 0 .' minutes', strtotime($value)));
            dd($jamSelesai);
        }
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
