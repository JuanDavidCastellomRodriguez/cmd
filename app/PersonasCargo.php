<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonasCargo extends Model
{
    public function Genero(){

        return $this->hasOne('App\Genero','id','id_genero');
    }

    public function NivelEducativo(){

        return $this->hasOne('App\NivelEducativo','id','id_nivel_educativo');
    }

    public function TipoPersonasCargo(){

        return $this->hasOne('App\TipoPersonasCargo','id','id_tipo');
    }
}
