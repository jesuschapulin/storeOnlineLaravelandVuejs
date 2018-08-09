<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ususarios extends Model
{
    protected $fillable=['nombre','ap_paterno','ap_materno','email','telefono','nickname','password','id_tipo_usuario','imagen','facebook','twitter','buyer_state'];
}
