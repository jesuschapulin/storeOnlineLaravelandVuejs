<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable=['id_producto','cantidad_registro','cantidad_disponible','id_usuario'];
}
