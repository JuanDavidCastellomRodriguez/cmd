<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class CreateUserController extends Controller
{
    public function index()
    {       
        return view('Usuarios.index');
    }

    public function createNewUser(Request $request)
    {    	
    	$user = new Usuario();
    	$user->nombre_usuario = $request->nombre." ".$request->apellidos;
    	$user->email = $request->correo;
    	$user->password = bcrypt($request->password);
    	$user->estado = $request->estado;
    	$user->id_perfil = $request->tipo_rol;
    	$user->remember_token = $request->_token;

    	$user->save();

    	return response()->json([
    		'estado' => 'ok',
            'mensaje' => 'Usuario creado con exito!'    		
    	]);


    }

    public function getUsers(Request $request)
    {
        try{
            return response()->json([
                'estado' => 'ok',
                'data' =>  Usuario::all()

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function changeState(Request $request)
    {
        try{
            if ($request->accion == 1) {
                Usuario::where('id', $request->data)
                    ->update([
                        'estado' => 1
                    ]);
            }else if ($request->accion == 0) {
                Usuario::where('id', $request->data)
                    ->update([
                        'estado' => 0
                    ]);
            }
            
            return response()->json([
                'estado' => 'ok',
                'mensaje' =>  'Cambio de estado exitoso'

            ]);

        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }   
    }

    public function buscarUsuario(Request $request)
    {
        try {
            $usuario = Usuario::where('id', $request->data)->firstOrFail();

            return response()->json([
                'estado' => 'ok',
                'id' => $usuario->id,
                'nombre_completo' =>  $usuario->nombre_usuario,
                'email' => $usuario->email,
                'tipo_rol' => $usuario->id_perfil,
                'password' => $usuario->password


            ]);
            
        } catch (\Exception $ee) {
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }

    public function editarUsuario(Request $request)
    {
        try {
            $request =  json_decode($request->getContent());
            $user = Usuario::where('id', $request->data)->update([
                        'nombre_usuario' => $request->info->nombre,
                        'email' => $request->info->correo,
                        'id_perfil' => $request->info->tipo_rol
                    ]);

            

            return response()->json([
                'estado' => 'ok',
                'data' => $user

            ]);        
            
        } catch (\Exception $ee) {
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage(),
            ]);
        }
    }
}
