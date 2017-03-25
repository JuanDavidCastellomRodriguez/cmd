<?php

namespace App\Http\Controllers;

use App\Subsidio;
use App\Visita;
use Illuminate\Http\Request;

class VisitasController extends Controller
{


    public function show($id){
        $subsidio = Subsidio::find($id);
        return view('visitas.index', compact('subsidio'));
    }
}
