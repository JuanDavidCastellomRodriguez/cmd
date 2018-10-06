<?php

namespace App\Http\Controllers;

use App\Cocina;
use App\Subsidio;
use App\InformacionVivienda;
use Illuminate\Http\Request;

class CocinasController extends Controller
{
    public function getAllCocinas(Request $request){
        try{
            $cocina = Cocina::where('id_informacion', $request->idInfo)->where('id_tipo_visita',$request->tipo_visita)->get()->first();
            if ($cocina === null) {
            $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_vivienda', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
            $info = InformacionVivienda::where('id', $subsidio->id_info_vivienda)->first();
            $cocina = Cocina::where('id_informacion', $info->id)->where('id_tipo_visita',$request->tipo_visita)->get()->first();
            $bandera = 1;
            }else {
                $info = '';
                $bandera = 0;
            }


            return response()->json([
                'estado' => 'ok',
                'cocinas' => $cocina,
                'bandera' => $bandera,
                'infoVivienda' => $info
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function guardarCocina(Request $request){
        $request =  json_decode($request->getContent());
        try{
            if($request->cocina->id != ''){
                $cocina = Cocina::find($request->cocina->id);
                $cocina->estructura_viga = $request->cocina->estructura_viga;
                $cocina->estructura_columna = $request->cocina->estructura_columna;
                $cocina->otra_estructura = $request->cocina->otra_estructura;
                $cocina->descripcion_otra_estructura = $request->cocina->descripcion_otra_estructura;
                $cocina->descripcion_otro_muro = $request->cocina->descripcion_otro_muro;
                $cocina->descripcion_otra_cubierta = $request->cocina->descripcion_otra_cubierta;
                $cocina->descripcion_otro_piso = $request->cocina->descripcion_otro_piso;
                $cocina->descripcion_otra_ventana = $request->cocina->descripcion_otra_ventana;
                $cocina->descripcion_otra_puerta = $request->cocina->descripcion_otra_puerta;
                $cocina->descripcion_otro_material_estufa = $request->cocina->descripcion_otro_material_estufa;
                $cocina->descripcion_otro_material_meson = $request->cocina->descripcion_otro_material_meson;
                $cocina->panete_interno = $request->cocina->panete_interno;
                $cocina->panete_externo = $request->cocina->panete_externo;
                $cocina->estuco = $request->cocina->estuco;
                $cocina->pintura = $request->cocina->pintura;
                $cocina->muros_enchapado = $request->cocina->muros_enchapado;
                $cocina->meson = $request->cocina->meson;
                $cocina->lavaplatos = $request->cocina->lavaplatos;
                $cocina->cantidad_puertas = $request->cocina->cantidad_puertas;
                $cocina->cantidad_ventanas = $request->cocina->cantidad_ventanas;
                $cocina->observaciones = $request->cocina->observaciones;
                $cocina->id_estado_vivienda = $request->cocina->id_estado_vivienda;
                $cocina->id_informacion = $request->cocina->id_informacion;
                $cocina->id_tipo_muro = $request->cocina->id_tipo_muro;
                $cocina->id_tipo_piso = $request->cocina->id_tipo_piso;
                $cocina->id_tipo_cubierta = $request->cocina->id_tipo_cubierta;
                $cocina->id_material_puertas = $request->cocina->id_material_puertas;
                $cocina->id_material_ventanas = $request->cocina->id_material_ventanas;
                $cocina->id_tipo_meson = $request->cocina->id_tipo_meson;
                $cocina->id_elemento_cocina = $request->cocina->id_elemento_cocina;
                $cocina->piso_deteriorado = $request->cocina->piso_deteriorado;
                $cocina->nombre = $request->cocina->nombre;
                $cocina->puertas = $request->cocina->puertas;
                $cocina->puerta_deteriorado = $request->cocina->puerta_deteriorado;
                $cocina->ventanas = $request->cocina->ventanas;
                $cocina->ventana_deteriorado = $request->cocina->ventana_deteriorado;
                $cocina->estufa = $request->cocina->estufa;
                $cocina->id_elemento_cocina = $request->cocina->id_fuente_energia_cocinas;


                $cocina->save();
                return response()->json([
                    'estado' => 'ok',
                    'edicion' => true
                ]);

            }else{
                $cocina = new Cocina();
                $cocina->id_tipo_visita = $request->cocina->id_tipo_visita;
                $cocina->estructura_viga = $request->cocina->estructura_viga;
                $cocina->estructura_columna = $request->cocina->estructura_columna;
                $cocina->otra_estructura = $request->cocina->otra_estructura;
                $cocina->descripcion_otra_estructura = $request->cocina->descripcion_otra_estructura;
                $cocina->descripcion_otro_muro = $request->cocina->descripcion_otro_muro;
                $cocina->descripcion_otra_cubierta = $request->cocina->descripcion_otra_cubierta;
                $cocina->descripcion_otro_piso = $request->cocina->descripcion_otro_piso;
                $cocina->descripcion_otra_ventana = $request->cocina->descripcion_otra_ventana;
                $cocina->descripcion_otra_puerta = $request->cocina->descripcion_otra_puerta;
                $cocina->descripcion_otro_material_estufa = $request->cocina->descripcion_otro_material_estufa;
                $cocina->descripcion_otro_material_meson = $request->cocina->descripcion_otro_material_meson;
                $cocina->panete_interno = $request->cocina->panete_interno;
                $cocina->panete_externo = $request->cocina->panete_externo;
                $cocina->estuco = $request->cocina->estuco;
                $cocina->pintura = $request->cocina->pintura;
                $cocina->muros_enchapado = $request->cocina->muros_enchapado;
                $cocina->meson = $request->cocina->meson;
                $cocina->lavaplatos = $request->cocina->lavaplatos;
                $cocina->cantidad_puertas = $request->cocina->cantidad_puertas;
                $cocina->cantidad_ventanas = $request->cocina->cantidad_ventanas;
                $cocina->observaciones = $request->cocina->observaciones;
                $cocina->id_estado_vivienda = $request->cocina->id_estado_vivienda;
                $cocina->id_informacion = $request->cocina->id_informacion;
                $cocina->id_tipo_muro = $request->cocina->id_tipo_muro;
                $cocina->id_tipo_piso = $request->cocina->id_tipo_piso;
                $cocina->id_tipo_cubierta = $request->cocina->id_tipo_cubierta;
                $cocina->id_material_puertas = $request->cocina->id_material_puertas;
                $cocina->id_material_ventanas = $request->cocina->id_material_ventanas;
                $cocina->id_tipo_meson = $request->cocina->id_tipo_meson;
                $cocina->id_elemento_cocina = $request->cocina->id_elemento_cocina;
                $cocina->piso_deteriorado = $request->cocina->piso_deteriorado;
                $cocina->nombre = $request->cocina->nombre;
                $cocina->puertas = $request->cocina->puertas;
                $cocina->puerta_deteriorado = $request->cocina->puerta_deteriorado;
                $cocina->ventanas = $request->cocina->ventanas;
                $cocina->ventana_deteriorado = $request->cocina->ventana_deteriorado;
                $cocina->estufa = $request->cocina->estufa;
                $cocina->id_elemento_cocina = $request->cocina->id_fuente_energia_cocinas;
                $cocina->save();

                return response()->json([
                    'estado' => 'ok',
                    'edicion' => false,
                    'id' => $cocina->id,
                ]);
            }

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

}
