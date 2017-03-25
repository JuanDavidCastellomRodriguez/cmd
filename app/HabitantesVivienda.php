<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HabitantesVivienda extends Model
{
    public function InformacionVivienda(){

        return $this->hasOne('App\InformacionVivienda','id','id_informacion');
    }

    public function Habitantes(){

        return $this->hasOne('App\Habitante', 'id', 'id_habitante');
    }
}
