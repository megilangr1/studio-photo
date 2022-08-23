<?php

namespace App\Http\Livewire\Booking;

use App\Models\AddOnBooking;
use App\Models\Booking;
use App\Models\HasilFoto;
use App\Models\KasBesar;
use App\Models\Paket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailForm extends Component
{
    use WithFileUploads;

    public $mode = 'backend';
    public $booking = [];
    public $jam = [];
    public $dataPaket = [];

    public $pemesanan = [];
    public $paket = [];
    public $biayaLainnya = [];

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
        'tambah_foto' => null,
        'harga_paket_tambah_foto' => null,
        'harga_akhir_tambah_foto' => null,
        'total_pembayaran' => null,
        'status_bayar' => null,
        'status_booking' => null,
        'file_bukti_pembayaran' => null,
        'file_path' => null,
        'gdrive_link' => null,

        'file_bukti_pembayaran_now' => null,
        'file_path_now' => null,
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

    public $gdrive = null;

    public $addOn = [];

    public $upload_hasil_foto = null; 
    public $hasilFoto = [];

    protected $listeners = [
        'setJam',
        'setPaket',
        'setVal',
    ];

    public function mount($mode = "", $booking = [])
    {
        $this->mode = $mode;
        $this->pemesanan = $this->params;

        if ($booking != null) {
            $this->booking = $booking;

            $this->pemesanan['nama_pemesan'] = $booking['nama_pemesan'];
            $this->pemesanan['tanggal_booking'] = $booking['tanggal_booking'];
            $this->pemesanan['jam_mulai'] = $booking['jam_mulai'];
            $this->pemesanan['jam_selesai'] = $booking['jam_selesai'];
            $this->pemesanan['id_paket'] = $booking['id_paket'];
            $this->pemesanan['jumlah_orang'] = $booking['jumlah_orang'];
            $this->pemesanan['nominal_booking'] = $booking['nominal_booking'];
            $this->pemesanan['rekening_transfer'] = $booking['rekening_transfer'];
            $this->pemesanan['nominal_dp'] = $booking['nominal_dp'];

            $this->pemesanan['tambah_foto'] = $booking['tambah_foto'];
            $this->pemesanan['harga_paket_tambah_foto'] = $booking['harga_paket_tambah_foto'];
            $this->pemesanan['harga_akhir_tambah_foto'] = $booking['harga_akhir_tambah_foto'];
            $this->pemesanan['total_pembayaran'] = $booking['total_pembayaran'];
            $this->pemesanan['status_bayar'] = $booking['status_bayar'];
            $this->pemesanan['status_booking'] = $booking['status_booking'];
            $this->pemesanan['file_bukti_pembayaran_now'] = $booking['file_bukti_pembayaran'];
            $this->pemesanan['file_path_now'] = $booking['file_path'];
            
            $this->pemesanan['gdrive_link'] = $booking['gdrive_link'];
            $this->gdrive = $booking['gdrive_link'];

            array_push($this->jam, $booking['jam_mulai']);
            if (isset($booking['add_on']) && $booking['add_on'] != null) {
                foreach ($booking['add_on'] as $key => $value) {
                    $this->addOn[$value['id_biaya_lainnya']] = true;
                }
            }

            foreach ($booking['hasil_foto'] as $key => $value) {
                $this->hasilFoto[$value['id']] = $value; 
            }
        }

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

        if ($key == 'tambah_foto') {
            $this->pemesanan['harga_akhir_tambah_foto'] = (double) $value * (double) $this->pemesanan['harga_paket_tambah_foto'];
        }

        $this->updateTotal();
    }

    public function updateTotal()
    {
        $totalAddOn = 0;

        foreach ($this->addOn as $key => $value) {
            if ($value == true) {
                if (isset($this->biayaLainnya[$key])) {
                    $totalAddOn += (double) $this->biayaLainnya[$key]['nominal_biaya'];
                }
            }
        }

        $total = (double) $this->pemesanan['nominal_booking'] + (double) $this->pemesanan['harga_akhir_tambah_foto'] + (double) $totalAddOn;
        $this->pemesanan['total_pembayaran'] = $total;
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
        return view('livewire.booking.detail-form');
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
        $getPaket = Paket::with('biaya_lainnya')->where('id', '=', $value)->first();
        if ($getPaket == null) {
            $this->getPaket();
            $this->emit('error', 'Paket Tidak Dapat di-Pilih !');
        } else {
            $this->paket = $getPaket->toArray();
            $this->reset('biayaLainnya');
            foreach ($getPaket->biaya_lainnya->toArray() as $key => $value) {
                $this->biayaLainnya[$value['id']] = $value;
            }
            $this->pemesanan['id_paket'] = $this->paket['id'];
            $this->pemesanan['nominal_booking'] = $this->paket['harga'] ?? 0;
            $this->pemesanan['harga_paket_tambah_foto'] = $this->paket['harga_tambah_foto'] ?? 0;

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
            'pemesanan.jumlah_orang' => 'required|numeric',
            'pemesanan.nominal_booking' => 'required|numeric',
            'pemesanan.rekening_transfer' => 'nullable|string',
            'pemesanan.nominal_dp' => 'nullable|numeric',
            'pemesanan.status_bayar' => 'nullable|numeric',
            'pemesanan.file_bukti_pembayaran' => 'nullable|image',
            'pemesanan.file_path' => 'nullable|string',
        ]);
        DB::beginTransaction();

        try {
            $booking = Booking::where('id', '=', $this->booking['id'])->first();
            $adminId = null;
            $userId = $booking->user_id;
            
            if ($this->mode == 'backend') {
                $adminId = Auth::user()->id;
            }

            $storage_disk_file = 'images';
            // File Pembayaran
            $uploadBuktiBayar = 0;
            $file_bukti_pembayaran = $booking->file_bukti_pembayaran;
            $storage_path_file_paket = $booking->file_path;
            if ($this->pemesanan['file_bukti_pembayaran'] != null) {
                $nama_file = $booking->kode_booking;

                $file_bukti_pembayaran = $nama_file . '-'. time() . '.' . $this->pemesanan['file_bukti_pembayaran']->getClientOriginalExtension();
                $storage_path_file_paket = $storage_disk_file .'/' . $file_bukti_pembayaran;
                $uploadBuktiBayar = 1;
            }

            $addOnBooking = [];
            foreach ($this->addOn as $key => $value) {
                if ($value == true) {
                    $addOnData = [
                        'id_booking' => $booking->id,
                        'id_paket' => $this->biayaLainnya[$key]['paket_id'],
                        'id_biaya_lainnya' => $this->biayaLainnya[$key]['id'],
                        'nama_biaya' => $this->biayaLainnya[$key]['nama_biaya'],
                        'nominal_biaya' => $this->biayaLainnya[$key]['nominal_biaya'],
                    ];

                    array_push($addOnBooking, $addOnData);
                }
            }

            $updateBooking = $booking->update([
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
                'rekening_transfer' => $this->pemesanan['rekening_transfer'],
                'nominal_dp' => $this->pemesanan['nominal_dp'],
                'tambah_foto' => $this->pemesanan['tambah_foto'],
                "harga_paket_tambah_foto" => $this->pemesanan['harga_paket_tambah_foto'],
                "harga_akhir_tambah_foto" => $this->pemesanan['harga_akhir_tambah_foto'],
                "total_pembayaran" => $this->pemesanan['total_pembayaran'],
                "status_bayar" => $this->pemesanan['status_bayar'],
                "status_booking" => $this->pemesanan['status_booking'],
                'file_bukti_pembayaran' => $file_bukti_pembayaran ?? null,
                'file_path' => $storage_path_file_paket ?? null,
            ]);

            $deleteAddOn = $booking->addOn()->delete();
            $biayaLainnya = AddOnBooking::insert($addOnBooking); 
            if ($booking->status_bayar == 2) {
                $nominalKas = $booking->total_pembayaran;
                $checkKasBooking = KasBesar::where('transaction_id', '=', $booking->id)->where('asal_uang', 'DP Booking')->first();
                if ($checkKasBooking != null) {
                    $nominalKas = $booking->total_pembayaran - $booking->nominal_dp;  
                }

                $createNew = 1;
                $checkKasBooking = KasBesar::where('transaction_id', '=', $booking->id)->where('asal_uang', 'Pembayaran Lunas')->first();
                if ($checkKasBooking != null) {
                    if ($checkKasBooking->nominal != $nominalKas) {
                        $deleteKas = $checkKasBooking->delete();
                        $createNew = 1;
                    } else {
                        $createNew = 0;
                    }
                }

                if ($createNew) {
                    $insertKas = KasBesar::create([
                        'tanggal_data' => date('Y-m-d', strtotime($booking->tanggal_booking)),
                        'transaction_id' => $booking->id,
                        'jenis_data' => 1,
                        'asal_uang' => 'Pembayaran Lunas',
                        'nominal' => $nominalKas,
                        'keterangan' => null,
                    ]);
                }
            }

            if ($uploadBuktiBayar) { $uploadBuktiBayar = $this->pemesanan['file_bukti_pembayaran']->storeAs('/', $file_bukti_pembayaran, $storage_disk_file); }

            DB::commit();

            session()->flash('info', 'Data Booking / Reservasi di-Ubah !');
            return redirect()->route('backend.booking.edit', $booking->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    
    public function setVal()
    {
        $this->emit('setJamVal', $this->booking['jam_mulai']);
        $this->emit('setPaketVal', $this->booking['id_paket']);
    }
    
    public function resetFile()
    {
        if (isset($this->pemesanan['file_bukti_pembayaran'])) {
            $this->pemesanan['file_bukti_pembayaran'] = null;
        }
    }

    public function tambahBiaya($id)
    {
        $this->addOn[$id] = true;
        $this->updateTotal();
    }

    public function batalkanBiaya($id)
    {
        if (isset($this->addOn[$id])) {
            $this->addOn[$id] = false;
            $this->updateTotal();
        }
    }

    public function uploadHasil()
    {
        $this->validate([
            'upload_hasil_foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        DB::beginTransaction();

        try {
            $storage_disk_file = 'images';
            $nama_file = $this->booking['kode_booking'];
            $file_bukti_pembayaran = $nama_file . '-'. rand(100, 999) . '.' . $this->upload_hasil_foto->getClientOriginalExtension();
            $storage_path_file_paket = $storage_disk_file .'/'. $file_bukti_pembayaran;

            $hasilFoto = HasilFoto::create([
                'id_booking' => $this->booking['id'],
                'nama_file' => $nama_file,
                'file_path' => $storage_path_file_paket,
            ]);

            $uploadHasil = $this->upload_hasil_foto->storeAs('/', $file_bukti_pembayaran, $storage_disk_file);
            $this->reset('upload_hasil_foto');
            $this->refreshFoto();

            DB::commit();
            $this->emit('success', 'File di-Upload !');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan !');
        }
    }

    public function refreshFoto()
    {
        $this->reset('hasilFoto');
        $getFoto = HasilFoto::where('id_booking', '=', $this->booking['id'])->get()->toArray();
        foreach ($getFoto as $key => $value) {
            $this->hasilFoto[$value['id']] = $value; 
        }
    }

    public function deleteFoto($id)
    {
        $foto = HasilFoto::where('id_booking', '=', $this->booking['id'])->where('id', '=', $id)->first();
        if ($foto != null) {
            $checkExists = File::exists(public_path($foto->file_path));
            $deleteFoto = $foto->delete();
            if ($checkExists) {
                $delete = File::delete(public_path($foto->file_path));
            }
        }

        $this->refreshFoto();
    }

    public function updateLink()
    {
        try {
            $booking = Booking::where('id', '=', $this->booking['id'])->first();

            $update = $booking->update([
                'gdrive_link' => $this->gdrive
            ]);

            $this->pemesanan['gdrive_link'] = $this->gdrive;
            $this->emit('info', 'Link Google Drive telah di-Ubah !');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function dummy()
    {
        $this->upload_hasil_foto = null;
    }
}
