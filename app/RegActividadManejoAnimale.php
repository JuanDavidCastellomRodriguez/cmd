<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegActividadManejoAnimale extends Model
{
    //
    public function ActividadManejo(){
        return $this->hasOne('App\ActividadManejoAnimale','id','id_actividad_manejo');
    }
}
