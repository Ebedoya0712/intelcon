<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crea un usuario administrador con los campos correctos según la migración
        User::create([
            'first_name'        => 'Eliecer',
            'last_name'         => 'Bedoya',
            'identification'    => '12345678',
            'email'             => 'admin@example.com',
            //'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'address'           => 'Calle Principal #123',
            'profile_photo'     => 'default.png',
            'service'           => 'activo',
            'role_id'           => 1, // Asegúrate de que el rol con ID 1 exista
            'state_id'          => 1, // Asegúrate de que el estado con ID 1 exista
            'remember_token'    => Str::random(10),
        ]);
    }
}