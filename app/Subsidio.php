<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidio extends Model
{
    public function Vereda(){

        return $this->hasOne('App\Vereda','id','id_vereda');
    }

    public function Municipio(){

        return $this->hasOne('App\Municipio','id','id_municipio');
    }

    public function OrdenServicio(){

        return $this->hasOne('App\OrdenServicio','id','id_orden');
    }

    public function Fase(){

        return $this->hasOne('App\Fase','id','id_fase');
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
        return $query->where('consecutivo','like',(int)$data.'%')
            ->orWhere('fecha_inicio', 'like', '%'.$data.'%')
            ->orWhereHas('Beneficiario',function ($query) use ($data){
                $query->where('nombres', 'like','%'.$data.'%')
                    ->orWhere('apellidos', 'like','%'.$data.'%')
                    ->orWhere('no_cedula', 'like','%'.$data.'%');
            })->orWhereHas('Fase',function ($query) use ($data){
               $query->where('nombre_fase','like','%'.$data.'%');
            })->orWhereHas('OrdenServicio',function ($query) use ($data){
                $query->where('consecutivo','like','%'.$data.'%');
             })->orWhereHas('Municipio',function ($query) use ($data){
                $query->where('municipio','like','%'.$data.'%');
             })->orWhereHas('Vereda',function ($query) use ($data){
                $query->where('vereda','like','%'.$data.'%');
             })->orWhereHas('Vereda',function ($query) use ($data){
                $query->where('vereda','like','%'.$data.'%')
                ->orWhere('id_campo', 'like','%'.$data.'%');
             });
    }
    public function Campos(){
        return $this->hasManyThrough('App\Campo','App\Vereda','id_subsidio', 'id_campo','id');
    }




    public function Predios(){
        //return $this->hasManyThrough('App\InformacionVivienda', 'App\Predio', 'id', 'id_predio', 'id');
        //return $this->hasOne('App\InformacionVivienda', 'id_predio', 'id');
        //return $this->hasOne('App\Predio', 'id_vereda', 'id');
    }

    public function picture()
    {
        return $this->hasMany('App\picture','id_subsidio','id');
    }
}
