<?php

namespace App\Http\Controllers;

use App\Habitacione;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HabitacionesController extends Controller
{
    public function getAllHabitaciones(Request $request){
        $habitaciones = Habitacione::where('id_informacion', $request->idInfo)->where('id_tipo_visita',$request->tipo_visita)->get()->first();
        /*$data = new Collection();
        foreach ($habitaciones as $item) {
            $data->add([
                'id' => $item->id,
                'estructura_viga' => $item->estructura_viga,
                'estructura_columna' => $item->estructura_columna,
                'panete_interno' => $item->panete_interno,
                'panete_externo' => $item->panete_externo,
                'estuco' => $item->estuco,
                'pintura' => $item->pintura,
                'cantidad_puertas' => $item->cantidad_puertas

            ]);
        }*/

        return response()->json([
            'estado' => 'ok',
            'habitaciones' => $habitaciones
        ]);
    }

    public function guardarHabitacion(Request $request){
        $request =  json_decode($request->getContent());
        try{
            if($request->habitacion->id != ''){
                $habitacion = Habitacione::find($request->habitacion->id);
                $habitacion->estructura_viga = $request->habitacion->estructura_viga;
                $habitacion->estructura_columna = $request->habitacion->estructura_columna;
                $habitacion->panete_interno = $request->habitacion->panete_interno;
                $habitacion->panete_externo = $request->habitacion->panete_externo;
                $habitacion->estuco = $request->habitacion->estuco;
                $habitacion->pintura = $request->habitacion->pintura;
                $habitacion->cantidad_puertas = $request->habitacion->cantidad_puertas;
                $habitacion->cantidad_ventanas = $request->habitacion->cantidad_ventanas;
                $habitacion->observaciones = $request->habitacion->observaciones;
                $habitacion->id_estado_vivienda = $request->habitacion->id_estado_vivienda;
                $habitacion->id_informacion = $request->habitacion->id_informacion;
                $habitacion->id_tipo_muro = $request->habitacion->id_tipo_muro;
                $habitacion->id_tipo_piso = $request->habitacion->id_tipo_piso;
                $habitacion->id_tipo_cubierta = $request->habitacion->id_tipo_cubierta;
                $habitacion->id_material_puertas = $request->habitacion->id_material_puertas;
                $habitacion->id_material_ventanas = $request->habitacion->id_material_ventanas;
                $habitacion->piso_deteriorado = $request->habitacion->piso_deteriorado;
                $habitacion->ventanas = $request->habitacion->ventanas;
                $habitacion->puertas = $request->habitacion->puertas;
                $habitacion->nombre = $request->habitacion->nombre;
                $habitacion->save();

                return response()->json([
                    'estado' => 'ok',
                    'edicion' => true
                ]);
            }else{

                $habitacion = new Habitacione();
                $habitacion->id_tipo_visita = $request->habitacion->id_tipo_visita;
                $habitacion->estructura_viga = $request->habitacion->estructura_viga;
                $habitacion->estructura_columna = $request->habitacion->estructura_columna;
                $habitacion->panete_interno = $request->habitacion->panete_interno;
                $habitacion->panete_externo = $request->habitacion->panete_externo;
                $habitacion->estuco = $request->habitacion->estuco;
                $habitacion->pintura = $request->habitacion->pintura;
                $habitacion->cantidad_puertas = $request->habitacion->cantidad_puertas;
                $habitacion->cantidad_ventanas = $request->habitacion->cantidad_ventanas;
                $habitacion->observaciones = $request->habitacion->observaciones;
                $habitacion->id_estado_vivienda = $request->habitacion->id_estado_vivienda;
                $habitacion->id_informacion = $request->habitacion->id_informacion;
                $habitacion->id_tipo_muro = $request->habitacion->id_tipo_muro;
                $habitacion->id_tipo_piso = $request->habitacion->id_tipo_piso;
                $habitacion->id_tipo_cubierta = $request->habitacion->id_tipo_cubierta;
                $habitacion->id_material_puertas = $request->habitacion->id_material_puertas;
                $habitacion->id_material_ventanas = $request->habitacion->id_material_ventanas;
                $habitacion->piso_deteriorado = $request->habitacion->piso_deteriorado;
                $habitacion->ventanas = $request->habitacion->ventanas;
                $habitacion->puertas = $request->habitacion->puertas;
                $habitacion->nombre = $request->habitacion->nombre;
                $habitacion->save();
                return response()->json([
                    'estado' => 'ok',
                    'edicion' => false,
                    'id' => $habitacion->id,
                ]);

            }
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }

    }

    public function eliminarHabitacion(Request $request){
        try{
            Habitacione::find($request->id)->delete();
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
