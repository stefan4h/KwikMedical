<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IncidentController extends Controller
{
    /**
     * The base URL for the external ambulance service.
     *
     * @var string
     */
    protected $ambulanceServiceUrl = 'http://127.0.0.1:8004/';

    /**
     * The base URL for the external patient service.
     *
     * @var string
     */
    protected $patientServiceUrl = 'http://127.0.0.1:8000/';

    /**
     * Store a new incident.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'emergency' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $emergency = $request->input('emergency');
        $region = $emergency['region'] ?? "North";
        $location = $emergency['location'] ?? "Not given";

        $ambulanceResponse = Http::get("{$this->ambulanceServiceUrl}ambulances/assign", [
            'region' => $region,
            'location' => $location,
        ]);

        if ($ambulanceResponse->failed()) {
            return response()->json(['message' => 'Failed to retrieve an ambulance.'], 500);
        }

        $ambulance = $ambulanceResponse->json();

        $incident = Incident::create([
            'patient' => $request->input('patient'),
            'emergency' => $request->input('emergency'),
            'ambulance' => $ambulance,
            'ongoing' => true,
            'hospital_id' => $request->input('hospital_id'),
        ]);

        return response()->json($incident, 201);
    }

    /**
     * Set an ambulance's on_call status to false.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOngoingFalse($id)
    {
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json(['message' => 'Incident not found'], 404);
        }

        $incident->update(['ongoing' => false]);

        $ambulanceResponse = Http::post("{$this->ambulanceServiceUrl}ambulances/{$incident->ambulance['id']}/release");

        if ($ambulanceResponse->failed()) {
            return response()->json(['message' => 'Failed to release ambulance.'], 500);
        }

        return response()->json($incident);
    }

    /**
     * Get incidents for a specific ambulance name, sorted by created_at (desc).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIncidentsByAmbulance(Request $request)
    {
        $request->validate([
            'ambulance_name' => 'required|string',
        ]);

        $ambulanceName = $request->query('ambulance_name');

        $incidents = Incident::whereJsonContains('ambulance->name', $ambulanceName)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($incidents, 200);
    }

    public function setIncidentDetails(Request $request, $id)
    {
        $request->validate([
            'what' => 'nullable|string',
            'when' => 'nullable|string',
            'where' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'time_on_call' => 'nullable|integer',
        ]);

        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json(['message' => 'Incident not found'], 404);
        }

        $incident->update($request->only([
            'what',
            'when',
            'where',
            'actions_taken',
            'time_on_call',
        ]));

        $recordData = [
            'patient_id' => (int)$incident->patient['id'],
            'what' => $request->input('what'),
            'when' => $request->input('when'),
            'where' => $request->input('where'),
            'actions_taken' => $request->input('actions_taken'),
            'time_on_call' => $request->input('time_on_call'),
        ];

        Http::post("{$this->patientServiceUrl}records", $recordData);

        return response()->json($incident, 200);
    }
}
