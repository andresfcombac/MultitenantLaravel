<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{

    public function handle(
        Request $request,
        Closure $next
    )
    {

        // SuperAdmin sin empresa
        if(session('rol') == 5){

            return $next($request);

        }


        // Usuarios normales necesitan empresa

        if (!session()->has('empresa')) {

            return redirect('/login');

        }


        app()->instance(
            'tenant_id',
            session('empresa')
        );


        return $next($request);
    }
}
