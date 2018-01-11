<?php

namespace App\Http\Controllers;

use App\Campo;
use App\CamposVereda;
use App\Fase;
use App\InformacionVivienda;
use App\Municipio;
use App\OrdenServicio;
use App\Subsidio;
use App\Vereda;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    //

    public function index()
    {

        return view('mapa.index');



    }
}