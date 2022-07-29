<?php

namespace App\Http\Controllers;

use App\Models\KasBesar;
use Illuminate\Http\Request;

class PencatatanKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kas = KasBesar::paginate(25);
        $total = KasBesar::select('nominal')->get()->sum('nominal');
        return view('backend.kas.index', [
            'kas' => $kas,
            'total' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $total = KasBesar::select('nominal')->get()->sum('nominal');
        return view('backend.kas.create', compact('total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal_data' => 'required|date',
            'jenis_data' => 'required|in:1,2',
            'asal_uang' => 'required|string',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $nominal = $request->nominal;
        $total = KasBesar::select('nominal')->get()->sum('nominal');
        if ($request->jenis_data == 2) {
            $sum = (double) $total - (double) $request->nominal;
            if ($sum < 0) {
                session()->flash('warning', 'Nominal Pengeluaran Kas Melebihi Nilai Kas Saat Ini !');
                return redirect()->back()->withInput($request->all());
            }

            $nominal = 0 - $request->nominal;
        }

        try {
            $createKas = KasBesar::create([
                'tanggal_data' => date('Y-m-d', strtotime($request->tanggal_data)),
                'transaction_id' => null,
                'jenis_data' => $request->jenis_data,
                'asal_uang' => $request->asal_uang,
                'nominal' => $nominal,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('backend.kas.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $kas = KasBesar::where('id', '=', $id)->firstOrFail();
            $total = KasBesar::select('nominal')->get()->sum('nominal');
            
            return view('backend.kas.edit', compact('kas', 'total'));
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal_data' => 'required|date',
            'jenis_data' => 'required|in:1,2',
            'asal_uang' => 'required|string',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $kas = KasBesar::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $nominal = $request->nominal;

        $total = KasBesar::select('nominal')->where('id', '!=', $id)->get()->sum('nominal');
        if ($request->jenis_data == 2) {
            $sum = (double) $total - (double) $request->nominal;
            if ($sum < 0) {
                session()->flash('warning', 'Nominal Pengeluaran Kas Melebihi Nilai Kas Saat Ini !');
                return redirect()->back();
            }
            $nominal = 0 - $request->nominal;
        }

        try {
            $update = $kas->update([
                'tanggal_data' => date('Y-m-d', strtotime($request->tanggal_data)),
                'transaction_id' => null,
                'jenis_data' => $request->jenis_data,
                'asal_uang' => $request->asal_uang,
                'nominal' => $nominal,
                'keterangan' => $request->keterangan,
            ]);

            session()->flash('info', 'Data Berhasil di-Ubah !');
            return redirect(route('backend.kas.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kas = KasBesar::findOrFail($id);

            $total = KasBesar::select('nominal')->where('id', '!=', $id)->get()->sum('nominal');
            if ($total < 0) {
                session()->flash('error', 'Tidak Dapat Menghapus Data ! <br> Karena Saldo Kas Menjadi Minus !');
                return redirect()->back();
            }
            $kas->delete();

            session()->flash('warning', 'Data Kas di-Hapus !');
            return redirect(route('backend.kas.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }
}
