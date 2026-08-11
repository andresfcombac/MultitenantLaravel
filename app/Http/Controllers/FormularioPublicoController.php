<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Formulario;
use App\Models\FormularioRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistroFormularioMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FormularioPublicoController extends Controller
{
    public function show($id)
    {

        $formulario = Formulario::with('campos')
            ->findOrFail($id);

        if ($formulario->estado == 0) {

            abort(404);

        }

        return view(
            'formularios.publico',
            compact('formulario')
        );

    }

    public function store(Request $request, $id)
    {

        $formulario = Formulario::with('campos')
            ->findOrFail($id);

        // No permitir responder formularios inactivos (mismo control
        // que ya existe en FormularioController::responder).
        if ($formulario->estado == 0) {

            return back()->with(
                'warning',
                'Este formulario ya no está disponible para recibir respuestas.'
            );

        }

        $request->validate([
            'nombres' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'correo' => 'required|email|max:150',
            'telefono' => 'nullable|max:20',
            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|max:30',
        ]);

        // Construir "datos" únicamente a partir de los campos reales
        // del formulario (no de todo lo que llegue en el request), para
        // no permitir inyectar claves/valores arbitrarios en el JSON.
        $datos = [];

        foreach ($formulario->campos as $campo) {

            $valor = $request->input($campo->etiqueta);

            if (is_array($valor)) {
                $valor = implode(', ', $valor);
            }

            $datos[$campo->etiqueta] = $valor;

        }

        $respuesta = FormularioRespuesta::create([

            'id_formulario' => $formulario->id_formulario,

            'datos' => $datos,

            'nombres' => $request->nombres,

            'apellidos' => $request->apellidos,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'tipo_documento' => $request->tipo_documento,

            'numero_documento' => $request->numero_documento,

        ]);

        // Mantener consistencia con FormularioController::responder,
        // que sí crea el registro de asistencia asociado.
        Asistencia::create([

            'id_respuesta' => $respuesta->id_respuesta,

            'estado_asistencia' => 'pendiente',

        ]);

        /*
        |----------------------------------------------------------------
        | Generar imagen QR del registro
        | (mismo criterio que FormularioController::responder; antes
        | esto solo ocurría en el flujo interno autenticado y el
        | formulario público nunca generaba el QR).
        |----------------------------------------------------------------
        */

        $baseUrl = rtrim(
            env('QR_BASE_URL', config('app.url')),
            '/'
        );

        $contenidoQr = $baseUrl.'/validador/'.$respuesta->qr_token;

        $qr = QrCode::format('png')
            ->size(400)
            ->margin(2)
            ->generate($contenidoQr);

        Storage::disk('public')->put(
            'qr/'.$respuesta->qr_token.'.png',
            $qr
        );

if (! empty($respuesta->correo)) {
 Log::info('RegistroFormularioMail', [
    'id_respuesta' => $respuesta->id_respuesta,
    'correo' => $respuesta->correo,
]);
    try {

        Mail::to($respuesta->correo)
            ->send(
                new RegistroFormularioMail($respuesta)
            );
        
    } catch (\Throwable $e) {

        \Log::error('Error enviando correo de registro', [
            'mensaje' => $e->getMessage(),
            'archivo' => $e->getFile(),
            'linea' => $e->getLine(),
        ]);

    }

}
        return back()->with(
            'success',
            'Respuesta enviada correctamente'
        );

    }
}
