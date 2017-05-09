<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->intended('login');
    //return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index');
    Route::resource('vivienda','ViviendasController');
    Route::post('/vivienda/guardarpredio','ViviendasController@guardarPredio');

    Route::post('/getdepartamentos','SelectsController@getDepartamentos');
    Route::post('/getmunicipios','SelectsController@getMunicipios');
    Route::post('/getveredas','SelectsController@getVeredas');
    Route::post('/getveredasbycampo','SelectsController@getVeredasByCampo');
    Route::post('/gettipovehiculo', 'SelectsController@getTipoVehiculo');
    Route::post('/gettipologiasfamilia', 'SelectsController@getTipologiaFamilia');
    Route::post('/gettiemposrecorrido', 'SelectsController@getTiemposRecorrido');
    Route::post('/getestadosvia', 'SelectsController@getEstadoVias');
    Route::post('/getviasacceso', 'SelectsController@getViaAcceso');
    Route::post('/getestadosciviles', 'SelectsController@getEstadosCivil');
    Route::post('/getniveleseducativos', 'SelectsController@getTNivelesEducativos');
    Route::post('/getgeneros', 'SelectsController@getGeneros');
    Route::post('/gettipopersonascargo', 'SelectsController@getTipoPersonasCargo');
    Route::post('/getcampos', 'SelectsController@getCampos');
    Route::post('/gettipossubsidios', 'SelectsController@getTiposSubsidio');
    Route::post('/getselectspredio', 'SelectsController@getSelectsPredio');
    Route::post('/getselectsservicios', 'SelectsController@getSelectsServicios');



    Route::post('/vivienda/getselectsgenericos', 'SelectsController@getSelectsHabitacion');
    Route::post('/vivienda/cocinas/getselectscocina', 'SelectsController@getSelectsCocina');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/getselects', 'SelectsController@getSelectsUSanitarias');


    Route::post('/vivienda/getpredio','ViviendasController@getPredio');
    Route::post('/vivienda/getgeneralidades','ViviendasController@getGeneralidades');
    Route::post('/vivienda/guardargeneralidades','ViviendasController@guardarGeneralidades');
    Route::post('/vivienda/habitantes/get','HabitantesController@getHabitantes');
    Route::post('/vivienda/habitantes/buscar','HabitantesController@buscarHabitante');
    Route::post('/vivienda/habitantes/guardar','HabitantesController@guardarHabitante');
    Route::post('/vivienda/habitantes/remove','HabitantesController@removerHabitante');
    Route::post('/vivienda/general/getinfo','ViviendasController@getInformacionVivienda');
    Route::post('/vivienda/personascargo/getpersonas','ViviendasController@getPersonasCargo');
    Route::post('/vivienda/personacargo/remove','ViviendasController@DeletePersonaCargo');
    Route::post('/vivienda/personacargo/agregar','ViviendasController@agregarPersonaCargo');
    Route::post('/vivienda/habitaciones/getallhabitaciones','HabitacionesController@getAllHabitaciones');
    Route::post('/vivienda/habitaciones/guardarhabitacion','HabitacionesController@guardarHabitacion');
    Route::post('/vivienda/habitaciones/eliminarhabitacion','HabitacionesController@eliminarHabitacion');
    Route::post('/vivienda/cocinas/getallcocinas','CocinasController@getAllCocinas');
    Route::post('/vivienda/cocinas/guardarcocina','CocinasController@guardarCocina');
    Route::post('/vivienda/cocinas/eliminarcocina','CocinasController@eliminarCocina');



    //Route::resource('subsidios','SubsidiosController');
    Route::get('/subsidios/vivienda', "SubsidiosController@subsidiosVivienda");

    Route::get('/subsidios/vivienda/visitas/{id}', "VisitasController@show");


    Route::get('/subsidios/productivos', "SubsidiosController@subsidiosProductivos");
    Route::resource('/subsidios/productivos/diagnostico', "ProductivosController");

    Route::get('/subsidios/productivos/visitas/{id}', "VisitasController@show");

    Route::post('/subsidios/getinfo','SubsidiosController@getSubsidios');
    Route::post('/subsidios/guardarsubsidio','SubsidiosController@guardarSubsidio');

    Route::post('/beneficiarios/buscarbeneficiario', 'BeneficiariosController@buscarBeneficiarioPorCedula');


    Route::resource('subsidios/informes', 'InformesController' );
    Route::get('/informes/getdiagnosticovivienda/{id}', 'InformesController@reporteDiagnosticoVivienda');

    Route::post('/informes/getdatareport', 'InformesController@getDataReport');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/getallunidades', 'UnidadesSanitariasController@getAllUnidades');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/guardarunidad', 'UnidadesSanitariasController@guardarUnidad');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/eliminar', 'UnidadesSanitariasController@eliminarUnidad');

    Route::post('/subsidios/vivienda/diagnostico/servicios/getallservicios', 'ServiciosPublicosController@getAllServicios');
    Route::post('/subsidios/vivienda/diagnostico/servicios/guardarservicios', 'ServiciosPublicosController@guardarServicios');
    Route::post('/subsidios/vivienda/diagnostico/cierre/agregarimagenes', 'ViviendasController@agregarFotos');
    Route::post('/subsidios/vivienda/diagnostico/cierre/todasimagenes', 'ViviendasController@todasImagenes');
    Route::post('/subsidios/vivienda/diagnostico/cierre/borrarimagen', 'ViviendasController@borrarImagen');
    Route::post('/fases/getfases', 'FasesController@getAllFases');
    Route::post('/fases/getpaginatefases', 'FasesController@getPaginateFases');
    Route::post('/ordenes/getpaginateordenes', 'OrdenServiciosController@getPaginateOrdenes');
    Route::resource('/fases', 'FasesController');
    Route::post('//fases/listabyorden', 'FasesController@getFasesByOrden');
    Route::resource('/ordenes', 'OrdenServiciosController');
    Route::post('/ordenes/lista', 'OrdenServiciosController@getListOrdenServicios');


    Route::post('/campos/listabyfase', 'CamposController@getCamposByFase');


});

