<?php

namespace Database\Seeders;

use App\Constants\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'super@admin.com',
        //     'password' => 'secret',
        //     'type' => UserTypes::SUPER_ADMIN,
        //     'phone' => "0123456780",
        //     'active' => true
        // ]);
    }
}
