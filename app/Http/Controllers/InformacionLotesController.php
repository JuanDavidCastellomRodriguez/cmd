<?php

namespace App\Http\Controllers;

use App\InformacionLote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InformacionLotesController extends Controller
{
    public function getPotreros(Request $request){
        $potreros = InformacionLote::where('id_info_productivo',$request->idInfo)->get();
        return response()->json([
            'estado' => 'ok',
            'data' => $potreros,


        ]);
    }

    public function guardarPotrero(Request $request){
        try{
            $request =  json_decode($request->getContent());

            $potrero = new InformacionLote();
            $potrero->potrero_lote = $request->potrero->potrero_lote;
            $potrero->extension_has = $request->potrero->extension_has;
            $potrero->rotacional_dias_descanso = $request->potrero->rotacional_dias_descanso;
            $potrero->rotacional_dias_ocupacion = $request->potrero->rotacional_dias_ocupacion;
            $potrero->id_info_productivo = $request->potrero->id_info_productivo;
            $potrero->id_subtipo_cobertura = $request->potrero->id_subtipo_cobertura;
            $potrero->id_fuente_hidrica = $request->potrero->id_fuente_hidrica;
            $potrero->uso = $request->potrero->uso;
            $potrero->save();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Potrero creado Correctamente',
                'id'=>$potrero->id,

            ]);




        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception,
            ]);
        }
    }

    public function borrarPotrero(Request $request){
        try{
            $potrero = InformacionLote::where('id',$request->potrero)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Potrero borrado correctamente',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
            ]);
        }
    }


}
