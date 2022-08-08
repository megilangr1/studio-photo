<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = Pelanggan::withTrashed()->with('user')->paginate(5);
        return view('backend.pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pelanggan.create');
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
            'nama_lengkap' => 'required|string', 
            'nomor_hp' => 'required|string', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|confirmed', 
        ]);

        
        DB::beginTransaction();
        try {
            $createUser = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $createPelanggan = Pelanggan::create([
                'user_id' => $createUser->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => null,
            ]);

            $createUser->assignRole(3);
            DB::commit();

            session()->flash('success', 'Data Berhasil di-Buat !');
            return redirect(route('backend.pelanggan.index'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput($request->all());
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
    public function edit(Pelanggan $pelanggan)
    {
        return view('backend.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $this->validate($request, [
            'nama_lengkap' => 'required|string', 
            'nomor_hp' => 'required|string', 
            'email' => 'required|email|unique:users,email,'.$pelanggan->user_id, 
            'password' => 'nullable|string|confirmed', 
        ]);

        try {
            if ($request->password != null) {
                $password = Hash::make($request->password);
            } else {
                $password = $pelanggan->user->password;
            }

            $updatePelanggan = $pelanggan->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_hp' => $request->nomor_hp,
            ]);

            $updateUser = $pelanggan->user()->update([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => $password
            ]);

            session()->flash('info', 'Data Berhasil di-Ubah !');
            return redirect(route('backend.pelanggan.index'));
        } catch (\Exception $e) {
            dd($e);
        }
        dd($request->all());
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
            $pelanggan = Pelanggan::withTrashed()->where('id', '=', $id)->firstOrFail();

            $alert = 'warning';
            $msg = 'Data di-Hapus / di-Nonaktifkan !';
            if ($pelanggan->deleted_at != null) {
                $pelanggan->restore();
                $alert = 'info';
                $msg = 'Data di-Pulihkan / di-Aktifkan Kembali !';
            } else {
                $pelanggan->delete();
            }

            session()->flash($alert, $msg);
            return redirect(route('backend.pelanggan.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
