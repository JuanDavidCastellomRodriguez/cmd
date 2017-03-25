<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public function Departamento(){

        return $this->hasOne('App\Departamento','id','id_departamento');
    }
}
