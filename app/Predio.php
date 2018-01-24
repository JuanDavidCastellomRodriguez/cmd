<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predio extends Model
{

    public function Vereda(){
        return $this->hasOne('App\Vereda','id','id_vereda');
    }

    public function InformacionVivienda(){
        return $this->hasOne('App\InformacionVivienda','id','id_predio');
    }



}
