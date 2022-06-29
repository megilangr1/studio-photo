<?php

namespace App\Http\Controllers;

use App\Models\KategoriProperti;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriProperti::paginate(5);
        return view('backend.kategori.index', [
            'kategoris' => $kategoris
        ]);
    }

    public function create()
    {
        return view('backend.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $createData = KategoriProperti::create([
                'nama_kategori' => $request->nama_kategori,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('backend.kategori.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function edit(KategoriProperti $kategori)
    {
        return view('backend.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriProperti $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $updateData = $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('success', 'Perubahan Data di-Simpan !');
            return redirect(route('backend.kategori.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, KategoriProperti $kategori)
    {
        try {
            $delete = $kategori->delete();

            session()->flash('warning', 'Data di-Hapus !');
            return redirect(route('backend.kategori.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
