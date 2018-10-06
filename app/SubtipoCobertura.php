<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubtipoCobertura extends Model
{
    public function TipoCobertura(){
        return $this->hasOne('App\TipoCobertura','id','id_tipo_cobertura');
    }
}
