<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'numero_documento'

    ];


    protected $casts = [
        'datos' => 'array'
    ];


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
