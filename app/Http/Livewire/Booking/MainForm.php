<?php

namespace App\Http\Livewire\Booking;

use App\Models\Booking;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $mode = 'backend';
    public $jam = [];
    public $dataPaket = [];

    public $pemesanan = [];
    public $paket = [];

    public $reservedJam = [];

    public $params = [
        'nama_pemesan' => null,
        'tanggal_booking' => null,
        'jam_mulai' => null,
        'jam_selesai' => null,
        'id_paket' => null,
        'jumlah_orang' => null,
        'nominal_booking' => null,
        'rekening_transfer' => null,
        'nominal_dp' => null,
        'status_bayar' => null,
        'file_bukti_pembayaran' => null,
        'file_path' => null,

        'user_id' => null,
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

    public $selectPaket = null;

    protected $listeners = [
        'setJam',
        'setPaket',
        'selectPelanggan',
    ];

    public function mount($mode = "", $paket = null)
    {
        $this->mode = $mode;
        $this->pemesanan = $this->params;

        if ($mode == 'frontend') {
            $this->pemesanan['nama_pemesan'] = Auth::user()->name;
        }

        $this->getPaket();

        if ($paket != null) {
            $check = Paket::where('id', '=', $paket)->first();
            if ($check != null) {
                $this->selectPaket = $check->id;
            }
        }
    }

    public function selectPelanggan($data)
    {
        $this->pelanggan = $data;
        $this->pemesanan['nama_pemesan'] = $data['nama_lengkap'];
        $this->pemesanan['user_id'] = $data['user_id'];
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
            $durasi = $this->paket['durasi'] ?? 0;
            // $jamSelesai = date("H:i", strtotime("+".$this->paket['durasi'] ?? 0 .' minutes', strtotime($value)));
            if ($durasi == 0) {
                $jamSelesai = $value;
            } else {
                $jamSelesai = date("H:i", strtotime($value . "+" . $durasi . " minutes"));
            }

            $this->pemesanan['jam_mulai'] = $value;
            $this->pemesanan['jam_selesai'] = $jamSelesai;
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

            $this->pemesanan['id_paket'] = $this->paket['id'];
            $this->pemesanan['nominal_booking'] = $this->paket['harga'] ?? 0;

            if ($this->pemesanan['jam_mulai'] != null) {
                $jamSelesai = date("H:i", strtotime($this->pemesanan['jam_mulai'] . "+" . $this->paket['durasi'] . " minutes"));
                $this->pemesanan['jam_selesai'] = $jamSelesai;
            }
        }
    }

    public function tambahData()
    {
        $this->validate([
            'pemesanan.nama_pemesan' => 'required|string',
            'pemesanan.tanggal_booking' => 'required|date',
            'pemesanan.jam_mulai' => 'required|string',
            'pemesanan.jam_selesai' => 'required|string',
            'pemesanan.id_paket' => 'required|numeric|exists:pakets,id',
            'pemesanan.jumlah_orang' => 'required|string',
            'pemesanan.nominal_booking' => 'required|numeric',
            'pemesanan.rekening_transfer' => 'nullable|string',
            'pemesanan.nominal_dp' => 'nullable|string',
            'pemesanan.status_bayar' => 'nullable|string',
            'pemesanan.file_bukti_pembayaran' => 'nullable|string',
            'pemesanan.file_path' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $adminId = null;
            $userId = null;
            $status_booking = 0;
            
            if ($this->mode == 'backend') {
                $adminId = Auth::user()->id;
                $status_booking = 1;
                if ($this->pemesanan['user_id'] != null) {
                    $userId = $this->pemesanan['user_id'];
                }
            } else {
                $userId = Auth::user()->id;
            }

            $booking = Booking::create([
                'kode_booking' => "ASF-".time() . rand(100, 999),
                'admin_id' => $adminId,
                'user_id' => $userId,
                'nama_pemesan' => $this->pemesanan['nama_pemesan'],
                'id_paket' => $this->pemesanan['id_paket'],
                'durasi' => $this->paket['durasi'],
                'tanggal_booking' => $this->pemesanan['tanggal_booking'],
                'jam_mulai' => $this->pemesanan['jam_mulai'],
                'jam_selesai' => $this->pemesanan['jam_selesai'],
                'jumlah_orang' => $this->pemesanan['jumlah_orang'],
                'nominal_booking' => $this->pemesanan['nominal_booking'],
                'rekening_transfer' => null,
                'nominal_dp' => null,
                'total_pembayaran' => $this->pemesanan['nominal_booking'],
                'status_bayar' => 0,
                'status_booking' => $status_booking,
                'file_bukti_pembayaran' => null,
                'file_path' => null,
            ]);

            DB::commit();
            session()->flash('success', 'Data Booking / Reservasi di-Buat !');

            if ($this->mode == 'frontend') {
                // return redirect()->route('data-booking');
                return redirect(route('cara-bayar', $booking->kode_booking));
            } else {
                return redirect()->route('backend.booking.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        dd($this->pemesanan);
    }
    
    public function dummy()
    {
        dd($this->pemesanan);
    }
}
