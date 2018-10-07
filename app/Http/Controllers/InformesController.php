<?php

namespace App\Http\Controllers;

use App\Campo;
use App\CamposVereda;
use App\Fase;
use App\InformacionVivienda;
use App\InformacionProductivos;
use App\Municipio;
use App\OrdenServicio;
use App\Subsidio;
use App\Vereda;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InformesController extends Controller
{
    //

    public function index(){

        return view('informes.index');


    }




    public function getDataReport(Request $request){

        $subsidios = '';
        $datosGenerales = '';

        if($request->campo == "9999"  && $request->fase == "9999"){
            $subsidios = OrdenServicio::find($request->ordenServicio)->Subsidios;
            $datosGenerales = $subsidios;

            if($request->tipo == '9999'){
                $subsidios = $subsidios->where('valor', '<>', 0)
                                        ->where('porcentaje_ejecucion', '<>', 0)
                                        ->where('caso_especial', '=', 0)
                                        ->groupBy( 'Fase.nombre_fase');
                //dd($subsidios);
            }else{
                $subsidios = $subsidios->where('id_tipo_subsidio', $request->tipo)
                                        ->where('caso_especial', '=', 0)
                                        ->where('valor', '<>', 0);
                //dd($subsidios);
                $datosGenerales = $subsidios;
                $subsidios = $subsidios->groupBy( 'Fase.nombre_fase');
            }
        }

        if($request->campo == "9999"  && $request->fase != "9999"){
            $subsidios = Fase::find($request->fase)->Subsidios;
            $datosGenerales = $subsidios;
            if($request->tipo == '9999'){
                $subsidios = $subsidios->where('valor', '<>', 0)
                                        ->where('caso_especial', '=', 0)
                                        ->groupBy( 'Fase.nombre_fase');
            }else{
                $subsidios = $subsidios->where('id_tipo_subsidio', $request->tipo)
                                        ->where('caso_especial', '=', 0);
                $datosGenerales = $subsidios;
                $subsidios = $subsidios->groupBy( 'Fase.nombre_fase');
            }
        }

        if($request->campo != "9999"  && $request->fase != "9999"){
            $subsidios = Fase::find($request->fase)->Subsidios;

            $veredas = Campo::find($request->campo)->Veredas;
            $veredas = $veredas->pluck('id');
            if ($request->vereda == '9999') {
                $subsidios = $subsidios->whereIn('id_vereda',$veredas);
            }else{

                $subsidios = $subsidios->whereIn('id_vereda',$request->vereda);
            }
            $datosGenerales = $subsidios;
            if($request->tipo == '9999' || $request->vereda == '9999'){
                $subsidios = $subsidios->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupBy( 'Vereda.Campo.nombre_campo');
            }else{
                $subsidios = $subsidios->where('id_tipo_subsidio', $request->tipo);
                $datosGenerales = $subsidios;
                $subsidios = $subsidios->where('valor', '<>', 0)
                                        ->where('caso_especial', '=', 0)
                                        ->where('id_vereda', '=', $request->vereda)
                                        ->groupBy( 'Vereda.Campo.nombre_campo');
            }

        }

        if($request->campo != "9999"  && $request->fase == "9999"){
            $subsidios = OrdenServicio::find($request->ordenServicio)->Subsidios;
            //$datosGenerales = $subsidios;
            $veredas = Campo::find($request->campo)->Veredas;
            $veredas = $veredas->pluck('id');
            if ($request->vereda == '9999') {
                $subsidios = $subsidios->whereIn('id_vereda',$veredas);
            }else{

                $subsidios = $subsidios->whereIn('id_vereda',$request->vereda);
            }
            //$subsidios = $subsidios->whereIn('id_vereda',$request->vereda);
            $datosGenerales = $subsidios;
            if($request->tipo == '9999' || $request->vereda == '9999'){
                $subsidios = $subsidios->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupBy( 'Vereda.Campo.nombre_campo');
            }else{
                $subsidios = $subsidios->where('id_tipo_subsidio', $request->tipo);
                $datosGenerales = $subsidios;
                $subsidios = $subsidios->where('valor', '<>', 0)
                                        ->where('caso_especial', '=', 0)
                                        ->where('id_vereda', '=', $request->vereda)
                                        ->groupBy( 'Vereda.Campo.nombre_campo');
            }

        }


    /*

        if($request->campo == "9999"  && $request->fase == "9999"){
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
*/

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






        //return $data;




    //return $datosGenerales;

        return response()->json([
            'estado' => 'ok',
            'data' =>$this->tabularInfo($subsidios,$request->campo),
            'dataBloque' => $this->tabularInfoBloque($datosGenerales,$request->campo),



        ]);

    }
    public function tabularInfoBloque($subsidios, $bloque){
        $data = new Collection();

        if($bloque != '9999'){
            /*
            $subsidios->each(function ($item, $key) use ($data) {
                $data2 = new Collection();
                $item = $item->groupBy('Vereda.nombre_vereda');
                $item->each(function ($item,$key) use ($data2){
                    $data2->add([
                        $key=> $this->consolidadoSubsidios($item)
                    ]);

                }) ;
                $data->add([
                    $key => $data2->all()
                ]);
            });
            */
            $subsidios = $subsidios->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupBy('Vereda.vereda');
            $subsidios->each(function ($item, $key) use ($data) {
                $data->put($key,$this->consolidadoSubsidios($item));

            });

        }else{
            
            $subsidios = $subsidios->where('valor', '<>', 0)
                                    ->where('caso_especial', '=', 0)
                                    ->groupBy('Vereda.Campo.nombre_campo');
            $subsidios->each(function ($item, $key) use ($data) {
                $data->put($key,$this->consolidadoSubsidios($item));

            });
            
            
        }


        return $data->all();
    }

    public function tabularInfo($subsidios, $bloque){
        $data = new Collection();

        if($bloque != '9999'){
            $subsidios->each(function ($item, $key) use ($data) {
                $item = $item->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupby('Fase.nombre_fase');
                $data2 = new Collection();
                $item->each(function ($sub, $key) use ($data2){
                    $subsbloque = $sub->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupBy('Vereda.vereda');
                    $data3 = new Collection();
                    $subsbloque->each(function ($itemBloque, $key) use ($data3){
                       $data3->put(
                           $key, $this->consolidadoSubsidios($itemBloque)
                       );

                    });


                    $data2->put(
                        $key, $data3
                    );
                });
                $data->put(
                    $key , $data2
                );
            });

        }else{
            
            $subsidios->each(function ($item, $key) use ($data) {
                $data2 = new Collection();
                $item = $item->where('valor', '<>', 0)->where('caso_especial', '=', 0)->groupBy('Vereda.Campo.nombre_campo');
                $item->each(function ($item,$key) use ($data2){
                    $data2->add([
                        $key=> $this->consolidadoSubsidios($item)
                    ]);

                }) ;
                $data->add([
                    $key => $data2->all()
                ]);
            });
            
            
        }
        //$this->ExportExcel();
        return $data->all();



    }

    public function consolidadoSubsidios($subsidios){
        //dd($subsidios);
        $data = new Collection();
        $i=0;
        foreach ( $subsidios as $subsidio){
            //dd($subsidio);
            /*$indicadores = DB::table('informacion_viviendas')
                                ->join('indicadores', 'informacion_viviendas.id', '=', 'indicadores.id_informacion')
                                ->where('informacion_viviendas.id', '=', $subsidio->id_info_vivienda)
                                ->select('indicadores.hacinamiento', 'indicadores.saneamiento_basico', 'indicadores.condiciones_seguridad', 'indicadores.estados_vivienda_id')
                                ->get();
            dd($indicadores);*/

            $data->add([
                'id'=> $subsidio->id,
                'diagnostico' =>  ($subsidio->id_info_vivienda != null ? $subsidio->InformacionVivienda : $subsidio->InformacionProductivos) != '' ? true : false,
                'valor' => $subsidio->valor,
                'vereda' => $subsidio->Vereda,
                'fecha_inicio' => $subsidio->fecha_inicio,
                'tipo_subsidio' => $subsidio->TipoSubsidio->tipo_subsidio,
                
                'id_tipo_subsidio'=>$subsidio->id_tipo_subsidio,
                'valor_ejecutado' => $subsidio->valor_ejecutado,
                'porcentaje_ejecucion' => $subsidio->valor_ejecutado * 100 / $subsidio->valor,
                'concertado' => $subsidio->concertado,
                'entregado' => $subsidio->entregado,

                'estados_vivienda' => ($subsidio->id_info_vivienda != null ? $subsidio->InformacionVivienda->Indicadore : 0),
                //'tipo_proyecto' => $subsidio->InformacionProductivos->Generalidade->TipoProyecto,
                //'estados_vivienda_regular' => $subsidio->InformacionVivienda->Indicadore->where('estados_vivienda_id', 2)->count(),
                //'estados_vivienda_bueno1' => $subsidio->InformacionVivienda->Indicadore->where('estados_vivienda_id', 3)->count(),
                //'estados_vivienda_bueno2' => $subsidio->InformacionVivienda->Indicadore->where('estados_vivienda_id', 4)->count(),
                'obras_en_construccion' => $subsidio->obras_en_construccion,
                'visitas_seguimiento' =>$subsidio->Visitas->where('id_tipo_visita',2)->count(),
                'visitas_entrega' =>$subsidio->Visitas->where('id_tipo_visita',3)->count()

            ]);
            $i++;
        }
        //$i = 0;

        $datos = new Collection([
            'numeroSubsidio' => $data->count(),
            'subsidiosVivienda' => $data->where('id_tipo_subsidio',1)->count(),
            'subsidiosProyectos' => $data->where('id_tipo_subsidio',2)->count(),
            'concertados' => $data->where('concertado', 1)->count(),
            'entregado' => $data->where('entregado', 1)->count(),
            'obras_en_construccion' => $data->where('obras_en_construccion', 1)->count(),
            'valor' => $data->sum('valor'),
            'ejecutado' => $data->sum('valor_ejecutado'),
            'visitas_seguimiento' => $data->sum('visitas_seguimiento'),
            'visitas_entrega' => $data->sum('visitas_entrega'),
            'visitas_diagnostico' => $data->sum('diagnostico'),
            'estado_malo' => $data->where('estados_vivienda.estados_vivienda_id', 1)->count(),
            'estado_regular' => $data->where('estados_vivienda.estados_vivienda_id', 2)->count(),
            'estado_bueno1' => $data->where('estados_vivienda.estados_vivienda_id', 3)->count(),
            'estado_bueno2' => $data->where('estados_vivienda.estados_vivienda_id', 4)->count(),

            'hacinamiento' => $data->where('estados_vivienda.hacinamiento', 1)->count(),
            'saneamiento' => $data->where('estados_vivienda.saneamiento_basico', 1)->count(),
            'seguridad' => $data->where('estados_vivienda.condiciones_seguridad', 1)->count(),

            //'agricola' => $data->where('tipo_proyecto.id_tipo_proyecto', 2)->count(),
            //'estado_regular' => $data->estados_vivienda_regular,
            //'estado_bueno_sin' => $data->estados_vivienda_bueno1,
            //'estado_bueno_con' => $data->estados_vivienda_bueno2

        ]);
        //dd($datos);
        //$this->ExportExcel($datos);
        
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


        //comentrio para juanchoooo pkkkkkk Parece que si 3 2 1

    }

    public function reporteDiagnosticoProductivo($id){
        $info_productivo = InformacionProductivos::find($id);
        //return 'ok';
        //$pdf = PDF::loadView('informes.diagnostico_vivienda',$info_vivienda);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('informes.diagnostico_productivo',compact('info_productivo'));
        return  $pdf->stream('invoice.pdf');
        //return view('informes.diagnostico_vivienda', compact('info_vivienda'));


        //comentrio para juanchoooo pkkkkkk Parece que si 3 2 1

    }

    public function ExportExcel(Request $request)
    {
        
        if ($request->op == 1) {
            $arrayName = array();
            $i = 0;
            foreach ($request->data[0] as $key => $value) {
                $arrayName[$i] = array($key, $value);
                $i++;

            }
            $dataseriesLabels1 = array(
                new \PHPExcel_Chart_DataSeriesValues('String', 'ChartTest!$B$1', NULL, 1),
            );
            $dataSeriesValues1 = array(
                new \PHPExcel_Chart_DataSeriesValues('Number', '!$B$2:$B$'.count($request->data[0]), NULL),
            );
            for ($i=1; $i <= count($arrayName); $i++) { 
                $xAxisTickValues = array(
                    new \PHPExcel_Chart_DataSeriesValues('String', 'ChartTest!$A$2:$A$'.$i, NULL), //  Jan to Dec
                );
                # code...
            }
        }else{
            $arrayName = $request->data;
            //echo count($arrayName);
            $dataseriesLabels1 = array(
                new \PHPExcel_Chart_DataSeriesValues('String', '', NULL, 1),
            );
            $dataSeriesValues1 = array(
                new \PHPExcel_Chart_DataSeriesValues('Number', '!$B$1:$B$'.count($arrayName), NULL),
            );
            for ($i=1; $i <= count($arrayName); $i++) { 
                $xAxisTickValues = array(
                    new \PHPExcel_Chart_DataSeriesValues('String', 'ChartTest!$A$1:$A$'.$i, NULL), //  Jan to Dec
                );
                # code...
            }
        }
        
       
        $excel = new \PHPExcel();

        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');

        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray($arrayName);
                    
        

        //  Build the dataseries
        $series1 = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
                range(0, count($dataSeriesValues1) - 1), // plotOrder
                $dataseriesLabels1, // plotLabel
                $xAxisTickValues, // plotCategory
                $dataSeriesValues1                              // plotValues
        );
        //  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);

        /*$dataSeriesValues2 = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', '!$C$2:$C$13', NULL, 12),
        );

        //  Build the dataseries
        $series2 = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
                range(0, count($dataSeriesValues2) - 1), // plotOrder
                $dataseriesLabels2, // plotLabel
                NULL, // plotCategory
                $dataSeriesValues2                              // plotValues
        );

        $dataSeriesValues3 = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', '!$D$2:$D$13', NULL, 12),
        );

        //  Build the dataseries
        $series3 = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
                range(0, count($dataSeriesValues2) - 1), // plotOrder
                $dataseriesLabels3, // plotLabel
                NULL, // plotCategory
                $dataSeriesValues3                             // plotValues
        );*/


        //  Set the series in the plot area
        $plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($series1));
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        $title = new \PHPExcel_Chart_Title('Titulo 1');

        //  Create the chart
        $chart = new \PHPExcel_Chart(
                'chart1', // name
                $title, // title
                $legend, // legend
                $plotarea, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                NULL, // xAxisLabel
                NULL            // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');

        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);

        $writer = new \PHPExcel_Writer_Excel2007($excel);
        $writer->setIncludeCharts(TRUE);

        // Save the file.
        $writer->save(storage_path().'/'.Carbon::now()->timestamp.'file.xlsx');
        
    }
    
}
