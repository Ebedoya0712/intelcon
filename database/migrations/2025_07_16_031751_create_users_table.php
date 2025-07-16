<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
    $table->id();

    // Información personal
    $table->string('first_name');
    $table->string('last_name');
    $table->string('identification')->unique(); // cédula
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('address')->nullable();

    // Foto de perfil
    $table->string('profile_photo')->nullable();

    // Servicio activo, esto es para saber si tiene un servicio de intenet activo oh no
    $table->string('service')->nullable();

    // Relaciones
    $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
    $table->foreignId('state_id')->constrained('states')->onDelete('cascade');

    // Autenticación
    $table->rememberToken();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
