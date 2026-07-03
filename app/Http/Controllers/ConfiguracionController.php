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

        return view(
            'configuracion.index',
            compact('usuario')
        );
    }
}