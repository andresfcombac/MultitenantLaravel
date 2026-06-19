<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(
            'rol',
            'empresa'
        )->get();

        return view(
            'usuarios.index',
            compact('usuarios')
        );
    }
}
