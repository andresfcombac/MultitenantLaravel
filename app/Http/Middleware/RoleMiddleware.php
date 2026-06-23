<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleMiddleware
{

    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    )
    {

        $rol = Role::find(
            session('rol')
        );


        if(
            !$rol ||
            !in_array(
                $rol->nombre_rol,
                $roles
            )
        ){

            abort(
                403,
                'Acceso no autorizado'
            );

        }


        return $next($request);

    }

}