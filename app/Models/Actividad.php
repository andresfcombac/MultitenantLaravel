<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $connection = 'legacy';

    protected $table = 'actividades';

    protected $primaryKey = 'id_actividad';

    public $timestamps = false;

    protected $fillable = [
        'nombre_actividad',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(
            Empresa::class,
            'empresa_id',
            'id_empresa'
        );
    }

    public function formularios()
    {
        return $this->hasMany(
            Formulario::class,
            'id_actividad',
            'id_actividad'
        );
    }
}
