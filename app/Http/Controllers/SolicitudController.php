<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Muestra el formulario para crear una solicitud de acceso.
     */
    public function create()
    {
        return view('auth.solicitud');
    }

    /**
     * Procesa la solicitud y redirige a WhatsApp.
     */
    public function send(Request $request)
    {
        // 1. Valida los datos que vienen del formulario
        $validated = $request->validate([
            'identification' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        // 2. Define el número del administrador que recibirá el mensaje
        // ¡IMPORTANTE! Usa el formato internacional sin '+' ni espacios. ej: 584121234567
        $numeroAdmin = '584126304159'; // <-- REEMPLAZA ESTE NÚMERO POR EL REAL

        // 3. Construye el mensaje con formato para WhatsApp
        $mensaje = "¡Nueva Solicitud de Acceso! 🚀\n\n"
                 . "Un cliente solicita ser registrado en el sistema de intelcon, con los siguientes datos:\n\n"
                 . "👤 *Nombre:* " . $validated['first_name'] . " " . $validated['last_name'] . "\n"
                 . "📄 *Cédula:* " . $validated['identification'] . "\n"
                 . "📞 *Teléfono:* " . $validated['telefono'] . "\n\n"
                 . "Por favor, verificar y proceder con el registro.";

        // 4. Codifica el mensaje para que sea seguro en una URL (convierte espacios a %20, etc.)
        $mensajeCodificado = urlencode($mensaje);

        // 5. Crea la URL de WhatsApp y redirige al usuario
        $whatsappUrl = "https://wa.me/{$numeroAdmin}?text={$mensajeCodificado}";
        
        // redirect()->away() se usa para redirigir a URLs externas a tu aplicación
        return redirect()->away($whatsappUrl);
    }
}