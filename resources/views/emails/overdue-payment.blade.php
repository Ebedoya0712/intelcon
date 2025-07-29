<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Pago Vencido</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; margin-top: 20px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 20px 0; background-color: #007bff; color: #ffffff;">
                <h1 style="margin: 0;">Recordatorio de Pago</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="color: #333;">Hola, {{ $payment->user->first_name }}</h2>
                <p style="color: #555; line-height: 1.6;">
                    Te escribimos para recordarte que tienes un pago vencido correspondiente al mes de <strong>{{ \Carbon\Carbon::parse($payment->month_paid)->format('F Y') }}</strong> por un monto de <strong>${{ number_format($payment->amount, 2) }}</strong>.
                </p>
                <p style="color: #555; line-height: 1.6;">
                    Para evitar la suspensión de tu servicio, te agradecemos que realices el pago a la brevedad posible.
                </p>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                    <tr>
                        <td align="center">
                            <a href="{{ route('payments.create') }}" style="background-color: #28a745; color: #ffffff; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                Realizar Pago Ahora
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px; font-size: 12px; color: #888; background-color: #f4f4f4;">
                &copy; {{ date('Y') }} Intelcon. Todos los derechos reservados.
            </td>
        </tr>
    </table>
</body>
</html>
