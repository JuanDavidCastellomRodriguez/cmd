<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cocina extends Model
{
    //
    public function EstadosVivienda(){
        return $this->hasOne('App\EstadosVivienda','id','id_estado_vivienda');
    }

    public function TipoMuro(){
        return $this->hasOne('App\TipoMuro','id','id_tipo_muro');
    }

    public function TipoCubierta(){
        return $this->hasOne('App\TipoCubierta','id','id_tipo_cubierta');
    }

    public function TipoPiso(){
        return $this->hasOne('App\TipoPiso','id','id_tipo_piso');
    }

    public function MaterialesVentana(){
        return $this->hasOne('App\MaterialesVentana','id','id_material_ventanas');
    }

    public function MaterialesPuerta(){
        return $this->hasOne('App\MaterialesPuerta','id','id_material_puertas');
    }

    public function ElementosCocina(){
        return $this->hasOne('App\ElementosCocina','id','id_elemento_cocina');
    }

    public function TiposMesone(){
        return $this->hasOne('App\TiposMesone','id','id_tipo_meson');
    }


}
