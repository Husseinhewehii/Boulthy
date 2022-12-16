<?php

namespace Database\Seeders;

use App\Constants\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'super@admin.com'],[
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => 'Admin#12',
            'type' => UserTypes::SUPER_ADMIN,
            'phone' => "0123456780",
            'active' => true
        ]);
    }
}
