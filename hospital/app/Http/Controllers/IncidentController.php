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
}
