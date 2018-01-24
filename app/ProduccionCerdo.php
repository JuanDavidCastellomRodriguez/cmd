<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionCerdo extends Model
{
    //
    public function TipoCorral(){
        return $this->hasOne('App\TipoCorrale','id','id_tipo_corral');
    }
    public function TipoProduccion(){
        return $this->hasOne('App\TipoProduccione','id','id_tipo_produccion');
    }
    public function EstadoInstalacion(){
        return $this->hasOne('App\EstadoInstalacione','id','id_estado_instalaciones');
    }
    public function MetodoReproduccion(){
        return $this->hasOne('App\MetodoReproduccione','id','id_metodo_reproduccion');
    }
}
