<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    /**
     * Maneja el intento de inicio de sesión.
     */

     public function store(Request $request)
    {
        // 1. Valida los datos del formulario
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:roles,id'], // El admin debe especificar el rol
        ]);

        // 2. Crea el nuevo usuario
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'identification' => $request->identification,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Se obtiene el rol desde la petición
            'state_id' => 1, // O se puede obtener desde la petición si es necesario
        ]);

        // 3. Redirige a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identification' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('identification', $request->identification)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if (!$user) {
                return back()->with('error_user_not_found', 'El número de identificación no se encuentra en nuestros registros.');
            }
            return back()->withErrors(['identification' => 'La contraseña es incorrecta.'])->withInput($request->only('identification'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- MÉTODOS PARA RECUPERAR CONTRASEÑA ---

    /**
     * Muestra el formulario para pedir el enlace de reseteo.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Envía el correo de verificación de email al usuario autenticado.
     */
    public function sendVerificationEmail(Request $request)
    {
        $user = $request->user();

        // Si el correo ya está verificado, no hace nada.
        if ($user->hasVerifiedEmail()) {
            return back()->with('status', 'Tu correo electrónico ya ha sido verificado.');
        }

        // Envía la notificación de verificación.
        $user->sendEmailVerificationNotification();

        // Devuelve un mensaje de éxito para SweetAlert2.
        return back()->with('verification-link-sent', '¡Un nuevo correo de verificación ha sido enviado a tu dirección de email!');
    }


    /**
     * Envía el enlace de reseteo al correo del usuario.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // --- INICIO DE LA MODIFICACIÓN ---
        // Verificamos manualmente si el usuario existe
        $user = User::where('email', $request->email)->first();

        // Si el usuario NO existe, devolvemos un error para SweetAlert2
        if (!$user) {
            return back()->with('error_email_not_found', 'Este correo no se encuentra registrado en nuestro sistema.');
        }
        // --- FIN DE LA MODIFICACIÓN ---

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        // Devolvemos un mensaje de éxito para SweetAlert2
        return back()->with('status', '¡Te hemos enviado el enlace para recuperar tu contraseña!');
    }

    /**
     * Muestra el formulario para resetear la contraseña.
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Procesa el reseteo de la contraseña.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withInput()->withErrors(['email' => 'Este token de reseteo no es válido.']);
        }

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', '¡Tu contraseña ha sido cambiada exitosamente!');
    }
}