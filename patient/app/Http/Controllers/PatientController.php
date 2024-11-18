<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Get a patient by ID or NHS registration number.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatient(Request $request, $id = null)
    {
        if ($request->has('nhs')) {
            $nhsNumber = $request->query('nhs');
            $patient = Patient::with('records')->where('nhs_registration_number', $nhsNumber)->first();

            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }

            return response()->json($patient, 200);
        }

        if ($id !== null) {
            $patient = Patient::with('records')->find($id);

            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }

            return response()->json($patient, 200);
        }

        return response()->json(['message' => 'Invalid request. Provide either ID or NHS number'], 400);
    }
}
