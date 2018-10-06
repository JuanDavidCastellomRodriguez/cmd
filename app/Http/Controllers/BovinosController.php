<?php

namespace App\Http\Controllers;

use App\Bovino;
use App\RegActividadManejoAnimale;
use App\RegOrdenio;
use App\Subsidio;
use App\InformacionProductivos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BovinosController extends Controller
{
    //
    public function getBovinos(Request $request){
        try{

            $bovinos = Bovino::where('id_info_productivo',$request->idInfo)->get();
            $data = new Collection();
            $infoProductivo = '';
            if (count($bovinos) == 0) {
                $banderaB = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $bovinos = Bovino::where('id_info_productivo',$infoProductivo->id)->select('id_raza', 'id_tipo_propiedad', 'id_tipo_bovino', 'cantidad')->get();
                foreach ($bovinos as $bovino){
                    $bovino->setAttribute('raza',$bovino->Raza->raza);
                    $bovino->setAttribute('propiedad',$bovino->TipoPropiedad->tipo_propiedad);
                    $bovino->setAttribute('tipo',$bovino->TipoBovino->tipo_animal);
                    $data->add($bovino);
                }
            }else {
                $banderaB = 0;
                foreach ($bovinos as $bovino){
                    $bovino->setAttribute('raza',$bovino->Raza->raza);
                    $bovino->setAttribute('propiedad',$bovino->TipoPropiedad->tipo_propiedad);
                    $bovino->setAttribute('tipo',$bovino->TipoBovino->tipo_animal);
                    $data->add($bovino);
                }
            }            

            $manejos = RegActividadManejoAnimale::where('id_info_productivo',$request->idInfo)->get();
            $dataManejo = new Collection();
            if (count($manejos) == 0) {
                $banderaM = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivoM = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $manejos = RegActividadManejoAnimale::where('id_info_productivo',$infoProductivoM->id)->select('cantidad', 'periodicidad', 'id_actividad_manejo', 'producto_actividad')->get();
                foreach ($manejos as $manejo){
                    $manejo->setAttribute('actividad',$manejo->ActividadManejo->nombre_actividad);
                    $dataManejo->add($manejo);
                }

            } else {
                $banderaM = 0;
                foreach ($manejos as $manejo){
                    $manejo->setAttribute('actividad',$manejo->ActividadManejo->nombre_actividad);
                    $dataManejo->add($manejo);
                }
            }     

            $ordenios = RegOrdenio::where('id_info_productivo',$request->idInfo)->get();
            $dataOrdenio = new Collection();
            if (count($ordenios) == 0) {
                $banderaO = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivoO = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $ordenios = RegOrdenio::where('id_info_productivo',$infoProductivoO->id)->select('produccion_dia', 'cantidad_cuaja', 'cantidad_autoconsumo', 'cantidad_venta', 'id_frecuencia_ordenio', 'id_unidades_ordenio')->get();
                foreach ($ordenios as $ordenio){
                    $ordenio->setAttribute('unidad',$ordenio->UnidadOrdenio->unidades_ordenio);
                    $ordenio->setAttribute('frecuencia',$ordenio->FrecuenciaOrdenio->frecuencia);
                    $dataOrdenio->add($ordenio);
                }
            } else {
                $banderaO = 0;
                foreach ($ordenios as $ordenio){
                    $ordenio->setAttribute('unidad',$ordenio->UnidadOrdenio->unidades_ordenio);
                    $ordenio->setAttribute('frecuencia',$ordenio->FrecuenciaOrdenio->frecuencia);
                    $dataOrdenio->add($ordenio);
                }
            }
            
            

            return response()->json([
                'estado' => 'ok',
                'data' => $data->toArray(),
                'manejo' => $dataManejo->toArray(),
                'ordenio' => $dataOrdenio,
                'banderaB' => $banderaB,
                'banderaM' => $banderaM,
                'banderaO' => $banderaO,
                'infoProductivo' => $infoProductivo

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function guardarBovinoAnterior(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $bovino = new Bovino();
            $bovino->id_info_productivo = $request->idInfo;
            $bovino->id_raza = $request->bovino->id_raza;
            $bovino->id_tipo_propiedad = $request->bovino->id_tipo_propiedad;
            $bovino->id_tipo_bovino = $request->bovino->id_tipo_bovino;
            $bovino->cantidad = $request->bovino->cantidad;
            $bovino->save();
            $bovino->setAttribute('raza',$bovino->Raza->raza);
            $bovino->setAttribute('propiedad',$bovino->TipoPropiedad->tipo_propiedad);
            $bovino->setAttribute('tipo',$bovino->TipoBovino->tipo_animal);

            return response()->json([
                'estado' => 'ok',
                'bovino' => $bovino,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function guardarBovino(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $bovino = new Bovino();
            $bovino->id_info_productivo = $request->bovino->id_info_productivo;
            $bovino->id_raza = $request->bovino->id_raza;
            $bovino->id_tipo_propiedad = $request->bovino->id_tipo_propiedad;
            $bovino->id_tipo_bovino = $request->bovino->id_tipo_bovino;
            $bovino->cantidad = $request->bovino->cantidad;
            $bovino->save();
            $bovino->setAttribute('raza',$bovino->Raza->raza);
            $bovino->setAttribute('propiedad',$bovino->TipoPropiedad->tipo_propiedad);
            $bovino->setAttribute('tipo',$bovino->TipoBovino->tipo_animal);

            return response()->json([
                'estado' => 'ok',
                'bovino' => $bovino,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarBovino(Request $request){
        try{
            Bovino::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Bovino eliminado correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarManejoAnterior(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $manejo = new RegActividadManejoAnimale();
            $manejo->cantidad = $request->manejo->cantidad;
            $manejo->periodicidad = $request->manejo->periodicidad;
            $manejo->id_actividad_manejo = $request->manejo->id_actividad_manejo;
            $manejo->id_info_productivo = $request->idInfo;
            $manejo->producto_actividad = $request->manejo->producto_actividad;
            $manejo->save();
            $manejo->setAttribute('actividad',$manejo->ActividadManejo->nombre_actividad);

            return response()->json([
                'estado' => 'ok',
                'manejo' => $manejo,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function guardarManejoBovino(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $manejo = new RegActividadManejoAnimale();
            $manejo->cantidad = $request->manejo->cantidad;
            $manejo->periodicidad = $request->manejo->periodicidad;
            $manejo->id_actividad_manejo = $request->manejo->id_actividad_manejo;
            $manejo->id_info_productivo = $request->manejo->id_info_productivo;
            $manejo->producto_actividad = $request->manejo->producto_actividad;
            $manejo->save();
            $manejo->setAttribute('actividad',$manejo->ActividadManejo->nombre_actividad);

            return response()->json([
                'estado' => 'ok',
                'manejo' => $manejo,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarManejoBovino(Request $request){
        try{
            RegActividadManejoAnimale::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Manejo eliminado correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarOrdenioAnterior(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $ordenio = new RegOrdenio();
            $ordenio->produccion_dia = $request->ordenio->produccion_dia;
            $ordenio->cantidad_cuaja = $request->ordenio->cantidad_cuaja;
            $ordenio->cantidad_autoconsumo = $request->ordenio->cantidad_autoconsumo;
            $ordenio->cantidad_venta = $request->ordenio->cantidad_venta;
            $ordenio->id_info_productivo = $request->idInfo;
            $ordenio->id_frecuencia_ordenio = $request->ordenio->id_frecuencia_ordenio;
            $ordenio->id_unidades_ordenio = $request->ordenio->id_unidades_ordenio;
            $ordenio->save();

            $ordenio->setAttribute('unidad',$ordenio->UnidadOrdenio->unidades_ordenio);
            $ordenio->setAttribute('frecuencia',$ordenio->FrecuenciaOrdenio->frecuencia);

            return response()->json([
                'estado' => 'ok',
                'ordenio' => $ordenio,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function guardarOrdenioBovino(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $ordenio = new RegOrdenio();
            $ordenio->produccion_dia = $request->ordenio->produccion_dia;
            $ordenio->cantidad_cuaja = $request->ordenio->cantidad_cuaja;
            $ordenio->cantidad_autoconsumo = $request->ordenio->cantidad_autoconsumo;
            $ordenio->cantidad_venta = $request->ordenio->cantidad_venta;
            $ordenio->id_info_productivo = $request->ordenio->id_info_productivo;
            $ordenio->id_frecuencia_ordenio = $request->ordenio->id_frecuencia_ordenio;
            $ordenio->id_unidades_ordenio = $request->ordenio->id_unidades_ordenio;
            $ordenio->save();

            $ordenio->setAttribute('unidad',$ordenio->UnidadOrdenio->unidades_ordenio);
            $ordenio->setAttribute('frecuencia',$ordenio->FrecuenciaOrdenio->frecuencia);

            return response()->json([
                'estado' => 'ok',
                'ordenio' => $ordenio,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarOrdenioBovino(Request $request){
        try{
            RegOrdenio::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Registro ordeño eliminado correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }
}
