<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
                'name' => 'Super User',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin123'),
            ]
        ];

        try {
            foreach ($data as $key => $value) {
                $users = User::firstOrCreate($value);
            }
        } catch (\Exception $e) {
            //
        }
    }
}
