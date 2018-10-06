<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenenciaTierra extends Model
{
    public function TipoTenenciaTierra(){
        return $this->belongsTo('App\TipoTenenciaTierra','id_tipo_tenencia_tierras','id');
    }

    public function OpcionTenenciaTierra(){
        return $this->belongsTo('App\OpcionTenenciaTierra','id_opcion','id');
    }
}
