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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relación con el usuario que realiza el pago
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Monto del pago
            $table->decimal('amount', 10, 2); // 10 dígitos en total, 2 decimales

            // Fecha en que se realizó el pago
            $table->date('payment_date');

            // Mes y año al que corresponde el pago (ej: "2025-07")
            $table->string('month_paid');

            // Estado del pago (pagado, pendiente, vencido)
            $table->enum('status', ['paid', 'pending', 'overdue'])->default('pending');

            // Campo para la captura de pantalla del pago
            $table->string('receipt_path')->nullable(); // Aquí se guarda la ruta al archivo de la captura
            
            // Campo para notas o comentarios del administrador
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
