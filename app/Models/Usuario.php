<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $connection = 'legacy';

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_usu',
        'num_doc_usu',
        'nombre_usu',
        'apellidos_usu',
        'telefono_usu',
        'correo_usu',
        'pwd',
        'rol_usu',
        'cargo',
        'empresa_usu',
        'ultimo_ingreso',
        'fecha_crea',
        'fecha_up',
        'fecha_del'
    ];

    protected $hidden = [
        'pwd'
    ];

    public function getAuthPassword()
    {
        return $this->pwd;
    }

    public function getAuthIdentifierName()
    {
        return 'correo_usu';
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_usu', 'id_rol');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_usu', 'id_empresa');
    }
}