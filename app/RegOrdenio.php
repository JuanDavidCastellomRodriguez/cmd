<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegOrdenio extends Model
{
    //
    public function FrecuenciaOrdenio(){
        return $this->hasOne('App\FrecuenciaOrdenio','id','id_frecuencia_ordenio');
    }
    public function UnidadOrdenio(){
        return $this->hasOne('App\UnidadesOrdenio','id','id_unidades_ordenio');
    }

}
