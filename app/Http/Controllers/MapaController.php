<?php

namespace App\Http\Controllers;

use App\Subsidio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapaController extends Controller
{

    public function index()
    {
       	//return view('mapa.index');
        //return view('maps.php');
		//return redirect()->route('http://localhost/cmd/resources/views/mapa/maps.php');
		return view('mapa.maps');
    }

    public function getFases()
    {
		return view('mapa.get_fase');
    }

    public function guardarsitio()
    {
		return view('mapa.guardar_sitio');
    }

    public function vermapa(){
        return 'Prueba';
    }
    

}