<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunicaciones extends Model
{
    public function MediosComunicaciones(){

        return $this->belongsTo('App\MediosComunicaciones','id_medio_comunicacion','id');
    }
}
