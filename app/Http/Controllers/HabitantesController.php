<?php

namespace App\Http\Controllers;


use App\Habitante;
use App\HabitantesVivienda;
use App\InformacionProductivos;
use App\InformacionVivienda;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class HabitantesController extends Controller
{
    public function getHabitantes(Request  $request){
        if($request->tipoSubsidio == 1){
            $info = InformacionVivienda::find($request->idInfo)->HabitantesViviendas->all();
            //$data = InformacionVivienda::find($request->idInfo)->with(['HabitantesViviendas'])->get();
            return response()->json([
                'data'=> $info
            ]);
        }else{
            $info = InformacionProductivos::find($request->idInfo)->HabitantesViviendas->all();
            //$data = InformacionVivienda::find($request->idInfo)->with(['HabitantesViviendas'])->get();
            return response()->json([
                'data'=> $info
            ]);
        }


    }

    public function buscarHabitante(Request $request){

        $habitante = Habitante::where('no_cedula', $request->no_cedula)->first();
        if($habitante != null){
            return response()->json([
                'estado' => 'ok',
                'habitante' => $habitante
            ]);
        }else{
            return response()->json([
                'estado' => 'fail',
                $habitante => null
            ]);
        }
    }

    public function guardarHabitante(Request $request){
        //return $request;
        $request =  json_decode($request->getContent());
        $idHabitante = '';
        $existeOtroPrograma = false;
        try{


            if($request->habitante->id == ''){
                $habitante = new Habitante();
                $habitante->no_cedula = $request->habitante->no_cedula;
                $habitante->nombres = $request->habitante->nombres;
                $habitante->apellidos = $request->habitante->apellidos;
                $habitante->fecha_nacimiento = $request->habitante->fecha_nacimiento;
                $habitante->no_celular = $request->habitante->no_celular;
                $habitante->correo_electronico = $request->habitante->correo_electronico;
                $habitante->ocupacion = $request->habitante->ocupacion;
                $habitante->id_estado_civil = $request->habitante->id_estado_civil;
                $habitante->id_nivel_educativo = $request->habitante->id_nivel_educativo;
                $habitante->id_genero = $request->habitante->id_genero;
                $habitante->cabeza_hogar = $request->habitante->cabeza_hogar;
                $habitante->save();

                $habitanteVivienda = new HabitantesVivienda();
                $habitanteVivienda->id_habitante = $habitante->id;
                if($request->tipoSubsidio == 1){
                    $habitanteVivienda->id_informacion = $request->idInfo;
                }else{
                    $habitanteVivienda->id_productivo = $request->idInfo;
                }


                $habitanteVivienda->save();

                $idHabitante = $habitante->id;

            }else{
                $habitante = Habitante::findOrFail($request->habitante->id);
                $habitante->no_cedula = $request->habitante->no_cedula;
                $habitante->nombres = $request->habitante->nombres;
                $habitante->apellidos = $request->habitante->apellidos;
                $habitante->fecha_nacimiento = $request->habitante->fecha_nacimiento;
                $habitante->no_celular = $request->habitante->no_celular;
                $habitante->correo_electronico = $request->habitante->correo_electronico;
                $habitante->ocupacion = $request->habitante->ocupacion;
                $habitante->id_estado_civil = $request->habitante->id_estado_civil;
                $habitante->id_nivel_educativo = $request->habitante->id_nivel_educativo;
                $habitante->id_genero = $request->habitante->id_genero;
                $habitante->cabeza_hogar = $request->habitante->cabeza_hogar;
                $habitante->save();

                $verificaHabitante = HabitantesVivienda::where('id_habitante', $request->habitante->id)->get();
                if($verificaHabitante != null){
                    $existeOtroPrograma = true;
                }

                $habitanteVivienda = new HabitantesVivienda();
                $habitanteVivienda->id_habitante = $habitante->id;
                if($request->tipoSubsidio == 1){
                    $habitanteVivienda->id_informacion = $request->idInfo;
                }else{
                    $habitanteVivienda->id_productivo = $request->idInfo;
                }


                $habitanteVivienda->save();

                $idHabitante = $habitante->id;
            }

            return response()->json([
                'estado' => 'ok',
                'habitante' => Habitante::find($idHabitante),
                'yaEsHabitante' => $existeOtroPrograma

            ]);

        }catch (QueryException $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()

            ]);

        }catch (Exception $e){
            return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()

            ]);
        }

    }
    public function removerHabitante(Request $request){
        //dd($request);
        try{
            if($request->tipoSubsidio == 1){


                HabitantesVivienda::where('id_informacion', $request->idInfo)->where('id_habitante', $request->habitante)->first()->delete();
                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Habitante removido'
                ]);
            }else{
                HabitantesVivienda::where('id_productivo', $request->idInfo)->where('id_habitante', $request->habitante)->first()->delete();
                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Habitante removido'
                ]);
            }



        }catch (Exception $ee){
            return response()->json([
                'estado' => 'ok',
                'mensaje' => $ee->getMessage()
            ]);

        }catch (QueryException $e){
            return response()->json([
                'estado' => 'ok',
                'mensaje' => $e->getMessage()
            ]);
        }

    }
}
