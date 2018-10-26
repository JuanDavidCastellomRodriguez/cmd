<?php

namespace App\Http\Controllers;

use App\InformacionLote;
use App\Subsidio;
use App\InformacionProductivos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InformacionLotesController extends Controller
{
    public function getPotreros(Request $request){
        $potreros = InformacionLote::where('id_info_productivo',$request->idInfo)->get();
        $bandera = 0;
        $infoProductivo = '';
        if (count($potreros) == 0) {
            $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
            if ($subsidio != null) {
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $potreros = InformacionLote::where('id_info_productivo',$infoProductivo->id)->get();
                for ($i=0; $i < count($potreros); $i++) { 
                    $potreros[$i]->id = '';
                    $potreros[$i]->id_info_productivo = $request->idInfo;
                }
                $bandera = 1;                           
            } else {
                $infoProductivo = '';
                $potreros = '';
                $bandera = 0;
            }
            
        }
        return response()->json([
            'estado' => 'ok',
            'data' => $potreros,
            'bandera' => $bandera,
            'infoProductivo' => $infoProductivo


        ]);
    }

    public function guardarPotreroAnterior(Request $request)
    {
        try {
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
            $potrero->observaciones = $request->potrero->observaciones;
            $potrero->save();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Potrero creado Correctamente',
                'id'=>$potrero->id,

            ]);            
            
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'fail',
                'error' => $e,
            ]);
        }
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
            $potrero->observaciones = $request->potrero->observaciones;
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
