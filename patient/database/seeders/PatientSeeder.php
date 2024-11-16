<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            [
                'name' => 'John Doe',
                'nhs_registration_number' => 'NHS123456',
                'address' => '123 Main Street, Cityville',
                'medical_condition' => 'Asthma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'nhs_registration_number' => 'NHS654321',
                'address' => '456 Elm Street, Townsville',
                'medical_condition' => 'Diabetes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'nhs_registration_number' => 'NHS987654',
                'address' => '789 Oak Avenue, Villageton',
                'medical_condition' => 'Hypertension',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
