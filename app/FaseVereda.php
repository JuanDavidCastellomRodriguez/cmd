<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaseVereda extends Model
{

    public function Vereda(){
        return $this->hasOne('App\Vereda','id','id_vereda');
    }
}
