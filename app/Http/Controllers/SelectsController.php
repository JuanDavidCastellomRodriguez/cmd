<?php

namespace App\Http\Controllers;

use App\AcabadosTanque;
use App\Campo;
use App\Comunicacione;
use App\Departamento;
use App\ElementosCocina;
use App\ElementosSanitario;
use App\ElementosSanitariosInstalado;
use App\EstadosCivile;
use App\EstadosVia;
use App\EstadosVivienda;
use App\Fase;
use App\FuenteEnergiaElectrica;
use App\FuentesAgua;
use App\Gas;
use App\Genero;
use App\ManejoResiduosSolido;
use App\MaterialesPuerta;
use App\MaterialesTanquesElevado;
use App\MaterialesTanquesLavadero;
use App\MaterialesVentana;
use App\MediosComunicaciones;
use App\MetodosDisposicionBasura;
use App\Municipio;
use App\NivelEducativo;
use App\OpcionTenenciaTierra;
use App\SistemaEliminacionAguasGrise;
use App\SubtipoCobertura;
use App\TiemposRecorrido;
use App\TipoCobertura;
use App\TipoCubierta;
use App\TipoFuentesHidrica;
use App\TipologiasFamilia;
use App\TipoMuro;
use App\TipoPersonasCargo;
use App\TipoPiso;
use App\TipoProyecto;
use App\TiposMesone;
use App\TipoSubsidio;
use App\TiposVehiculo;
use App\TiposViasAcceso;
use App\TipoTenenciaTierra;
use App\TipoUnidadesSanitaria;
use App\Vereda;
use Illuminate\Http\Request;

class SelectsController extends Controller
{
    //
    public function getDepartamentos(){
        $departamentos = Departamento::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $departamentos
        ]);
    }
    public function getMunicipios(Request $request){
        $municipios =  Municipio::where('id_departamento',$request->id)->get(['id','municipio']);
        return response()->json([
            'estado' => 'ok',
            'data' => $municipios,
        ]);
    }

    public function getVeredas(Request $request){
        $veredas =  Vereda::where('id_municipio',$request->id)->get(['id','vereda']);
        return response()->json([
            'estado' => 'ok',
            'data' => $veredas,
        ]);
    }

    public function getVeredasByCampo(Request $request){
        $veredas = Campo::find($request->id)->VeredasCampo;
        return response()->json([
            'estado' => 'ok',
            'data' => $veredas,
        ]);
    }

    public function getVeredasByFase(Request $request){
        $veredas = Fase::find($request->id)->VeredasFase;
        return response()->json([
            'estado' => 'ok',
            'data' => $veredas,
        ]);
    }


    public function getTipoVehiculo(){
        $tipoVehiculo =TiposVehiculo::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $tipoVehiculo,
        ]);
    }

    public function getViaAcceso(){
        $tipoVia =TiposViasAcceso::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $tipoVia,
        ]);
    }

    public function getEstadoVias(){
        $estadosVia =EstadosVia::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $estadosVia,
        ]);
    }

    public function getTiemposRecorrido(){
        $tiempos =TiemposRecorrido::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $tiempos,
        ]);
    }

    public function getTipologiaFamilia(){
        $tipologia =TipologiasFamilia::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $tipologia,
        ]);
    }

    public function getEstadosCivil(){
        $estados =EstadosCivile::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $estados,
        ]);
    }

    public function getTNivelesEducativos(){
        $niveles =NivelEducativo::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $niveles,
        ]);
    }

    public function getGeneros(){
        $generos =Genero::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $generos,
        ]);
    }

    public function getTipoPersonasCargo (){
        $tipos = TipoPersonasCargo::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $tipos,
        ]);
    }

    public function getSelectsPredio(){

        try{
            return response()->json([
                'estado' => 'ok',
                'opciones' =>  OpcionTenenciaTierra::all(),
                'tipo' => TipoTenenciaTierra::all(),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsHabitacion(){
        try{
            return response()->json([
                'estado' => 'ok',
                'tipoMuro' => TipoMuro::all(),
                'tipoPiso' => TipoPiso::all(),
                'tipoCubierta' => TipoCubierta::all(),
                'materialPuertas' => MaterialesPuerta::all(),
                'materialVentanas' => MaterialesVentana::all(),
                'estadoVivienda' => EstadosVivienda::all()
            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public  function getSelectsCocina(){
        try{
            return response()->json([
                'estado' => 'ok',
                'tiposMeson' => TiposMesone::all(),
                'elementosCocina' => ElementosCocina::all(),
            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public  function getCampos(){
        try{
            return response()->json([
                'estado' => 'ok',
                'data' => Campo::all(),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public  function getTiposSubsidio(){
        try{
            return response()->json([
                'estado' => 'ok',
                'data' => TipoSubsidio::all(),

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsUSanitarias(){
        try{
            return response()->json([
                'estado' => 'ok',
                'elementosSanitarios' => ElementosSanitario::all(),
                'tipoUnidadesSanitarias' => TipoUnidadesSanitaria::all(),
                'acabadosTanque' => AcabadosTanque::all(),
                'materialesTanqueElevado' => MaterialesTanquesElevado::all(),
                'materialesTanqueLavadero' => MaterialesTanquesLavadero::all(),


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsServicios(){
        try{
            return response()->json([
                'estado' => 'ok',
                'fuenteAgua' => FuentesAgua::all(),
                'aguasResiduales' => SistemaEliminacionAguasGrise::all(),
                'residuosSolidos' => MetodosDisposicionBasura::all(),
                'gas' => Gas::all(),
                'electricidad' => FuenteEnergiaElectrica::all(),
                'comunicaciones' => MediosComunicaciones::all(),


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsTipoProyectos(){
        try{
            return response()->json([
                'estado' => 'ok',
                'data'=> TipoProyecto::all()


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }
    public function getSelectsTipoCobertura(){
        try{
            return response()->json([
                'estado' => 'ok',
                'data'=> TipoCobertura::all()


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsSubtipoCobertura(Request $request){
        try{
            return response()->json([
                'estado' => 'ok',
                'data'=> SubtipoCobertura::where('id_tipo_cobertura',$request->id)->get(),


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function getSelectsTipoFuentesHidricas(){
        try{
            return response()->json([
                'estado' => 'ok',
                'data'=> TipoFuentesHidrica::all()


            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }




}
