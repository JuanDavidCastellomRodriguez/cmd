<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionPece extends Model
{
    //
    public function TipoProduccion(){
        return $this->hasOne('App\TipoProduccione','id','id_tipo_produccion');
    }
    public function EspeciePeces(){
        return $this->hasOne('App\EspeciePece','id','id_especie');
    }

}
