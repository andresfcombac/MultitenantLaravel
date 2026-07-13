<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCampo extends Model
{
    protected $connection = 'legacy';

    protected $table = 'formulario_campos';

    protected $primaryKey = 'id_campo';

    public $timestamps = false;

    protected $fillable = [

        'id_formulario',
        'etiqueta',
        'tipo_campo',
        'opciones',
        'obligatorio',
        'orden',

    ];

    public function formulario()
    {
        return $this->belongsTo(
            Formulario::class,
            'id_formulario',
            'id_formulario'
        );
    }
}
