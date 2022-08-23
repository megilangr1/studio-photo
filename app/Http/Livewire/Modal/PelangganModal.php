<?php

namespace App\Http\Livewire\Modal;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PelangganModal extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pelanggan = [];
    public $pelangganData = [];
    public $search_data = null;

    protected $listeners = [
        'select-pelanggan' => 'selectPelanggan',
        'getMainPelanggan'
    ];

    public function updatingSearchData()
    {
        $this->resetPage();
    }

    public function mount($old = [])
    {
        $this->old = $old;
    }


    public function getMainPelanggan()
    {
        $this->reset('search_data');
        $this->resetPage();
    }

    public function render()
    {
        $getData = Pelanggan::select(DB::raw('pelanggans.*, users.email'))->join('users', 'users.id', '=', 'pelanggans.user_id')
            ->where('nama_lengkap', 'like', '%'. $this->search_data .'%')
            ->orWhere('email', 'like', '%'. $this->search_data .'%')
            ->orWhere('nomor_hp', 'like', '%'. $this->search_data .'%')
            ->orderBy('pelanggans.id', 'ASC')
            ->paginate('5');   

        $x = json_decode(json_encode($getData), true);
        if (count($x['data']) > 0) {
            foreach ($x['data'] as $key => $value) {
                $this->pelangganData[$value['id']] = $value;
            }
        }

        return view('livewire.modal.pelanggan-modal', [
            'dataPelanggan' => $getData,
        ]);
    }

    public function selectPelanggan($id)
    {
        if (isset($this->pelangganData[$id])) {
            $this->emit('close-modal-skpd');
            $this->emitUp('selectPelanggan', $this->pelangganData[$id]);
        } else {
            $this->emit('error', 'Terjadi Kesalahan ! <br>Silahkan Refresh Ulang Halaman !');
        }
    }
} 