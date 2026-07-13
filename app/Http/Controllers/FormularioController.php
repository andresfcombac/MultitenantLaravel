<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Formulario;
use App\Models\FormularioCampo;
use App\Models\FormularioRespuesta;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormularioController extends Controller
{
    public function index()
    {

        $consulta = Formulario::with(
            'actividad'
        );

        // Control tenant

        if (session('rol') != 5) {

            $consulta->whereHas(
                'actividad',
                function ($q) {

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            );

        }

        $formularios = $consulta->get();

        return view(
            'formularios.index',
            compact('formularios')
        );

    }

    public function create()
    {

        if (session('rol') == 5) {

            $actividades = Actividad::all();

        } else {

            $actividades = Actividad::where(
                'empresa_id',
                app('tenant_id')
            )->get();

        }

        return view(
            'formularios.create',
            compact('actividades')
        );

    }

    public function store(Request $request)
    {

        $request->validate([

            'nombre_formulario' => 'required|max:255',

            'descripcion' => 'nullable',

            'id_actividad' => 'required',

        ]);

        // validar actividad según tenant

        if (session('rol') == 5) {

            $actividad = Actividad::findOrFail(
                $request->id_actividad
            );

        } else {

            $actividad = Actividad::where(
                'empresa_id',
                app('tenant_id')
            )
                ->findOrFail(
                    $request->id_actividad
                );

        }

        $formulario = Formulario::create([

            'nombre_formulario' => $request->nombre_formulario,

            'descripcion' => $request->descripcion,

            'imagen_fondo' => null,

            'id_actividad' => $request->id_actividad,

            'estado' => 1,

            'creado_por' => session('usuario_id'),

        ]);

        /*$campos = json_decode($request->campos_json, true);

        if (is_array($campos)) {

            foreach ($campos as $index => $campo) {

                FormularioCampo::create([

                    'id_formulario' => $formulario->id_formulario,

                    'etiqueta' => $campo['nombre'],

                    'tipo_campo' => $campo['tipo'],

                    'opciones' => '[]',

                    'obligatorio' => !empty($campo['obligatorio']) ? 1 : 0,

                    'orden' => $index

                ]);

            }

        }*/
        if ($request->filled('campos_json')) {

            $campos = json_decode($request->campos_json, true);

            foreach ($campos as $i => $campo) {

                FormularioCampo::create([

                    'id_formulario' => $formulario->id_formulario,

                    'etiqueta' => $campo['nombre'],

                    'tipo_campo' => $campo['tipo'],

                    'opciones' => json_encode($campo['opciones'] ?? []),

                    'obligatorio' => $campo['obligatorio'] ? 1 : 0,

                    'orden' => $i,

                ]);

            }

        }

        return redirect('/formularios')
            ->with(

                'success',

                'Formulario creado correctamente'

            );

    }

    public function show($id)
    {

        if (session('rol') == 5) {

            $formulario = Formulario::with(
                'campos',
                'actividad'
            )
                ->findOrFail($id);

        } else {

            $formulario = Formulario::with(
                'campos',
                'actividad'
            )
                ->whereHas(
                    'actividad',
                    function ($q) {

                        $q->where(
                            'empresa_id',
                            app('tenant_id')
                        );

                    }
                )
                ->findOrFail($id);

        }

        return view(
            'formularios.show',
            compact('formulario')
        );

    }

    public function edit($id)
    {

        if (session('rol') == 5) {

            // $formulario = Formulario::findOrFail($id);
            $formulario = Formulario::with('campos')->findOrFail($id);

        } else {

            $formulario = Formulario::whereHas(
                'actividad',
                function ($q) {

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            )
                ->with('campos')
                ->findOrFail($id);

        }

        // actividades disponibles

        if (session('rol') == 5) {

            $actividades = Actividad::all();

        } else {

            $actividades = Actividad::where(
                'empresa_id',
                app('tenant_id')
            )
                ->get();

        }

        return view(
            'formularios.edit',
            compact(
                'formulario',
                'actividades'
            )
        );

    }

    public function update(Request $request, $id)
    {

        $request->validate([

            'nombre_formulario' => 'required|max:255',

            'descripcion' => 'nullable',

            'id_actividad' => 'required',

        ]);

        if (session('rol') == 5) {

            $formulario = Formulario::findOrFail($id);

        } else {

            $formulario = Formulario::whereHas(
                'actividad',
                function ($q) {

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            )->findOrFail($id);

        }

        $formulario->update([

            'nombre_formulario' => $request->nombre_formulario,

            'descripcion' => $request->descripcion,

            'id_actividad' => $request->id_actividad,

        ]);

        FormularioCampo::where(
            'id_formulario',
            $formulario->id_formulario
        )->delete();

        if ($request->filled('campos_json')) {

            $campos = json_decode($request->campos_json, true);

            foreach ($campos as $i => $campo) {

                FormularioCampo::create([

                    'id_formulario' => $formulario->id_formulario,

                    'etiqueta' => $campo['nombre'],

                    'tipo_campo' => $campo['tipo'],

                    'opciones' => json_encode($campo['opciones'] ?? []),

                    'obligatorio' => $campo['obligatorio'] ? 1 : 0,

                    'orden' => $i,

                ]);

            }

        }

        return redirect('/formularios')

            ->with(
                'success',
                'Formulario actualizado correctamente'
            );

    }

    public function estado($id)
    {

        if (session('rol') == 5) {

            $formulario = Formulario::findOrFail($id);

        } else {

            $formulario = Formulario::whereHas(
                'actividad',
                function ($q) {

                    $q->where(
                        'empresa_id',
                        app('tenant_id')
                    );

                }
            )
                ->findOrFail($id);

        }

        $formulario->update([

            'estado' => $formulario->estado == 1 ? 0 : 1,

        ]);

        return redirect('/formularios')
            ->with(
                'success',
                'Estado actualizado correctamente'
            );

    }

    public function responder(Request $request, $id)
    {
        $formulario = Formulario::with('campos')
            ->findOrFail($id);

        $datos = [];

        foreach ($formulario->campos as $campo) {

            $valor = $request->input($campo->etiqueta);

            // Si es checkbox múltiple
            if (is_array($valor)) {
                $valor = implode(', ', $valor);
            }

            $datos[$campo->etiqueta] = $valor;
        }

        FormularioRespuesta::create([

            'id_formulario' => $id,

            'datos' => $datos,

            'nombres' => $request->nombres,

            'apellidos' => $request->apellidos,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'tipo_documento' => $request->tipo_documento,

            'numero_documento' => $request->numero_documento,

        ]);

        return redirect()
            ->back()
            ->with('success', 'Formulario enviado correctamente.');
    }

    public function exportar($id)
    {
        $formulario = Formulario::findOrFail($id);

        $respuestas = FormularioRespuesta::where(
            'id_formulario',
            $id
        )->get();

        $response = new StreamedResponse(function () use ($respuestas) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Nombres',
                'Apellidos',
                'Correo',
                'Telefono',
                'Tipo Documento',
                'Numero Documento',
                'Fecha',
                'Datos',
            ]);

            foreach ($respuestas as $respuesta) {

                fputcsv($handle, [

                    $respuesta->id_respuesta,
                    $respuesta->nombres,
                    $respuesta->apellidos,
                    $respuesta->correo,
                    $respuesta->telefono,
                    $respuesta->tipo_documento,
                    $respuesta->numero_documento,
                    $respuesta->fecha_respuesta,
                    json_encode(
                        $respuesta->datos,
                        JSON_UNESCAPED_UNICODE
                    ),

                ]);

            }

            fclose($handle);

        });

        $nombre = 'respuestas_formulario_'.$formulario->id_formulario.'.csv';

        $response->headers->set(
            'Content-Type',
            'text/csv'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="'.$nombre.'"'
        );

        return $response;

    }
}
