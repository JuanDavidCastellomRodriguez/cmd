<?php

namespace App\Http\Controllers;

use App\Subsidio;
use App\InformacionProductivos;
use App\FortalecimientoInfraestructura;
use Illuminate\Http\Request;

class FortalecimientoInfraestructuraController extends Controller
{
    public function guardar(Request $request)
    {
    	$request =  json_decode($request->getContent());
    	try {
    		$bandera = 0;
    		if ($request->fortalecimiento->id != '') {
    			$nuevo = FortalecimientoInfraestructura::findOrFail($request->fortalecimiento->id);
    			$nuevo->tipo = $request->fortalecimiento->tipo;
	    		$nuevo->descripcion = $request->fortalecimiento->descripcion;
	    		$nuevo->id_productivo = $request->idInfo;

	    		$nuevo->save();
	    		$updated = true;
    		}else{
    			$nuevo = new FortalecimientoInfraestructura();
    			$nuevo->tipo = $request->fortalecimiento->tipo;
    			$nuevo->descripcion = $request->fortalecimiento->descripcion;
    			$nuevo->id_productivo = $request->idInfo;

    			$nuevo->save();	
    			$updated = false;
    		}
    		
    		return response()->json([
                'estado' => 'ok',
                'data' => $nuevo,
                'updated' => $updated,
                'bandera' => $bandera 

            ]);
    	} catch (\Exception $e) {
    		return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()

            ]);
    	}
    }

    public function obtener(Request $request)
    {
    	try {
    		$nuevo = FortalecimientoInfraestructura::where('id_productivo', $request->idInfo)->get();
    		$bandera = 0;
    		$infoProductivo = '';
    		if (count($nuevo) == 0) {
    			$subsidio = Subsidio::where('id_beneficiario', $request->id)
                                ->where('id_info_productivo', '<', $request->idInfo)
                                ->orderBy('created_at', 'desc')->first();
                $infoProductivo = InformacionProductivos::where('id', $subsidio->id_info_productivo)->first();
                $nuevo = FortalecimientoInfraestructura::where('id_productivo', $infoProductivo->id)->get();
                $bandera = 1;
    		}
    		return response()->json([
                'estado' => 'ok',
                'data' => $nuevo,
                'bandera' => $bandera,
                'infoProductivo' => $infoProductivo

            ]);
    	} catch (\Exception $e) {
    		return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()

            ]);
    	}
    }

    public function borrar(Request $request)
    {
    	$request =  json_decode($request->getContent());
    	try {
    	FortalecimientoInfraestructura::where('id_productivo', $request->idInfo)->where('id', $request->fortalecimiento->id)->delete();

    		return response()->json([
                'estado' => 'ok',

            ]);
    	} catch (\Exception $ee) {
    		return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
    	}    	
    }
}
