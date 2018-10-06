<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generalidade extends Model
{
    public function TipologiasFamilia(){
        return $this->hasOne('App\TipologiasFamilia','id','id_tipologia_familia');
    }

    public function TiposVehiculo(){
        return $this->hasOne('App\TiposVehiculo','id','id_tipo_vehiculo');
    }

    public function TiposViasAcceso(){
        return $this->hasOne('App\TiposViasAcceso','id','id_tipo_via_acceso');
    }

    public function EstadosVia(){
        return $this->hasOne('App\EstadosVia','id','id_estado_via');
    }

    public function TiemposRecorrido(){
        return $this->hasOne('App\TiemposRecorrido','id','id_tiempo_recorrido');
    }

    public function TipoSubsidio(){
        return $this->hasOne('App\TipoSubsidio','id','relacion_otro');
    }

    public function TipoProyecto(){
        return $this->hasOne('App\TipoProyecto','id','id_tipo_proyecto');
    }
}
