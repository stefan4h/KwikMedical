<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Store a new record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'what' => 'nullable|string',
            'when' => 'nullable|string',
            'where' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'time_on_call' => 'nullable|integer',
        ]);

        $record = Record::create($request->all());

        return response()->json($record, 201);
    }
}
