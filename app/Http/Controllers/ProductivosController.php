<?php

namespace App\Http\Controllers;

use App\Generalidade;
use App\InformacionProductivos;
use App\Predio;
use App\PropietariosPredio;
use App\Subsidio;
use App\TenenciaTierra;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductivosController extends Controller
{

    public function show($id){
        $info = InformacionProductivos::find($id);
        return view('subsidios_productivos.diagnostico.show', compact('info'));
    }

    public function store (Request $request){

        $validador = Validator::make($request->all(),[
            'fechaEncuesta'=>'required',
            'numeroFamiliasVivienda' => 'required | numeric',

        ]);
        if($validador->fails()){
            return response()->json([
                'estado' => 'fail',
                'mensaje' => 'Error al guardar',
                'error' => $validador->getMessageBag()->toArray(),
            ]);

        }else{
            try{
                $last = InformacionProductivos::all()->last();
                if($last == null){
                    $consecutivo = 1;
                }else{
                    $consecutivo = $last->consecutivo + 1;
                }

                $informacion = new InformacionProductivos();
                $informacion->fecha_encuesta = $request->fechaEncuesta;
                $informacion->responde_propietario = $request->respondePropietario;
                $informacion->no_familias_vivienda = $request->numeroFamiliasVivienda;
                $informacion->beficiarios_prog_inv_social = $request->programaSocial;
                $informacion->consecutivo = $consecutivo;
                $informacion->id_usuario = Auth::User()->id;
                $informacion->save();

                $subsidio = Subsidio::find($request->subsidio);
                $subsidio->id_info_productivo = $informacion->id;
                $subsidio->save();
                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Informacion Guardada',
                    'id' => $informacion->id,
                ]);

            }catch (QueryException $ee){
                return response()->json([
                    'estado' => 'fail',
                    'mensaje' => 'Error al guardar',
                    'error' => $ee->getMessage(),
                ]);
            }


        }



    }

    public function getGeneralidades(Request $request){

        try{
            $generalidades = Generalidade::where('id_info_productivo', $request->idInfo)->first();
            return response()->json([
                'estado'=> 'ok',
                'generalidades' => $generalidades,

            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }

    }

    public function guardarGeneralidades(Request $request){
        $request =  json_decode($request->getContent());
        try{
            $idGeneralidades = '';
            if($request->generalidades->id != ''){
                $generalidades = Generalidade::findOrfail($request->generalidades->id);
                $generalidades->fecha_vive_vereda = $request->generalidades->fechaViveVereda;
                $generalidades->fecha_vive_vivienda = $request->generalidades->fechaViveVivienda;
                $generalidades->id_tipo_vehiculo = $request->generalidades->idTipoVehiculo;
                $generalidades->id_tipo_via_acceso = $request->generalidades->idTipoViaAcceso;
                $generalidades->id_estado_via = $request->generalidades->idEstadoVia;
                $generalidades->id_tiempo_recorrido = $request->generalidades->idTiempoRecorrido;
                $generalidades->id_tipologia_familia = $request->generalidades->idTipologiaFamilia;
                $generalidades->id_tipo_proyecto = $request->generalidades->id_tipo_proyecto;
                $generalidades->save();
                $idGeneralidades = $generalidades->id;

                $infoProductivo = InformacionProductivos::findOrFail($request->infoProductivo->id);
                $infoProductivo->fecha_encuesta = $request->infoProductivo->fechaEncuesta;
                $infoProductivo->responde_propietario = $request->infoProductivo->respondePropietario;
                $infoProductivo->no_familias_vivienda = $request->infoProductivo->numeroFamiliasVivienda;
                $infoProductivo->beficiarios_prog_inv_social = $request->infoProductivo->programaSocial;
                $infoProductivo->save();

            }else{
                $generalidades = new Generalidade();
                $generalidades->id_info_productivo = $request->infoProductivo->id;
                $generalidades->fecha_vive_vereda = $request->generalidades->fechaViveVereda;
                $generalidades->fecha_vive_vivienda = $request->generalidades->fechaViveVivienda;
                $generalidades->id_tipo_vehiculo = $request->generalidades->idTipoVehiculo;
                $generalidades->id_tipo_via_acceso = $request->generalidades->idTipoViaAcceso;
                $generalidades->id_estado_via = $request->generalidades->idEstadoVia;
                $generalidades->id_tiempo_recorrido = $request->generalidades->idTiempoRecorrido;
                $generalidades->id_tipologia_familia = $request->generalidades->idTipologiaFamilia;
                $generalidades->id_tipo_proyecto = $request->generalidades->id_tipo_proyecto;
                $generalidades->save();
                $idGeneralidades = $generalidades->id;

                $infoProductivo = InformacionProductivos::findOrFail($request->infoProductivo->id);
                $infoProductivo->fecha_encuesta = $request->infoProductivo->fechaEncuesta;
                $infoProductivo->responde_propietario = $request->infoProductivo->respondePropietario;
                $infoProductivo->no_familias_vivienda = $request->infoProductivo->numeroFamiliasVivienda;
                $infoProductivo->beficiarios_prog_inv_social = $request->infoProductivo->programaSocial;
                $infoProductivo->save();

            }

            return response()->json([
                'estado' =>'ok',
                'mensaje' => 'Informacion guardada correctamente',
                'idGeneralidades' => $idGeneralidades,
            ]);

        }catch (QueryException $ee){
            return response()->json([
                'estado' =>'fail',
                'mensaje' => 'Error al guardar la informacion',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function guardarPredio(Request $request){

        $request =  json_decode($request->getContent());
        $idPredio = '';
        $idPropietario = '';
        $idTenencia = '';
        try{
            if($request->predio->id != ''){
                $predio = Predio::findOrFail($request->predio->id);
                $predio->nombre_predio = $request->predio->nombre;
                $predio->direccion = $request->predio->direccion;
                $predio->latitud = $request->predio->latitud;
                $predio->longitud = $request->predio->longitud;
                //$predio->id_vereda = $request->predio->idVereda;
                $predio->msnm = $request->predio->msnm;
                $predio->save();





                $tenencia = TenenciaTierra::find($request->tenencia->id);
                $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                $tenencia->id_opcion = $request->tenencia->id_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                //if($request->tenencia->pdf){

                //}



                $tenencia->save();

                if($tenencia->id_tipo_tenencia_tierras != 1){
                    $propietario = PropietariosPredio::findOrFail($request->propietario->id);
                    $propietario->no_cedula = $request->propietario->noCedula;
                    $propietario->nombres_propietario = $request->propietario->nombres;
                    $propietario->apellidos_propietario = $request->propietario->apellidos;
                    $propietario->no_telefonico = $request->propietario->telefono;
                    $propietario->id_predio = $predio->id;
                    $propietario->save();


                    $idPropietario  = $propietario->id;

                }
                $idPredio = $predio->id;
                $idTenencia = $tenencia->id;

            }else{
                $predio = new Predio();
                $predio->nombre_predio = $request->predio->nombre;
                $predio->direccion = $request->predio->direccion;
                $predio->latitud = $request->predio->latitud;
                $predio->longitud = $request->predio->longitud;
                //$predio->id_vereda = $request->predio->idVereda;
                $predio->msnm = $request->predio->msnm;
                $predio->save();
                $info = InformacionProductivos::findOrFail($request->idInfo);
                $info->id_predio = $predio->id;
                $info->save();



                $tenencia = new TenenciaTierra();
                $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                //$tenencia->file = base64_encode(file_get_contents(($request->tenencia->file)->getRealPath()));
                $tenencia->id_opcion = $request->tenencia->id_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                $tenencia->id_productivo = $request->tenencia->id_productivo;
                $tenencia->save();

                if($tenencia->id_tipo_tenencia_tierras != 1){
                    $propietario = new PropietariosPredio();
                    $propietario->no_cedula = $request->propietario->noCedula;
                    $propietario->nombres_propietario = $request->propietario->nombres;
                    $propietario->apellidos_propietario = $request->propietario->apellidos;
                    $propietario->no_telefonico = $request->propietario->telefono;
                    $propietario->id_predio = $predio->id;
                    $propietario->save();
                    $idPredio = $predio->id;
                }

                $idPropietario  = $propietario->id;
                $idTenencia = $tenencia->id;

            }
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Guardado Correctamente',
                'id_predio' => $idPredio,
                'id_propietario' => $idPropietario,
                'id_tenencia' => $idTenencia,
            ]);
        }catch (QueryException $ee){
            return response()->json([
                'estado' => 'fail',
                'mensaje' => 'Error al guardar '.$ee->getMessage(),
            ]);
        }


    }
    public function getPredio(Request $request){

        try{
            $predio = Predio::findOrFail($request->idPredio);
            $propietario = PropietariosPredio::find($request->idPredio);
            $tenencia = TenenciaTierra::where('id_productivo',$request->idInfo)->get()->first();
            return response()->json([
                'estado'=> 'ok',
                'predio' => $predio,
                'propietario' => $propietario,
                'tenencia' => $tenencia,

            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }

    }


}
