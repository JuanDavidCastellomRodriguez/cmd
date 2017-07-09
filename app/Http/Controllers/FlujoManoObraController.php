<?php

namespace App\Http\Controllers;

use App\FlujoManoObra;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FlujoManoObraController extends Controller
{
    //

    public function getFlujoManoObra(Request $request)
    {
        $mano = FlujoManoObra::where('id_info_productivo',$request->idInfo)->orderBy('id_mes')->get();
        $data = new Collection();
        foreach($mano as $m){

          $data->add([
              'id'=> $m->id,
              'actividad_jornal_contratado'=> $m->actividad_jornal_contratado,
              'actividad_jornal_vendido'=> $m->actividad_jornal_vendido,
              'id_info_productivo'=> $m->id_info_productivo,
              'id_mes'=> $m->id_mes,
              'jornal_contratado'=> $m->jornal_contratado,
              'jornal_vendido'=> $m->jornal_vendido,
              'mes' => $m->Mes->mes,

          ]);


        }

        return response()->json([
            'estado' => 'ok',
            'data' => $data,


        ]);
    }

    public function guardarFlujoManoObra(Request $request){

        try{
        $request =  json_decode($request->getContent());
        //return $request->mano->id_mes;
            $manoExiste = FlujoManoObra::where('id_mes',$request->mano->id_mes)->where('id_info_productivo',$request->mano->id_info_productivo)->get();
            //return $manoExiste->isEmpty();
            if($manoExiste->isEmpty()){
                $mano = new FlujoManoObra();
                $mano->actividad_jornal_contratado = $request->mano->actividad_jornal_contratado;
                $mano->actividad_jornal_vendido = $request->mano->actividad_jornal_vendido;
                $mano->id_mes = $request->mano->id_mes;
                $mano->jornal_contratado = $request->mano->jornal_contratado;
                $mano->jornal_vendido = $request->mano->jornal_vendido;
                $mano->id_info_productivo = $request->mano->id_info_productivo;
                $mano->save();
                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Mano de Obra creada Correctamente',
                    'id'=>$mano->id,

                ]);
            }else{
                return response()->json([
                   'estado' => 'fail',
                    'error' => 'La mano de obra de este mes ya se encuentra registrada!'
                ]);
            }


        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception,
            ]);
        }
    }

    public function borrarFlujoManoObra(Request $request){
        try{
            $mano = FlujoManoObra::where('id',$request->mes)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Mano de Obra removida correctamente',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
            ]);
        }

    }
}
