<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'legacy';

    protected $table = 'roles';

    protected $primaryKey = 'id_rol';

    public $timestamps = false;

    protected $fillable = [
        'nombre_rol',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_usu', 'id_rol');
    }
}
