<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Correo</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 0; width: 100%; background-color: #f2f4f6;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f2f4f6;">
        <tr>
            <td align="center" style="padding: 20px;">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <!-- Encabezado con Logo -->
                    <tr>
                        <td align="center" style="padding: 20px 0; border-bottom: 1px solid #dddddd;">
                            <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo de Intelcon" style="width: 150px;">
                        </td>
                    </tr>
                    <!-- Contenido Principal -->
                    <tr>
                        <td style="padding: 40px;">
                            <h1 style="color: #333333; font-size: 24px; font-weight: bold; margin-top: 0; text-align: center;">
                                ¡Casi listo! Verifica tu correo
                            </h1>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                ¡Gracias por unirte a Intelcon! Para completar tu registro, por favor, haz clic en el botón de abajo para verificar tu dirección de correo electrónico.
                            </p>
                            <!-- Botón de Acción -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" target="_blank" style="background-color: #007bff; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; display: inline-block;">
                                            Verificar Correo Electrónico
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                Si no creaste una cuenta, no se requiere ninguna acción adicional.
                            </p>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: left;">
                                Saludos,<br>
                                El equipo de Intelcon
                            </p>
                        </td>
                    </tr>
                    <!-- Pie de página -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #f8f9fa; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; color: #888888; font-size: 12px;">
                            &copy; {{ date('Y') }} Intelcon. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
