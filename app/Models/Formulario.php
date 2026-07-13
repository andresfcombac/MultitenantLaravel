<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $connection = 'legacy';

    protected $table = 'formularios';

    protected $primaryKey = 'id_formulario';

    public $timestamps = false;

    protected $fillable = [

        'nombre_formulario',
        'descripcion',
        'imagen_fondo',
        'id_actividad',
        'estado',
        'creado_por',
        'fecha_crea',

    ];

    public function actividad()
    {
        return $this->belongsTo(
            Actividad::class,
            'id_actividad',
            'id_actividad'
        );
    }

    public function creador()
    {
        return $this->belongsTo(
            Usuario::class,
            'creado_por',
            'id_usuario'
        );
    }

    public function campos()
    {
        return $this->hasMany(
            FormularioCampo::class,
            'id_formulario',
            'id_formulario'
        );
    }

    public function respuestas()
    {
        return $this->hasMany(
            FormularioRespuesta::class,
            'id_formulario',
            'id_formulario'
        );
    }
}
