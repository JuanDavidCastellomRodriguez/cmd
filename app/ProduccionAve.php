<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionAve extends Model
{
    //
    public function TipoAve(){
        return $this->hasOne('App\TipoAve','id','id_tipo_ave');
    }
    public function TipoCorral(){
        return $this->hasOne('App\TipoCorrale','id','id_tipo_corral');
    }
    public function TipoProduccion(){
        return $this->hasOne('App\TipoProduccione','id','id_tipo_produccione');
    }
    public function EstadoInstalacion(){
        return $this->hasOne('App\EstadoInstalacione','id','id_estado_instalaciones');
    }
}
