<?php

use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

Route::get('/hospitals', [HospitalController::class, 'index']);
