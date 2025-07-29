<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Listado de ciudades con su estado asociado
        $cities = [
            ['name' => 'Puerto Ayacucho', 'state' => 'Amazonas'],
            ['name' => 'Barcelona', 'state' => 'Anzoátegui'],
            ['name' => 'San Fernando de Apure', 'state' => 'Apure'],
            ['name' => 'Maracay', 'state' => 'Aragua'],
            ['name' => 'Barinas', 'state' => 'Barinas'],
            ['name' => 'Ciudad Bolívar', 'state' => 'Bolívar'],
            ['name' => 'Valencia', 'state' => 'Carabobo'],
            ['name' => 'San Carlos', 'state' => 'Cojedes'],
            ['name' => 'Tucupita', 'state' => 'Delta Amacuro'],
            ['name' => 'Caracas', 'state' => 'Distrito Capital'],
            ['name' => 'Coro', 'state' => 'Falcón'],
            ['name' => 'San Juan de los Morros', 'state' => 'Guárico'],
            ['name' => 'Barquisimeto', 'state' => 'Lara'],
            ['name' => 'Mérida', 'state' => 'Mérida'],
            ['name' => 'Los Teques', 'state' => 'Miranda'],
            ['name' => 'Maturín', 'state' => 'Monagas'],
            ['name' => 'La Asunción', 'state' => 'Nueva Esparta'],
            ['name' => 'Guanare', 'state' => 'Portuguesa'],
            ['name' => 'Cumaná', 'state' => 'Sucre'],
            ['name' => 'San Cristóbal', 'state' => 'Táchira'],
            ['name' => 'Trujillo', 'state' => 'Trujillo'],
            ['name' => 'La Guaira', 'state' => 'La Guaira'],
            ['name' => 'San Felipe', 'state' => 'Yaracuy'],
            ['name' => 'Maracaibo', 'state' => 'Zulia'],
        ];

        foreach ($cities as $city) {
            $stateId = DB::table('states')->where('name', $city['state'])->value('id');

            if ($stateId) {
                DB::table('cities')->insert([
                    'name' => $city['name'],
                    'state_id' => $stateId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
