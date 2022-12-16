<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(10)->create();
        $this->call(SuperAdminSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(StaticContentSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PartitionSeeder::class);
        $this->call(PageHeaderSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(PromoSeeder::class);
        // $this->call(BlogSeeder::class);
    }
}
