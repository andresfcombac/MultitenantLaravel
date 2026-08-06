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

        $esRolSinEmpresa = $rol &&
            in_array(
                $rol->nombre_rol,
                [
                    'SuperAdmin',
                    'Validador QR',
                ]
            );

        if (! $esRolSinEmpresa && ! session()->has('empresa')) {

            return redirect('/login');

        }

        // Se enlaza siempre, aunque sea null para roles sin empresa
        // (SuperAdmin / Validador QR). Así app('tenant_id') nunca
        // lanza una BindingResolutionException si algún controlador
        // decide consultarlo por un criterio distinto al de este
        // middleware (p. ej. comparando session('rol') contra un id
        // numérico en vez del nombre del rol).
        app()->instance(
            'tenant_id',
            session('empresa')
        );

        return $next($request);

    }
}
