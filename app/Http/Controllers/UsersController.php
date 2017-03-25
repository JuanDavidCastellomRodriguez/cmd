<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //

    public function loginUser(Request $request){


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...

            return response()->json([
                'estado' => 'ok',
                'mensaje'=> 'Bienvenido ',
            ]);

        }else{

            return response()->json([
                'estado' => 'fail',
                'mensaje'=> 'Usuario o Contraseña incorrectos ',
            ]);

        }


    }
}
