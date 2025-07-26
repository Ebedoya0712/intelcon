<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SolicitudController; // Corregido para apuntar a la carpeta Auth
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Estas rutas son accesibles para cualquier visitante.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/acceder', [AuthController::class, 'login'])->name('auth.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Recuperación de Contraseña
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

// Rutas de Solicitud de Acceso para usuarios no registrados
Route::get('/solicitud-acceso', [SolicitudController::class, 'create'])->name('solicitud.acceso');
Route::post('/enviar-solicitud', [SolicitudController::class, 'send'])->name('solicitud.send');


/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
|
| Estas rutas requieren que el usuario haya iniciado sesión.
|
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // 2. Ruta para manejar el clic en el enlace del correo (la que te falta)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('status', '¡Tu correo ha sido verificado exitosamente!');
    })->middleware('signed')->name('verification.verify');

    // 3. (Opcional pero recomendado) Ruta para mostrar una página pidiendo verificar el correo
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Gestión de Usuarios (Admin)
    Route::resource('users', UserController::class);

    // Gestión de Pagos (Admin)
    Route::get('payments/pending', [PaymentController::class, 'pending'])->name('payments.pending');
    Route::get('payments/overdue', [PaymentController::class, 'overdue'])->name('payments.overdue');
    Route::resource('payments', PaymentController::class)->except(['show']);

});
