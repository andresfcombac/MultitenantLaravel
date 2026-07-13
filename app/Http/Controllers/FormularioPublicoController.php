<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\FormularioRespuesta;
use Illuminate\Http\Request;

class FormularioPublicoController extends Controller
{
    public function show($id)
    {

        $formulario = Formulario::with('campos')
            ->findOrFail($id);

        return view(
            'formularios.publico',
            compact('formulario')
        );

    }

    public function store(Request $request, $id)
    {

        $formulario = Formulario::findOrFail($id);

        $request->validate([
            'nombres' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'correo' => 'required|email|max:150',
            'telefono' => 'nullable|max:20',
            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|max:30',
        ]);

        $datos = $request->except([

            '_token',
            'nombres',
            'apellidos',
            'correo',
            'telefono',
            'tipo_documento',
            'numero_documento',

        ]);

        FormularioRespuesta::create([

            'id_formulario' => $formulario->id_formulario,

            'datos' => $datos,

            'nombres' => $request->nombres,

            'apellidos' => $request->apellidos,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'tipo_documento' => $request->tipo_documento,

            'numero_documento' => $request->numero_documento,

        ]);

        return back()->with(
            'success',
            'Respuesta enviada correctamente'
        );

    }
}
