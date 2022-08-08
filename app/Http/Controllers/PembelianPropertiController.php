<?php

namespace App\Http\Controllers;

use App\Helper\MainHelper;
use App\Models\KasBesar;
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
        $pembelian = PembelianProperti::with('kas')->paginate(5);
        return view('backend.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $studio = Studio::orderBy('nama_studio')->get();
        $total = KasBesar::select('nominal')->get()->sum('nominal');
        return view('backend.pembelian.create', compact('studio', 'total'));
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
            'pakai_kas' => 'nullable|boolean'
        ]);

        $total = 0;
        if (isset($request->pakai_kas) && $request->pakai_kas == 1) {
            $kas = KasBesar::select('nominal')->get()->sum('nominal');
            foreach ($request->jumlah as $key => $value) {
                $total = (double) $total + ( (double) $request->jumlah[$key] * (double) $request->harga[$key] ); 
            }
    
            if ($kas < $total) {
                session()->flash('error', 'Nominal Pembelian Lebih Besar Dari Sisa Kas Saat Ini !');
                return redirect()->back()->withInput($request->all());
            }
        }

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

            $idPembelian = $createPembelian->id;

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

            if (isset($request->pakai_kas) && $request->pakai_kas == 1) {
                $insertKas = KasBesar::create([
                    'tanggal_data' => date('Y-m-d'),
                    'transaction_id' => $idPembelian,
                    'jenis_data' => 2,
                    'asal_uang' => 'Pembelian Properti',
                    'nominal' => -1 * $total,
                    'keterangan' => null,
                ]);
            }

            DB::commit();
            session()->flash('success', 'Data Pembelian Properti di-Buat !');

            return redirect(route('backend.pembelian.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        try {
            $pembelian = PembelianProperti::with('kas')->where('id', '=', $id)->firstOrFail();
            $studio = Studio::orderBy('nama_studio')->get();

            if ($pembelian->kas != null) {
                $total = KasBesar::select('nominal')->where('id', '!=', $pembelian->kas->id)->get()->sum('nominal');
            } else {
                $total = KasBesar::select('nominal')->get()->sum('nominal');
            }

            return view('backend.pembelian.edit', compact('pembelian', 'studio', 'total'));
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
            'pakai_kas' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        try {
            $pembelian = PembelianProperti::with('kas')->where('id', '=', $id)->firstOrFail();
            $detailPembelian = $pembelian->detail;

            $total = 0;
            if ($pembelian->kas != null) {
                $kas = KasBesar::select('nominal')->where('id', '!=', $pembelian->kas->id)->get()->sum('nominal');
            } else {
                $kas = KasBesar::select('nominal')->get()->sum('nominal');
            }

            if (isset($request->pakai_kas) && $request->pakai_kas == 1) {
                foreach ($request->jumlah as $key => $value) {
                    $total = (double) $total + ( (double) $request->jumlah[$key] * (double) $request->harga[$key] ); 
                }
                if ($kas < $total) {
                    session()->flash('error', 'Nominal Pembelian Lebih Besar Dari Sisa Kas Saat Ini !');
                    return redirect()->back()->withInput($request->all());
                }
            }

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

            if ($pembelian->kas != null) {
                if (isset($request->pakai_kas) && $request->pakai_kas == 1) {
                    $updateKas = $pembelian->kas()->update([
                        'tanggal_data' => $pembelian->tanggal_pembelian,
                        'nominal' => -1 * $total
                    ]);
                } else {
                    $deleteKas = $pembelian->kas()->delete();
                }
            } else {
                if (isset($request->pakai_kas) && $request->pakai_kas == 1) {
                    $insertKas = KasBesar::create([
                        'tanggal_data' => $pembelian->tanggal_pembelian,
                        'transaction_id' => $pembelian->id,
                        'jenis_data' => 2,
                        'asal_uang' => 'Pembelian Properti',
                        'nominal' => -1 * $total,
                        'keterangan' => null,
                    ]);
                }
            }

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
