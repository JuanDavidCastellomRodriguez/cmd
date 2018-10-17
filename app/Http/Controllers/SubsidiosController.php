<?php

namespace App\Http\Controllers;

use App\Predio;
use App\Subsidio;
use App\Municipio;
use App\Vereda;
use App\InformacionVivienda;
use App\ArchivoBeneficiario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Excel;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Border;
use PHPExcel_Style_Color;

class SubsidiosController extends Controller
{
    public function getSubsidios(Request $request){
        if ($request->caso_especial) {
            $subsidios = Subsidio::where('id_tipo_subsidio',$request->tipoSubsidio)
                                    ->where('caso_especial', 1)
                                    ->Buscar($request->buscar)->orderBy('id', 'desc')->paginate(10);
        } else {
            $subsidios = Subsidio::where('id_tipo_subsidio',$request->tipoSubsidio)->Buscar($request->buscar)->orderBy('id', 'desc')->paginate(10);
        }
        
        
        //return $subsidios->total();
        $data = new Collection();
        $pagination = "";
        $puntos = "";

        if($subsidios->total() > 0){
            foreach ($subsidios as $subs){

                //$puntos = $puntos.'{ position: { lat:'.$subs->InformacionVivienda->Predio->latitud.', lng:'.$subs->InformacionVivienda->Predio->latitud .'}},';
                
                $data->add([
                    'id' => $subs->id,
                    'id_tipo_subsidio' => $subs->id_tipo_subsidio == 1 ?'Beneficio vivienda' : 'Proyecto productivo',
                    'consecutivo' => $subs->consecutivo,
                    'fecha_inicio' => $subs->fecha_inicio,
                    'municipio' => $subs->Municipio->municipio,
                    'vereda' => $subs->id_vereda != null ? $subs->Vereda->vereda."(".$subs->Vereda->Municipio->municipio.")" : null,
                    'fase' => $subs->Fase->nombre_fase,
                    'id_fase' => $subs->id_fase,
                    'cedula_beneficiario' => $subs->Beneficiario->no_cedula,
                    'beneficiario' => $subs->Beneficiario->nombres." ". $subs->Beneficiario->apellidos." (".$subs->Beneficiario->no_cedula.")",
                    //'predio' => $subs->id_info_vivienda != null ? $subs->InformacionVivienda->id_predio : null,
                    //'nombre_predio' => $subs->id_info_vivienda != null ? $subs->InformacionVivienda->Predio : null,
                    //'campo'=> $subs->Vereda->Campo
                    'orden_servicio' => $subs->OrdenServicio->consecutivo,
                    'caso_especial' => $subs->caso_especial == 1 ? 'Si' : 'No',
                    'valor' => $subs->valor != 0 ? $subs->valor: '0',
                    'valor_beneficiario' => $subs->valor_beneficiario != 0 ? $subs->valor_beneficiario : '0',
                    'porcentaje_ejecucion' => $subs->porcentaje_ejecucion != 0 ? $subs->porcentaje_ejecucion : '0',
                    'id_info_vivienda' => $subs->id_info_vivienda,
                    'id_info_productivo' => $subs->id_info_productivo,
                    //'entregado' => $subs->entregado,
                    //'obras_en_construccion' => $subs->obras_en_construccion,

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

        }

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
            //dd($request);
            $consecutivo = 1;
            $vere = Vereda::find($request->subsidio->id_vereda);
            //dd($vere->id_municipio);
            $muni = Municipio::find($vere->id_municipio);
            //dd($muni);
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
                    $subsidio->id_orden = $request->subsidio->id_orden;
                    $subsidio->id_municipio = $muni->id;
                    $subsidio->id_vereda = $request->subsidio->id_vereda;
                    $subsidio->fecha_inicio = $request->subsidio->fecha_inicio;
                    $subsidio->valor = $request->subsidio->valor;
                    $subsidio->valor_beneficiario = $request->subsidio->valor_beneficiario;
                    $subsidio->id_usuario = Auth::User()->id;
                    $subsidio->observaciones = $request->subsidio->observaciones;

                    $subsidio->save();
                    $id = $subsidio->id;                    

                    return response()->json([
                        'estado' => 'ok',
                        'id' => $id,
                        'idBeneficiario' => $subsidio->id_beneficiario,
                        'vereda' => $subsidio->Vereda->vereda."(".$subsidio->Vereda->Municipio->municipio.")",
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
                $subsidio->id_orden = $request->subsidio->id_orden;
                $subsidio->id_municipio = $muni->id;
                $subsidio->id_vereda = $request->subsidio->id_vereda;
                $subsidio->fecha_inicio = $request->subsidio->fecha_inicio;
                $subsidio->valor = $request->subsidio->valor;
                $subsidio->valor_beneficiario = $request->subsidio->valor_beneficiario;
                $subsidio->id_usuario = Auth::User()->id;
                $subsidio->observaciones = $request->subsidio->observaciones;
                $subsidio->save();
                $id = $subsidio->id;

                
                return response()->json([
                    'estado' => 'ok',
                    'id' => $id,
                    'idBeneficiario' => $subsidio->id_beneficiario,
                    'vereda' => $subsidio->Vereda->vereda."(".$subsidio->Vereda->Municipio->municipio.")",
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

    public function obtenerDatosMapa(Request $request){
    //public function obtenerDatosMapa(){
        //$subsidios = Predio::where('id_vereda',$request->vereda)->Buscar($request->buscar)-get();

        //$subsidios = Predio::where('id_vereda',$request->vereda)->first();

        //$subsidios = Subsidio::where('id_tipo_subsidio',$request)->Buscar($request->buscar)->get();
        //$subsidios = Subsidio::Buscar($request->buscar)->get();
        //return $subsidios->total();

        $subsidios = Subsidio::with(['InformacionVivienda.Predio']);

        if($request->fase != ''){
            $subsidios->where('id_fase',$request->fase);
        }
        if($request->tipoSubsidio != ''){
            $subsidios->where('id_tipo_subsidio',$request->tipoSubsidio);
        }
        if($request->campo != ''){
            $subsidios->whereHas('Vereda',function ($query) use ($request){
                $query->where('id_campo',$request->campo);
            });
        }
        if($request->vereda != ''){
            $subsidios->where('id_vereda',$request->vereda);
        }


        return response()->json([
            'estado' => 'ok',
            'data' => $subsidios->get(),

            //'data' =>$this->tabularInfo($subsidios,$request->campo) ,
            //'data' =>$subsidios->InformacionVivienda()->getResults(),
            //'cocinas' => Cocina::where('id_informacion', $request->idInfo)->where('id_tipo_visita',$request->tipo_visita)->get()->first(),
            //'data' => Subsidio::where('id_tipo_subsidio', $request->tipoSubsidio)->get(),
            //'data' => $subsidios,
        ]);

    }
    public function guardarArchivos(Request $request)
    {
        try {
            $archivos = $request->file('files');
            if ($request->idPredio != '') {
                $idPredio = $request->idPredio;
            }else{
                $idPredio = null;
            }
            
            //var_dump($archivos);
            //$keys = array_keys($archivos);
            //$count = count(get_object_vars($archivos));
            //dd(gettype($request->archivo));
            $destino = public_path('/img/vivienda/beneficiarios/');
            if (count($archivos) > 0) {
                foreach ($archivos as $files) {
                    $imageData = $files;
                    $fileName = Carbon::now()->timestamp . $files->getClientOriginalName();
                    $upload_success = $files->move($destino, $fileName);
                    $fil = new ArchivoBeneficiario();
                    $fil->nombres = $files->getClientOriginalName();
                    $fil->ruta = '/img/vivienda/beneficiarios/'.$fileName;
                    $fil->id_beneficiario = $request->id_beneficiario;
                    $fil->id_predio = $idPredio;
                    $fil->tipo_subsidio = $request->tipo_subsidio;
                    $fil->save();
                }
            }

            return response()->json([
                'estado' => 'ok',

            ]);
        } catch (\Exception $ee) {
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace' => $ee->getTrace(),
            ]);
        }
    }

    public function crearExcel(Request $request){
        //dd($request->data);
        $arrayName = array();
        $arrayName = $request->data;
        //unset($arrayName['id'], $arrayName['id_tipo_subsidio'], $arrayName['id_fase'], $arrayName['id_info_vivienda'], $arrayName['id_info_productivo']);
        $i=0;
        //unset($arrayName[0]);
        foreach ($arrayName as $key => $value) {
            foreach ($arrayName[$key] as $key2 => $value2) {
                //array_unshift($arrayName[$key], $key2);
                if ($key2 == 'id' || $key2 == 'id_info_vivienda' || $key2 == 'id_info_productivo' || $key2 == 'id_fase') {
                    unset($arrayName[$key][$key2]);
                }
            }
        }
        //dd(count($arrayName[0]));
        $excel = new \PHPExcel();

        //$excel->createSheet();
        $excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Tipo beneficio')
                ->setCellValue('B1', 'Consecutivo')
                ->setCellValue('C1', 'Fecha Inicio')
                ->setCellValue('D1', 'Municipio')
                ->setCellValue('E1', 'Vereda')
                ->setCellValue('F1', 'Fase')
                ->setCellValue('G1', 'Identificacion')
                ->setCellValue('H1', 'Beneficiario')
                ->setCellValue('I1', 'Orden Servicio (Consecutivo)')
                ->setCellValue('J1', 'Caso Espcial')
                ->setCellValue('K1', 'Valor inversion (pesos)')
                ->setCellValue('L1', 'Aporte beneficiario')
                ->setCellValue('M1', 'Porcentaje ejecucion %');

        $excel->getActiveSheet()->setTitle('Listado de beneficios');

        $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

        $excel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '17ac2f')
                ),
                'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
            )
        );

        $excel->getActiveSheet()->getStyle('A1:M'.(count($arrayName)+1))->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID
                ),
                'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
            )
        );       

        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray($arrayName, null, 'A2');
        
        //echo count($arrayName);
        /*$dataseriesLabels1 = array(
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
        }*/
        
        $writer = new \PHPExcel_Writer_Excel2007($excel);
        $writer->save(storage_path().'/'.Carbon::now()->timestamp.'listado.xlsx');

        return response()->json([
            'estado' => 'ok',

        ]);
    }


}
