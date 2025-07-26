<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

// Rutas para obtener datos de ubicación de forma dinámica
Route::post('/get-cities', [LocationController::class, 'getCities'])->name('api.get-cities');
Route::post('/get-municipalities', [LocationController::class, 'getMunicipalities'])->name('api.get-municipalities');
