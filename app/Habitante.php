<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitante extends Model
{
    public function HabitantesViviendas(){
        return $this->belongsToMany('App\HabitantesViviendas','habitantes_viviendas','id_informacion','id_habitante');
    }
    public function EstadoCivil(){
        return $this->hasOne('App\EstadosCivile','id','id_estado_civil');
    }

    public function NivelEducativo(){

        return $this->hasOne('App\NivelEducativo', 'id', 'id_nivel_educativo');
    }
}
