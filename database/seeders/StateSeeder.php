<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas',
            'Bolívar', 'Carabobo', 'Cojedes', 'Delta Amacuro', 'Distrito Capital',
            'Falcón', 'Guárico', 'Lara', 'Mérida', 'Miranda',
            'Monagas', 'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira',
            'Trujillo', 'La Guaira', 'Yaracuy', 'Zulia'
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
