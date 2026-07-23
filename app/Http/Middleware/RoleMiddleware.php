<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ) {

        $rol = Role::find(
            session('rol')
        );

      if (
    ! $rol ||
    ! in_array(
        $rol->nombre_rol,
        $roles
    )
) {

    $modulo = match (true) {
        str_contains($request->path(), 'usuarios') => 'Usuarios',
        str_contains($request->path(), 'formularios') => 'Formularios',
        str_contains($request->path(), 'actividades') => 'Actividades',
        str_contains($request->path(), 'asistencias') => 'Asistencias',
        str_contains($request->path(), 'historico') => 'Histórico',
        str_contains($request->path(), 'configuracion') => 'Configuración',
        default => 'este módulo',
    };

    return redirect()->back()->with(
        'error',
        "No tiene permisos para acceder a {$modulo}."
    );

}

        return $next($request);

    }
}
