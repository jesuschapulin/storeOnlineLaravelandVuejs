<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $fillable = ['nombre', 'precio_unitario','precio_volumen','id_categorias_productos','gramage','imagen','tipo_peso'
    ];
}
