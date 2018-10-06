<?php

namespace App\Http\Controllers;

use App\Comunicaciones;
use App\ServiciosPublico;
use App\Subsidio;
use App\InformacionVivienda;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ServiciosPublicosController extends Controller
{
    public function getAllServicios(Request $request){
        try{
            $servicio = ServiciosPublico::where('id_informacion', $request->idInfo)->first();
            $data = "";
            if(!Empty($servicio)){

                $listas = "";//$servicio->Comunicaciones->pluck('id_medio_comunicacion');
                $data =[
                    'id'=> $servicio->id,
                    "comunicaciones" => $servicio->Comunicaciones->pluck('id_medio_comunicacion'),
                    'id_informacion' => $servicio->id_informacion,
                    'id_fuente_agua' => $servicio->id_fuente_agua,
                    'tratamiento_agua' => $servicio->tratamiento_agua,
                    'id_sistemas_tratamiento_aguas' => $servicio->id_sistemas_tratamiento_aguas,
                    'id_metodo_disposicion_basura' => $servicio->id_metodo_disposicion_basura,
                    'id_gas' => $servicio->id_gas,
                    'id_fuente_energia_electrica' => $servicio->id_fuente_energia_electrica,
                ];
                $bandera = 0;
                $info= '';
            }else{
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_vivienda', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
                $info = InformacionVivienda::where('id', $subsidio->id_info_vivienda)->first();
                $servicio = ServiciosPublico::where('id_informacion', $info->id)->first();
                $bandera = 1;
                $data =[
                    'id'=> $servicio->id,
                    "comunicaciones" => $servicio->Comunicaciones->pluck('id_medio_comunicacion'),
                    'id_informacion' => $servicio->id_informacion,
                    'id_fuente_agua' => $servicio->id_fuente_agua,
                    'tratamiento_agua' => $servicio->tratamiento_agua,
                    'id_sistemas_tratamiento_aguas' => $servicio->id_sistemas_tratamiento_aguas,
                    'id_metodo_disposicion_basura' => $servicio->id_metodo_disposicion_basura,
                    'id_gas' => $servicio->id_gas,
                    'id_fuente_energia_electrica' => $servicio->id_fuente_energia_electrica,
                ];
            }
            //return $servicios->Comunicaciones;
            return response()->json([
                'estado' => 'ok',
                'data' =>$data,
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

    public function guardarServicios(Request $request){
        $request =  json_decode($request->getContent());
        //dd($request);

            if($request->id != ''){
                $servicio = ServiciosPublico::find($request->id);
                $servicio->id_fuente_agua = $request->id_fuente_agua;
                $servicio->tratamiento_agua = $request->tratamiento_agua;
                $servicio->id_sistemas_tratamiento_aguas = $request->id_sistemas_tratamiento_aguas;
                $servicio->id_metodo_disposicion_basura = $request->id_metodo_disposicion_basura;
                $servicio->id_gas = $request->id_gas;
                $servicio->id_fuente_energia_electrica = $request->id_fuente_energia_electrica;
                $servicio->save();

                Comunicaciones::where('id_servicios_publicos', $request->id)->delete();
                foreach ($request->comunicaciones as $com){
                    $comunicacion = new Comunicaciones();
                    $comunicacion->id_medio_comunicacion = $com;
                    $comunicacion->id_servicios_publicos = $servicio->id;
                    $comunicacion->save();
                }
                return response()->json([
                    'estado' => 'ok',
                    'edit' => true,

                ]);

            }else{
                $servicio = new ServiciosPublico();
                $servicio->id_fuente_agua = $request->id_fuente_agua;
                $servicio->id_informacion = $request->id_informacion;
                $servicio->tratamiento_agua = $request->tratamiento_agua;
                $servicio->id_sistemas_tratamiento_aguas = $request->id_sistemas_tratamiento_aguas;
                $servicio->id_metodo_disposicion_basura = $request->id_metodo_disposicion_basura;
                $servicio->id_gas = $request->id_gas;
                $servicio->id_fuente_energia_electrica = $request->id_fuente_energia_electrica;
                $servicio->save();

                foreach ($request->comunicaciones as $com){
                    $comunicacion = new Comunicaciones();
                    $comunicacion->id_medio_comunicacion = $com;
                    $comunicacion->id_servicios_publicos = $servicio->id;
                    $comunicacion->save();
                }
                return response()->json([
                    'estado' => 'ok',
                    'edit' => false,
                    'id' => $servicio->id,

                ]);
            }


    }
}
