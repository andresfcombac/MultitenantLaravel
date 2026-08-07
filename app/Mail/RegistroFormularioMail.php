<?php

namespace App\Mail;

use App\Models\FormularioRespuesta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RegistroFormularioMail extends Mailable
{
    use Queueable, SerializesModels;

    public FormularioRespuesta $respuesta;

    public function __construct(FormularioRespuesta $respuesta)
    {
        $this->respuesta = $respuesta;
    }

    public function build()
{
    $mail = $this
        ->subject('Registro de formulario')
        ->view('emails.registro-formulario');

    $rutaQr = 'qr/'.$this->respuesta->qr_token.'.svg';

    if (Storage::disk('public')->exists($rutaQr)) {

        $mail->attach(
            Storage::disk('public')->path($rutaQr),
            [
                'as' => 'QR-'.$this->respuesta->numero_documento.'.svg',
                'mime' => 'image/svg+xml',
            ]
        );

    }

    return $mail;
}
}