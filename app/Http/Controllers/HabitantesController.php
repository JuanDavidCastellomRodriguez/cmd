<?php

namespace App\Http\Controllers;


use App\Habitante;
use App\HabitantesVivienda;
use App\InformacionProductivos;
use App\InformacionVivienda;
use App\Subsidio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class HabitantesController extends Controller
{
    public function beneficiarioAnterior(Request $request)
    {
        if ($request->tipo == 1) {
            $enlace = new HabitantesVivienda();
            $enlace->id_habitante = $request->id;
            $enlace->id_informacion = $request->idInfo;
            $enlace->save();

            $bandera = 0;
        } else if ($request->tipo == 2) {
            $enlace = new HabitantesVivienda();
            $enlace->id_habitante = $request->id;
            $enlace->id_productivo = $request->idInfo;
            $enlace->save();

            $bandera = 0;
        }
        

        return response()->json([
                'data'=> $enlace,
                'bandera' => $bandera
            ]); 
    }
    public function getHabitantes(Request  $request){
        if($request->tipoSubsidio == 1){            
            $info = InformacionVivienda::find($request->idInfo)->HabitantesViviendas->all();
            $bandera = 0;
            $idPredio = '';
            if (count($info) == 0) {
                $bandera = 1;
                $info_vivienda = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_vivienda', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
                if ($info_vivienda != null) {
                    $idPredio = InformacionVivienda::where('id', $info_vivienda->id_info_vivienda)->first();
                    $info2 = HabitantesVivienda::where('id_informacion', $idPredio->id)->get();                    
                    for ($i=0; $i < count($info2); $i++) { 
                        $info[$i] = Habitante::where('id', $info2[$i]->id_habitante)->first();
                    }
                } else {
                    $idPredio = '';
                    $info2 = '';
                    $bandera = 0;
                }
                
                
            }
            
            //$data = InformacionVivienda::find($request->idInfo)->with(['HabitantesViviendas'])->get();
            return response()->json([
                'data'=> $info,
                'bandera' => $bandera,
                'infoVivienda' =>$idPredio
            ]);
        }else{
            $info = InformacionProductivos::find($request->idInfo)->HabitantesViviendas->all();
            $bandera = 0;
            $infoProductivo = '';
            if (count($info) == 0) {
                $bandera = 1;
                $subsidio = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_productivo', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
                if ($subsidio != null) {
                    $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                    $habitantes = HabitantesVivienda::where('id_productivo', $infoProductivo->id)->get();
                    for ($i=0; $i < count($habitantes); $i++) { 
                        $info[$i] = Habitante::where('id', $habitantes[$i]->id_habitante)->first();
                    }
                } else {
                    $infoProductivo = '';
                    $bandera = '';
                }
                
                
            }
            //$data = InformacionVivienda::find($request->idInfo)->with(['HabitantesViviendas'])->get();
            return response()->json([
                'data'=> $info,
                'bandera' => $bandera,
                'infoProductivo' =>$infoProductivo
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
                $habitante->estudia = $request->habitante->estudia;
                $habitante->descripcion_estudio = $request->habitante->descripcion_estudio;
                $habitante->id_genero = $request->habitante->id_genero;
                $habitante->cabeza_hogar = $request->habitante->cabeza_hogar;
                $habitante->id_tipo_persona_a_cargo = $request->habitante->id_tipo_persona_a_cargo;
                $habitante->id_parentesco = $request->habitante->id_parentesco;
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
                $habitante->estudia = $request->habitante->estudia;
                $habitante->descripcion_estudio = $request->habitante->descripcion_estudio;
                $habitante->id_genero = $request->habitante->id_genero;
                $habitante->cabeza_hogar = $request->habitante->cabeza_hogar;
                $habitante->id_tipo_persona_a_cargo = $request->habitante->id_tipo_persona_a_cargo;
                $habitante->id_parentesco = $request->habitante->id_parentesco;
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
            $bandera = 0;
            return response()->json([
                'estado' => 'ok',
                'habitante' => Habitante::find($idHabitante),
                'yaEsHabitante' => $existeOtroPrograma,
                'bandera' => $bandera

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
