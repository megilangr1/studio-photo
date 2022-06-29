<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::paginate(5);
        return view('backend.studio.index', [
            'studios' => $studios
        ]);
    }

    public function create()
    {
        return view('backend.studio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_studio' => 'required|string',
            'keterangan_studio' => 'nullable|string',
        ]);

        try {
            $createData = Studio::create([
                'nama_studio' => $request->nama_studio,
                'keterangan_studio' => $request->keterangan_studio,
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('backend.studio.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function edit(Studio $studio)
    {
        return view('backend.studio.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'nama_studio' => 'required|string',
            'keterangan_studio' => 'nullable|string',
        ]);

        try {
            $updateData = $studio->update([
                'nama_studio' => $request->nama_studio,
                'keterangan_studio' => $request->keterangan_studio,
            ]);

            session()->flash('success', 'Perubahan Data di-Simpan !');
            return redirect(route('backend.studio.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, Studio $studio)
    {
        try {
            $delete = $studio->delete();

            session()->flash('warning', 'Data di-Hapus !');
            return redirect(route('backend.studio.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
