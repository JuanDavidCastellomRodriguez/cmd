<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformacionVivienda extends Model
{


    public function getConsecutivoAttribute($value){
        return str_pad($value, 5, "0", STR_PAD_LEFT);
    }

    public function HabitantesViviendas(){
        return $this->belongsToMany('App\Habitante','habitantes_viviendas','id_informacion','id_habitante');
    }

    public function BeneficiariosVivienda(){
        return $this->hasMany('App\HabitantesVivienda','id_informacion','id');
    }
    public function Fotografias(){
        return $this->hasMany('App\Fotografia','id_informacion','id');
    }

    public function Predio(){

        return $this->hasOne('App\Predio','id','id_predio');
    }
    public function PersonasCargo(){
        return $this->hasMany('App\PersonasCargo','id_informacion','id');
    }

}
