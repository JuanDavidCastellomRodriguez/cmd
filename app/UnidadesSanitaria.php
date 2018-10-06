<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadesSanitaria extends Model
{
    public function Elemento(){

        return $this->hasMany('App\ElementosSanitariosInstalado','id_unidades_sanitarias','id');
    }

    public function EstadosVivienda(){
        return $this->hasOne('App\EstadosVivienda','id','id_estado_vivienda');
    }

    public function TipoMuro(){
        return $this->hasOne('App\TipoMuro','id','id_tipo_muro');
    }

    public function TipoCubierta(){
        return $this->hasOne('App\TipoCubierta','id','id_tipo_cubierta');
    }

    public function TipoPiso(){
        return $this->hasOne('App\TipoPiso','id','id_tipo_piso');
    }

    public function MaterialesVentana(){
        return $this->hasOne('App\MaterialesVentana','id','id_material_ventanas');
    }

    public function MaterialesPuerta(){
        return $this->hasOne('App\MaterialesPuerta','id','id_material_puertas');
    }

    public function MaterialesTanquesElevado(){
        return $this->hasOne('App\MaterialesTanquesElevado','id','id_materiales_tanques_elevados');
    }

    public function MaterialesTanquesLavadero(){
        return $this->hasOne('App\MaterialesTanquesLavadero','id','id_materiales_tanques_lavaderos');
    }

    public function AcabadosTanque(){
        return $this->hasOne('App\AcabadosTanque','id','id_acabados_tanques_lavaderos');
    }

    public function TipoUnidadesSanitaria(){
        return $this->hasOne('App\TipoUnidadesSanitaria','id','id_tipo_unidad_sanitaria');
    }

    


}
