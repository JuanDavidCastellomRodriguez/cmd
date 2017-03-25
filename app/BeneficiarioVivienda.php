<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeneficiarioVivienda extends Model
{
    public function InformacionVivienda(){

        return $this->hasOne('App\InformacionVivienda','id','id_informacion');
    }

    public function Beneficiarios(){

        return $this->hasOne('App\Beneficiario', 'id', 'id_beneficiario');
    }
}
