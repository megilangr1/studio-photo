<?php

namespace App\Http\Livewire\PembelianProperti;

use App\Models\KategoriProperti;
use Livewire\Component;

class DataProperti extends Component
{
    public $dataProperti = [];
    public $kategori = [];

    public $param = [
        'nama_properti' => null,
        'kategori_id' => null,
        'jumlah' => 0,
        'harga' => 0,
        'keterangan' => null,
    ];

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
