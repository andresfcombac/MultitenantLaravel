<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $connection = 'legacy';

    protected $table = 'historico';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [

        'nombre',
        'apellidos',
        'cedula',
        'ingreso',
        'salida',
        'id_dato',
        'id_actividad',

    ];
}
