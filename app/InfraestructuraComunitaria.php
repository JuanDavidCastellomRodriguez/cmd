<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfraestructuraComunitaria extends Model
{
    public function Municipio(){
        return $this->hasOne('App\Municipio','id','id_municipio');
    }

    public function Vereda(){
        return $this->hasOne('App\Vereda','id','id_vereda');
    }

    public function OrdenServicio(){
        return $this->hasOne('App\OrdenServicio','id','id_orden');
    }
}
