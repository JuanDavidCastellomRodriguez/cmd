<?php

namespace App\Http\Controllers;

use App\Fase;
use App\FaseVereda;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class FasesController extends Controller
{
    public function getAllFases(){
        $fases = Fase::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $fases,
        ]);
    }

    public function getFasesByOrden(Request $request){
        $fases = Fase::where('id_orden_servicio',$request->id)->get();
        return response()->json([
            'estado' => 'ok',
            'data' => $fases,
        ]);
    }
    public function getPaginateFases(Request $request){
        $fases = Fase::paginate(10);
        foreach ($fases as $fase){
            $veredasFase = $fase->VeredasFase;
            $orden = $fase->Orden;
/*
            $veredas = new Collection();
            foreach ($veredasFase as $vereda){
                $veredas->put('veredas_fase',['id'=>$vereda->id, 'vereda'=>$vereda->vereda]);
            }

            $fase->push($veredas);*/
        }

        return $fases;
    }
    public function index(Request $request){
        return view('fases.index');
    }

    public function guardarFase(Request $request){
        $validador = Validator::make($request->all(),[
            'fecha_fase' => 'required',
            'nombre_fase' => 'required',
            'id_orden_servicio' => 'required'
        ]);
        if($validador->fails()){
            return response()->json([
                'estado' => 'fail',
                'mensaje' => 'Por favor rellene todos los campos',
            ]);
        }else{
            $request =  json_decode($request->getContent());

            if($request->id != ''){
                //actualizar
                try{
                    $fase = Fase::find($request->id);
                    $fase->id_orden_servicio = $request->id_orden_servicio;
                    $fase->nombre_fase = $request->nombre_fase;
                    $fase->observaciones = $request->observaciones;
                    $fase->fecha_fase = $request->fecha_fase;
                    //$fase->id_usuario = Auth::User()->id;
                    $fase->estado = $request->estado;
                    $fase->save();
                    FaseVereda::where('id_fase',$fase->id)->delete();
                    $this->guardarVeredasFase($request->veredas_fase,$fase->id);

                    return response()->json([
                        'estado' => 'ok',
                        //'id' => $fase->id,
                        'editado' => true,
                    ]);
                }catch (\Exception $ee){
                    return response()->json([
                        'estado' => 'fail',
                        'mensaje' => $ee->getMessage(),
                    ]);
                }
            }else{
                //nueva

               try{
                   $fase = new Fase();
                   $fase->id_orden_servicio = $request->id_orden_servicio;
                   $fase->nombre_fase = $request->nombre_fase;
                   $fase->observaciones = $request->observaciones;
                   $fase->fecha_fase = $request->fecha_fase;
                   $fase->id_usuario = Auth::User()->id;
                   $fase->estado = 1;
                   $fase->save();
                   $this->guardarVeredasFase($request->veredas_fase,$fase->id);

                   return response()->json([
                       'estado' => 'ok',
                       'id' => $fase->id,
                       'editado' => false,
                   ]);
               }catch (\Exception $ee){
                   return response()->json([
                       'estado' => 'fail',
                       'mensaje' => $ee->getMessage(),
                   ]);
               }


            }
        }
    }

    public function guardarVeredasFase($veredas, $idFase){

        ksort($veredas);
        $anterior = '';
        $actual = '';


        foreach ($veredas as $vereda){
            if($vereda !=  $anterior){
                $fv = new FaseVereda();
                $fv->id_fase = $idFase;
                $fv->id_vereda = $vereda->id;
                $fv->save();
            }
            $anterior  = $vereda;

        }
    }


}
