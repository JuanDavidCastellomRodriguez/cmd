<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiciosPublico extends Model
{
    public function Comunicaciones(){

        return $this->hasMany('App\Comunicaciones','id_servicios_publicos','id');
    }
}
