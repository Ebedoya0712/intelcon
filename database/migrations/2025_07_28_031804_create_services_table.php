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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ejemplo: "Plan Fibra Óptica 100 Mbps"
            $table->text('description')->nullable(); // Descripción del servicio
            $table->integer('speed_mbps'); // Velocidad en Megabits por segundo
            $table->decimal('price', 10, 2); // Precio mensual del servicio
            $table->enum('status', ['active', 'discontinued'])->default('active'); // Para saber si el plan está vigente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
