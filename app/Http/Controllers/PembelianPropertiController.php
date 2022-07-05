<?php

namespace App\Http\Controllers;

use App\Helper\MainHelper;
use App\Models\PembelianProperti;
use App\Models\PembelianPropertiDetail;
use App\Models\PropertiFoto;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianPropertiController extends Controller
{
    public function index()
    {
        $pembelian = PembelianProperti::paginate(5);
        return view('backend.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $studio = Studio::orderBy('nama_studio')->get();
        return view('backend.pembelian.create', compact('studio'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal_pembelian' => 'required|date',
            'nomor_kwitansi_pembelian' => 'required|string',
            'studio_id' => 'required|exists:studios,id',
            'nama_properti' => 'required|array',
            'kategori_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $helper = new MainHelper;
            $detail = [];
            $propertiFoto = [];
            foreach ($request->nama_properti as $key => $value) {
                if ($value != null && $request->kategori_id[$key] != null) {
                    $data = [
                        'nama_properti' => $value,
                        'kategori_id' => $request->kategori_id[$key],
                        'harga' => $request->harga[$key] ?? 0,
                        'jumlah' => $request->jumlah[$key] ?? 0,
                        'keterangan' => $request->keterangan_properti[$key] ?? null,
                    ];
                    array_push($detail, $data);
                }
            }

            if (count($detail) < 1) {
                session()->flash('error', 'Data Properti Pembelian Tidak Lengkap!');
                return redirect()->back()->withInput($request->all());
            }

            $createPembelian = PembelianProperti::create([
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'nomor_kwitansi_pembelian' => $request->nomor_kwitansi_pembelian,
                'studio_id' => $request->studio_id,
                'user_id' => Auth::user()->id,
                'keterangan' => $request->keterangan
            ]);

            foreach ($detail as $key => $value) {
                $detail[$key]['pembelian_properti_id'] = $createPembelian->id;
            }

            foreach ($detail as $key => $value) {
                $createPembelian = PembelianPropertiDetail::create($value); 
                for ($i=0; $i < $request->jumlah[$key]; $i++) { 
                    $properti = [
                        'transaction_id' => $createPembelian->id,
                        'kode_properti' => $helper->generateId('PROP'),
                        'studio_id' => $request->studio_id,
                        'nama_properti' => $value['nama_properti'],
                        'tanggal_masuk' => $request->tanggal_pembelian,
                        'tanggal_keluar' => null,
                        'kategori_id' => $request->kategori_id[$key],
                        'kondisi' => 'Baik',
                        'keterangan' => $request->keterangan_properti[$key] ?? null,
                    ];

                    array_push($propertiFoto, $properti);
                }
            }
            $createPropertiFoto = PropertiFoto::insert($propertiFoto);

            DB::commit();
            session()->flash('success', 'Data Pembelian Properti di-Buat !');

            return redirect(route('backend.pembelian.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            session()->flash('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        try {
            $pembelian = PembelianProperti::where('id', '=', $id)->firstOrFail();
            $studio = Studio::orderBy('nama_studio')->get();

            return view('backend.pembelian.edit', compact('pembelian', 'studio'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect(route('backend.pembelian.index'));
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal_pembelian' => 'required|date',
            'nomor_kwitansi_pembelian' => 'required|string',
            'studio_id' => 'required|exists:studios,id',
            'nama_properti' => 'required|array',
            'kategori_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = PembelianProperti::where('id', '=', $id)->firstOrFail();
            $detailPembelian = $pembelian->detail;

            $helper = new MainHelper;
            $detail = [];
            $propertiFoto = [];
            foreach ($request->nama_properti as $key => $value) {
                if ($value != null && $request->kategori_id[$key] != null) {
                    $data = [
                        'pembelian_properti_id' => $pembelian->id,
                        'nama_properti' => $value,
                        'kategori_id' => $request->kategori_id[$key],
                        'harga' => $request->harga[$key] ?? 0,
                        'jumlah' => $request->jumlah[$key] ?? 0,
                        'keterangan' => $request->keterangan_properti[$key] ?? null,
                    ];
                    array_push($detail, $data);
                }
            }

            if (count($detail) < 1) {
                session()->flash('error', 'Data Properti Pembelian Tidak Lengkap!');
                return redirect()->back()->withInput($request->all());
            }

            $createPembelian = $pembelian->update([
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'nomor_kwitansi_pembelian' => $request->nomor_kwitansi_pembelian,
                'studio_id' => $request->studio_id,
                'user_id' => Auth::user()->id,
                'keterangan' => $request->keterangan
            ]);

            $idDetail = $pembelian->detail()->pluck('id');
            $deleteDetail = $pembelian->detail()->delete();
            $deleteProperti = PropertiFoto::whereIn('transaction_id', $idDetail)->delete();

            foreach ($detail as $key => $value) {
                $createPembelian = PembelianPropertiDetail::create($value); 
                for ($i=0; $i < $request->jumlah[$key]; $i++) { 
                    $properti = [
                        'transaction_id' => $createPembelian->id,
                        'kode_properti' => $helper->generateId('PROP'),
                        'studio_id' => $request->studio_id,
                        'nama_properti' => $value['nama_properti'],
                        'tanggal_masuk' => $request->tanggal_pembelian,
                        'tanggal_keluar' => null,
                        'kategori_id' => $request->kategori_id[$key],
                        'kondisi' => 'Baik',
                        'keterangan' => $request->keterangan_properti[$key] ?? null,
                    ];

                    array_push($propertiFoto, $properti);
                }
            }
            $createPropertiFoto = PropertiFoto::insert($propertiFoto);

            DB::commit();
            session()->flash('success', 'Data Pembelian Properti di-Ubah !');

            return redirect(route('backend.pembelian.index'));


        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            session()->flash('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $pembelian = PembelianProperti::where('id', '=', $id)->firstOrFail();

            $deleteProperti = PropertiFoto::whereIn('transaction_id', $pembelian->detail()->pluck('id'))->delete();
            $deleteDetail = $pembelian->detail()->delete();
            $deletePembelian = $pembelian->delete();

            DB::commit();
            session()->flash('warning', 'Data di-Hapus !');
            return redirect(route('backend.pembelian.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            return redirect(route('backend.pembelian.index'));
        }
    }
}
