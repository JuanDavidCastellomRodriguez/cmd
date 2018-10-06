<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiciosPublico extends Model
{
    public function Comunicaciones(){

        return $this->hasMany('App\Comunicaciones','id_servicios_publicos','id');
    }

    public function FuentesAgua(){
        return $this->hasOne('App\FuentesAgua','id','id_fuente_agua');
    }

    public function SistemaEliminacionAguasGrise(){
        return $this->hasOne('App\SistemaEliminacionAguasGrise','id','id_sistemas_tratamiento_aguas');
    }

    public function MetodosDisposicionBasura(){
        return $this->hasOne('App\MetodosDisposicionBasura','id','id_metodo_disposicion_basura');
    }

    public function Gas(){
        return $this->hasOne('App\Gas','id','id_gas');
    }

    public function FuenteEnergiaElectrica(){
        return $this->hasOne('App\FuenteEnergiaElectrica','id','id_fuente_energia_electrica');
    }
}
