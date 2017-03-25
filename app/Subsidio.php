<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidio extends Model
{
    public function Vereda(){

        return $this->hasOne('App\Vereda','id','id_vereda');
    }

    public function Beneficiario(){

        return $this->hasOne('App\Beneficiario','id','id_beneficiario');
    }

    public function InformacionVivienda(){

        return $this->hasOne('App\InformacionVivienda','id','id_info_vivienda');
    }

    public function InformacionProductivos(){

        return $this->hasOne('App\InformacionProductivos','id','id_info_productivo');
    }

    public function TipoSubsidio(){

        return $this->hasOne('App\TipoSubsidio','id','id_tipo_subsidio');
    }

    public function Visitas(){

        return $this->hasMany('App\Visita','id_subsidio','id');
    }

    public function scopeBuscar($query, $data){
        return $query->where('consecutivo','like','%'.$data.'%')
            ->orWhere('fecha_inicio', 'like', '%'.$data.'%')
            ->orWhereHas('Beneficiario',function ($query) use ($data){
                $query->where('nombres', 'like','%'.$data.'%')
                    ->orWhere('apellidos', 'like','%'.$data.'%')
                    ->orWhere('no_cedula', 'like','%'.$data.'%');
            });
    }
}
