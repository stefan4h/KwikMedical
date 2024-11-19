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
            return response()->json(['message' => 'No available ambulances in this region'], 404);
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
            return response()->json(['message' => 'Ambulance not found'], 404);
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
            'message' => 'All ambulances have been released.',
        ]);
    }
}
