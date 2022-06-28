<?php

namespace App\Http\Livewire\Paket;

use App\Models\BiayaLainnya;
use App\Models\JumlahCetakan;
use App\Models\Paket;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $editPaket = [];

    public $paket = [];
    public $params = [
        'nama_paket' => null,
        'harga' => null,
        'jumlah_foto' => null,
        'durasi' => null,
        'jumlah_baju' => null,
        'pose' => null,
        'harga_tambah_foto' => null,
        'informasi_tambahan' => null,
        'keterangan_lainnya' => null,

        'jumlah_cetakan' => [],
        'biaya_lainnya' => [],
        'edit' => 0
    ];

    public function mount($paket = [])
    {
        $this->paket = $this->params;
        $this->editPaket = $paket;

        if ($paket != null) {
            $this->paket['edit'] = $paket['id'];
            $this->paket['nama_paket'] = $paket['nama_paket'];
            $this->paket['harga'] = $paket['harga'];
            $this->paket['jumlah_foto'] = $paket['jumlah_foto'];
            $this->paket['durasi'] = $paket['durasi'];
            $this->paket['jumlah_baju'] = $paket['jumlah_baju'];
            $this->paket['pose'] = $paket['pose'];
            $this->paket['harga_tambah_foto'] = $paket['harga_tambah_foto'];
            $this->paket['informasi_tambahan'] = $paket['informasi_tambahan'];
            $this->paket['keterangan_lainnya'] = $paket['keterangan_lainnya'];

            if (count($paket['jumlah_cetakan']) > 0) {
                foreach ($paket['jumlah_cetakan'] as $key => $value) {
                    array_push($this->paket['jumlah_cetakan'], [
                        'jumlah_cetakan' => $value['jumlah_cetakan'],
                        'ukuran_cetakan' => $value['ukuran_cetakan'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }

            if (count($paket['biaya_lainnya']) > 0) {
                foreach ($paket['biaya_lainnya'] as $key => $value) {
                    array_push($this->paket['biaya_lainnya'], [
                        'nama_biaya' => $value['nama_biaya'],
                        'nominal_biaya' => $value['nominal_biaya'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.paket.main-form');
    }

    public function tambahJumlahCetakan()
    {
        array_push($this->paket['jumlah_cetakan'], [
            'jumlah_cetakan' => null,
            'ukuran_cetakan' => null,
            'keterangan' => null,
        ]);
    }

    public function hapusJumlahCetakan($key)
    {
        if (isset($this->paket['jumlah_cetakan'][$key])) {
            unset($this->paket['jumlah_cetakan'][$key]);
        }
    }

    public function tambahBiayaLainnya()
    {
        array_push($this->paket['biaya_lainnya'], [
            'nama_biaya' => null,
            'nominal_biaya' => null,
            'keterangan' => null,
        ]);
    }
    
    public function hapusBiayaLainnya($key)
    {
        if (isset($this->paket['biaya_lainnya'][$key])) {
            unset($this->paket['biaya_lainnya'][$key]);
        }
    }

    public function buatData()
    {
        $this->validate([
            'paket.nama_paket' => 'required|string',
            'paket.harga' => 'required|numeric',
            'paket.jumlah_foto' => 'required|numeric',
            'paket.durasi' => 'required|numeric',
            'paket.jumlah_baju' => 'required|numeric',
            'paket.pose' => 'nullable|numeric',
            'paket.harga_tambah_foto' => 'required|numeric',
            'paket.informasi_tambahan' => 'nullable|string',
            'paket.keterangan_lainnya' => 'nullable|string',

            'paket.jumlah_cetakan' => 'nullable|array',
            'paket.jumlah_cetakan.*.jumlah_cetakan' => 'required|numeric',
            'paket.jumlah_cetakan.*.ukuran_cetakan' => 'required|string',
            'paket.jumlah_cetakan.*.keterangan' => 'nullable|string',
            
            'paket.biaya_lainnya' => 'nullable|array',
            'paket.biaya_lainnya.*.nama_biaya' => 'required|string',
            'paket.biaya_lainnya.*.nominal_biaya' => 'required|numeric',
            'paket.biaya_lainnya.*.keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try { 
            $createPaket = Paket::create([
                'nama_paket' => $this->paket['nama_paket'],
                'harga' => $this->paket['harga'],
                'jumlah_foto' => $this->paket['jumlah_foto'],
                'durasi' => $this->paket['durasi'],
                'jumlah_baju' => $this->paket['jumlah_baju'],
                'pose' => $this->paket['pose'],
                'harga_tambah_foto' => $this->paket['harga_tambah_foto'],
                'informasi_tambahan' => $this->paket['informasi_tambahan'],
                'keterangan_lainnya' => $this->paket['keterangan_lainnya'],
            ]);

            foreach ($this->paket['jumlah_cetakan'] as $key => $value) {
                if ($value['jumlah_cetakan'] != null && $value['ukuran_cetakan'] != null) {
                    $createJumlahCetakan = JumlahCetakan::create([
                        'paket_id' => $createPaket->id,
                        'jumlah_cetakan' => $value['jumlah_cetakan'],
                        'ukuran_cetakan' => $value['ukuran_cetakan'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }

            foreach ($this->paket['biaya_lainnya'] as $key => $value) {
                if ($value['nama_biaya'] != null && $value['nominal_biaya'] != null) {
                    $createBiayaLainnya = BiayaLainnya::create([
                        'paket_id' => $createPaket->id,
                        'nama_biaya' => $value['nama_biaya'],
                        'nominal_biaya' => $value['nominal_biaya'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Data Berhasil di-Buat !');

            return redirect(route('backend.paket.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    
    public function resetInput()
    {
        $this->mount($this->editPaket);
    }

    public function updateData()
    {
        $this->validate([
            'paket.nama_paket' => 'required|string',
            'paket.harga' => 'required|numeric',
            'paket.jumlah_foto' => 'required|numeric',
            'paket.durasi' => 'required|numeric',
            'paket.jumlah_baju' => 'required|numeric',
            'paket.pose' => 'nullable|numeric',
            'paket.harga_tambah_foto' => 'required|numeric',
            'paket.informasi_tambahan' => 'nullable|string',
            'paket.keterangan_lainnya' => 'nullable|string',

            'paket.jumlah_cetakan' => 'nullable|array',
            'paket.jumlah_cetakan.*.jumlah_cetakan' => 'required|numeric',
            'paket.jumlah_cetakan.*.ukuran_cetakan' => 'required|string',
            'paket.jumlah_cetakan.*.keterangan' => 'nullable|string',
            
            'paket.biaya_lainnya' => 'nullable|array',
            'paket.biaya_lainnya.*.nama_biaya' => 'required|string',
            'paket.biaya_lainnya.*.nominal_biaya' => 'required|numeric',
            'paket.biaya_lainnya.*.keterangan' => 'nullable|string',
        ]);

        
        DB::beginTransaction();

        try { 
            $getPaket = Paket::where('id', '=', $this->paket['edit'])->firstOrFail();

            $updatePaket = $getPaket->update([
                'nama_paket' => $this->paket['nama_paket'],
                'harga' => $this->paket['harga'],
                'jumlah_foto' => $this->paket['jumlah_foto'],
                'durasi' => $this->paket['durasi'],
                'jumlah_baju' => $this->paket['jumlah_baju'],
                'pose' => $this->paket['pose'],
                'harga_tambah_foto' => $this->paket['harga_tambah_foto'],
                'informasi_tambahan' => $this->paket['informasi_tambahan'],
                'keterangan_lainnya' => $this->paket['keterangan_lainnya'],
            ]);

            $deleteCetakan = $getPaket->jumlah_cetakan()->delete();
            foreach ($this->paket['jumlah_cetakan'] as $key => $value) {
                if ($value['jumlah_cetakan'] != null && $value['ukuran_cetakan'] != null) {
                    $createJumlahCetakan = JumlahCetakan::create([
                        'paket_id' => $getPaket->id,
                        'jumlah_cetakan' => $value['jumlah_cetakan'],
                        'ukuran_cetakan' => $value['ukuran_cetakan'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }

            $deleteBiaya = $getPaket->biaya_lainnya()->delete();
            foreach ($this->paket['biaya_lainnya'] as $key => $value) {
                if ($value['nama_biaya'] != null && $value['nominal_biaya'] != null) {
                    $createBiayaLainnya = BiayaLainnya::create([
                        'paket_id' => $getPaket->id,
                        'nama_biaya' => $value['nama_biaya'],
                        'nominal_biaya' => $value['nominal_biaya'],
                        'keterangan' => $value['keterangan'],
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Data Berhasil di-Buat !');

            return redirect(route('backend.paket.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
