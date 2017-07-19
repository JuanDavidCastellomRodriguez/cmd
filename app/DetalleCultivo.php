<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCultivo extends Model
{
    //
    public function Componente(){
        return $this->hasOne('App\ComponentesCultivo','id','id_componente_cultivo');
    }
}
