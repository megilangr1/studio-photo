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
            'Administrator'
        ];

        try {
            $user = User::where('name', '=', 'Administrator')->first();
            if ($user != null) {
                $user->syncRoles($role);
            }
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
