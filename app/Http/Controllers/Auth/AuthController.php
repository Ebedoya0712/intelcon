<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Maneja el intento de inicio de sesión.
     */
    public function login(Request $request)
    {
        // 1. Valida que los datos del formulario lleguen correctamente
        $request->validate([
            'identification' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Busca al usuario en la base de datos por su 'identification'
        $user = User::where('identification', $request->identification)->first();

        // 3. Escenario: El usuario NO existe
        if (!$user) {
            // Redirige de vuelta al login con un mensaje de sesión para SweetAlert2
            return back()->with('error_user_not_found', 'El número de identificación no se encuentra en nuestros registros.');
        }

        // 4. Escenario: El usuario SÍ existe, pero la contraseña es INCORRECTA
        if (!Hash::check($request->password, $user->password)) {
            // Redirige de vuelta con un error de validación estándar de Laravel
            return back()->withErrors([
                'identification' => 'La contraseña es incorrecta.',
            ])->withInput($request->only('identification')); // Devuelve la cédula para no reescribirla
        }

        // 5. Escenario: ÉXITO (usuario y contraseña correctos)
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }
}