<?php

use App\Http\Controllers\DispatchController;
use Illuminate\Support\Facades\Route;

Route::post('/dispatches', [DispatchController::class, 'store']);
