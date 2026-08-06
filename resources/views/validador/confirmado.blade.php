<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Ingreso confirmado</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="alert alert-success">

        <h3>Ingreso confirmado</h3>

        <p>

            La asistencia de

            <strong>

                {{ $respuesta->nombres }}
                {{ $respuesta->apellidos }}

            </strong>

            ya fue confirmada.

        </p>

    </div>

</div>

</body>

</html>