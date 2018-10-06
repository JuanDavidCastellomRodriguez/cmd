<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementosSanitariosInstalado extends Model
{
    public function ElementosSanitario(){
        return $this->belongsTo('App\ElementosSanitario','id_elementos_sanitarios','id');
    }
}
