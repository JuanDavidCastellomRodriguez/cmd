<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bovino extends Model
{
    public function Raza(){
        return $this->hasOne('App\Raza','id','id_raza');
    }

    public function TipoBovino(){
        return $this->hasOne('App\TipoBovino','id','id_tipo_bovino');
    }

    public function TipoPropiedad(){
        return $this->hasOne('App\TipoPropiedade','id','id_tipo_propiedad');
    }
}
