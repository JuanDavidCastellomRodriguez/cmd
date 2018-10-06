<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionAve extends Model
{
    //
    public function TipoAve(){
        return $this->hasOne('App\TipoAve','id','id_tipo_aves');
    }
    public function TipoCorral(){
        return $this->hasOne('App\TipoCorrale','id','id_tipo_corral');
    }
    public function TipoProduccionAve(){
        return $this->hasOne('App\TipoProduccionAve','id','id_produccion_aves');
    }
    public function EstadoInstalacion(){
        return $this->hasOne('App\EstadoInstalacione','id','id_estado_instalaciones');
    }
}
