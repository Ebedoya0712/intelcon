<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;
use App\Models\Municipality;

class MunicipalitySeeder extends Seeder
{
    public function run(): void
    {
        // Ejemplo para el Estado Anzoátegui
        $anzoategui = State::where('name', 'Anzoátegui')->first();

        if ($anzoategui) {
            $barcelona = City::firstOrCreate([
                'name' => 'Barcelona',
                'state_id' => $anzoategui->id,
            ]);

            $elTigre = City::firstOrCreate([
                'name' => 'El Tigre',
                'state_id' => $anzoategui->id,
            ]);

            Municipality::insert([
                ['name' => 'Municipio Bolívar', 'city_id' => $barcelona->id],
                ['name' => 'Municipio Simón Rodríguez', 'city_id' => $elTigre->id],
                // Agrega más municipios aquí...
            ]);
        }

        // Repite para otros estados
    }
}
