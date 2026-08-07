<?php

namespace App\Mail;

use App\Models\FormularioRespuesta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionAsistenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    public FormularioRespuesta $respuesta;

    public function __construct(FormularioRespuesta $respuesta)
    {
        $this->respuesta = $respuesta;
    }

    public function build()
    {
        return $this
            ->subject('Confirmación de asistencia')
            ->view('emails.confirmacion-asistencia');
    }
}