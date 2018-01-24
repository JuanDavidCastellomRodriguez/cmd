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
    Route::post('/getveredasbyfase','SelectsController@getVeredasByFase');
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
    Route::post('/getselectstipoproyectos', 'SelectsController@getSelectsTipoProyectos');
    Route::post('/getselectstipocobertura', 'SelectsController@getSelectsTipoCobertura');
    Route::post('/getselectssubtipocobertura', 'SelectsController@getSelectsSubtipoCobertura');
    Route::post('/getselectstipofuentehidrica', 'SelectsController@getSelectsTipoFuentesHidricas');
    Route::post('/getselectssitioventa', 'SelectsController@getSelectsSitioVenta');
    Route::post('/getselectsunidadproducto', 'SelectsController@getSelectsUnidadProducto');
    Route::post('/getselectsprocedenciasemilla', 'SelectsController@getSelectsProcedenciaSemilla');
    Route::post('/getselectscomponentescultivos', 'SelectsController@getSelectsComponentesCultivos');
    Route::post('/getselectsbovinos', 'SelectsController@getSelectsBovinos');
    Route::post('/getselectsespecies', 'SelectsController@getSelectsEspeciesMenores');



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
    Route::post('/subsidios/productivos/diagnostico/getgeneralidades', "ProductivosController@getGeneralidades");
    Route::post('/subsidios/productivos/diagnostico/guardargeneralidades', "ProductivosController@guardarGeneralidades");
    Route::post('/subsidios/productivos/diagnostico/getpredio', "ProductivosController@getPredio");
    Route::post('/subsidios/productivos/diagnostico/guardarpredio', "ProductivosController@guardarPredio");
    Route::post('/subsidios/productivos/diagnostico/getmanoobra', "FlujoManoObraController@getFlujoManoObra");
    Route::post('/subsidios/productivos/diagnostico/guardarmanoobra', "FlujoManoObraController@guardarFlujoManoObra");
    Route::post('/subsidios/productivos/diagnostico/borrarmanoobra', "FlujoManoObraController@borrarFlujoManoObra");
    Route::post('/subsidios/productivos/diagnostico/getpotreros', "InformacionLotesController@getPotreros");
    Route::post('/subsidios/productivos/diagnostico/borrarpotrero', "InformacionLotesController@borrarPotrero");
    Route::post('/subsidios/productivos/diagnostico/guardarpotrero', "InformacionLotesController@guardarPotrero");
    Route::post('/subsidios/productivos/diagnostico/getcultivos', "CultivosController@getCultivos");
    Route::post('/subsidios/productivos/diagnostico/guardarcultivo', "CultivosController@guardarCultivo");
    Route::post('/subsidios/productivos/diagnostico/getdetallecultivo', "CultivosController@getDetalleCultivo");
    Route::post('/subsidios/productivos/diagnostico/guardardetallecultivo', "CultivosController@guardarDetalleCultivo");
    Route::post('/subsidios/productivos/diagnostico/eliminardetallecultivo', "CultivosController@eliminarDetalleCultivo");
    Route::post('/subsidios/productivos/diagnostico/guardarinsumocultivo', "CultivosController@guardarInsumoCultivo");
    Route::post('/subsidios/productivos/diagnostico/guardarplagacultivo', "CultivosController@guardarPlagaCultivo");
    Route::post('/subsidios/productivos/diagnostico/eliminarplagacultivo', "CultivosController@eliminarPlagaCultivo");
    Route::post('/subsidios/productivos/diagnostico/eliminarinsumocultivo', "CultivosController@eliminarInsumoCultivo");
    Route::post('/subsidios/productivos/diagnostico/guardarventacultivo', "CultivosController@guardarVentaCultivo");
    Route::post('/subsidios/productivos/diagnostico/eliminarventacultivo', "CultivosController@eliminarVentaCultivo");
    Route::post('/subsidios/productivos/diagnostico/guardarbovino', "BovinosController@guardarBovino");
    Route::post('/subsidios/productivos/diagnostico/getbovinos', "BovinosController@getBovinos");
    Route::post('/subsidios/productivos/diagnostico/eliminarbovino', "BovinosController@eliminarBovino");
    Route::post('/subsidios/productivos/diagnostico/eliminarmanejobovino', "BovinosController@eliminarManejoBovino");
    Route::post('/subsidios/productivos/diagnostico/guardarmanejobovino', "BovinosController@guardarManejoBovino");
    Route::post('/subsidios/productivos/diagnostico/guardarordeniobovino', "BovinosController@guardarOrdenioBovino");
    Route::post('/subsidios/productivos/diagnostico/eliminarordeniobovino', "BovinosController@eliminarOrdenioBovino");
    Route::post('/subsidios/productivos/diagnostico/cierre/agregarimagenes', 'ProductivosController@agregarFotos');
    Route::post('/subsidios/productivos/diagnostico/cierre/todasimagenes', 'ProductivosController@todasImagenes');
    Route::post('/subsidios/productivos/diagnostico/cierre/borrarimagen', 'ProductivosController@borrarImagen');
    Route::post('/subsidios/productivos/diagnostico/especies/todaslasespecies', 'ProductivosController@getDataOtrasEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/guardaraveespecies', 'ProductivosController@guardarAvesEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/eliminaraveespecies', 'ProductivosController@eliminarAvesEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/guardarcerdoespecies', 'ProductivosController@guardarCerdoEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/eliminarcerdoespecies', 'ProductivosController@eliminarCerdoEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/guardarpecesespecies', 'ProductivosController@guardarPecesEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/eliminarpecesespecies', 'ProductivosController@eliminarPecesEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/guardarotrasespecies', 'ProductivosController@guardarOtrasEspecies');
    Route::post('/subsidios/productivos/diagnostico/especies/eliminarotrasespecies', 'ProductivosController@eliminarOtrasEspecies');


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
    Route::post('/subsidios/vivienda/diagnostico/cierre/riesgos', 'ViviendasController@getRiesgos');

    Route::post('/fases/getfases', 'FasesController@getAllFases');
    Route::post('/fases/getpaginatefases', 'FasesController@getPaginateFases');

    Route::resource('/fases', 'FasesController');
    Route::post('/fases/listabyorden', 'FasesController@getFasesByOrden');
    Route::post('/fases/guardarfase', 'FasesController@guardarFase');

    Route::resource('/ordenes', 'OrdenServiciosController');
    Route::post('/ordenes/lista', 'OrdenServiciosController@getListOrdenServicios');
    Route::post('/ordenes/guardarorden', 'OrdenServiciosController@guardarOrden');
    Route::post('/ordenes/getpaginateordenes', 'OrdenServiciosController@getPaginateOrdenes');


    Route::post('/campos/listabyfase', 'CamposController@getCamposByFase');


});

