<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos_listas extends Model
{
    protected $fillable=['id_inventario','cantidad','total','id_lista'];
}
