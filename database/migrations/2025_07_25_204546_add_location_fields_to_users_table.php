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
            // Añade la columna para la ciudad, la hace nullable y la relaciona
            $table->foreignId('city_id')->nullable()->after('state_id')->constrained('cities')->onDelete('set null');
            
            // Añade la columna para el municipio, la hace nullable y la relaciona
            $table->foreignId('municipality_id')->nullable()->after('city_id')->constrained('municipalities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina las columnas en el orden inverso
            $table->dropForeign(['municipality_id']);
            $table->dropColumn('municipality_id');

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
