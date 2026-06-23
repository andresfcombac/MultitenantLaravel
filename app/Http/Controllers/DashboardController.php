<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index()
    {

        if (!session()->has('usuario_id')) {

            return redirect('/login');

        }


        if(session('rol') == 5){

            $usuario = Usuario::with(
                'rol',
                'empresa'
            )
            ->findOrFail(
                session('usuario_id')
            );


        }else{


            $usuario = Usuario::with(
                'rol',
                'empresa'
            )
            ->where(
                'empresa_usu',
                app('tenant_id')
            )
            ->findOrFail(
                session('usuario_id')
            );


        }


        return view(
            'dashboard',
            compact('usuario')
        );

    }
}