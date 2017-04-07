<?php

namespace App\Http\Controllers;



use App\Beneficiario;
use App\BeneficiarioVivienda;
use App\Fotografia;
use App\Generalidade;
use App\InformacionVivienda;
use App\PersonasCargo;
use App\Predio;
use App\PropietariosPredio;
use App\Subsidio;
use App\TenenciaTierra;
use Carbon\Carbon;
use Faker\Provider\File;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
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
                $last = InformacionVivienda::all()->last();
                if($last == null){
                    $consecutivo = 1;
                }else{
                    $consecutivo = $last->consecutivo + 1;
                }

                $informacion = new InformacionVivienda();
                $informacion->fecha_encuesta = $request->fechaEncuesta;
                $informacion->responde_propietario = $request->respondePropietario;
                $informacion->no_familias_vivienda = $request->numeroFamiliasVivienda;
                $informacion->beficiarios_prog_inv_social = $request->programaSocial;
                $informacion->consecutivo = $consecutivo;
                $informacion->id_usuario = Auth::User()->id;
                $informacion->save();

                $subsidio = Subsidio::find($request->subsidio);
                $subsidio->id_info_vivienda = $informacion->id;
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

                $propietario = PropietariosPredio::findOrFail($request->propietario->id);
                $propietario->no_cedula = $request->propietario->noCedula;
                $propietario->nombres_propietario = $request->propietario->nombres;
                $propietario->apellidos_propietario = $request->propietario->apellidos;
                $propietario->no_telefonico = $request->propietario->telefono;
                $propietario->id_predio = $predio->id;
                $propietario->save();

                $tenencia = TenenciaTierra::find($request->tenencia->id);
                $tenencia->area_predio_has = $request->tenencia->area_predio_has;
                $tenencia->id_opcion = $request->tenencia->id_opcion;
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
                //if($request->tenencia->pdf){

                //}


                $tenencia->save();



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
                $tenencia->id_tipo_tenencia_tierras = $request->tenencia->id_tipo_tenencia_tierras;
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
                'mensaje' => 'Error al guardar '.$ee->getMessage(),
            ]);
        }


    }
    public function getPredio(Request $request){

        try{
            $predio = Predio::findOrFail($request->idPredio);
            $propietario = PropietariosPredio::findOrFail($request->idPredio);
            $tenencia = TenenciaTierra::where('id_informacion',$request->idInfo)->get()->first();
            return response()->json([
                'estado'=> 'ok',
                'predio' => $predio,
                'propietario' => $propietario,
                'tenencia' => $tenencia,
                'departamento' => $predio->Vereda->Municipio->Departamento->id,
                'municipio' => $predio->Vereda->Municipio->id,
            ]);
        }catch (QueryException $ee ){
            return response()->json([
                'estado'=>'fail',
                'mensaje'=> 'Error en el servidor '+ $ee->getMessage(),
            ]);
        }

    }

    public function getGeneralidades(Request $request){

        try{
            $generalidades = Generalidade::where('id_informacion', $request->idInfo)->first();
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

}
