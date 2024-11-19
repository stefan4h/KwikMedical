<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Route;

Route::get('/hospitals', [HospitalController::class, 'index']);
Route::post('/incidents', [IncidentController::class, 'store']);
Route::post('/incidents/{id}/complete', [IncidentController::class, 'setOngoingFalse']);
