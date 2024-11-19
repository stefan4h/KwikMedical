<?php

use App\Http\Controllers\AmbulanceController;
use Illuminate\Support\Facades\Route;

Route::get('/ambulances/assign', [AmbulanceController::class, 'getAmbulanceForRegion']);
Route::post('/ambulances/{id}/release', [AmbulanceController::class, 'setOnCallFalse']);
Route::post('/ambulances/release-all', [AmbulanceController::class, 'releaseAllAmbulances']);

