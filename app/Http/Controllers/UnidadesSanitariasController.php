<?php

namespace App\Http\Controllers;

use App\ElementosSanitariosInstalado;
use App\UnidadesSanitaria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UnidadesSanitariasController extends Controller
{
    public function getAllUnidades(Request $request){
        try{
            $unidades = UnidadesSanitaria::where('id_informacion', $request->id)->get();
            $data = new Collection();
            foreach ( $unidades as $u){
                //$list = ElementosSanitariosInstalado::where('id_unidades_sanitarias',$u->id)->get()->pluck('id_elementos_sanitarios');

                $data->push([
                    'elementos' => $u->Elemento->pluck('id'),
                    'id' => $u->id,
                    'estructura_viga' => $u->estructura_viga,
                    'estructura_columna' => $u->estructura_columna,
                    'panete_interno' => $u->panete_interno,
                    'panete_externo' => $u->panete_externo,
                    'estuco' => $u->estuco,
                    'pintura' => $u->pintura,
                    'muros_enchapado' => $u->muros_enchapado,
                    'cantidad_puertas' => $u->cantidad_puertas,
                    'cantidad_ventanas' => $u->cantidad_ventanas,
                    'observaciones' => $u->observaciones,
                    'id_estado_vivienda' => $u->id_estado_vivienda,
                    'id_informacion' => $u->id_informacion,
                    'id_tipo_muro' => $u->id_tipo_muro,
                    'id_tipo_piso' => $u->id_tipo_piso,
                    'id_tipo_cubierta' => $u->id_tipo_cubierta,
                    'id_material_puertas' => $u->id_material_puertas,
                    'id_material_ventanas' => $u->id_material_ventanas,
                    'piso_deteriorado' => $u->piso_deteriorado,
                    'nombre' => $u->nombre,
                    'puertas' => $u->puertas,
                    'ventanas' => $u->ventanas,
                    'id_tipo_unidad_sanitaria' => $u->id_tipo_unidad_sanitaria,
                    'tanque_elevado' => $u->tanque_elevado,
                    'tanque_lavadero' => $u->tanque_lavadero,
                    'id_materiales_tanques_elevados' => $u->id_materiales_tanques_elevados,
                    'id_materiales_tanques_lavaderos' => $u->id_materiales_tanques_lavaderos,
                    'id_acabados_tanques_lavaderos' => $u->id_acabados_tanques_lavaderos,
                ]);


            }

            return response()->json([
                'estado' => 'ok',
                'data' => $data


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }

    }
    public function guardarUnidad(Request $request){
        $request =  json_decode($request->getContent());
        try{
            if($request->unidad->id != ''){
                $unidad = UnidadesSanitaria::find($request->unidad->id);
                $unidad->estructura_viga = $request->unidad->estructura_viga;
                $unidad->estructura_columna = $request->unidad->estructura_columna;
                $unidad->panete_interno = $request->unidad->panete_interno;
                $unidad->panete_externo = $request->unidad->panete_externo;
                $unidad->estuco = $request->unidad->estuco;
                $unidad->pintura = $request->unidad->pintura;
                $unidad->muros_enchapado = $request->unidad->muros_enchapado;
                $unidad->cantidad_puertas = $request->unidad->cantidad_puertas;
                $unidad->cantidad_ventanas = $request->unidad->cantidad_ventanas;
                $unidad->observaciones = $request->unidad->observaciones;
                $unidad->id_estado_vivienda = $request->unidad->id_estado_vivienda;
                $unidad->id_informacion = $request->unidad->id_informacion;
                $unidad->id_tipo_muro = $request->unidad->id_tipo_muro;
                $unidad->id_tipo_piso = $request->unidad->id_tipo_piso;
                $unidad->id_tipo_cubierta = $request->unidad->id_tipo_cubierta;
                $unidad->id_material_puertas = $request->unidad->id_material_puertas;
                $unidad->id_material_ventanas = $request->unidad->id_material_ventanas;
                $unidad->piso_deteriorado = $request->unidad->piso_deteriorado;
                $unidad->nombre = $request->unidad->nombre;
                $unidad->puertas = $request->unidad->puertas;
                $unidad->ventanas = $request->unidad->ventanas;
                $unidad->id_tipo_unidad_sanitaria = $request->unidad->id_tipo_unidad_sanitaria;
                $unidad->tanque_elevado = $request->unidad->tanque_elevado;
                $unidad->tanque_lavadero = $request->unidad->tanque_lavadero;
                $unidad->id_materiales_tanques_elevados = $request->unidad->id_materiales_tanques_elevados;
                $unidad->id_materiales_tanques_lavaderos = $request->unidad->id_materiales_tanques_lavaderos;
                $unidad->id_acabados_tanques_lavaderos = $request->unidad->id_acabados_tanques_lavaderos;

                $elementos = ElementosSanitariosInstalado::where('id_unidades_sanitarias',$unidad->id)->delete();
                foreach ( $request->unidad->elementos as $e){
                    $nuevoElemento = new ElementosSanitariosInstalado();
                    $nuevoElemento->id_elementos_sanitarios = $e;
                    $nuevoElemento->id_unidades_sanitarias = $unidad->id;
                    $nuevoElemento->save();
                }

                $unidad->save();
                return response()->json([
                    'estado' => 'ok',
                    'edicion' => true
                ]);

            }else{
                $unidad = new UnidadesSanitaria();
                $unidad->estructura_viga = $request->unidad->estructura_viga;
                $unidad->estructura_columna = $request->unidad->estructura_columna;
                $unidad->panete_interno = $request->unidad->panete_interno;
                $unidad->panete_externo = $request->unidad->panete_externo;
                $unidad->estuco = $request->unidad->estuco;
                $unidad->pintura = $request->unidad->pintura;
                $unidad->muros_enchapado = $request->unidad->muros_enchapado;
                $unidad->cantidad_puertas = $request->unidad->cantidad_puertas;
                $unidad->cantidad_ventanas = $request->unidad->cantidad_ventanas;
                $unidad->observaciones = $request->unidad->observaciones;
                $unidad->id_estado_vivienda = $request->unidad->id_estado_vivienda;
                $unidad->id_informacion = $request->unidad->id_informacion;
                $unidad->id_tipo_muro = $request->unidad->id_tipo_muro;
                $unidad->id_tipo_piso = $request->unidad->id_tipo_piso;
                $unidad->id_tipo_cubierta = $request->unidad->id_tipo_cubierta;
                $unidad->id_material_puertas = $request->unidad->id_material_puertas;
                $unidad->id_material_ventanas = $request->unidad->id_material_ventanas;
                $unidad->piso_deteriorado = $request->unidad->piso_deteriorado;
                $unidad->nombre = $request->unidad->nombre;
                $unidad->puertas = $request->unidad->puertas;
                $unidad->ventanas = $request->unidad->ventanas;
                $unidad->id_tipo_unidad_sanitaria = $request->unidad->id_tipo_unidad_sanitaria;
                $unidad->tanque_elevado = $request->unidad->tanque_elevado;
                $unidad->tanque_lavadero = $request->unidad->tanque_lavadero;
                $unidad->id_materiales_tanques_elevados = $request->unidad->id_materiales_tanques_elevados;
                $unidad->id_materiales_tanques_lavaderos = $request->unidad->id_materiales_tanques_lavaderos;
                $unidad->id_acabados_tanques_lavaderos = $request->unidad->id_acabados_tanques_lavaderos;
                $unidad->save();

                foreach ( $request->unidad->elementos as $e){
                    $nuevoElemento = new ElementosSanitariosInstalado();
                    $nuevoElemento->id_elementos_sanitarios = $e;
                    $nuevoElemento->id_unidades_sanitarias = $unidad->id;
                    $nuevoElemento->save();
                }

                return response()->json([
                    'estado' => 'ok',
                    'edicion' => false,
                    'id' => $unidad->id,
                ]);
            }

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function eliminarUnidad(Request $request){
        try{
            ElementosSanitariosInstalado::where('id_unidades_sanitarias',$request->id)->delete();
            UnidadesSanitaria::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Borrada Correctamente'
            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }
}
