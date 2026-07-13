<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ) {

        $rol = Role::find(
            session('rol')
        );

        if (
            $rol &&
            $rol->nombre_rol == 'SuperAdmin'
        ) {

            return $next($request);

        }

        if (! session()->has('empresa')) {

            return redirect('/login');

        }

        app()->instance(
            'tenant_id',
            session('empresa')
        );

        return $next($request);

    }
}
