<?php

namespace App\Http\Controllers;

use App\InformacionProductivos;
use Illuminate\Http\Request;

class ProductivosController extends Controller
{

    public function show($id){
        $info = InformacionProductivos::find($id);
        return view('subsidios_productivos.diagnostico.show', compact('info'));
    }
}
