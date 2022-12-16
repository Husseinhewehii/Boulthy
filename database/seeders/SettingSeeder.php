<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            "orderfees" =>  14,
            "clientregistrationpromotime" =>  1296000,
            "clientregistrationpromopercentage" =>  15,
            "associatecommissionpercentage" =>  1,
            "resetpasswordlinkexpirationtime" =>  600,
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(["key"=> $key], ["key"=> $key, "value" => $value]);
        }
    }
}
