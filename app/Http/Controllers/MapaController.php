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
        return view('mapa.index');
    }

}