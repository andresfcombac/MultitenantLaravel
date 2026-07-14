<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ) {

        $rol = Role::find(session('rol'));

        if (! $rol || $rol->nombre_rol != 'SuperAdmin') {

            abort(403, 'Acceso no autorizado');

        }

        return $next($request);

    }
}