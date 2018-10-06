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

    public function Subsidio(){
        return $this->belongsTo('App\Subsidio','id','id_info_vivienda');
    }

    public function Habitacione(){
        return $this->belongsTo('App\Habitacione','id','id_informacion');
    }

    public function Cocina(){
        return $this->belongsTo('App\Cocina','id','id_informacion');
    }

    public function UnidadesSanitaria(){
        return $this->belongsTo('App\UnidadesSanitaria','id','id_informacion');
    }

    public function TenenciaTierra(){
        return $this->belongsTo('App\TenenciaTierra','id','id_informacion');
    }

    public function Generalidade(){
        return $this->belongsTo('App\Generalidade','id','id_informacion');
    }

    public function ServiciosPublico(){
        return $this->hasOne('App\ServiciosPublico','id_informacion','id');
    }

    public function Indicadore(){
        return $this->hasOne('App\Indicadore','id_informacion','id');
    }
}