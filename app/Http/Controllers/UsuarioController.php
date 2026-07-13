<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $consulta = Usuario::with(
            'rol',
            'empresa'
        );

        if (session('rol') != 5) {

            $consulta->where(
                'empresa_usu',
                app('tenant_id')
            );

        }

        $usuarios = $consulta->get();

        return view(
            'usuarios.index',
            compact('usuarios')
        );
    }

    public function create()
    {
        if (session('rol') == 5) {

            $roles = Role::all();

        } else {

            $roles = Role::whereIn(
                'id_rol',
                [1, 2]
            )->get();

        }

        $empresa = null;

        if (session('rol') != 5) {

            $empresa = Empresa::find(
                app('tenant_id')
            );

        }

        return view(
            'usuarios.create',
            compact(
                'roles',
                'empresa'
            )
        );

    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre_usu' => 'required|max:50',
            'apellidos_usu' => 'required|max:50',
            'correo_usu' => 'required|email|unique:legacy.usuarios,correo_usu',
            'password' => 'required|min:6',
            'rol_usu' => 'required',
        ]);

        Usuario::create([

            'nombre_usu' => $request->nombre_usu,

            'apellidos_usu' => $request->apellidos_usu,

            'correo_usu' => $request->correo_usu,

            'pwd' => Hash::make(
                $request->password
            ),

            'rol_usu' => $request->rol_usu,

            'empresa_usu' => session('rol') == 5
                ? $request->empresa_usu
                : app('tenant_id'),

            'fecha_crea' => now(),

        ]);

        return redirect('/usuarios')
            ->with(
                'success',
                'Usuario creado correctamente'
            );

    }

    public function edit($id)
    {

        if (session('rol') == 5) {

            $usuario = Usuario::findOrFail($id);

            $empresas = Empresa::all();

        } else {

            $usuario = Usuario::where(
                'empresa_usu',
                app('tenant_id')
            )
                ->findOrFail($id);

            $empresas = Empresa::where(
                'id_empresa',
                app('tenant_id')
            )->get();

        }

        if (session('rol') == 5) {

            $roles = Role::all();

        } else {

            $roles = Role::whereIn(
                'id_rol',
                [1, 2]
            )->get();

        }

        return view(
            'usuarios.edit',
            compact(
                'usuario',
                'roles',
                'empresas'
            )
        );

    }

    public function update(
        Request $request,
        $id
    ) {

        if (session('rol') == 5) {

            $usuario = Usuario::findOrFail($id);

        } else {

            $usuario = Usuario::where(
                'empresa_usu',
                app('tenant_id')
            )
                ->findOrFail($id);

        }

        $request->validate([
            'nombre_usu' => 'required|max:50',
            'apellidos_usu' => 'required|max:50',
            'correo_usu' => 'required|email|unique:legacy.usuarios,correo_usu,'.$usuario->id_usuario.',id_usuario',
            'rol_usu' => [
                'required',
                function ($attribute, $value, $fail) {

                    if (session('rol') != 5 && $value == 5) {

                        $fail('No tiene permisos para asignar SuperAdmin');

                    }

                },
            ],
        ]);

        $usuario->update([
            'nombre_usu' => $request->nombre_usu,
            'apellidos_usu' => $request->apellidos_usu,
            'correo_usu' => $request->correo_usu,
            'telefono_usu' => $request->telefono_usu,
            'cargo' => $request->cargo,
            'rol_usu' => $request->rol_usu,
            'empresa_usu' => session('rol') == 5
                ? $request->empresa_usu
                : app('tenant_id'),
            'fecha_up' => now(),
        ]);

        return redirect('/usuarios')
            ->with(
                'success',
                'Usuario actualizado correctamente'
            );

    }

    public function destroy($id)
    {

        if (session('rol') == 5) {

            $usuario = Usuario::findOrFail($id);

        } else {

            $usuario = Usuario::where(
                'empresa_usu',
                app('tenant_id')
            )
                ->findOrFail($id);

        }

        $usuario->delete();

        return redirect('/usuarios')
            ->with(
                'success',
                'Usuario eliminado correctamente'
            );

    }

    public function perfil()
{
    $usuario = Usuario::with([
        'rol',
        'empresa'
    ])->findOrFail(session('usuario_id'));

    return view(
        'usuarios.perfil',
        compact('usuario')
    );
}

public function actualizarPerfil(Request $request)
{
    $usuario = Usuario::findOrFail(
        session('usuario_id')
    );

    $request->validate([
    'nombre_usu' => 'required|max:50',
    'apellidos_usu' => 'required|max:50',
    'correo_usu' =>
        'required|email|unique:legacy.usuarios,correo_usu,' .
        $usuario->id_usuario .
        ',id_usuario',

    'telefono_usu' => 'nullable|max:20',

    'password' => 'nullable|min:6|confirmed',
]);

if ($request->filled('password')) {

    if (!$request->filled('password_actual')) {

        return back()
            ->withErrors([
                'password_actual' =>
                    'Debe ingresar la contraseña actual.'
            ])
            ->withInput();

    }

    if (!Hash::check(
        $request->password_actual,
        $usuario->pwd
    )) {

        return back()
            ->withErrors([
                'password_actual' =>
                    'La contraseña actual es incorrecta.'
            ])
            ->withInput();

    }

}
   $datosActualizar = [

    'nombre_usu' => $request->nombre_usu,

    'apellidos_usu' => $request->apellidos_usu,

    'correo_usu' => $request->correo_usu,

    'telefono_usu' => $request->telefono_usu,

    'fecha_up' => now(),

];

if ($request->filled('password')) {

    $datosActualizar['pwd'] = Hash::make(
        $request->password
    );

}

$usuario->update($datosActualizar);

    session([
        'nombre' => $usuario->nombre_usu
    ]);

    return redirect()
        ->route('perfil')
        ->with(
            'success',
            'Perfil actualizado correctamente.'
        );
}

}
