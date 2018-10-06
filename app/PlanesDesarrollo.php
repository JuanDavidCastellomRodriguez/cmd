<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanesDesarrollo extends Model
{
    public function Municipio(){

        return $this->hasOne('App\Municipio','id','id_municipio');
    }

    public function Vereda(){

        return $this->hasOne('App\Vereda','id','id_vereda');
    }

    public function Archivos(){

        return $this->belongsTo('App\ArchivosPlane','id','id_plan');
    }
}
