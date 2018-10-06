<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Usuario;

class UsersController extends Controller
{
    //

    public function loginUser(Request $request){

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            //return view("home");            
            return response()->json([
                'estado' => 'ok',
                'mensaje'=> 'Bienvenido'
            ]);

        }else{

            return response()->json([
                'estado' => 'fail',
                'mensaje'=> 'Usuario o Contraseña incorrectos ',
            ]);

        }


    }

    public function validateActivate(Request $request)
    {
        try {
            $usuario = Usuario::where('email', $request->email)->firstOrFail();
            if ($usuario->estado == 1) {
                return response()->json([
                    'estado' => 'ok'
                ]);
            }else {
                return response()->json([
                    'estado' => 'fail',
                    'mensaje' => 'Usuario inactivo'
                ]);
            }   

                        
            
        } catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
                'mensaje' => "Usuario o contraseña incorrectos"
            ]);
        }
    }
}
