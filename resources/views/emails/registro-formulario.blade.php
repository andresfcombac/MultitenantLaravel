<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de registro</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial,sans-serif; color:#333;">

    <div style="max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden;">

        <div style="background:#1f4e79; padding:25px; text-align:center; color:#ffffff;">
            <h1 style="margin:0; font-size:26px;">
                Registro exitoso
            </h1>
        </div>

        <div style="padding:30px;">

            <p style="font-size:16px;">
                Hola
                <strong>
                    {{ $respuesta->nombres }}
                    {{ $respuesta->apellidos }}
                </strong>
            </p>

            <p style="font-size:16px; line-height:1.6;">
                Su inscripción fue registrada correctamente.
            </p>

            <div style="margin:30px 0; padding:20px; background:#f8f9fa; border:1px solid #ddd; border-radius:8px; text-align:center;">

                <h2 style="margin-top:0;">
                    Código QR de asistencia
                </h2>

                <p style="font-size:14px; color:#666;">
                    Presente este código QR el día del evento
                    para validar su asistencia.
                </p>

                @if (!empty($qrPath))
                    <div style="margin:25px 0;">
                        <img
                            src="cid:qr-code"
                            alt="Código QR de asistencia"
                            style="width:280px; max-width:100%; height:auto;"
                        >
                    </div>
                @endif

                <p style="font-size:13px; color:#777;">
                    También encontrará el código QR como archivo adjunto
                    en este correo.
                </p>

            </div>

            <hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">

            <h3>Datos del registro</h3>

            <table width="100%" cellpadding="8" cellspacing="0">

                <tr>
                    <td>
                        <strong>Documento</strong>
                    </td>
                    <td>
                        {{ $respuesta->tipo_documento }}
                        {{ $respuesta->numero_documento }}
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Correo</strong>
                    </td>
                    <td>
                        {{ $respuesta->correo }}
                    </td>
                </tr>

            </table>

        </div>

        <div style="background:#f4f6f8; padding:20px; text-align:center; font-size:12px; color:#777;">
            Este correo fue generado automáticamente.
        </div>

    </div>

</body>

</html>