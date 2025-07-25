<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Arr; // Importa la clase Arr

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil y la foto del usuario.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // 1. Maneja la subida de la foto PRIMERO
        if ($request->hasFile('profile_photo')) {
            // Borra la foto anterior si existe
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // Guarda la nueva foto y asigna la ruta correcta al modelo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // 2. Rellena el modelo con los demás datos, EXCLUYENDO la foto para evitar sobrescribir la ruta
        $user->fill(Arr::except($validated, ['profile_photo']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 3. Guarda todos los cambios (incluyendo la nueva ruta de la foto)
        $user->save();

        return redirect()->route('profile.edit')->with('success_profile', '¡Tus datos se actualizaron correctamente!');
    }

    /**
     * Actualiza la contraseña del usuario autenticado.
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success_password', '¡Contraseña cambiada exitosamente!');
    }
}