<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed patients
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

        // Seed realistic records for each patient
        for ($i = 1; $i <= 3; $i++) {
            $patientId = $i;
            if ($patientId === 1) {
                // Records for John Doe (Asthma)
                DB::table('records')->insert([
                    [
                        'patient_id' => $patientId,
                        'what' => 'Severe asthma attack',
                        'when' => now()->subDays(30),
                        'where' => '123 Main Street, Cityville',
                        'actions_taken' => 'Administered inhaler and oxygen',
                        'time_on_call' => 15, // Time in minutes
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'patient_id' => $patientId,
                        'what' => 'Shortness of breath',
                        'when' => now()->subDays(15),
                        'where' => 'Cityville Shopping Mall',
                        'actions_taken' => 'Provided inhaler and observed',
                        'time_on_call' => 20,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            } elseif ($patientId === 2) {
                // Records for Jane Smith (Diabetes)
                DB::table('records')->insert([
                    [
                        'patient_id' => $patientId,
                        'what' => 'Low blood sugar (hypoglycemia)',
                        'when' => now()->subDays(25),
                        'where' => '456 Elm Street, Townsville',
                        'actions_taken' => 'Administered glucose gel and monitored',
                        'time_on_call' => 30,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'patient_id' => $patientId,
                        'what' => 'High blood sugar (hyperglycemia)',
                        'when' => now()->subDays(10),
                        'where' => 'Townsville Community Center',
                        'actions_taken' => 'Insulin injection and hydration',
                        'time_on_call' => 25,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            } elseif ($patientId === 3) {
                // Records for Alice Johnson (Hypertension)
                DB::table('records')->insert([
                    [
                        'patient_id' => $patientId,
                        'what' => 'High blood pressure emergency',
                        'when' => now()->subDays(20),
                        'where' => '789 Oak Avenue, Villageton',
                        'actions_taken' => 'Administered antihypertensive medication',
                        'time_on_call' => 40,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'patient_id' => $patientId,
                        'what' => 'Severe headache and dizziness',
                        'when' => now()->subDays(5),
                        'where' => 'Villageton Park',
                        'actions_taken' => 'Monitoring and provided medication',
                        'time_on_call' => 35,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }
}
