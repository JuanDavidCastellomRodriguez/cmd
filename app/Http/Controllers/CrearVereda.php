<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vereda;
use App\Municipio;
use Illuminate\Support\Facades\Validator;

class CrearVereda extends Controller
{
    public function index()
    {    	
    	return view('CrearVereda.index');
    }

    public function nuevaVereda(Request $request)
    {    	
    	$validador = Validator::make($request->all(),[
            'municipio_id' => 'required',
            'campo_id' => 'required',
            'vereda' => 'required'
        ]);
        if($validador->fails()){
            return response()->json([
                'estado' => 'fail',
                'mensaje' => 'Por favor complete todos los campos',
            ]);
        }else{
        	try {
        		$request =  json_decode($request->getContent());
	            $vereda = new Vereda();
	            $vereda->vereda = $request->vereda;
	            $vereda->id_municipio = $request->municipio_id;
	            $vereda->id_campo = $request->campo_id;
	            $vereda->save();

	            return response()->json([
	                       'estado' => 'ok',
	                       'id' => $vereda->id,
	                       'editado' => false,
	                   ]);
        	} catch (\Exception $ee) {
        		return response()->json([
                       'estado' => 'fail',
                       'mensaje' => $ee->getMessage(),
                   ]);
        	}
            
        }
    }

    public function getVeredaPagination(Request $request)
    {
        $veredas = Vereda::all()->paginate(10);
        $data = "";
        $pagination = "";

        if($veredas->total() > 0){
            foreach ($veredas as $vereda){

                $data = $vereda->Municipio;

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
            'data' => $veredas,
            'pagination' => $pagination,
            ]);
    }
}
