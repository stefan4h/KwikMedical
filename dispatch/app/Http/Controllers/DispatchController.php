<?php

namespace App\Http\Controllers;

use App\Models\dispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DispatchController extends Controller
{
    /**
     * The base URL for the external patient service.
     *
     * @var string
     */
    protected $hospitalServiceUrl = 'http://127.0.0.1:8003/';

    public function store(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'emergency' => 'required',
        ]);

        $emergency = $request->input('emergency');
        $patient = $request->input('patient');

        $response = Http::get("{$this->hospitalServiceUrl}hospitals");

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to retrieve hospitals'], 500);
        }

        $hospitals = $response->json();

        $hospital = collect($hospitals)->firstWhere(function ($hospital) use ($emergency) {
            return $hospital['region'] === $emergency['region'] &&
                $hospital['specialty'] === $emergency['type'];
        });

        if (!$hospital) {
            return response()->json(['message' => 'No suitable hospital found'], 404);
        }

        $dispatch = Dispatch::create([
            'patient' => $emergency,
            'emergency' => $patient,
            'hospital_id' => $hospital['id'],
        ]);

        return response()->json($dispatch, 201);
    }
}
