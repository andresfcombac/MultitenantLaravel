<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Role;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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

public function create()
{
    $roles = Role::all();
    $empresas = Empresa::all();

    return view(
        'usuarios.create',
        compact('roles', 'empresas')
    );
}

public function store(Request $request)
{
    $request->validate([
        'nombre_usu' => 'required|max:50',
        'apellidos_usu' => 'required|max:50',
        'correo_usu' => 'required|email',
        'password' => 'required|min:6',
        'rol_usu' => 'required',
        'empresa_usu' => 'required'
    ]);

    Usuario::create([
        'nombre_usu' => $request->nombre_usu,
        'apellidos_usu' => $request->apellidos_usu,
        'correo_usu' => $request->correo_usu,
        'pwd' => Hash::make($request->password),
        'rol_usu' => $request->rol_usu,
        'empresa_usu' => $request->empresa_usu,
        'fecha_crea' => now()
    ]);

    return redirect('/usuarios')
        ->with('success', 'Usuario creado correctamente');
}
}
