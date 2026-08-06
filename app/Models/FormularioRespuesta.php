<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormularioRespuesta extends Model
{
    protected $connection = 'legacy';

    protected $table = 'formulario_respuestas';

    protected $primaryKey = 'id_respuesta';

    public $timestamps = false;

    protected $fillable = [

        'id_formulario',
        'datos',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'tipo_documento',
        'numero_documento',
        'qr_token',

    ];

    protected $casts = [
        'datos' => 'array',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($respuesta) {

        if (empty($respuesta->qr_token)) {

            $respuesta->qr_token = (string) Str::uuid();

        }

    });
}
    public function formulario()
    {
        return $this->belongsTo(
            Formulario::class,
            'id_formulario',
            'id_formulario'
        );
    }

    public function asistencia()
    {
        return $this->hasOne(
            Asistencia::class,
            'id_respuesta',
            'id_respuesta'
        );
    }
}
