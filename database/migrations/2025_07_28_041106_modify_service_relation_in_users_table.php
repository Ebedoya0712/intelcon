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
        Schema::table('users', function (Blueprint $table) {
            // 1. Elimina la columna de texto 'service' que ya no se usará.
            $table->dropColumn('service');

            // 2. Añade la nueva columna para la relación con la tabla de servicios.
            $table->foreignId('service_id')
                  ->nullable() // Permite que un usuario no tenga un servicio asignado.
                  ->after('profile_photo') // Coloca la columna después de la foto de perfil.
                  ->constrained('services') // Crea la relación con la tabla 'services'.
                  ->onDelete('set null'); // Si se borra un servicio, el campo en user se pone a null.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Define cómo revertir los cambios
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
            $table->string('service')->nullable()->after('profile_photo');
        });
    }
};
