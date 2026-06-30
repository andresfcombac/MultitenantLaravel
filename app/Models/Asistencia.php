<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $connection = 'legacy';

    protected $table = 'asistencias';

    protected $primaryKey = 'id_asistencia';

    public $timestamps = false;

    protected $fillable = [

        'id_respuesta',
        'confirmado_por',
        'fecha_confirmacion'

    ];

    public function respuesta()
    {
        return $this->belongsTo(
            FormularioRespuesta::class,
            'id_respuesta',
            'id_respuesta'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'confirmado_por',
            'id_usuario'
        );
    }
}