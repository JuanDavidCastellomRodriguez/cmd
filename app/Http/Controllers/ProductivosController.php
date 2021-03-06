<?php

namespace App\Http\Controllers;

use App\Fotografia;
use App\Generalidade;
use App\InformacionProductivos;
use App\Predio;
use App\ProduccionAve;
use App\ProduccionCerdo;
use App\ProduccionEspeciesMenore;
use App\ProduccionPece;
use App\PropietariosPredio;
use App\Subsidio;
use App\TenenciaTierra;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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
                $informacion->caso_especial = $request->caso_especial;
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
            $bandera = 0;
            $infoProductivo = '';
            if ($generalidades === null) {
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $generalidades = Generalidade::where('id_info_productivo', $infoProductivo->id)->first();
                $bandera = 1;
            }
            
            return response()->json([
                'estado'=> 'ok',
                'generalidades' => $generalidades,
                'bandera' => $bandera,
                'infoProductivo' => $infoProductivo


            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                //'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
                'mensaje'=> 'Error en el servidor ',
            ]);
        }

    }

    /*public function getgeneralidadesAnterior(Request $request)
    {
        try {
            $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
            $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
            $generalidades = Generalidade::where('id_info_productivo', $infoProductivo->id)->first();
            $bandera = 1;
            return response()->json([
                'estado'=> 'ok',
                'generalidades' => $generalidades,
                'infoProductivo' => $infoProductivo->consecutivo,
                'bandera' => $bandera

            ]);
        } catch (Exception $ee) {
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }
    }*/

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
                $tenencia->otra_opcion = $request->tenencia->otra_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                $tenencia->otra_tenencia = $request->tenencia->otra_tenencia;
                //if($request->tenencia->pdf){

                //}



                $tenencia->save();
                if($request->propietario->id != ''){
                    $propietario = PropietariosPredio::findOrFail($request->propietario->id);
                    $propietario->no_cedula = $request->propietario->noCedula;
                    $propietario->nombres_propietario = $request->propietario->nombres;
                    $propietario->apellidos_propietario = $request->propietario->apellidos;
                    $propietario->no_telefonico = $request->propietario->telefono;
                    $propietario->id_predio = $predio->id;
                    $propietario->save();
                }else{
                    $propietario = new PropietariosPredio();
                    $propietario->no_cedula = $request->propietario->noCedula;
                    $propietario->nombres_propietario = $request->propietario->nombres;
                    $propietario->apellidos_propietario = $request->propietario->apellidos;
                    $propietario->no_telefonico = $request->propietario->telefono;
                    $propietario->id_predio = $predio->id;
                    $propietario->save();
                }

                $idPredio = $predio->id;
                $idTenencia = $tenencia->id;
                $idPropietario  = $propietario->id;

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
                $tenencia->otra_opcion = $request->tenencia->otra_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                $tenencia->otra_tenencia = $request->tenencia->otra_tenencia;
                $tenencia->id_productivo = $request->tenencia->id_productivo;
                $tenencia->save();

                $idPropietario  = $request->id;
                $idTenencia = $tenencia->id;

                if($tenencia->id_tipo_tenencia_tierras != 1){
                    $propietario = new PropietariosPredio();
                    $propietario->no_cedula = $request->propietario->noCedula;
                    $propietario->nombres_propietario = $request->propietario->nombres;
                    $propietario->apellidos_propietario = $request->propietario->apellidos;
                    $propietario->no_telefonico = $request->propietario->telefono;
                    $propietario->id_predio = $predio->id;
                    $propietario->save();
                    $idPredio = $predio->id;

                    $idPropietario  = $propietario->id;
                    $idTenencia = $tenencia->id;
                }


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
                'mensaje' => 'Error al guardar ',
                //'mensaje' => 'Error al guardar '.$ee->getMessage(),
            ]);
        }


    }
    public function getPredio(Request $request){

        try{
            $predio = Predio::findOrFail($request->idPredio);
            $propietario = PropietariosPredio::where('id_predio',$request->idPredio)->first();
            $tenencia = TenenciaTierra::where('id_productivo',$request->idInfo)->get()->first();
            $bandera = 0;
            $infoProductivo = '';
            return response()->json([
                'estado'=> 'ok',
                'predio' => $predio,
                'propietario' => $propietario,
                'tenencia' => $tenencia,
                'bandera' => $bandera,
                'infoProductivo' => $infoProductivo

            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }

    }

    public function predioAnterior(Request $request)
    {
        try {
            $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
            $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
            $predio = Predio::where('id', $infoProductivo->id_predio)->first();
            $propietario = PropietariosPredio::where('id_predio', $predio->id)->first();
            $tenencia = TenenciaTierra::where('id_productivo', $infoProductivo->id)->first();
            $bandera = 1;
            return response()->json([
                'estado'=> 'ok',
                'predio' => $predio,
                'propietario' => $propietario,
                'tenencia' => $tenencia,
                'bandera' => $bandera,
                'infoProductivo' => $infoProductivo->consecutivo

            ]);
        } catch (Exception $ee) {
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }
    }

    public function agregarFotos(Request $request){
        $request =  json_decode($request->getContent());
        $fotos = new Collection();
        foreach($request->images as $img){
            $imageData = $img;
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->save(public_path('/img/productivos/diagnostico/').$fileName, 60);
            $foto = new Fotografia();
            $foto->ruta = '/img/productivos/diagnostico/'.$fileName;
            $foto->tipo = 2;
            $foto->id_productivo = $request->id;
            $foto->save();
            $fotos->add($foto);
            //return response()->json(['error'=>false]);
        }
        return response([
            'estado' => 'ok',
            'fotos' => $fotos

        ]);

    }

    public function getInfoCierre(Request $request){
        try{
            $fotos = Fotografia::where('id_productivo', $request->id)->where('tipo', $request->tipo)->get();
            /*$data = [];
            foreach ($fotos as $foto){
                array_push($data,[public_path($foto)]);
            }

*/
            $obs = InformacionProductivos::find($request->id)->observaciones_proyecto;
            $caso = Subsidio::where('id_info_productivo', $request->id)
                                ->where('id_tipo_subsidio', 2)
                                ->firstOrFail();

            return response()->json([
                'estado' => 'ok',
                'data' => $fotos,
                'obs' => $obs,
                'caso' => $caso->caso_especial == 1 ? true : false,
                'razon' => $caso->razon_especial,
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }


    }

    public function SaveCierre(Request $request){
        try{
            $productivo = InformacionProductivos::find($request->id);
            $productivo->observaciones_proyecto = $request->obs;
            $productivo->save();

            Subsidio::where('id_info_productivo', $request->id)
                    ->where('id_tipo_subsidio', 2)
                    ->update([
                        'caso_especial' => $request->caso,
                        'razon_especial' => $request->razon,
                    ]);

            return response()->json([
                'estado' => 'ok',

            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }
    }

    public function todasImagenes(Request $request){
        try{
            $fotos = Fotografia::where('id_productivo', $request->id)->where('tipo', $request->tipo)->get();
            /*$data = [];
            foreach ($fotos as $foto){
                array_push($data,[public_path($foto)]);
            }
*/
            return response()->json([
                'estado' => 'ok',
                'data' => $fotos
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }


    }

    public function borrarImagen(Request $request){

        try{
            Fotografia::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',

            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }
    }

    public function getDataOtrasEspecies(Request $request){

        try{
            //$fotos = Fotografia::where('id_productivo', $request->id)->where('tipo', $request->tipo)->get();
            /*$data = [];
            foreach ($fotos as $foto){
                array_push($data,[public_path($foto)]);
            }
*/          
            $aves = ProduccionAve::where('id_info_productivo',$request->idInfo)->with(['TipoAve','TipoCorral','TipoProduccionAve','EstadoInstalacion'])->get();
            $banderaA = 0;
            $infoProductivo = '';
            if (count($aves) == 0) {
                $banderaA = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $aves = ProduccionAve::where('id_info_productivo',$infoProductivo->id)->with(['TipoAve','TipoCorral','TipoProduccionAve','EstadoInstalacion'])->select('cantidad_polluelos', 'produccion', 'kg_comida', 'observaciones', 'id_produccion_aves', 'id_info_productivo', 'id_estado_instalaciones', 'id_tipo_aves', 'id_tipo_corral')->get();
            }

            $cerdos = ProduccionCerdo::where('id_info_productivo',$request->idInfo)->with(['MetodoReproduccion','TipoCorral','TipoProduccion','EstadoInstalacion'])->get();
            $banderaC = 0;
            if (count($cerdos) == 0) {
                $banderaC = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $cerdos = ProduccionCerdo::where('id_info_productivo',$infoProductivo->id)->with(['MetodoReproduccion','TipoCorral','TipoProduccion','EstadoInstalacion'])->select('kg_producidos', 'cantidad_animales', 'observaciones', 'id_info_productivo', 'id_estado_instalaciones', 'id_tipo_produccion', 'id_tipo_corral', 'id_metodo_reproduccion')->get();
            }

            $peces = ProduccionPece::where('id_info_productivo',$request->idInfo)->with(['TipoProduccion','EspeciePeces'])->get();
            $banderaP = 0;
            if (count($peces) == 0) {
                $banderaP = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $peces = ProduccionPece::where('id_info_productivo',$infoProductivo->id)->with(['TipoProduccion','EspeciePeces'])->select('cantidad_estanques', 'kg_comida', 'kg_producidos', 'observaciones', 'id_especie', 'id_info_productivo', 'id_tipo_produccion')->get();
            }

            $otras = ProduccionEspeciesMenore::where('id_info_productivo',$request->idInfo)->get();
            $banderaO = 0;
            if (count($otras) == 0) {
                $banderaO = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $otras = ProduccionEspeciesMenore::where('id_info_productivo',$infoProductivo->id)->select('especie', 'cantidad_animales','observaciones', 'id_info_productivo')->get();
            }

            return response()->json([
                'estado' => 'ok',
                'aves' => $aves,
                'cerdos' => $cerdos,
                'peces' => $peces,
                'otras' => $otras,
                'infoProductivo' =>$infoProductivo,
                'banderaA' =>$banderaA,
                'banderaC' =>$banderaC,
                'banderaP' =>$banderaP,
                'banderaO' =>$banderaO
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }


    }

    public function guardarAveAnterior(Request $request){
        $request =  json_decode($request->getContent());
        try{
            $ave = new ProduccionAve();
            $ave->cantidad_polluelos = $request->ave->cantidad_polluelos;
            //$ave->cantidad_ponedoras = $request->ave->cantidad_ponedoras;
            //$ave->cantidad_huevos = $request->ave->cantidad_huevos;
            $ave->kg_comida = $request->ave->kg_comida;
            $ave->observaciones = $request->ave->observaciones;
            $ave->produccion = $request->produccion;
            $ave->id_produccion_aves = $request->ave->id_produccion_aves;
            $ave->id_info_productivo = $request->idInfo;
            $ave->id_estado_instalaciones = $request->ave->id_estado_instalaciones;
            $ave->id_tipo_aves = $request->ave->id_tipo_aves;
            $ave->id_tipo_corral = $request->ave->id_tipo_corral;
            $ave->save();

            return response()->json([
                'estado' => 'ok',
                'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccionAve','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarAvesEspecies(Request$request){
        try{
            $ave = new ProduccionAve();
            $ave->cantidad_polluelos = $request->cantidad_polluelos;
            //$ave->cantidad_ponedoras = $request->cantidad_ponedoras;
            //$ave->cantidad_huevos = $request->cantidad_huevos;
            $ave->kg_comida = $request->kg_comida;
            $ave->observaciones = $request->observaciones;
            $ave->produccion = $request->produccion;
            $ave->id_produccion_aves = $request->id_tipo_produccione;
            $ave->id_info_productivo = $request->id_info_productivo;
            $ave->id_estado_instalaciones = $request->id_estado_instalaciones;
            $ave->id_tipo_aves = $request->id_tipo_ave;
            $ave->id_tipo_corral = $request->id_tipo_corral;
            $ave->save();

            return response()->json([
                'estado' => 'ok',
                'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccionAve','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }
    public function eliminarAvesEspecies(Request $request){
        try{
            $ave = ProduccionAve::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                //'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    //Cerdos
    public function guardarCerdoAnterior(Request $request){
        $request =  json_decode($request->getContent());
        try{
            $cerdo = new ProduccionCerdo();
            //$cerdo->kg_comida = $request->cerdo->kg_comida;
            $cerdo->kg_producidos = $request->cerdo->kg_producidos;
            $cerdo->cantidad_animales = $request->cerdo->cantidad_animales;
            $cerdo->observaciones = $request->cerdo->observaciones;
            $cerdo->id_info_productivo = $request->idInfo;
            $cerdo->id_estado_instalaciones = $request->cerdo->id_estado_instalaciones;
            $cerdo->id_tipo_produccion = $request->cerdo->id_tipo_produccion;
            $cerdo->id_tipo_corral = $request->cerdo->id_tipo_corral;
            $cerdo->id_metodo_reproduccion = $request->cerdo->id_metodo_reproduccion;
            $cerdo->save();

            return response()->json([
                'estado' => 'ok',
                'cerdo' => ProduccionCerdo::with(['MetodoReproduccion','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($cerdo->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarCerdoEspecies(Request$request){
        try{
            $cerdo = new ProduccionCerdo();
            //$cerdo->kg_comida = $request->kg_comida;
            $cerdo->kg_producidos = $request->kg_producidos;
            $cerdo->cantidad_animales = $request->cantidad_animales;
            $cerdo->observaciones = $request->observaciones;
            $cerdo->id_info_productivo = $request->id_info_productivo;
            $cerdo->id_estado_instalaciones = $request->id_estado_instalaciones;
            $cerdo->id_tipo_produccion = $request->id_tipo_produccion;
            $cerdo->id_tipo_corral = $request->id_tipo_corral;
            $cerdo->id_metodo_reproduccion = $request->id_metodo_reproduccion;
            $cerdo->save();

            return response()->json([
                'estado' => 'ok',
                'cerdo' => ProduccionCerdo::with(['MetodoReproduccion','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($cerdo->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }
    public function eliminarCerdoEspecies(Request $request){
        try{
            $ave = ProduccionCerdo::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                //'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarPezAnterior(Request $request){
        $request =  json_decode($request->getContent());
        try{
            $peces = new ProduccionPece();
            $peces->cantidad_estanques = $request->pez->cantidad_estanques;
            $peces->kg_comida = $request->pez->kg_comida;
            $peces->kg_producidos = $request->pez->kg_producidos;
            $peces->observaciones = $request->pez->observaciones;
            $peces->id_especie = $request->pez->id_especie;
            $peces->id_info_productivo = $request->idInfo;
            $peces->id_tipo_produccion = $request->pez->id_tipo_produccion;
            $peces->save();

            return response()->json([
                'estado' => 'ok',
                'peces' => ProduccionPece::with(['TipoProduccion','EspeciePeces'])->find($peces->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarPecesEspecies(Request$request){
        try{
            $peces = new ProduccionPece();
            $peces->cantidad_estanques = $request->cantidad_estanques;
            $peces->kg_comida = $request->kg_comida;
            $peces->kg_producidos = $request->kg_producidos;
            $peces->observaciones = $request->observaciones;
            $peces->id_especie = $request->id_especie;
            $peces->id_info_productivo = $request->id_info_productivo;
            $peces->id_tipo_produccion = $request->id_tipo_produccion;
            $peces->save();

            return response()->json([
                'estado' => 'ok',
                'peces' => ProduccionPece::with(['TipoProduccion','EspeciePeces'])->find($peces->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }
    public function eliminarPecesEspecies(Request $request){
        try{
            $ave = ProduccionPece::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                //'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarOtraAnterior(Request $request){
        $request =  json_decode($request->getContent());
        try{
            $otras = new ProduccionEspeciesMenore();
            $otras->especie = $request->otra->especie;
            $otras->cantidad_animales = $request->otra->cantidad_animales;
            $otras->observaciones = $request->otra->observaciones;
            $otras->id_info_productivo = $request->idInfo;
            $otras->save();

            return response()->json([
                'estado' => 'ok',
                'otras' => $otras

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

    public function guardarOtrasEspecies(Request$request){
        try{
            $otras = new ProduccionEspeciesMenore();
            $otras->especie = $request->especie;
            $otras->cantidad_animales = $request->cantidad_animales;
            $otras->observaciones = $request->observaciones;
            $otras->id_info_productivo = $request->id_info_productivo;
            $otras->save();

            return response()->json([
                'estado' => 'ok',
                'otras' => $otras

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }
    public function eliminarOtrasEspecies(Request $request){
        try{
            $ave = ProduccionEspeciesMenore::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                //'ave' => ProduccionAve::with(['TipoAve','TipoCorral','TipoProduccion','EstadoInstalacion'])->find($ave->id),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace'=>$ee->getTrace()
            ]);
        }
    }

}
