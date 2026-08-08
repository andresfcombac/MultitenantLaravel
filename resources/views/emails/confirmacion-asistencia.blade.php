<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Confirmación de asistencia</title>

</head>

<body style="font-family:Arial,sans-serif;background:#f4f4f4;padding:30px;">

<div style="max-width:700px;margin:auto;background:#ffffff;border-radius:8px;padding:30px;">

<h2 style="color:#0d6efd;">

Confirmación de asistencia

</h2>

<p>

Hola

<strong>

{{ $respuesta->nombres }}

{{ $respuesta->apellidos }}

</strong>

</p>

<p>

Su asistencia fue registrada correctamente.

</p>

<hr>

<table style="width:100%;">

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

<tr>

<td><strong>Fecha de registro</strong></td>

<td>

{{ $respuesta->fecha_respuesta }}

</td>

</tr>

</table>

<br>

<p>

Gracias por utilizar la plataforma.

</p>

</div>

</body>

</html>