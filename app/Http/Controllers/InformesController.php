<?php

namespace App\Http\Controllers;

use App\Campo;
use App\CamposVereda;
use App\InformacionVivienda;
use App\Municipio;
use App\Subsidio;
use App\Vereda;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InformesController extends Controller
{
    //

    public function index(){

        return view('informes.index');


    }




    public function getDataReport(Request $request){

        $subsidios = '';
        if($request->campo == "9999"  && $request->municipio == "9999"){
            if($request->tipo == '9999'){
                $subsidios = Subsidio::whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('TipoSubsidio.tipo_subsidio', true);
            }else{
                $subsidios = Subsidio::where('id_tipo_subsidio', $request->tipo)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('TipoSubsidio.tipo_subsidio', true);
            }

        }

        if($request->campo != '9999' && $request->vereda == '9999'){
            $veredas = Campo::find($request->campo)->VeredasCampo->pluck('id');
            if($request->tipo == '9999'){
                $subsidios = Subsidio::whereIn('id_vereda',$veredas)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('Vereda.vereda', true);
            }else{
                $subsidios = Subsidio::whereIn('id_vereda',$veredas)->where('id_tipo_subsidio', $request->tipo)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('Vereda.vereda', true);
            }

        }

        if($request->municipio != '9999' && $request->vereda == '9999'){
            $veredas = Vereda::where('id_municipio', $request->municipio)->pluck('id');
            if($request->tipo == '9999'){

                $subsidios = Subsidio::whereIn('id_vereda',$veredas)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('Vereda.vereda', true);
            }else{
                $subsidios = Subsidio::whereIn('id_vereda',$veredas)->where('id_tipo_subsidio', $request->tipo)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('Vereda.vereda', true);
            }
        }

        if($request->vereda != '9999'){
            if($request->tipo == '9999'){
                $subsidios = Subsidio::where('id_vereda', $request->vereda)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('TipoSubsidio.tipo_subsidio', true);
            }else{
                $subsidios = Subsidio::where('id_tipo_subsidio', $request->tipo)->where('id_vereda', $request->vereda)->whereBetween('fecha_inicio', [$request->fechaInicial, $request->fechaFinal])->get();
                $subsidios = $subsidios->groupBy('TipoSubsidio.tipo_subsidio', true);
            }
        }


        //$veredas = CamposVereda::where('id_campo',1)->Veredas->get();
        //$veredas = Campo::find(2)->VeredasCampo;
        //$lista = [];
        //foreach ( $veredas as $item){
          //  array_push($lista,$item->id);
            //dd($item);
        //}
        //return ($lista);
        //$subsidios = Subsidio::whereIn('id_vereda',$lista)->get();
        //$subsidios = $subsidios->groupBy('Vereda.vereda', true);
        //return $xx;
        //$subsidios = Subsidio::all()->groupBy('Vereda.vereda', true);
        //$subsidios = Subsidio::all()->groupBy('TipoSubsidio.tipo_subsidio', true);
        //$subsidios = Subsidio::all()->groupBy('Vereda.Municipio.municipio', true);
        //$subsidios = Subsidio::all()->groupBy('Vereda.Municipio.Departamento.departamento', true);
        //return $subsidios;
        //$subsidios = Subsidio::all()->groupBy('Vereda.CamposVereda.Campo', true);

        $data = new Collection();
        $subsidios->each(function ($item, $key) use ($data) {
            $data->add([
                $key => $this->consolidadoSubsidios($item)
            ]);
        });

        //return $data;






        return response()->json([
            'estado' => 'ok',
            'data' =>$data ,
        ]);

    }

    public function consolidadoSubsidios($subsidios){
        $data = new Collection();
        foreach ( $subsidios as $subsidio){
            $data->add([
                'id'=> $subsidio->id,
                'diagnostico' =>  ($subsidio->id_info_vivienda != null ? $subsidio->InformacionVivienda : $subsidio->InformacionProductivos) != '' ? true : false,
                'valor' => $subsidio->valor,
                'vereda' => $subsidio->Vereda,
                'municipio' => $subsidio->Vereda->Municipio,
                'fecha_inicio' => $subsidio->fecha_inicio,
                'tipo_subsidio' => $subsidio->TipoSubsidio->tipo_subsidio,
                'valor_ejecutado' => $subsidio->valor_ejecutado,
                'porcentaje_ejecucion' => $subsidio->valor_ejecutado * 100 / $subsidio->valor,
                'concertado' => $subsidio->concertado,
                'entregado' => $subsidio->entregado,
                'obras_en_construccion' => $subsidio->obras_en_construccion,
                'visitas_seguimiento' =>$subsidio->Visitas->where('id_tipo_visita',2)->count(),
                'visitas_entrega' =>$subsidio->Visitas->where('id_tipo_visita',3)->count()

            ]);
        }
        $datos = new Collection([
            'numeroSubsidio' => $data->count(),
            'concertados' => $data->where('concertado', 1)->count(),
            'entregado' => $data->where('entregado', 1)->count(),
            'obras_en_construccion' => $data->where('obras_en_construccion', 1)->count(),
            'valor' => $data->sum('valor'),
            'ejecutado' => $data->sum('valor_ejecutado'),
            'visitas_seguimiento' => $data->sum('visitas_seguimiento'),
            'visitas_entrega' => $data->sum('visitas_entrega'),
            'visitas_diagnostico' => $data->sum('diagnostico'),


        ]);
        //dd($data);
        return $datos;

    }
    public function reporteDiagnosticoVivienda($id){
        $info_vivienda = InformacionVivienda::find($id);
        //return 'ok';
        //$pdf = PDF::loadView('informes.diagnostico_vivienda',$info_vivienda);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('informes.diagnostico_vivienda',compact('info_vivienda'));
        return  $pdf->stream('invoice.pdf');
        //return view('informes.diagnostico_vivienda', compact('info_vivienda'));
<<<<<<< HEAD
        //comentrio para juanchoooo pkkkkkk Parece que si 3 2 1
=======
        //comentrio para juanchoooo pkkkkkk Parece que si yesss
>>>>>>> origin/master
    }
}
