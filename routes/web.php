<?php

use App\Http\Controllers\Admin\AdminDocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegistrationCompletionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MyServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceAssignmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SolicitudController; // Corregido para apuntar a la carpeta Auth
use App\Http\Controllers\ZoneController;
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


Route::get('register/complete', [RegistrationCompletionController::class, 'showCompletionForm'])->name('register.show_completion_form');
Route::post('register/complete', [RegistrationCompletionController::class, 'complete'])->name('register.complete');

// Rutas de Recuperación de Contraseña
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

// Rutas de Solicitud de Acceso para usuarios no registrados
Route::get('/solicitud-acceso', [SolicitudController::class, 'create'])->name('solicitud.acceso');
Route::post('/enviar-solicitud', [SolicitudController::class, 'send'])->name('solicitud.send');


Route::get('users/pre-register', [UserController::class, 'showPreRegisterForm'])->name('users.pre-register.form');
Route::post('users/pre-register', [UserController::class, 'preRegisterStore'])->name('users.pre-register.store');



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
    // Rutas para notificar pagos morosos
    Route::post('payments/notify-all-overdue', [PaymentController::class, 'notifyAllOverdue'])->name('payments.notifyAllOverdue');
    Route::post('payments/{payment}/notify', [PaymentController::class, 'notifyOverdue'])->name('payments.notify');
    Route::get('payments/paid', [PaymentController::class, 'paid'])->name('payments.paid');
    Route::resource('payments', PaymentController::class)->except(['show']);

    // Gestión de Servicios (Admin)
    
    Route::resource('services', ServiceController::class);

    Route::get('my-service', [MyServiceController::class, 'show'])->name('my-service.show');

    Route::resource('service-assignments', ServiceAssignmentController::class);

    Route::resource('zones', ZoneController::class);

    Route::resource('roles', RoleController::class);
    // Agrega esta ruta
    Route::post('/roles/{role}/update-users', [RoleController::class, 'updateUsers'])->name('roles.update-users');

    // CÁMBIALO A ESTO:
        Route::get('roles/{user}/edit-role', [RoleController::class, 'editUserRole'])
       ->name('roles.user.edit'); // <-- Nombre corregido y único
        
    Route::put('roles/{user}/update-role', [RoleController::class, 'updateUserRole'])
        ->name('roles.user.update');

    Route::get('/roles/edit-user-role/{user}', [RoleController::class, 'editUserRole'])->name('roles.edit-user-role');
    Route::put('/roles/update-user-role/{user}', [RoleController::class, 'updateUserRole'])->name('roles.update-user-role');

    Route::get('admin/documents', [AdminDocumentController::class, 'index'])->name('admin.documents.index');

    Route::resource('documents', DocumentController::class)->only(['index', 'store', 'destroy']);

    
});
