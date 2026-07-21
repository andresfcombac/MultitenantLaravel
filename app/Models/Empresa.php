<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $connection = 'legacy';

    protected $table = 'empresas';

    protected $primaryKey = 'id_empresa';

    public $timestamps = false;

    protected $fillable = [
        'nombre_empresa',
        'url',
        'img',
        'color_corporativo',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'empresa_usu', 'id_empresa');
    }
}
