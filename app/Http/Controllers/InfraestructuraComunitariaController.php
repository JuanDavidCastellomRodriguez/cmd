<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InfraestructuraComunitaria;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\ArchivosInfraestructuraComunitaria;

class InfraestructuraComunitariaController extends Controller
{
    public function index(Request $request)
    {
    	return view('InfraestructuraComunitaria.index');
    }

    public function getObras(Request $request){
        try{
            $datosinfraestructura  = InfraestructuraComunitaria::all();
            

            $data = new Collection();
            if(count($datosinfraestructura) > 0){
                
                foreach ($datosinfraestructura as $plan){
                    //echo $plan->id;                    
                    
                    $data->add([
                        'id' => $plan->id,
                        'fecha' => $plan->fecha,
                        'nombre_obra' => $plan->nombre_obra,
                        'descripcion' => $plan->descripcion,
                        'orden' => $plan->OrdenServicio->consecutivo,
                        'municipio_vereda' => $plan->Municipio->municipio.' - '.$plan->Vereda->vereda,
                        'valor_inversion' => $plan->valor_inversion,
                        'recibe' => $plan->nombre_recibe.' ('.$plan->identificacion_recibe.')'    
                    ]);
                    
                    
                    
                }
    
            }
            //dd($data);
            return response()->json([
                'estado' => 'ok',
                'data' =>  $data,

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }

    }

    public function guardarObra(Request $request)
    {
    	try {
    		$request =  json_decode($request->getContent()); 
    		$obra = new InfraestructuraComunitaria();
    		$obra->id_municipio = $request->nuevaObra->municipio_id;
    		$obra->id_vereda = $request->nuevaObra->vereda_id;
    		$obra->nombre_obra = $request->nuevaObra->nombre_obra;
    		$obra->nombre_recibe = $request->nuevaObra->nombre_recibe;
    		$obra->descripcion = $request->nuevaObra->descripcion;
    		$obra->valor_inversion = $request->nuevaObra->valor;
    		$obra->fecha = $request->nuevaObra->fecha;
    		$obra->save();


	        $fotos = new Collection();
	        foreach($request->images as $img){
	            $imageData = $img;
	            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
	            Image::make($imageData)->save(public_path('/img/vivienda/obra_comunitaria/').$fileName, 60);
	            $foto = new ArchivosInfraestructuraComunitaria();
	            $foto->ruta = '/img/vivienda/obra_comunitaria/'.$fileName;
	            $foto->id_infraestructura_comun = $obra->id;
	            $foto->save();
	            $fotos->add($foto);
	            //return response()->json(['error'=>false]);
	        }

    		return response()->json([
                'estado' => 'ok'

            ]);
    	} catch (\Exception $e) {
    		return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()

            ]);
    	}
    }
    
    public function getImagenes(Request $request){
        try{
            
            return response()->json([
                'estado' => 'ok',
                'data' => ArchivosInfraestructuraComunitaria::all()
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }


    }

    public function borrarImagenVisita(Request $request){

        try{
            FotografiasVisita::find($request->id)->delete();
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
