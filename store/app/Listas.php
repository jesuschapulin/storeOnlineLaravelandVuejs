<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{
    protected $fillable=['nombre','id_usuario','total','subtotal','estado'];
}
