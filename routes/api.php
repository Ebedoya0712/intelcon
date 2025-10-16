<?php

use App\Http\Controllers\Auth\AuthController; // ¡IMPORTACIÓN REQUERIDA!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

/*
|--------------------------------------------------------------------------
| Rutas API
|--------------------------------------------------------------------------
|
| Estas rutas son cargadas por el RouteServiceProvider dentro de un grupo 
| que está asignado al middleware "api".
|
*/

// RUTA NECESARIA PARA VERIFICAR EL ESTADO DE LA CONTRASEÑA
// La URL para esta ruta es: /api/check-password-status/{identification}
Route::get('/check-password-status/{identification}', [AuthController::class, 'checkPasswordStatus']);

// Rutas para obtener datos de ubicación de forma dinámica
Route::post('/get-cities', [LocationController::class, 'getCities'])->name('api.get-cities');
Route::post('/get-municipalities', [LocationController::class, 'getMunicipalities'])->name('api.get-municipalities');

// Ejemplo de una ruta de API que requiere autenticación (si la tienes)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
