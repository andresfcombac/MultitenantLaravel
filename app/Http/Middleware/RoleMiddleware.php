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

            abort(
                403,
                'Acceso no autorizado'
            );

        }

        return $next($request);

    }
}
