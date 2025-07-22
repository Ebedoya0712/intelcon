<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;


Route::get('/', function () {
    return view('welcome');
});

// Ruta para MOSTRAR el formulario de login
Route::get('/login', function () {
    return view('auth.login'); // Asegúrate que la vista exista en resources/views/auth/login.blade.php
})->name('login');



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::resource('users', UserController::class);
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('payments/pending', [PaymentController::class, 'pending'])->name('payments.pending');
Route::resource('payments', PaymentController::class)->except(['show']);
