<?php

namespace App\Http\Controllers;

use App\OrdenServicio;
use Illuminate\Http\Request;

class OrdenServiciosController extends Controller
{
    public function getPaginateOrdenes(Request $request){
        return OrdenServicio::paginate(10);
    }
    public function index(Request $request){
        return view('ordenes.index');
    }
}
