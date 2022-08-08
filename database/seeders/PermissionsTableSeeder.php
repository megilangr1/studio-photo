<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Data Pengguna', 'guard_name' => 'web' ],
            [ 'name' => 'Data Pelanggan', 'guard_name' => 'web' ],
            [ 'name' => 'Data Paket', 'guard_name' => 'web' ],
            [ 'name' => 'Data Studio', 'guard_name' => 'web' ],
            [ 'name' => 'Data Kategori Properti', 'guard_name' => 'web' ],
            [ 'name' => 'Data Properti', 'guard_name' => 'web' ],
            [ 'name' => 'Transaksi Pembelian Properti', 'guard_name' => 'web' ],
            [ 'name' => 'Transaksi Booking', 'guard_name' => 'web' ],
            [ 'name' => 'Transaksi Pencatatan Kas', 'guard_name' => 'web' ],
        ];

        try {
            foreach ($data as $key => $value) {
                $permission = Permission::firstOrCreate($value);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
