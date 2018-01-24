<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformacionProductivos extends Model
{
    //
    public function HabitantesViviendas(){
        return $this->belongsToMany('App\Habitante','habitantes_viviendas','id_productivo','id_habitante');
    }

    public function getConsecutivoAttribute($value){
        return str_pad($value, 5, "0", STR_PAD_LEFT);
    }
    public function Subsidio(){
        return $this->belongsTo('App\Subsidio','id','id_info_productivo');
    }
}
