<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    public function UnidadProducto(){
        return $this->hasOne('App\UnidadProducto','id','id_unidad_producto');
    }

    public function SitioVenta(){
        return $this->hasOne('App\SitioVenta','id','id_sitio_venta');
    }
}
