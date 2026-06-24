<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        $consulta = Actividad::with('empresa');

        if (session('rol') != 5) {

            $consulta->where(
                'empresa_id',
                app('tenant_id')
            );

        }

        $actividades = $consulta->get();

        return view(
            'actividades.index',
            compact('actividades')
        );
    }

    public function create()
    {
        $empresas = Empresa::all();

        return view(
            'actividades.create',
            compact('empresas')
        );
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
