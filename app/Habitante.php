<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitante extends Model
{
    public function HabitantesViviendas(){
        return $this->belongsToMany('App\HabitantesViviendas','habitantes_viviendas','id_informacion','id_habitante');
    }
}
