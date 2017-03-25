<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadesSanitaria extends Model
{
    public function Elemento(){

        return $this->hasMany('App\ElementosSanitariosInstalado','id_unidades_sanitarias','id');
    }
}
