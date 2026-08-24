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
        $request->validate([
            'correo_usu' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where(
            'correo_usu',
            $request->correo_usu
        )->first();

        // Mensaje genérico para no revelar si el correo existe o no
        // (evita enumeración de usuarios).
        if (
            ! $usuario ||
            ! Hash::check(
                $request->password,
                $usuario->pwd
            )
        ) {
            return back()->with(
                'error',
                'Credenciales incorrectas.'
            );
        }

        if (
    ! in_array(
        $usuario->rol_usu,
        [5, 6]
    )
    && ! $usuario->empresa_usu
) {

    return back()->with(
        'error',
        'Usuario sin empresa asignada'
    );

}

        $request->session()->regenerate();

        session([

            'usuario_id' => $usuario->id_usuario,

            'nombre' => $usuario->nombre_usu,

            'rol' => $usuario->rol_usu,

            'empresa' => $usuario->empresa_usu,

        ]);

        if ($usuario->rol_usu == 6) {

    return redirect('/validador');

}

return redirect('/dashboard');
    }

    public function logout()
    {
        // Invalida la sesión (regenera el ID) y el token CSRF para que
        // la cookie de sesión anterior no pueda reutilizarse.
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    }
}
