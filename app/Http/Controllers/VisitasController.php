<?php

namespace App\Http\Controllers;

use App\Subsidio;
use App\Visita;
use App\Fotografia;
use App\picture;
use App\UnidadesSanitaria;
use App\Habitacione;
use App\Cocina;
use App\EstadosVivienda;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Faker\Provider\File;

class VisitasController extends Controller
{
    public function show($id){
        $subsidio = Subsidio::find($id);
        return view('visitas.index', compact('subsidio'));
    }


    public function getVisitas(Request $request){
        $request =  json_decode($request->getContent());
        $visitas = DB::table('visitas')->where('id_subsidio', $request->id)->get();
        //$visitas = Visita::all();

        return response()->json([
                'estado' => 'ok',
                'data' => $visitas
            ]);

    }

    public function saveNuevaVisita(Request $request){
        try{

            $request =  json_decode($request->getContent());

            if($request->visitando->id_subsidio != ''){
                if ($request->visitando->id_tipo_visita == 2) {
                    Subsidio::where('id_beneficiario', $request->subsidio->id_beneficiario)
                    ->where('id_tipo_subsidio', $request->subsidio->id_tipo_subsidio)
                    ->where('id', $request->subsidio->id)
                    ->update([
                        'valor' => $request->visitando->valor,
                        'valor_beneficiario' => $request->visitando->valor_beneficiario,
                        'porcentaje_ejecucion' => $request->visitando->porcentaje_ejecucion
                    ]);
                }else {
                    Subsidio::where('id_beneficiario', $request->subsidio->id_beneficiario)
                    ->where('id_tipo_subsidio', $request->subsidio->id_tipo_subsidio)
                    ->where('id', $request->subsidio->id)
                    ->update([
                        'porcentaje_ejecucion' => $request->visitando->porcentaje_ejecucion
                    ]);
                }
                
                $visita = new Visita();
                $visita->fecha = $request->visitando->fecha;
                $visita->observaciones = $request->visitando->observaciones;
                $visita->id_tipo_visita = $request->visitando->id_tipo_visita;
                $visita->id_subsidio = $request->visitando->id_subsidio;
                $visita->id_tipo_mejoramientos = $request->visitando->id_tipo_mejoramiento;
                $visita->otra_mejora = $request->visitando->otra_mejora;

                $visita->save();
                
                picture::where('id_subsidio', $request->visitando->id_subsidio)
                ->where('id_tipo_subsidio', $request->visitando->id_tipo_visita)
                ->update([
                    'id_visita' => $visita->id
                ]);
            }else{
                $visita = Visita::find($request->visitando->id_subsidio);
                $visita->fecha = $request->visitando->fecha;
                $visita->observaciones = $request->visitando->observaciones;
                $visita->id_tipo_visita = $request->visitando->id_tipo_visita;
                $visita->id_subsidio = $request->visitando->id_subsidio;
                $visita->id_tipo_mejoramientos = $request->visitando->id_tipo_mejoramiento;
                $visita->otra_mejora = $request->visitando->otra_mejora;

                $visita->save();

                picture::where('id_subsidio', $request->visitando->id_subsidio)
                ->where('id_tipo_subsidio', $request->visitando->id_tipo_visita)
                ->update([
                    'id_visita' => $visita->id
                ]);
            }

            return response()->json([
                'estado' => 'ok',
                'mensaje'=> 'Visita Guardada',
                'id' => $visita
            ]);


        }catch (QueryException $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()

            ]);

        }catch (Exception $e){
            return response()->json([
                'estado' => 'fail',
                'error' => $e->getMessage()

            ]);

        }catch (TokenMismatchException $exception){
            return response()->json([
                'estado' => 'fail',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function agregarFotosVisita(Request $request){
        $request =  json_decode($request->getContent());        
        $fotos = new Collection();
        foreach($request->images as $img){
            $imageData = $img;
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->save(public_path('/img/vivienda/visitas/').$fileName, 60);
            $foto = new picture();
            $foto->ruta = '/img/vivienda/visitas/'.$fileName;
            $foto->id_tipo_subsidio = $request->tipo_subsidio;
            $foto->id_subsidio = $request->id;
            $foto->save();
            $fotos->add($foto);
            //return response()->json(['error'=>false]);
        }
        return response([
            'estado' => 'ok',
            'fotos' => $fotos

        ]);

    }
    public function todasImagenesVisita(Request $request){
        try{
            $fotos = FotografiasVisita::where('id_informacion', $request->id)->where('tipo', $request->tipo)->get();
            /*$data = [];
            foreach ($fotos as $foto){
                array_push($data,[public_path($foto)]);
            }
*/
            return response()->json([
                'estado' => 'ok',
                'data' => $fotos
            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }


    }

    public function borrarImagenVisita(Request $request){

        try{
            FotografiasVisita::find($request->id)->delete();
            return response()->json([
                'estado' => 'ok',

            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }
    }

    public function getEstadosALL(Request $request)
    {
        try{
           $unidad = UnidadesSanitaria::where('id_informacion', $request->id)->get(['id_estado_vivienda']);
            $habitacion = Habitacione::where('id_informacion', $request->id)->get(['id_estado_vivienda']);
            $cocina = Cocina::where('id_informacion', $request->id)->get(['id_estado_vivienda']);
            return response()->json([
                'estado' => 'ok',
                'unidad'=> $unidad,
                'habitacion' => $habitacion,
                'cocina'=> $cocina

            ]);
        }catch (\Exception $ee){
            return response()->json([
                'estado' => 'fail',
                'error' => $ee->getMessage()
            ]);
        }
    }
}
