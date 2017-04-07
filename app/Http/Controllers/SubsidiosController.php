<?php

namespace App\Http\Controllers;

use App\Subsidio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubsidiosController extends Controller
{
    public function getSubsidios(Request $request){

        $subsidios = Subsidio::where('id_tipo_subsidio',$request->tipoSubsidio)->Buscar($request->buscar)->paginate(10);
        //return $subsidios;
        $data = new Collection();
        foreach ($subsidios as $subs){

            $data->add([
                'vereda' => $subs->Fase->Vereda->vereda."(".$subs->Fase->Vereda->Municipio->municipio.")",
                'beneficiario' => $subs->Beneficiario->nombres." ". $subs->Beneficiario->apellidos." (".$subs->Beneficiario->no_cedula.")",
                'id' => $subs->id,
                //'campo'=> $subs->Vereda->Campo
                'consecutivo' => $subs->consecutivo,
                'id_tipo_subsidio' => $subs->id_tipo_subsidio,
                'id_fase' => $subs->id_fase,
                'fase' => $subs->Fase->nombre_fase,
                'fecha_inicio' => $subs->fecha_inicio,
                'valor' => $subs->valor,
                'id_info_vivienda' => $subs->id_info_vivienda,
                'id_info_productivo' => $subs->id_info_productivo,
                'porcentaje_ejecucion' => $subs->porcentaje_ejecucion,
                'entregado' => $subs->entregado,
                'obras_en_construccion' => $subs->obras_en_construccion,



            ]);

        }
        $pagination = ([
            'current_page' =>$subsidios->currentPage(),
            'from' => $subsidios->firstItem(),
            'last_page' =>$subsidios->lastPage(),
            'next_page_url' => $subsidios->nextPageUrl(),
            'per_page' => $subsidios->perPage(),
            'prev_page_url' => $subsidios->previousPageUrl(),
            'to' => $subsidios->lastItem(),
            'total' => $subsidios->total(),
        ]);

        return response()->json([
            'estado' => 'ok',
            'data' => $data,
            'pagination' => $pagination,
            ]);

    }

    public function index(){
        return view('subsidios_vivienda.index');
    }

    public function subsidiosVivienda(){
        return view('subsidios_vivienda.index');
    }
    public function subsidiosProductivos(){
        return view('subsidios_productivos.index');
    }

    public function guardarSubsidio(Request $request){

        try{
            $request =  json_decode($request->getContent());
            $consecutivo = 1;
            $last = Subsidio::where('id_tipo_subsidio', $request->subsidio->id_tipo_subsidio)->get()->last();
            if($last != null){
                $consecutivo = $last->consecutivo + 1;
            }

            $id = '';

            if($request->subsidio->id_beneficiario == ''){
                $idBeneficiario = BeneficiariosController::guardarBeneficiario($request->beneficiario);
                if($idBeneficiario != 0){
                    $subsidio = new Subsidio();
                    $subsidio->id_beneficiario = $idBeneficiario;
                    $subsidio->consecutivo = $consecutivo;
                    $subsidio->id_tipo_subsidio = $request->subsidio->id_tipo_subsidio;
                    $subsidio->id_fase = $request->subsidio->id_fase;
                    $subsidio->fecha_inicio = $request->subsidio->fecha_inicio;
                    $subsidio->valor = $request->subsidio->valor;
                    $subsidio->id_usuario = Auth::User()->id;
                    $subsidio->observaciones = $request->subsidio->observaciones;

                    $subsidio->save();
                    $id = $subsidio->id;

                    return response()->json([
                        'estado' => 'ok',
                        'id' => $id,
                        'idBeneficiario' => $subsidio->id_beneficiario,
                        'vereda' => $subsidio->Fase->Vereda->vereda."(".$subsidio->Fase->Vereda->Municipio->municipio.")",
                        'beneficiario' => $subsidio->Beneficiario->nombres." ". $subsidio->Beneficiario->apellidos." (".$subsidio->Beneficiario->no_cedula.")",
                        'consecutivo' => $subsidio->consecutivo
                    ]);

                }
            }else{
                $subsidio = new Subsidio();
                $subsidio->id_beneficiario = $request->subsidio->id_beneficiario;
                $subsidio->id_tipo_subsidio = $request->subsidio->id_tipo_subsidio;
                $subsidio->consecutivo = $consecutivo;
                $subsidio->id_fase = $request->subsidio->id_fase;
                $subsidio->fecha_inicio = $request->subsidio->fecha_inicio;
                $subsidio->valor = $request->subsidio->valor;
                $subsidio->id_usuario = Auth::User()->id;
                $subsidio->observaciones = $request->subsidio->observaciones;
                $subsidio->save();
                $id = $subsidio->id;

                return response()->json([
                    'estado' => 'ok',
                    'id' => $id,
                    'idBeneficiario' => $subsidio->id_beneficiario,
                    'vereda' => $subsidio->Fase->Vereda->vereda."(".$subsidio->Fase->Vereda->Municipio->municipio.")",
                    'beneficiario' => $subsidio->Beneficiario->nombres." ". $subsidio->Beneficiario->apellidos." (".$subsidio->Beneficiario->no_cedula.")",
                    'consecutivo' => $subsidio->consecutivo
                ]);
            }


        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }




    }

}
