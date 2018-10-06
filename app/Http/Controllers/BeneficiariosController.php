<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use Illuminate\Http\Request;

class BeneficiariosController extends Controller
{

    public function save(Request $request){
       $id = $this->guardarBeneficiario($request->beneficiario);
       if($id != 0){
           return response()->json([
               'estado' => 'ok',
               'id' => $id,
           ]);
       }


    }


    public static function guardarBeneficiario($beneficiario){
        $nuevoBeneficiario = new Beneficiario();
        $nuevoBeneficiario->no_cedula = $beneficiario->no_cedula;
        $nuevoBeneficiario->nombres = $beneficiario->nombres;
        $nuevoBeneficiario->apellidos = $beneficiario->apellidos;
        $nuevoBeneficiario->no_celular = $beneficiario->no_celular;
        $nuevoBeneficiario->fecha_nacimiento = $beneficiario->fecha_nacimiento;
        if($nuevoBeneficiario->save()){
            return $nuevoBeneficiario->id;
        }else{
            return 0;
        }


    }

    public function buscarBeneficiarioPorCedula(Request $request){
        try{
            $beneficiario = Beneficiario::where('no_cedula',$request->no_cedula)->first();
            return response([
                'estado' => 'ok',
                'data' => $beneficiario
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }

    }
}
