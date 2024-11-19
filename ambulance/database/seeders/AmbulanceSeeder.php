<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmbulanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ['North', 'East', 'West', 'South'];
        $regionInitials = ['N', 'E', 'W', 'S'];

        foreach ($regions as $index => $region) {
            $initial = $regionInitials[$index];

            for ($i = 10; $i < 20; $i++) {
                DB::table('ambulances')->insert([
                    'region' => $region,
                    'name' => "{$initial}{$i}",
                    'gps_location' => $this->generateRandomLocation(),
                    'on_call' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Generate a random GPS location for the ambulance.
     *
     * @return string
     */
    private function generateRandomLocation(): string
    {
        $latitude = mt_rand(-90000000, 90000000) / 1000000;
        $longitude = mt_rand(-180000000, 180000000) / 1000000;

        return "{$latitude},{$longitude}";
    }
}
