<?php

namespace App\Http\Controllers;

use App\Models\dispatch;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'patient' => 'required',
            'emergency' => 'required',
        ]);

        $dispatch = Dispatch::create([
            'patient' => $request->input('patient'),
            'emergency' => $request->input('emergency'),
            'hospital_id' => 1,
        ]);

        return response()->json($dispatch, 201);
    }
}
