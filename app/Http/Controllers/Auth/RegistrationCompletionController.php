<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegistrationCompletionController extends Controller
{
    public function showCompletionForm(Request $request)
    {
        // Obtenemos la cédula de la sesión flash que envió el AuthController
        $identification = $request->session()->get('identification');

        if (!$identification) {
            // Si alguien intenta acceder a esta URL directamente, lo enviamos al login
            return redirect()->route('login');
        }

        return view('auth.complete-registration', ['identification' => $identification]);
    }

    public function complete(Request $request)
    {
        $validated = $request->validate([
            'identification' => ['required', 'string', 'exists:users,identification'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('identification', $validated['identification'])->first();

        // Si el usuario ya tiene contraseña, no debería estar aquí.
        if ($user->password) {
            return redirect()->route('login')->withErrors(['identification' => 'Esta cuenta ya ha sido registrada.']);
        }

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect('/dashboard');
    }
}