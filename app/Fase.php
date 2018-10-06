<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    public function Vereda(){

        return $this->hasOne('App\Vereda','id','id_vereda');
    }
    public function Veredas(){
        return $this->hasMany('App\Vereda','id','id_vereda');
    }

    public function VeredasFase(){
        return $this->belongsToMany('App\Vereda','fase_veredas','id_fase','id_vereda');
    }

    public function Subsidios(){
        return $this->hasMany('App\Subsidio','id_fase','id');
    }

    public function Orden(){

        return $this->hasOne('App\OrdenServicio','id','id_orden_servicio');
    }
}
