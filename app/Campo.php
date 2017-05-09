<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    public function Veredas(){

        return $this->hasMany('App\Vereda','id_campo','id');
    }
    public function VeredasCampo(){
        return $this->belongsToMany('App\Vereda','campos_veredas','id_campo','id_vereda');
    }
}
