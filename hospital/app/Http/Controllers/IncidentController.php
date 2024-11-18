<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Hospital;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
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

        $incident = Incident::create([
            'patient' => $request->input('patient'),
            'emergency' => $request->input('emergency'),
            'hospital_id' => $request->input('hospital_id'),
        ]);

        return response()->json($incident, 201);
    }
}
