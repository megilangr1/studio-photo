<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Owner',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Pelanggan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Photography',
                'guard_name' => 'web',
            ]
        ];

        
        try {
            foreach ($data as $key => $value) {
                $role = Role::firstOrCreate($value);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
