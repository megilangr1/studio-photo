<?php

namespace App\Http\Controllers;

use App\Helper\MainHelper;
use App\Models\KategoriProperti;
use App\Models\PropertiFoto;
use App\Models\Studio;
use Illuminate\Http\Request;

class PropertiController extends Controller
{
    public function index()
    {
        $propertis = PropertiFoto::paginate(5);
        return view('backend.properti.index', [
            'propertis' => $propertis
        ]);
    }

    public function create()
    {
        $studio = Studio::get();
        $kategori = KategoriProperti::get();
        return view('backend.properti.create', compact('studio', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "studio_id" => 'required|exists:studios,id',
            "kategori_id" => 'required|exists:kategori_propertis,id',
            "nama_properti" => 'required|string',
            "tanggal_masuk" => 'required|string',
            "kondisi" => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $helper = new MainHelper;

            $createData = PropertiFoto::create([
                "kode_properti" => $helper->generateId('PROPS'),
                "studio_id" => $request->studio_id,
                "kategori_id" => $request->kategori_id,
                "nama_properti" => $request->nama_properti,
                "tanggal_masuk" => $request->tanggal_masuk,
                "kondisi" => $request->kondisi,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('backend.properti.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function edit(PropertiFoto $properti)
    {
        $studio = Studio::get();
        $kategori = KategoriProperti::get();
        return view('backend.properti.edit', compact('properti', 'studio', 'kategori'));
    }

    public function update(Request $request, PropertiFoto $properti)
    {
        $request->validate([
            "studio_id" => 'required|exists:studios,id',
            "kategori_id" => 'required|exists:kategori_propertis,id',
            "nama_properti" => 'required|string',
            "tanggal_masuk" => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $updateData = $properti->update([
                "studio_id" => $request->studio_id,
                "kategori_id" => $request->kategori_id,
                "nama_properti" => $request->nama_properti,
                "tanggal_masuk" => $request->tanggal_masuk,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('success', 'Perubahan Data di-Simpan !');
            return redirect(route('backend.properti.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, PropertiFoto $properti)
    {
        try {
            $delete = $properti->delete();

            session()->flash('warning', 'Data di-Hapus !');
            return redirect(route('backend.properti.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
