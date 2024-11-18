<?php

namespace Database\Seeders;

use App\Models\hospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ['North', 'East', 'West', 'South'];
        $specialties = ['Heart Attack', 'Stroke', 'Accident', 'Fire', 'Poison'];

        foreach ($regions as $region) {
            foreach ($specialties as $specialty) {
                Hospital::create([
                    'region' => $region,
                    'specialty' => $specialty,
                ]);
            }
        }
    }
}
