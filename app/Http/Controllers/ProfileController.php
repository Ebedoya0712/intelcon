<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Arr;
use App\Models\State;
use App\Models\City;
use App\Models\Municipality;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        
        // Carga las ciudades y municipios basados en la selección actual del usuario
        $cities = $user->state_id ? City::where('state_id', $user->state_id)->get() : collect();
        $municipalities = $user->city_id ? Municipality::where('city_id', $user->city_id)->get() : collect();

        return view('profile.edit', [
            'user' => $user,
            'states' => State::all(),
            'cities' => $cities,
            'municipalities' => $municipalities,
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
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->fill(Arr::except($validated, ['profile_photo']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

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
