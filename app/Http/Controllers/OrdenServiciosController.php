<?php

namespace App\Http\Controllers;

use App\OrdenServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdenServiciosController extends Controller
{
    public function getPaginateOrdenes(Request $request){
        return OrdenServicio::paginate(10);
    }
    public function index(Request $request){
        return view('ordenes.index');
    }

    public function getListOrdenServicios(){
        return response()->json([
            'estado' => 'ok',
            'data' => OrdenServicio::where('estado',1)->get(),
        ]);
    }
    public function guardarOrden(Request $request){
        $validator = Validator::make($request->all(),[
           'consecutivo' => 'required',
            'presupuesto' => 'required',
            'fecha_inicio' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'estado'=> 'fail',
                'mensaje' => 'Por favor rellene todos los campos'
            ]);
        }else{
            if($request->id == ''){
                try{
                    $orden = new OrdenServicio();
                    $orden->consecutivo = $request->consecutivo;
                    $orden->observaciones = $request->observaciones;
                    $orden->presupuesto = $request->presupuesto;
                    $orden->estado = 1;
                    $orden->id_usuario = Auth::User()->id;
                    $orden->fecha_inicio = $request->fecha_inicio;
                    $orden->fecha_final = $request->fecha_final;
                    $orden->objeto = $request->objeto;
                    $orden->save();

                    return response()->json([
                        'estado' => 'ok',
                        'id' => $orden->id,
                        'editado' => false,
                    ]);
                }catch (\Exception $ee){
                    return response()->json([
                        'estado' => 'fail',
                        'mensaje' => $ee->getMessage(),

                    ]);
                }




            }else{
                try{
                    $orden = OrdenServicio::find($request->id);
                    $orden->consecutivo = $request->consecutivo;
                    $orden->observaciones = $request->observaciones;
                    $orden->presupuesto = $request->presupuesto;
                    $orden->estado = $request->estado;
                    $orden->id_usuario = Auth::User()->id;
                    $orden->fecha_inicio = $request->fecha_inicio;
                    $orden->fecha_final = $request->fecha_final;
                    $orden->objeto = $request->objeto;
                    $orden->save();

                    return response()->json([
                        'estado' => 'ok',
                        'id' => $orden->id,
                        'editado' => true,
                    ]);
                }catch (\Exception $ee){
                    return response()->json([
                        'estado' => 'fail',
                        'mensaje' => $ee->getMessage(),

                    ]);
                }
            }
        }
    }

}
