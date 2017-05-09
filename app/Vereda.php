<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vereda extends Model
{
    public function Municipio(){

        return $this->hasOne('App\Municipio','id','id_municipio');
    }

    public function CampoVereda(){

        return $this->hasMany('App\CamposVereda','id_vereda','id');
    }

    public function Campo(){

        return $this->hasOne('App\Campo','id','id_campo');
    }


}
