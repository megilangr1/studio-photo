<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::doesntHave('pelanggan')->paginate(5);
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        try {
            $createData = User::firstOrCreate([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('backend.user.index'));
        } catch (\Exception $e) {
            dd($e);
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
    public function edit(User $user)
    {
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$user->id,
            'password' => 'nullable|string|confirmed',
        ]);

        try {
            if ($request->password != null) {
                $password = Hash::make($request->password);
            } else {
                $password = $user->password;
            }

            $update = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password
            ]);

            session()->flash('success', 'Perubahan Data di-Simpan !');
            return redirect(route('backend.user.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $delete = $user->delete();

            session()->flash('warning', 'Data di-Hapus !');
            return redirect(route('backend.user.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function permission(User $user)
    {
        $roles = Role::get();
        $permission = Permission::get();
        if ($user->email == 'admin@mail.com' || $user->pelanggan != null) {
            abort(404);
        }
        return view('backend.user.permission', compact('roles', 'permission', 'user'));
    }
    
    public function permissionSync(Request $request, User $user)
    {
        $this->validate($request, [
            'role' => 'required|array',
            'role.*' => 'required|exists:roles,id',
            'permission' => 'required|array',
            'permission.*' => 'required|exists:permissions,id',
        ]);

        try {
            $user->syncRoles($request->role);
            $user->syncPermissions($request->permission);

            return redirect(route('backend.user.index'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
