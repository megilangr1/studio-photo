<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            'Owner',
            'Administrator',
            'Photography'
        ];

        $permission = [
            'Data Pengguna',
            'Data Pelanggan',
            'Data Paket',
            'Data Studio',
            'Data Kategori Properti',
            'Data Properti',
            'Transaksi Pembelian Properti',
            'Transaksi Booking',
            'Transaksi Pencatatan Kas',
        ];

        try {
            $user = User::where('email', '=', 'admin@mail.com')->first();
            if ($user != null) {
                $user->syncRoles($role);
                $user->syncPermissions($permission);
            }
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
