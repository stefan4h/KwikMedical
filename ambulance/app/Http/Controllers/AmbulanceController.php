<?php

namespace App\Http\Controllers;

use App\Models\ambulance;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    /**
     * Get an available ambulance for a specific region and location.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAmbulanceForRegion(Request $request)
    {
        $request->validate([
            'region' => 'required|string|in:North,East,West,South',
            'location' => 'required|string',
        ]);

        $region = $request->query('region');

        $ambulances = Ambulance::where('region', $region)
            ->where('on_call', false)
            ->get();

        if ($ambulances->isEmpty()) {
            return response()->json(['incident' => 'No available ambulances in this region'], 404);
        }

        // Pick a random ambulance to simulate picking by location
        $ambulance = $ambulances->random();

        $ambulance->update(['on_call' => true]);

        return response()->json($ambulance);
    }


    /**
     * Set an ambulance's on_call status to false.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOnCallFalse($id)
    {
        $ambulance = Ambulance::find($id);

        if (!$ambulance) {
            return response()->json(['incident' => 'Ambulance not found'], 404);
        }

        // Set the ambulance to not on call
        $ambulance->update(['on_call' => false]);

        return response()->json($ambulance);
    }

    /**
     * Release all ambulances by setting their on_call status to false.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function releaseAllAmbulances()
    {
        // Update all ambulances to set on_call to false
        Ambulance::where('on_call', true)->update(['on_call' => false]);

        return response()->json([
            'incident' => 'All ambulances have been released.',
        ]);
    }

    /**
     * Get all ambulances for a specific region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAmbulancesForRegion(Request $request)
    {
        $request->validate([
            'region' => 'required|string|in:North,East,West,South',
        ]);

        $region = $request->query('region');

        $ambulances = Ambulance::where('region', $region)->get();

        if ($ambulances->isEmpty()) {
            return response()->json(['incident' => 'No ambulances found in this region'], 404);
        }

        return response()->json($ambulances);
    }

    /**
     * Update the GPS location of an ambulance by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGpsLocationByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gps_location' => 'required|string',
        ]);

        $ambulance = Ambulance::where('name', $request->input('name'))->first();

        if (!$ambulance) {
            return response()->json(['message' => 'Ambulance not found'], 404);
        }

        $ambulance->update(['gps_location' => $request->input('gps_location')]);

        return response()->json(['message' => 'GPS location updated', 'ambulance' => $ambulance], 200);
    }
}
