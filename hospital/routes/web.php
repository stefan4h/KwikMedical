<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Route;

Route::get('/hospitals', [HospitalController::class, 'index']);
Route::get('/incidents', [IncidentController::class, 'getIncidentsByAmbulance']);
Route::post('/incidents', [IncidentController::class, 'store']);
Route::post('/incidents/{id}/complete', [IncidentController::class, 'setOngoingFalse']);
Route::patch('/incidents/{id}/details', [IncidentController::class, 'setIncidentDetails']);
