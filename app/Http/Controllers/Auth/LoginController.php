<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $usuario = Usuario::where(
            'correo_usu',
            $request->correo_usu
        )->first();

        if (! $usuario) {
            return back()->with(
                'error',
                'Usuario no encontrado'
            );
        }

        if (! Hash::check(
            $request->password,
            $usuario->pwd
        )) {
            return back()->with(
                'error',
                'Contraseña incorrecta'
            );
        }

        if (
            $usuario->rol_usu != 5
            && ! $usuario->empresa_usu
        ) {

            return back()->with(
                'error',
                'Usuario sin empresa asignada'
            );

        }

        session([

            'usuario_id' => $usuario->id_usuario,

            'nombre' => $usuario->nombre_usu,

            'rol' => $usuario->rol_usu,

            'empresa' => $usuario->empresa_usu,

        ]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}
