<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Aplica la migración: hace los campos de detalle del usuario opcionales.
     */
    public function up(): void
    {
        // Importante: El método change() requiere que la librería doctrine/dbal esté instalada.
        // Si no la tienes, instálala con: composer require doctrine/dbal
        Schema::table('users', function (Blueprint $table) {
            // Hacemos estos campos nullable para que el pre-registro (solo con identificación)
            // pueda crear el usuario antes de la fase de 'completion'.
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revierte el cambio a not nullable (requerido).
            // NOTA: Esto fallará si ya hay registros con valores NULL en la base de datos.
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
