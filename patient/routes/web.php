<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/patients/{id?}', [PatientController::class, 'getPatient']);
Route::post('/records', [RecordController::class, 'store']);
