<?php

namespace App\Http\Controllers;

use App\AplicacionInsumo;
use App\ControlPlagasEnfermedades;
use App\Cultivo;
use App\DetalleCultivo;
use App\MatrizCultivo;
use App\ProductosVenta;
use App\Semilla;
use App\Subsidio;
use App\InformacionProductivos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CultivosController extends Controller
{
    public function getCultivos(Request $request){
        try{
            $cultivos = Cultivo::where('id_info_productivo',$request->idInfo)->get();
            $bandera = 0;
            $infoProductivo = '';
            if (count($cultivos) == 0) {
                $bandera = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $cultivos = Cultivo::where('id_info_productivo',$infoProductivo->id)->get();              
                $data = new Collection();
                foreach ($cultivos as $cultivo){                    
                    $cultivo->setAttribute('actividades',$this->actividadesCultivo($cultivo->id));
                    $cultivo->setAttribute('semillas',Semilla::where('id_cultivo',$cultivo->id)->select('variedad', 'densidad', 'certificado_ica', 'otra_procedencia')->get()->toArray());
                    $cultivo->id = '';
                    $cultivo->id_info_productivo = $request->idInfo;
                    $data->add($cultivo);
                }
            }else {
                $data = new Collection();
                foreach ($cultivos as $cultivo){
                    $cultivo->setAttribute('actividades',$this->actividadesCultivo($cultivo->id));
                    $cultivo->setAttribute('semillas',Semilla::where('id_cultivo',$cultivo->id)->get()->toArray());
                    $data->add($cultivo);
                }
            }

            return response()->json([
                'estado' => 'ok',
                'data' => $data,
                'bandera' => $bandera,
                'infoProductivo' => $infoProductivo


            ]);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'ok',
                'error' => $exception->getMessage(),


            ],500);
        }
    }

    public function getDetalleCultivo(Request $request){

        try{
            $insumos = AplicacionInsumo::where('id_cultivo',$request->id)->get()->toArray();
            $plagas = ControlPlagasEnfermedades::where('id_cultivo',$request->id)->get()->toArray();
            $detalle = DetalleCultivo::where('id_cultivo',$request->id)->get();
            $ventas = ProductosVenta::where('id_cultivo',$request->id)->get();
            $data = new Collection();
            foreach ($detalle as $deta){
                $deta->setAttribute('id_etapa',$deta->Componente->id_etapa);
                $data->push($deta);
            }

            $dataVentas = new Collection();
            foreach ($ventas as $venta){
                $venta->setAttribute('mes',$venta->Mes->mes);
                $dataVentas->push($venta);
            }
            return response()->json([
                'estado' => 'ok',
                'detalle' => $data,
                'insumos' => $insumos,
                'plagas' => $plagas,
                'ventas'=>$dataVentas,


            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }



    }

    public function guardarCultivoAnterior(Request $request)
    {
        $request =  json_decode($request->getContent());
        try {
            DB::beginTransaction();
            $cultivo = new Cultivo();
            $cultivo->descripcion_cultivo = $request->cultivo->descripcion_cultivo;
            $cultivo->nombre_producto = $request->cultivo->nombre_producto;
            $cultivo->fecha_establecimiento_cultivo = $request->cultivo->fecha_establecimiento_cultivo;
            $cultivo->fecha_renovacion = $request->cultivo->fecha_renovacion;
            $cultivo->id_info_productivo = $request->cultivo->id_info_productivo;
            $cultivo->id_unidad_producto = $request->cultivo->id_unidad_producto;
            $cultivo->id_sitio_venta = $request->cultivo->id_sitio_venta;
            if($cultivo->save()){
                foreach ($request->cultivo->actividades->preparacion as $mes){
                    $actividad = new MatrizCultivo();
                    $actividad->id_actividad_cultivo = 1;
                    $actividad->id_cultivo = $cultivo->id;
                    $actividad->id_mes = $mes;
                    $actividad->save();

                }
                foreach ($request->cultivo->actividades->siembra as $mes){
                    $actividad = new MatrizCultivo();
                    $actividad->id_actividad_cultivo = 2;
                    $actividad->id_cultivo = $cultivo->id;
                    $actividad->id_mes = $mes;
                    $actividad->save();

                }
                foreach ($request->cultivo->actividades->deshierbado as $mes){
                    $actividad = new MatrizCultivo();
                    $actividad->id_actividad_cultivo = 3;
                    $actividad->id_cultivo = $cultivo->id;
                    $actividad->id_mes = $mes;
                    $actividad->save();

                }
                foreach ($request->cultivo->actividades->abonado as $mes){
                    $actividad = new MatrizCultivo();
                    $actividad->id_actividad_cultivo = 4;
                    $actividad->id_cultivo = $cultivo->id;
                    $actividad->id_mes = $mes;
                    $actividad->save();

                }
                foreach ($request->cultivo->actividades->cosecha as $mes){
                    $actividad = new MatrizCultivo();
                    $actividad->id_actividad_cultivo = 5;
                    $actividad->id_cultivo = $cultivo->id;
                    $actividad->id_mes = $mes;
                    $actividad->save();

                }

                foreach ($request->cultivo->semillas as $semilla){
                    $nuevaSemilla = new Semilla();
                    $nuevaSemilla->variedad = $semilla->variedad;
                    $nuevaSemilla->densidad = $semilla->densidad;
                    $nuevaSemilla->certificado_ica = $semilla->certificado_ica;
                    $nuevaSemilla->otra_procedencia = $semilla->otra_procedencia;
                    $nuevaSemilla->id_cultivo = $cultivo->id;
                    $nuevaSemilla->save();
                }


            }
            DB::commit();
            $data = $this->actividadesCultivo($cultivo->id);


            $cultivo->setAttribute('actividades',$data);
            $cultivo->setAttribute('semillas',Semilla::where('id_cultivo',$cultivo->id)->get()->toArray());
            return response()->json([
                'estado' => 'ok',
                //'id' => $cultivo->id,
                //'actividades' => $data,
                'cultivo' => $cultivo

            ]);

        }catch (\Exception $e) {
            return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage(),
                'descripcion' => $e->getTrace()


            ],500);
        }                       
    }


    public function guardarCultivo(Request $request){
        $request =  json_decode($request->getContent());
        try{
            DB::beginTransaction();
            $cultivo = '';
            $updated = false;
            if($request->cultivo->id != ''){ // Actualizar Cultivo
                $cultivo = Cultivo::find($request->cultivo->id);
                $cultivo->descripcion_cultivo = $request->cultivo->descripcion_cultivo;
                $cultivo->nombre_producto = $request->cultivo->nombre_producto;
                $cultivo->fecha_establecimiento_cultivo = $request->cultivo->fecha_establecimiento_cultivo;
                $cultivo->fecha_renovacion = $request->cultivo->fecha_renovacion;
                $cultivo->id_info_productivo = $request->cultivo->id_info_productivo;
                $cultivo->id_unidad_producto = $request->cultivo->id_unidad_producto;
                $cultivo->id_sitio_venta = $request->cultivo->id_sitio_venta;
                if($cultivo->save()){
                    MatrizCultivo::where('id_cultivo',$cultivo->id)->delete();
                    Semilla::where('id_cultivo',$cultivo->id)->delete();

                    foreach ($request->cultivo->actividades->preparacion as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 1;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->siembra as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 2;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->deshierbado as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 3;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->abonado as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 4;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->cosecha as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 5;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }

                    foreach ($request->cultivo->semillas as $semilla){
                        $nuevaSemilla = new Semilla();
                        $nuevaSemilla->variedad = $semilla->variedad;
                        $nuevaSemilla->densidad = $semilla->densidad;
                        $nuevaSemilla->certificado_ica = $semilla->certificado_ica;
                        $nuevaSemilla->otra_procedencia = $semilla->otra_procedencia;
                        $nuevaSemilla->id_cultivo = $cultivo->id;
                        $nuevaSemilla->save();
                    }



                }
            $updated = true;

            }else{//Nuevo Cultivo
                $cultivo = new Cultivo();
                $cultivo->descripcion_cultivo = $request->cultivo->descripcion_cultivo;
                $cultivo->nombre_producto = $request->cultivo->nombre_producto;
                $cultivo->fecha_establecimiento_cultivo = $request->cultivo->fecha_establecimiento_cultivo;
                $cultivo->fecha_renovacion = $request->cultivo->fecha_renovacion;
                $cultivo->id_info_productivo = $request->cultivo->id_info_productivo;
                $cultivo->id_unidad_producto = $request->cultivo->id_unidad_producto;
                $cultivo->id_sitio_venta = $request->cultivo->id_sitio_venta;
                if($cultivo->save()){
                    foreach ($request->cultivo->actividades->preparacion as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 1;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->siembra as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 2;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->deshierbado as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 3;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->abonado as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 4;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }
                    foreach ($request->cultivo->actividades->cosecha as $mes){
                        $actividad = new MatrizCultivo();
                        $actividad->id_actividad_cultivo = 5;
                        $actividad->id_cultivo = $cultivo->id;
                        $actividad->id_mes = $mes;
                        $actividad->save();

                    }

                    foreach ($request->cultivo->semillas as $semilla){
                        $nuevaSemilla = new Semilla();
                        $nuevaSemilla->variedad = $semilla->variedad;
                        $nuevaSemilla->densidad = $semilla->densidad;
                        $nuevaSemilla->certificado_ica = $semilla->certificado_ica;
                        $nuevaSemilla->otra_procedencia = $semilla->otra_procedencia;
                        $nuevaSemilla->id_cultivo = $cultivo->id;
                        $nuevaSemilla->save();
                    }


                }

            }

            DB::commit();
            $data = $this->actividadesCultivo($cultivo->id);


            $cultivo->setAttribute('actividades',$data);
            $cultivo->setAttribute('semillas',Semilla::where('id_cultivo',$cultivo->id)->get()->toArray());

            return response()->json([
                'estado' => 'ok',
                //'id' => $cultivo->id,
                //'actividades' => $data,
                'cultivo' => $cultivo,
                'updated' => $updated,



            ]);


        }catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarDetalleCultivo(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $detalle = new DetalleCultivo();
            $detalle->id_componente_cultivo = $request->detalle->id_componente_cultivo;
            $detalle->id_cultivo = $request->detalle->id_cultivo;
            $detalle->actividades = $request->detalle->actividades;
            $detalle->frecuencia = $request->detalle->frecuencia;
            $detalle->mano_obra = $request->detalle->mano_obra;
            $detalle->save();
            $detalle->setAttribute('id_etapa',$detalle->Componente->id_etapa);
            return response()->json([
                'estado' => 'ok',
                'detalle' => $detalle,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarDetalleCultivo(Request $request){
        try{
            DetalleCultivo::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Actividad eliminada correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarInsumoCultivo(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $insumo = new AplicacionInsumo();
            $insumo->insumo = $request->insumo->insumo;
            $insumo->cantidad = $request->insumo->cantidad;
            $insumo->frecuencia = $request->insumo->frecuencia;
            $insumo->id_cultivo = $request->insumo->id_cultivo;
            $insumo->id_etapa = $request->insumo->id_etapa;
            $insumo->save();
            //$insumo->setAttribute('id_etapa',$detalle->Componente->id_etapa);
            return response()->json([
                'estado' => 'ok',
                'insumo' => $insumo,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarInsumoCultivo(Request $request){
        try{
            AplicacionInsumo::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Insumo eliminado correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarPlagaCultivo(Request $request){
        try{
            $request =  json_decode($request->getContent());
            $plaga = new ControlPlagasEnfermedades();
            $plaga->caracteristicas_control = $request->plaga->caracteristicas_control;
            $plaga->frecuencia = $request->plaga->frecuencia;
            //$plaga->mano_obra = $request->plaga->mano_obra;
            $plaga->tipo_plaga = $request->plaga->tipo_plaga;
            $plaga->id_cultivo = $request->plaga->id_cultivo;
            $plaga->save();
            //$insumo->setAttribute('id_etapa',$detalle->Componente->id_etapa);
            return response()->json([
                'estado' => 'ok',
                'plaga' => $plaga,

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarPlagaCultivo(Request $request){
        try{
            ControlPlagasEnfermedades::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Plaga eliminada correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function guardarVentaCultivo(Request $request){
        try{

            $request =  json_decode($request->getContent());
            $mesExiste = ProductosVenta::where('id_mes',$request->venta->id_mes)->where('id_cultivo',$request->venta->id_cultivo)->get();
            if($mesExiste->isEmpty()){
                $venta = new ProductosVenta();
                $venta->cantidad_autoconsumo = $request->venta->cantidad_autoconsumo;
                $venta->cantidad_venta = $request->venta->cantidad_venta;
                $venta->cantidad_primera_calidad = $request->venta->cantidad_primera_calidad;
                $venta->cantidad_segunda_calidad = $request->venta->cantidad_segunda_calidad;
                $venta->cantidad_tercera_calidad = $request->venta->cantidad_tercera_calidad;
                $venta->id_mes = $request->venta->id_mes;
                $venta->id_cultivo = $request->venta->id_cultivo;
                $venta->save();
                $venta->setAttribute('mes',$venta->Mes->mes);
                //$insumo->setAttribute('id_etapa',$detalle->Componente->id_etapa);
                return response()->json([
                    'estado' => 'ok',
                    'venta' => $venta,

                ],200);
            }else{
                return response()->json([
                    'estado' => 'fail',
                    'error' => 'Mes ya existe en este cultivo',

                ],200);
            }


        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }
    }

    public function eliminarVentaCultivo(Request $request){
        try{
            ProductosVenta::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Venta eliminada correctamente',

            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage(),
                'descripcion' => $exception->getTrace()


            ],500);
        }

    }

    public function actividadesCultivo($id){
        $actividades = MatrizCultivo::where('id_cultivo',$id)->get();

        $data = new Collection();
        $preparacion = array();
        $siembra = array();
        $deshierbado = array();
        $abonado = array();
        $cosecha = array();
        foreach ($actividades as $act){
            switch ($act->id_actividad_cultivo){
                case '1':
                    array_push($preparacion,$act->id_mes);
                    break;
                case '2':
                    array_push($siembra,$act->id_mes);
                    break;
                case '3':
                    array_push($deshierbado,$act->id_mes);
                    break;
                case '4':
                    array_push($abonado,$act->id_mes);
                    break;
                case '5':
                    array_push($cosecha,$act->id_mes);
                    break;

            }

        }
        $data->put('preparacion', $preparacion);
        $data->put('siembra', $siembra);
        $data->put('deshierbado', $deshierbado);
        $data->put('abonado', $abonado);
        $data->put('cosecha', $cosecha);




        return $data;
    }

     public function borrarSemilla(Request $request)
     {
         try {
            $semilla = Semilla::where('id', $request)->delete(); 
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Semilla eliminada correctamente',

            ],200);

         } catch (\Exception $e) {
             return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage(),
                'descripcion' => $e->getTrace()


            ],500);
         }
     }
}
