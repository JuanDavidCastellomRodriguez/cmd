<?php

namespace App\Http\Controllers;



use App\Beneficiario;
use App\BeneficiarioVivienda;
use App\Fotografia;
use App\Generalidade;
use App\Indicadore;
use App\InformacionVivienda;
use App\PersonasCargo;
use App\Predio;
use App\PropietariosPredio;
use App\Riesgo;
use App\Subsidio;
use App\TenenciaTierra;
use App\Habitacione;
use App\Cocina;
use App\UnidadesSanitaria;

use Carbon\Carbon;
use Faker\Provider\File;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class ViviendasController extends Controller
{
    //
    public function index(){
        return view('vivienda.index');
    }

    public function store (Request $request){
        //dd($request);
        /*$validador = Validator::make($request->all(),[
            'fechaEncuesta'=>'required',
            'numeroFamiliasVivienda' => 'required | numeric',

        ]);
        if($validador->fails()){
            return response()->json([
                'estado' => 'fail',
                'mensaje' => 'Error al guardar',
                'error' => $validador->getMessageBag()->toArray(),
            ]);

        }else{*/
            try{
                $last = InformacionVivienda::all()->last();
                if($last == null){
                    $consecutivo = 1;
                }else{
                    $consecutivo = $last->consecutivo + 1;
                }

                $informacion = new InformacionVivienda();
                $informacion->fecha_encuesta = $request->fechaEncuesta;
                $informacion->responde_propietario = $request->responde_propietario;
                $informacion->no_familias_vivienda = $request->no_familias_vivienda;
                $informacion->caso_especial = $request->caso_especial;
                $informacion->beficiarios_prog_inv_social = $request->programa_social;
                $informacion->consecutivo = $consecutivo;
                $informacion->id_usuario = Auth::User()->id;
                $informacion->save();

                $subsidio = Subsidio::find($request->subsidio);
                $subsidio->id_info_vivienda = $informacion->id;
                $subsidio->caso_especial = $request->caso_especial;
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


        //}



    }


    /*public function getAllHabitaciones(Request $request){
        $habitaciones = Habitacione::where('id_informacion', $request->idInfo)->get()->first();

        return response()->json([
            'estado' => 'ok',
            'habitaciones' => $habitaciones
        ]);

    }*/



    public function show($id){
        $info = InformacionVivienda::findOrFail($id);
        return view('vivienda.show', compact('info') );
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
                $predio->id_vereda = $request->predio->idVereda;
                $predio->msnm = $request->predio->msnm;
                $predio->save();

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



                if($request->tenencia->id != ''){
                    $tenencia = TenenciaTierra::find($request->tenencia->id);
                    $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                    $tenencia->id_opcion = $request->tenencia->id_opcion;
                    $tenencia->otra_opcion = $request->tenencia->otra_opcion;
                    $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                    $tenencia->otra_tenencia = $request->tenencia->otra_tenencia;
                    $tenencia->save();
                }else{
                    $tenencia = new TenenciaTierra();
                    $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                    //$tenencia->file = base64_encode(file_get_contents(($request->tenencia->file)->getRealPath()));
                    $tenencia->id_opcion = $request->tenencia->id_opcion;
                    $tenencia->otra_opcion = $request->tenencia->otra_opcion;
                    $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                    $tenencia->otra_tenencia = $request->tenencia->otra_tenencia;
                    $tenencia->id_informacion = $request->tenencia->id_informacion;
                    $tenencia->save();
                }


                $info = InformacionVivienda::findOrFail($request->idInfo);
                $info->id_predio = $predio->id;
                $info->save();

                $idPredio = $predio->id;
                $idPropietario  = $propietario->id;
                $idTenencia = $tenencia->id;
            }else{
                $predio = new Predio();
                $predio->nombre_predio = $request->predio->nombre;
                $predio->direccion = $request->predio->direccion;
                $predio->latitud = $request->predio->latitud;
                $predio->longitud = $request->predio->longitud;
                $predio->id_vereda = $request->predio->idVereda;
                $predio->msnm = $request->predio->msnm;
                $predio->save();
                $info = InformacionVivienda::findOrFail($request->idInfo);
                $info->id_predio = $predio->id;
                $info->save();

                $propietario = new PropietariosPredio();
                $propietario->no_cedula = $request->propietario->noCedula;
                $propietario->nombres_propietario = $request->propietario->nombres;
                $propietario->apellidos_propietario = $request->propietario->apellidos;
                $propietario->no_telefonico = $request->propietario->telefono;
                $propietario->id_predio = $predio->id;
                $propietario->save();

                $tenencia = new TenenciaTierra();
                $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                //$tenencia->file = base64_encode(file_get_contents(($request->tenencia->file)->getRealPath()));
                $tenencia->id_opcion = $request->tenencia->id_opcion;
                $tenencia->otra_opcion = $request->tenencia->otra_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                $tenencia->otra_tenencia = $request->tenencia->otra_tenencia;
                $tenencia->id_informacion = $request->tenencia->id_informacion;
                $tenencia->save();

                $idPredio = $predio->id;
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
                'mensaje' => 'Error al guardar ',
                //'mensaje' => 'Error al guardar '.$ee->getMessage(),
            ]);
        }


    }
    public function getPredio(Request $request){

        try{
            $verificacion = InformacionVivienda::where('id', $request->idInfo)->first();
            //dd($verificacion);
            if ($verificacion->id_predio == null) {                
                $info_vivienda = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_vivienda', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
                //dd($info_vivienda);
                if ($info_vivienda != null) {
                    $idPredio = InformacionVivienda::where('id', $info_vivienda->id_info_vivienda)->first();
                    //dd($idPredio);
                    if ($idPredio->id_predio != null) {
                        $predio = Predio::findOrFail($idPredio->id_predio);
        
                        $tenencia = TenenciaTierra::where('id_informacion', $idPredio->id)->first();
                        $propietario = PropietariosPredio::where('id_predio', $predio->id)->first();
                        $bandera = 1;
                        
                        return response()->json([
                            'estado'=> 'ok',
                            'bandera' => $bandera,
                            'infoVivienda' => $idPredio,
                            'predio' => $predio,
                            'propietario' => $propietario,
                            'tenencia' => $tenencia,
                            'departamento' => $predio->Vereda->Municipio->Departamento->id,
                            'municipio' => $predio->Vereda->Municipio->id,
                        ]);
                    } else {
                        $idPredio = '';
                        $predio = '';
                        $tenencia = '';
                        $propietario = '';
                        $bandera = 0;
                    }
                    
                } else {
                    $idPredio = '';
                    $predio = '';
                    $tenencia = '';
                    $propietario = '';
                    $bandera = 0;
                }
                
            }else {
                $predio = Predio::findOrFail($request->idPredio);
                //dd($predio);
                $propietario = PropietariosPredio::where('id_predio',$request->idPredio)->first();
                $tenencia = TenenciaTierra::where('id_informacion',$request->idInfo)->get()->first();
                $idPredio = '';
                $bandera = 0;
                
                return response()->json([
                    'estado'=> 'ok',
                    'bandera' => $bandera,
                    'infoVivienda' => $idPredio,
                    'predio' => $predio,
                    'propietario' => $propietario,
                    'tenencia' => $tenencia,
                    'departamento' => $predio->Vereda->Municipio->Departamento->id,
                    'municipio' => $predio->Vereda->Municipio->id,
                ]);
            }

            
            
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }

    }

    public function getGeneralidades(Request $request){

        try{
            $general = Generalidade::where('id_informacion', $request->idInfo)->first();
            //dd($general);
            if ($general == null) {
                $info_vivienda = Subsidio::where('id_beneficiario', $request->id)
                                    ->where('id_info_vivienda', '<', $request->idInfo)
                                    ->orderBy('created_at', 'desc')->first();
                if ($info_vivienda != null) {
                    $idPredio = InformacionVivienda::where('id', $info_vivienda->id_info_vivienda)->first();
                    $generalidades = Generalidade::where('id_informacion', $idPredio->id)->first();
                    $bandera = 1;                    
                }else{
                    $idPredio= '';
                    $generalidades = '';
                    $bandera = 0;
                }
            }else {
                $generalidades = Generalidade::where('id_informacion', $request->idInfo)->first();
                $idPredio = '';
                $bandera = 0;
            }

            
            return response()->json([
                'estado'=> 'ok',
                'generalidades' => $generalidades,
                'info_vivienda' =>$idPredio,
                'bandera' => $bandera 

            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                //'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
                'mensaje'=> 'Error en el servidor ',
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
                $generalidades->relacion_otro = $request->generalidades->relacion_otro;
                $generalidades->descripcion_relacion = $request->generalidades->descripcion_relacion;
                $generalidades->save();
                $idGeneralidades = $generalidades->id;

                 $infoVivienda = InformacionVivienda::findOrFail($request->infoVivienda->id);
                $infoVivienda->fecha_encuesta = $request->infoVivienda->fechaEncuesta;
                $infoVivienda->responde_propietario = $request->infoVivienda->respondePropietario;
                $infoVivienda->no_familias_vivienda = $request->infoVivienda->numeroFamiliasVivienda;
                $infoVivienda->beficiarios_prog_inv_social = $request->infoVivienda->programaSocial;
                $infoVivienda->save();

            }else{
                $generalidades = new Generalidade();
                $generalidades->id_informacion = $request->infoVivienda->id;
                $generalidades->fecha_vive_vereda = $request->generalidades->fechaViveVereda;
                $generalidades->fecha_vive_vivienda = $request->generalidades->fechaViveVivienda;
                $generalidades->id_tipo_vehiculo = $request->generalidades->idTipoVehiculo;
                $generalidades->id_tipo_via_acceso = $request->generalidades->idTipoViaAcceso;
                $generalidades->id_estado_via = $request->generalidades->idEstadoVia;
                $generalidades->id_tiempo_recorrido = $request->generalidades->idTiempoRecorrido;
                $generalidades->id_tipologia_familia = $request->generalidades->idTipologiaFamilia;
                $generalidades->relacion_otro = $request->generalidades->relacion_otro;
                $generalidades->descripcion_relacion = $request->generalidades->descripcion_relacion;
                $generalidades->save();
                $idGeneralidades = $generalidades->id;

                $infoVivienda = InformacionVivienda::findOrFail($request->infoVivienda->id);
                $infoVivienda->fecha_encuesta = $request->infoVivienda->fechaEncuesta;
                $infoVivienda->responde_propietario = $request->infoVivienda->respondePropietario;
                $infoVivienda->no_familias_vivienda = $request->infoVivienda->numeroFamiliasVivienda;
                $infoVivienda->beficiarios_prog_inv_social = $request->infoVivienda->programaSocial;
                $infoVivienda->save();

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

    public function getInformacionVivienda(Request $request){
        $info = InformacionVivienda::all();
        $data = new Collection();
        foreach ($info as $item) {
            $data->add([
                'idInfo'=> $item->id,
                'consecutivo' => $item->consecutivo,
                'fechaEncuesta' => $item->fecha_encuesta,
                'predio'=>$item->Predio->nombre_predio,
                'vereda' => @$item->Predio->Vereda->vereda,
                'municipio' => @$item->Predio->Vereda->Municipio->municipio,
                'documento'=> @$item->HabitantesViviendas->where('cabeza_hogar',true)->first()->no_cedula,
                'nombres'=> @$item->HabitantesViviendas->where('cabeza_hogar',true)->first()->nombres,
                'apellidos'=> @$item->HabitantesViviendas->where('cabeza_hogar',true)->first()->apellidos,
            ]);
        }


        return response()->json([
            'estado'=> 'ok',
            //'data' => $info,
            'data' => $data
        ]);

        // fecha beneficiario, identificacion , vereda municipio
    }

    public function getPersonasCargo(Request $request){
        $personas = PersonasCargo::all();
        $data = new Collection();
        foreach ($personas as $persona){
            $data->add([
                'id' => $persona->id,
                'edad' => Carbon::createFromFormat('Y-m-d', $persona->fecha_nacimiento)->age,
                'genero' => $persona->Genero->genero,
                'tipo' => $persona->TipoPersonasCargo->tipo_persona,
                'educacion' => $persona->NivelEducativo->nivel_educativo,
                'id_genero' => $persona->id_genero,
                'fecha_nacimiento' => $persona->fecha_nacimiento,
                'id_nivel_educativo' => $persona->id_nivel_educativo,
                'id_tipo' => $persona->id_tipo,
                'observaciones' => $persona->observaciones

            ]);
        }

        return response()->json([
            'estado' => 'ok',
            'data'  => $data
        ]);
    }

    public function DeletePersonaCargo(Request $request){
        //dd($request);
        try{
            PersonasCargo::find($request->persona)->delete();
            return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Beneficiario Eliminado'

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

        }catch (TokenMismatchException $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function agregarPersonaCargo(Request $request){
        $request =  json_decode($request->getContent());

        try{
            if($request->persona->id == ''){
                $persona = new PersonasCargo();
                $persona->fecha_nacimiento = $request->persona->fecha_nacimiento;
                $persona->observaciones = $request->persona->observaciones;
                $persona->id_nivel_educativo = $request->persona->id_nivel_educativo;
                $persona->id_informacion = $request->idInfo;
                $persona->id_genero = $request->persona->id_genero;
                $persona->id_tipo = $request->persona->id_tipo;
                $persona->save();

                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Persona Agregada',
                    'persona' => [
                        'id' => $persona->id,
                        'edad' => Carbon::createFromFormat('Y-m-d', $persona->fecha_nacimiento)->age,
                        'genero' => $persona->Genero->genero,
                        'tipo' => $persona->TipoPersonasCargo->tipo_persona,
                        'educacion' => $persona->NivelEducativo->nivel_educativo,
                        'id_genero' => $persona->id_genero,
                        'fecha_nacimiento' => $persona->fecha_nacimiento,
                        'id_nivel_educativo' => $persona->id_nivel_educativo,
                        'id_tipo' => $persona->id_tipo,
                        'observaciones' => $persona->observaciones
                    ]
                ]);

            }else{
                $persona = PersonasCargo::find($request->persona->id);
                $persona->fecha_nacimiento = $request->persona->fecha_nacimiento;
                $persona->observaciones = $request->persona->observaciones;
                $persona->id_nivel_educativo = $request->persona->id_nivel_educativo;
                $persona->id_informacion = $request->idInfo;
                $persona->id_genero = $request->persona->id_genero;
                $persona->id_tipo = $request->persona->id_tipo;
                $persona->save();

                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Persona Editada',
                    'persona'  => [
                    'id' => $persona->id,
                    'edad' => Carbon::createFromFormat('Y-m-d', $persona->fecha_nacimiento)->age,
                    'genero' => $persona->Genero->genero,
                    'tipo' => $persona->TipoPersonasCargo->tipo_persona,
                    'educacion' => $persona->NivelEducativo->nivel_educativo,
                    'id_genero' => $persona->id_genero,
                    'fecha_nacimiento' => $persona->fecha_nacimiento,
                    'id_nivel_educativo' => $persona->id_nivel_educativo,
                    'id_tipo' => $persona->id_tipo,
                    'observaciones' => $persona->observaciones
                    ]
                ]);
            }

        }catch (QueryException $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);

        }catch (TokenMismatchException $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()
            ]);
        }


    }
    public function agregarFotos(Request $request){
        $request =  json_decode($request->getContent());
        $fotos = new Collection();
        foreach($request->images as $img){
            $imageData = $img;
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->save(public_path('/img/vivienda/diagnostico/').$fileName, 60);
            $foto = new Fotografia();
            $foto->ruta = '/img/vivienda/diagnostico/'.$fileName;
            $foto->tipo = 1;
            $foto->id_informacion = $request->id;
            $foto->save();
            $fotos->add($foto);
            //return response()->json(['error'=>false]);
        }
        return response([
            'estado' => 'ok',
            'fotos' => $fotos

        ]);

    }

    public function todasImagenes(Request $request){
        try{
            $fotos = Fotografia::where('id_informacion', $request->id)->where('tipo', $request->tipo)->get();
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
    public function getComplementosCierre(Request $request){
        $riesgos = $this->getEnumValues('indicadores','zonas_riesgos');
        return response()->json([
            'estado' => 'ok',
            'data' => $riesgos,
            'indicadores' => Indicadore::where('id_informacion',$request->id)->first()

        ]);
    }

    public function getCasoEspecial(Request $request){
        //dd($request->id);
        $caso_especial = Subsidio::where('id_tipo_subsidio',1)->where('id_info_vivienda', $request->id)->firstOrFail();
        //dd($caso_especial);
        return response()->json([
            'estado' => 'ok',
            'caso' => $caso_especial->caso_especial == 1 ? true : false,
            'razon' => $caso_especial->razon_especial,

        ]);
    }


    public function getComplementosCierreTipoInfraestructura(Request $request){

        $tipos_infraestructuras = $this->getEnumValues('indicadores','tipos_infraestructuras');
        return response()->json([
            'estado' => 'ok',
            'data' => $tipos_infraestructuras,
            'indicadores' => Indicadore::where('id_informacion',$request->id)->first()

        ]);
    }

    public function getComplementosCierreTipoRiesgo(Request $request){

        $tipos_riesgos = $this->getEnumValues('indicadores','tipos_riesgos');
        return response()->json([
            'estado' => 'ok',
            'data' => $tipos_riesgos,
            'indicadores' => Indicadore::where('id_informacion',$request->id)->first()

        ]);
    }

    public function getdatoshabitacion(Request $request){

        $tipos_riesgos = $this->getEnumValues('indicadores','tipos_riesgos');
        return response()->json([
            'estado' => 'ok',
            'data' => $tipos_riesgos,
            'indicadores' => Indicadore::where('id_informacion',$request->id)->first()

        ]);
    }



    public function saveIndicadores(Request$request){
        try{
            if($request->id == ''){
                $indicadores = new Indicadore();
                $indicadores->hacinamiento = $request->hacinamiento;
                $indicadores->saneamiento_basico = $request->saneamiento_basico;
                $indicadores->condiciones_seguridad = $request->condiciones_seguridad;
                $indicadores->id_informacion = $request->id_informacion;
                $indicadores->no_habitaciones = $request->no_habitaciones;
                $indicadores->no_personas_vivienda = $request->no_personas_vivienda;
                $indicadores->estados_vivienda_id = $request->estados_vivienda_id;
                $indicadores->zonas_riesgos = collect($request->zonas_riesgos)->implode(',');
                $indicadores->otro_riesgo = $request->otro_riesgo;
                $indicadores->infraestructura_cercana = $request->infraestructura_cercana;
                $indicadores->tipos_infraestructuras = collect($request->tipos_infraestructuras)->implode(',');
                $indicadores->tipos_riesgos = collect($request->tipos_riesgos)->implode(',');
                $indicadores->propiedad_geopark = $request->propiedad_geopark;
                $indicadores->obra_proyectada = $request->obra_proyectada;
                $indicadores->otra_infraestructura = $request->otra_infraestructura;
                $indicadores->cual_infraestructura = $request->cual_infraestructura;

                $indicadores->save();    
                
                Subsidio::where('id_info_vivienda', $request->id_informacion)
                    ->where('id_tipo_subsidio', 1)
                    ->update([
                        'caso_especial' => $request->caso_especial,
                        'razon_especial' => $request->razon_especial,
                    ]);
            }else{
                $indicadores = Indicadore::find($request->id);
                $indicadores->hacinamiento = $request->hacinamiento;
                $indicadores->saneamiento_basico = $request->saneamiento_basico;
                $indicadores->condiciones_seguridad = $request->condiciones_seguridad;
                //$indicadores->id_informacion = $request->id_informacion;
                $indicadores->no_habitaciones = $request->no_habitaciones;
                $indicadores->no_personas_vivienda = $request->no_personas_vivienda;
                $indicadores->estados_vivienda_id = $request->estados_vivienda_id;
                $indicadores->zonas_riesgos = collect($request->zonas_riesgos)->implode(',');
                $indicadores->otro_riesgo = $request->otro_riesgo;
                $indicadores->infraestructura_cercana = $request->infraestructura_cercana;
                $indicadores->tipos_infraestructuras = collect($request->tipos_infraestructuras)->implode(',');
                $indicadores->tipos_riesgos = collect($request->tipos_riesgos)->implode(',');
                $indicadores->propiedad_geopark = $request->propiedad_geopark;
                $indicadores->obra_proyectada = $request->obra_proyectada;

                $indicadores->save();

                Subsidio::where('id_info_vivienda', $request->id_informacion)
                    ->where('id_tipo_subsidio', 1)
                    ->update([
                        'caso_especial' => $request->caso_especial,
                        'razon_especial' => $request->razon_especial,
                    ]);
            }

            return response()->json([
                'estado' => 'ok',
                'mensaje'=> 'Cierre Guardado',
                'id' => $indicadores->id
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

        }catch (TokenMismatchException $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function getEnumValues($table, $column) {
        $type = DB::select( DB::raw("SHOW COLUMNS FROM ".$table." WHERE Field = '".$column."'") )[0]->Type;
        $dataTypes = explode("(", $type);
        $dataType = $dataTypes[0];
        if ($dataType == 'enum' || $dataType=='set'){
            preg_match('/^'.$dataType.'\((.*)\)$/', $type, $matches);
            $enum = array();
            foreach( explode(',', $matches[1]) as $value )
            {
                $v = trim( $value, "'" );
                $enum = array_add($enum, $v, $v);
            }
            return array_keys($enum);
        }
        return;
    }

    

}
