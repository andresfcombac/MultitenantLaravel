<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de inscripción</title>
</head>

<body style="font-family:Arial,sans-serif;">

<h2>Registro exitoso</h2>

<p>

Hola

<strong>

{{ $respuesta->nombres }}

{{ $respuesta->apellidos }}

</strong>

</p>

<p>

Su inscripción fue registrada correctamente.

</p>

<p>

Adjunto encontrará el código QR correspondiente a su registro.

Preséntelo el día del evento para validar su asistencia.

</p>

<hr>

<table>

<tr>

<td><strong>Documento</strong></td>

<td>

{{ $respuesta->tipo_documento }}

{{ $respuesta->numero_documento }}

</td>

</tr>

<tr>

<td><strong>Correo</strong></td>

<td>

{{ $respuesta->correo }}

</td>

</tr>

</table>

</body>

</html>