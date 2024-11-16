<?php

namespace App\Http\Controllers;

use App\Models\Emergency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmergencyController extends Controller
{
    /**
     * The base URL for the external patient service.
     *
     * @var string
     */
    protected $patientServiceUrl = 'http://127.0.0.1:8000/';

    /**
     * Create a new emergency.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEmergency(Request $request)
    {
        $request->validate([
            'caller_name' => 'required|string|max:255',
            'caller_phone' => 'nullable|string|max:255',
            'nhs_registration_number' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'region' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Call the external patient service to validate the patient
        $response = Http::get("{$this->patientServiceUrl}patients?nhs={$request->nhs_registration_number}");

        if ($response->failed() || !$response->json()) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient = $response->json();

        // Create the emergency record
        $emergency = Emergency::create([
            'caller_name' => $request->caller_name,
            'caller_phone' => $request->caller_phone,
            'patient_name' => $patient['name'],
            'patient_id' => $patient['id'],
            'nhs_registration_number' => $request->nhs_registration_number,
            'location' => $request->location,
            'region' => $request->region,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return response()->json($emergency, 201);
    }

    /**
     * Get an emergency by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmergency($id)
    {
        $emergency = Emergency::find($id);

        if (!$emergency) {
            return response()->json(['message' => 'Emergency not found'], 404);
        }

        // Fetch patient data from the external service
        $response = Http::get("{$this->patientServiceUrl}patients/{$emergency->patient_id}");

        $patient = $response->successful() ? $response->json() : null;

        return response()->json([
            'emergency' => $emergency,
            'patient' => $patient,
        ], 200);
    }

    /**
     * Get all emergencies.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEmergencies()
    {
        $emergencies = Emergency::all();

        return response()->json($emergencies, 200);
    }
}
