<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\FormularioCampo;
use Illuminate\Http\Request;

class FormularioCampoController extends Controller
{
    public function index()
    {

        $consulta = FormularioCampo::with('formulario');

        if (session('rol') != 5) {

            $consulta->whereHas(
                'formulario.actividad',
                function ($q) {
                    $q->where('empresa_id', app('tenant_id'));
                }
            );

        }

        $campos = $consulta->get();

        return view(
            'formulario_campos.index',
            compact('campos')
        );

    }

    public function camposFormulario($id)
    {

        $formulario = Formulario::with('actividad')->findOrFail($id);

        if (session('rol') != 5 && $formulario->actividad->empresa_id != app('tenant_id')) {

            abort(403, 'Acceso no autorizado');

        }

        $campos = FormularioCampo::where(
            'id_formulario',
            $id
        )
            ->orderBy('orden')
            ->get();

        return view(
            'formulario_campos.index',
            compact(
                'formulario',
                'campos'
            )
        );

    }

    public function create()
    {

        if (session('rol') == 5) {

            $formularios = Formulario::all();

        } else {

            $formularios = Formulario::whereHas(
                'actividad',
                function ($q) {
                    $q->where('empresa_id', app('tenant_id'));
                }
            )->get();

        }

        return view(
            'formulario_campos.create',
            compact('formularios')
        );

    }

    public function store(Request $request)
    {

        $request->validate([

            'id_formulario' => 'required',
            'etiqueta' => 'required|max:255',
            'tipo_campo' => 'required',
            'opciones' => 'nullable',
            'orden' => 'nullable|integer',

        ]);

        $formulario = Formulario::with('actividad')
            ->findOrFail(
                $request->id_formulario
            );

        // Control tenant
        if (session('rol') != 5) {

            if (
                $formulario->actividad->empresa_id
                != app('tenant_id')
            ) {

                abort(
                    403,
                    'Acceso no autorizado'
                );

            }

        }

        // Convertir opciones a JSON cuando aplique

        $opciones = [];

        if (! empty($request->opciones)) {

            $opciones = array_filter(
                array_map(
                    'trim',
                    explode("\n", $request->opciones)
                )
            );

        }

        FormularioCampo::create([

            'id_formulario' => $request->id_formulario,

            'etiqueta' => $request->etiqueta,

            'tipo_campo' => $request->tipo_campo,

            'opciones' => json_encode($opciones),

            'obligatorio' => $request->obligatorio ?? 0,

            'orden' => $request->orden ?? 0,

        ]);

        return redirect('/formulario-campos')
            ->with(
                'success',
                'Campo creado correctamente'
            );

    }

    public function edit($id)
    {

        $campo = FormularioCampo::findOrFail($id);

        $formularios = Formulario::all();

        return view(
            'formulario_campos.edit',
            compact(
                'campo',
                'formularios'
            )
        );

    }

    public function update(Request $request, $id)
    {

        $campo = FormularioCampo::findOrFail($id);

        $request->validate([

            'etiqueta' => 'required|max:255',
            'tipo_campo' => 'required',

        ]);

        $campo->update([

            'id_formulario' => $request->id_formulario,

            'etiqueta' => $request->etiqueta,

            'tipo_campo' => $request->tipo_campo,

            'opciones' => $request->opciones,

            'obligatorio' => $request->obligatorio ?? 0,

            'orden' => $request->orden ?? 0,

        ]);

        return redirect('/formulario-campos')
            ->with(
                'success',
                'Campo actualizado correctamente'
            );

    }

    public function destroy($id)
    {

        $campo = FormularioCampo::findOrFail($id);

        $campo->delete();

        return redirect('/formulario-campos')
            ->with(
                'success',
                'Campo eliminado correctamente'
            );

    }
}
