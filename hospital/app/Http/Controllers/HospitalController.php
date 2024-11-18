<?php

namespace App\Http\Controllers;

use App\Models\hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of hospitals.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $hospitals = Hospital::all();
        return response()->json($hospitals);
    }
}
