<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{

    public function Subsidios(){
        return $this->hasManyThrough('App\Subsidio','App\Fase','id_orden_servicio', 'id_fase','id');
    }
    public function idVeredas(){
        return $this->hasManyThrough('App\FaseVereda','App\Fase','id_orden_servicio', 'id_fase','id');
    }

}
