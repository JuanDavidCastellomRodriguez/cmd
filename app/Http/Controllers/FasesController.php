<?php

namespace App\Http\Controllers;

use App\Fase;
use Illuminate\Http\Request;

class FasesController extends Controller
{
    public function getAllFases(){
        $fases = Fase::all();
        return response()->json([
            'estado' => 'ok',
            'data' => $fases,
        ]);
    }

    public function getFasesByOrden(Request $request){
        $fases = Fase::where('id_orden_servicio',$request->id)->get();
        return response()->json([
            'estado' => 'ok',
            'data' => $fases,
        ]);
    }
    public function getPaginateFases(Request $request){
        return Fase::paginate(10);
    }
    public function index(Request $request){
        return view('fases.index');
    }
}
