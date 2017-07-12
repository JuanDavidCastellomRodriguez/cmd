<?php

namespace App\Http\Controllers;

use App\Cultivo;
use App\MatrizCultivo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CultivosController extends Controller
{
    public function getCultivos(Request $request){
        try{
            $cultivos = Cultivo::where('id_info_productivo',$request->idInfo)->get();
            $data = new Collection();
            foreach ($cultivos as $cultivo){
                $cultivo->setAttribute('actividades',$this->actividadesCultivo($cultivo->id));
                $data->add($cultivo);
            }

            return response()->json([
                'estado' => 'ok',
                'data' => $data,


            ]);

        }catch (\Exception $exception){
            return response()->json([
                'estado' => 'ok',
                'error' => $exception->getMessage(),


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


                }

            }

            DB::commit();
            $data = $this->actividadesCultivo($cultivo->id);


            $cultivo->setAttribute('actividades',$data);

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
}
