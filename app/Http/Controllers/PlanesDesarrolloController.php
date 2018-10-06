<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\PlanesDesarrollo;
use App\ArchivosPlane;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PlanesDesarrolloController extends Controller
{
    public function index()
    {
    	return view('PlanDesarrollo.index');
    }

    public function getPlanes(Request $request)
    {
    	$planes = PlanesDesarrollo::all();
        $archivos = ArchivosPlane::all();
        $data = new Collection();
        if(count($planes) > 0){
            
            foreach ($planes as $plan){
                //echo $plan->id;                    
                
                $data->add([
                    'id' => $plan->id,
                    'vereda' => $plan->Vereda->vereda,
                    'municipio' => $plan->Vereda->Municipio->municipio,
                    'titulo' => $plan->titulo,
                    'fecha'=> $plan->fecha

                ]);
                
                
                
            }

        }

    	return response()->json([
            'estado' => 'ok',
            'data' => $data,
            'archivos' => $archivos
        ]); 
    }

    public function guardarPlan(Request $request)
    {
    	//$request =  json_decode($request->getContent());
    	//dd($request->all());
        try {
    		$plan = new PlanesDesarrollo();
    		$plan->titulo = $request->titulo;
    		$plan->fecha = $request->fecha;
    		$plan->id_municipio = $request->municipio_id;
    		$plan->id_vereda = $request->vereda_id;
    		$plan->save();

    		$id_plan = $plan->id;
            $data = new Collection();
            $data->add([
                    'id' => $plan->id,
                    'vereda' => $plan->Vereda->vereda,
                    'municipio' => $plan->Vereda->Municipio->municipio,
                    'titulo' => $plan->titulo,
                    'fecha'=> $plan->fecha,
                ]);
            
    		$archivos = $request->file('files');
            //var_dump($archivos);
            //$keys = array_keys($archivos);
    		//$count = count(get_object_vars($archivos));
            //dd(gettype($request->archivo));
            $destino = public_path('/img/vivienda/planes/');
            if (count($archivos) > 0) {
    			foreach ($archivos as $files) {
                    $imageData = $files;
    				$fileName = Carbon::now()->timestamp . $files->getClientOriginalName();
                    $upload_success = $files->move($destino, $fileName);
            		$file = new ArchivosPlane();
                    $file->nombres = $files->getClientOriginalName();
		            $file->ruta = '/img/vivienda/planes/'.$fileName;
		            $file->id_plan = $id_plan;
		            $file->save();
    			}
    		}

    		
    		return response()->json([
                'estado' => 'ok',
                'mensaje' => 'Plan creado correctamente',
                'data'=> $data

            ]);
    	} catch (\Exception $ee) {
    		return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'trace' => $ee->getTrace(),
            ]);
    	}
    }

    
}
