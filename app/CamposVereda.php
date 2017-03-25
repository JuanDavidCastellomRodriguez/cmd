<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CamposVereda extends Model
{
    public function Campo(){

        return $this->hasOne('App\Campo','id','id_campo');
    }

    public function Veredas(){

        return $this->hasOne('App\Vereda','id','id_vereda');
    }
}
