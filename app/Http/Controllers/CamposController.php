<?php

namespace App\Http\Controllers;

use App\Campo;
use App\Fase;
use App\FaseVereda;
use App\Vereda;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CamposController extends Controller
{
    public function getCamposByFase(Request $request){

        /*
        $veredas = Fase::find($request->id)->VeredasFase;
        $data = new Collection();
        foreach ( $veredas as $vereda){
            $data->add($vereda->Campo);
        }

        return response()->json([
            'estado' => 'ok',
            'data' => $data->unique('id'),
        ]);
        */
        return response()->json([
            'estado' => 'ok',
            'data' => Campo::all(),
        ]);
    }
}
