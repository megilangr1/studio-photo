<?php

namespace App\Http\Livewire\PembelianProperti;

use App\Models\KategoriProperti;
use Livewire\Component;

class DataProperti extends Component
{
    public $dataProperti = [];
    public $kategori = [];
    public $total = 0;

    public $param = [
        'nama_properti' => null,
        'kategori_id' => null,
        'jumlah' => 0,
        'harga' => 0,
        'keterangan' => null,
    ];

    public function updatedDataProperti($value, $key)
    {
        $this->sumTotal();
    }

    public function mount($old = [], $pembelian = [])
    {
        $this->getKategori();

        if ($old != null) {
            if (isset($old['nama_properti'])) {
                foreach ($old['nama_properti'] as $key => $value) {
                    $this->dataProperti[$key]['nama_properti'] = $value;
                    $this->dataProperti[$key]['kategori_id'] = $old['kategori_id'][$key] ?? null;
                    $this->dataProperti[$key]['jumlah'] = $old['jumlah'][$key] ?? 0;
                    $this->dataProperti[$key]['harga'] = $old['harga'][$key] ?? 0;
                    $this->dataProperti[$key]['keterangan'] = $old['keterangan_properti'][$key] ?? null;
                }
            }
        } else {
            if ($pembelian != null) {
                foreach ($pembelian as $key => $value) {
                    $this->dataProperti[$key]['nama_properti'] = $value['nama_properti'];
                    $this->dataProperti[$key]['kategori_id'] = $value['kategori_id'] ?? null;
                    $this->dataProperti[$key]['jumlah'] = $value['jumlah'] ?? 0;
                    $this->dataProperti[$key]['harga'] = $value['harga'] ?? 0;
                    $this->dataProperti[$key]['keterangan'] = $value['keterangan'] ?? null;
                }
            }
        }
        $this->sumTotal();
    }

    public function sumTotal()
    {
        $total = 0;
        foreach ($this->dataProperti as $key => $value) {
            $total = (double) $total + ( (double) $value['jumlah'] * (double) $value['harga'] ); 
        }

        $this->total = $total;
    }

    public function getKategori()
    {
        $kategori = KategoriProperti::get();
        $this->kategori = $kategori;
    }

    public function render()
    {
        return view('livewire.pembelian-properti.data-properti');
    }

    public function tambahProperti()
    {
        array_push($this->dataProperti, $this->param);
    }

    public function hapusProperti($key)
    {
        if (isset($this->dataProperti[$key])) {
            unset($this->dataProperti[$key]);
        }
    }
}
