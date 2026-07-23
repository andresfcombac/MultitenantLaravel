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
// No permitir responder formularios inactivos
if ($formulario->estado == 0) {

    return redirect('/formularios')
        ->with(
            'warning',
            'El formulario está inactivo. Debe activarlo antes de poder diligenciarlo.'
        );

}
        return view(
            'formularios.show',
            compact('formulario')
        );

    }

    public function edit($id)
{

    if (session('rol') == 5) {

    $formulario = Formulario::with('campos')
        ->find($id);

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
    ->find($id);

}

// Validación de acceso al recurso
if (! $formulario) {

    return redirect('/formularios')
        ->with(
            'error',
            'No tiene permisos para visualizar este formulario.'
        );

}

    // No permitir editar formularios inactivos
    if ($formulario->estado == 0) {

        return redirect('/formularios')
            ->with(
                'warning',
                'El formulario está inactivo. Debe activarlo antes de poder editarlo.'
            );

    }

    // Actividades disponibles

    if (session('rol') == 5) {

        $actividades = Actividad::all();

    } else {

        $actividades = Actividad::where(
            'empresa_id',
            app('tenant_id')
        )->get();

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

    $formulario = Formulario::find($id);

} else {

    $formulario = Formulario::whereHas(
        'actividad',
        function ($q) {

            $q->where(
                'empresa_id',
                app('tenant_id')
            );

        }
    )->find($id);

}

// Validación de acceso al recurso
if (! $formulario) {

    return redirect('/formularios')
        ->with(
            'error',
            'No tiene permisos para modificar este formulario.'
        );

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

    $formulario = Formulario::find($id);

} else {

    $formulario = Formulario::whereHas(
        'actividad',
        function ($q) {

            $q->where(
                'empresa_id',
                app('tenant_id')
            );

        }
    )->find($id);

}

// Validación de acceso al recurso
if (! $formulario) {

    return redirect('/formularios')
        ->with(
            'error',
            'No tiene permisos para cambiar el estado de este formulario.'
        );

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
    ->find($id);

// Formulario inexistente
if (! $formulario) {
    abort(404);
}

// Formulario inactivo
if ($formulario->estado == 0) {

    return redirect('/formularios')
        ->with(
            'warning',
            'Este formulario ya no está disponible para recibir respuestas.'
        );

}
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

            'id_formulario' => $formulario->id_formulario,

            'datos' => $datos,

            'nombres' => $request->nombres,

            'apellidos' => $request->apellidos,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'tipo_documento' => $request->tipo_documento,

            'numero_documento' => $request->numero_documento,

        ]);

       return redirect('/formularios')
    ->with(
        'success',
        'Formulario enviado correctamente.'
    );
    }

public function exportar($id)
{
    // SuperAdmin puede exportar cualquier formulario
    if (session('rol') == 5) {

        $formulario = Formulario::find($id);

    } else {

        // Usuarios normales solo pueden exportar formularios de su empresa
        $formulario = Formulario::whereHas(
            'actividad',
            function ($q) {

                $q->where(
                    'empresa_id',
                    app('tenant_id')
                );

            }
        )->find($id);

    }

    // Validación de acceso al recurso
    if (! $formulario) {

        return redirect('/formularios')
            ->with(
                'error',
                'No tiene permisos para exportar las respuestas de este formulario.'
            );

    }

    // Obtener respuestas del formulario validado
    $respuestas = FormularioRespuesta::where(
        'id_formulario',
        $formulario->id_formulario
    )->get();

    // Generar CSV
    $response = new StreamedResponse(function () use ($respuestas) {

        $handle = fopen('php://output', 'w');

        // Encabezados del archivo
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

        // Filas de respuestas
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

    // Nombre del archivo
    $nombre = 'respuestas_formulario_' .
        $formulario->id_formulario .
        '.csv';

    // Headers de descarga
    $response->headers->set(
        'Content-Type',
        'text/csv; charset=UTF-8'
    );

    $response->headers->set(
        'Content-Disposition',
        'attachment; filename="' . $nombre . '"'
    );

    return $response;
}
}
