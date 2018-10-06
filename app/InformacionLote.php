<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformacionLote extends Model
{
    public function SubtipoCobertura(){
        return $this->hasOne('App\SubtipoCobertura','id','id_subtipo_cobertura');
    }

    public function FuentesAgua(){
        return $this->hasOne('App\FuentesAgua','id','id_fuente_hidrica');
    }
}
