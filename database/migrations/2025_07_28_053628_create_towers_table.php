<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('towers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre o identificador de la torre/antena
            $table->foreignId('municipality_id')->constrained('municipalities')->onDelete('cascade');
            $table->text('address')->nullable(); // Dirección específica o detalles de la ubicación
            $table->integer('capacity')->default(0); // Capacidad de clientes/conexiones
            $table->enum('status', ['active', 'maintenance', 'offline'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('towers');
    }
};

