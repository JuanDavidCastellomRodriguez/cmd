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

Route::post('/createUser', 'CreateUserController@createNewUser');
Route::post('/validarestado', 'UsersController@validateActivate');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index');
    Route::get('/infraestructura_comunitaria', 'InfraestructuraComunitariaController@index');
    Route::resource('vivienda','ViviendasController');
    Route::post('/vivienda/guardarpredio','ViviendasController@guardarPredio');
    
    Route::post('/getmunicipiosbycampo', 'SelectsController@getMunicipiosByCampo');
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
    Route::post('/subsidios/productivos/diagnostico/cierre/info-cierre', 'ProductivosController@getInfoCierre');
    Route::post('/subsidios/productivos/diagnostico/cierre/borrarimagen', 'ProductivosController@borrarImagen');
    Route::post('/subsidios/productivos/diagnostico/cierre/save-cierre', 'ProductivosController@SaveCierre');

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
    Route::post('/subsidios/getinfomapa','SubsidiosController@obtenerDatosMapa');


    Route::post('/subsidios/guardarsubsidio','SubsidiosController@guardarSubsidio');

    Route::post('/beneficiarios/buscarbeneficiario', 'BeneficiariosController@buscarBeneficiarioPorCedula');


    Route::resource('subsidios/informes', 'InformesController' );
    //Route::resource('subsidios/mapa/', 'MapaController' );
    Route::resource('subsidios/mapa/', 'MapaController' );
    Route::resource('subsidios/mapa/guardar', 'MapaController@guardarsitio' );

    Route::resource('subsidios/mapa/fases', 'MapaController@getFases' );

    Route::get('/informes/getdiagnosticovivienda/{id}', 'InformesController@reporteDiagnosticoVivienda');
    Route::get('/informes/getdiagnosticoproductivo/{id}', 'InformesController@reporteDiagnosticoProductivo');

    Route::post('/informes/getdatareport', 'InformesController@getDataReport');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/getallunidades', 'UnidadesSanitariasController@getAllUnidades');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/guardarunidad', 'UnidadesSanitariasController@guardarUnidad');
    Route::post('/subsidios/vivienda/diagnostico/usanitaria/eliminar', 'UnidadesSanitariasController@eliminarUnidad');

    Route::post('/subsidios/vivienda/diagnostico/servicios/getallservicios', 'ServiciosPublicosController@getAllServicios');
    Route::post('/subsidios/vivienda/diagnostico/servicios/guardarservicios', 'ServiciosPublicosController@guardarServicios');
    

    Route::post('/subsidios/vivienda/diagnostico/cierre/agregarimagenes', 'ViviendasController@agregarFotos');
    Route::post('/subsidios/vivienda/diagnostico/cierre/todasimagenes', 'ViviendasController@todasImagenes');
    Route::post('/subsidios/vivienda/diagnostico/cierre/borrarimagen', 'ViviendasController@borrarImagen');
    Route::post('/subsidios/vivienda/diagnostico/cierre/complementos', 'ViviendasController@getComplementosCierre');
    Route::post('/subsidios/vivienda/diagnostico/cierre/tipoinfraestructura', 'ViviendasController@getComplementosCierreTipoInfraestructura');
    Route::post('/subsidios/vivienda/diagnostico/cierre/tiporiesgo', 'ViviendasController@getComplementosCierreTipoRiesgo');
    Route::post('/subsidios/vivienda/diagnostico/cierre/datoshabitacion', 'ViviendasController@getdatoshabitacion');

    Route::post('/subsidios/vivienda/diagnostico/cierre/save-indicadores', 'ViviendasController@saveIndicadores');

    

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

    Route::post('/getselectstipovisita', 'SelectsController@getSelectsTipoVisita');
    Route::post('/subsidios/vivienda/visitas/guardarvisita', 'VisitasController@saveNuevaVisita');

    Route::resource('/crear_vereda', 'CrearVereda');
    Route::post('/crear_vereda/nuevaVereda', 'CrearVereda@nuevaVereda');
    Route::post('/obtenerVeredas','SelectsController@getVeredasAll');
    Route::post('/crear_vereda/getinfo','CrearVereda@getVeredaPagination');
    Route::post('/getvisitas','VisitasController@getVisitas');

    Route::post('/subsidios/visitas/agregarimagenesvisita', 'VisitasController@agregarFotosVisita');
    Route::post('/subsidios/visitas/todasimagenesvisita', 'VisitasController@todasImagenesVisita');
    Route::post('/subsidios/visitas/borrarimagenvisita', 'VisitasController@borrarImagenVisita');

    Route::post('/estadosCierre', 'VisitasController@getEstadosALL');

    Route::resource('/gestion_usuarios', 'CreateUserController');
    Route::post('/getusers', 'CreateUserController@getUsers');
    Route::post('/cambiarestado', 'CreateUserController@changeState');
    Route::post('/buscarUsuario', 'CreateUserController@buscarUsuario');
    Route::post('/editarUsuario', 'CreateUserController@editarUsuario');

    Route::post('/subsidios/productivos/cultivos/borrarSemilla', 'CultivosController@borrarSemilla');
    
    Route::resource('/PlanDesarrollo', 'PlanesDesarrolloController');
    Route::post('/getplanes', 'PlanesDesarrolloController@getPlanes');
    Route::post('/guardarplan', 'PlanesDesarrolloController@guardarPlan');

    Route::post('/guardar/beneficiarioAnterior', 'HabitantesController@beneficiarioAnterior');
    Route::post('/subsidios/productivos/diagnostico/getpredioAnterior', 'ProductivosController@predioAnterior');
    Route::post('/subsidios/productivos/diagnostico/getgeneralidadesAnterior', 'ProductivosController@getgeneralidadesAnterior');
    Route::post('/guardar/manoAnterior', 'FlujoManoObraController@guardarManoAnterior');
    Route::post('/guardar/potreroAnterior', 'InformacionLotesController@guardarPotreroAnterior');
    Route::post('/guardar/cultivoAnterior', 'CultivosController@guardarCultivoAnterior');

    Route::post('/guardar/bovinoAnterior', 'BovinosController@guardarBovinoAnterior');
    Route::post('/guardar/manejoAnterior', 'BovinosController@guardarManejoAnterior');
    Route::post('/guardar/ordenioAnterior', 'BovinosController@guardarOrdenioAnterior');

    Route::post('/guardar/aveAnterior', 'ProductivosController@guardarAveAnterior');
    Route::post('/guardar/cerdoAnterior', 'ProductivosController@guardarCerdoAnterior');
    Route::post('/guardar/pezAnterior', 'ProductivosController@guardarPezAnterior');
    Route::post('/guardar/otraAnterior', 'ProductivosController@guardarOtraAnterior');

    Route::post('/get_parentesco', 'SelectsController@parentesco');
    Route::post('/guardar/fortalecimiento', 'FortalecimientoInfraestructuraController@guardar');
    Route::post('/get/fortalecimientos', 'FortalecimientoInfraestructuraController@obtener');
    Route::post('/borrar/fortalecimiento', 'FortalecimientoInfraestructuraController@borrar');

    Route::post('/nueva_infraestructura_comunitaria', 'InfraestructuraComunitariaController@guardarObra');
    Route::post('/getObras', 'InfraestructuraComunitariaController@getObras');
    Route::post('/getImagenes', 'InfraestructuraComunitariaController@getImagenes');
    Route::post('/guardarArchivos', "SubsidiosController@guardarArchivos");
    Route::post('/get/otra_infraestructura', 'ViviendasController@getOtraInfraestructura');

    Route::post('/exportExcel', 'InformesController@ExportExcel');
    Route::post('/subsidios/excel', 'SubsidiosController@crearExcel');
    

    Route::post('/getordenes', 'SelectsController@getSelectsOrdenes'); 





});

