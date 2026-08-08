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
        ->subject('Confirmación de registro')
        ->view('emails.registro-formulario');

    $rutaQr = 'qr/' . $this->respuesta->qr_token . '.png';

    if (Storage::disk('public')->exists($rutaQr)) {

        $rutaCompleta = Storage::disk('public')->path($rutaQr);

        $mail->with([
            'qrPath' => $rutaCompleta,
        ]);

        $mail->withSymfonyMessage(function ($message) use ($rutaCompleta) {

            $message->embedFromPath(
                $rutaCompleta,
                'qr-code',
                'image/png'
            );

        });

        $mail->attach(
            $rutaCompleta,
            [
                'as' => 'QR-' . $this->respuesta->numero_documento . '.png',
                'mime' => 'image/png',
            ]
        );
    }

    return $mail;
}
}