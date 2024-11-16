<?php

use App\Http\Controllers\EmergencyController;
use Illuminate\Support\Facades\Route;

Route::post('/emergencies', [EmergencyController::class, 'createEmergency']);
Route::get('/emergencies/{id}', [EmergencyController::class, 'getEmergency']);
Route::get('/emergencies', [EmergencyController::class, 'getAllEmergencies']);
