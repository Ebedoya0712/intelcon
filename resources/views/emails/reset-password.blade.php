<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <style>
        /* Estilos generales, aunque los más importantes están en línea */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f2f4f6;
        }
    </style>
</head>
<body style="background-color: #f2f4f6; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px;">
                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo de Intelcon" class="mb-3" style="width: 150px;">
                        </td>
                    </tr>
                    <!-- Contenido Principal -->
                    <tr>
                        <td style="background-color: #ffffff; border-radius: 8px; padding: 40px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <h1 style="color: #333333; font-size: 24px; font-weight: bold; margin-top: 0; text-align: center;">
                                Recuperación de Contraseña
                            </h1>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                Hola,
                            </p>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                Has recibido este correo porque se solicitó un reseteo de contraseña para tu cuenta. Si no fuiste tú, puedes ignorar este mensaje.
                            </p>
                            <!-- Botón de Acción -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" target="_blank" style="background-color: #007bff; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; display: inline-block;">
                                            Cambiar Contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                Si tienes problemas con el botón, copia y pega la siguiente URL en tu navegador:
                            </p>
                            <p style="color: #007bff; font-size: 14px; line-height: 1.5; text-align: left; word-break: break-all;">
                                {{ $url }}
                            </p>
                        </td>
                    </tr>
                    <!-- Pie de página -->
                    <tr>
                        <td align="center" style="padding: 20px 0; color: #888888; font-size: 12px;">
                            &copy; {{ date('Y') }} Intelcon. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
