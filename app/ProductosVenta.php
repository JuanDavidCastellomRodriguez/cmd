<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosVenta extends Model
{
    //
    public function Mes(){
        return $this->hasOne('App\Meses','id','id_mes');
    }
}
