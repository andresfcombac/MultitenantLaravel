<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class ConfiguracionController extends Controller
{
    public function index()
{
    $usuario = Usuario::with(
        'empresa',
        'rol'
    )->findOrFail(
        session('usuario_id')
    );

    $version = 'v1.7.0';

    $php = PHP_VERSION;

    $laravel = app()->version();

    return view(
        'configuracion.index',
        compact(
            'usuario',
            'version',
            'php',
            'laravel'
        )
    );
}
}
