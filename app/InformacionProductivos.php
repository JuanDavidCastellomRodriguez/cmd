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

    public function TenenciaTierra(){
        return $this->belongsTo('App\TenenciaTierra','id','id_productivo');
    }

    public function Predio(){
        return $this->belongsTo('App\Predio','id_predio','id');
    } 

    public function Generalidade(){
        return $this->belongsTo('App\Generalidade','id','id_info_productivo');
    }

    public function FlujoManoObra(){
        return $this->hasMany('App\FlujoManoObra','id_info_productivo', 'id');
    }  

    public function InformacionLote(){
        return $this->hasMany('App\InformacionLote','id_info_productivo', 'id');
    }

    public function FortalecimientoInfraestructura(){
        return $this->hasMany('App\FortalecimientoInfraestructura','id_productivo', 'id');
    }

    public function Cultivo(){
        return $this->hasMany('App\Cultivo','id_info_productivo', 'id');
    }

    public function Bovino(){
        return $this->hasMany('App\Bovino','id_info_productivo', 'id');
    }

    public function RegActividadManejoAnimale(){
        return $this->hasMany('App\RegActividadManejoAnimale','id_info_productivo', 'id');
    }

    public function RegOrdenio(){
        return $this->hasMany('App\RegOrdenio','id_info_productivo', 'id');
    }

    public function ProduccionAve(){
        return $this->hasMany('App\ProduccionAve','id_info_productivo', 'id');
    }

    public function ProduccionCerdo(){
        return $this->hasMany('App\ProduccionCerdo','id_info_productivo', 'id');
    }

    public function ProduccionPece(){
        return $this->hasMany('App\ProduccionPece','id_info_productivo', 'id');
    }

    public function ProduccionEspeciesMenore(){
        return $this->hasMany('App\ProduccionEspeciesMenore','id_info_productivo', 'id');
    }

    public function Fotografias(){
        return $this->hasMany('App\Fotografia','id_productivo','id');
    }
}
