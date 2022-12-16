<?php

namespace Database\Seeders;

use App\Models\Partition;
use Illuminate\Database\Seeder;

class PartitionSeeder extends Seeder
{


    public function run()
    {
        $title = [];
        foreach (main_locales() as $locale) {
            $title[$locale] = "title $locale";
        }

        $partitionData = [
            "title" => $title,
            "active" => 1
        ];

        $partitions = [
            "homepage" => [
                "homepagehair" => $partitionData,
                "homepageskin" => $partitionData,
            ]
        ];

        foreach ($partitions as $group => $items) {
            foreach ($items as $key => $value) {
                Partition::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => $group, "title" => $value]);
            }
        }

    }
}
