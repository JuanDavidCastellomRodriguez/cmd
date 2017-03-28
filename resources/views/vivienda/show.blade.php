@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }} ">
    <style>
        #seccion-menu-lateral ul li {
            width: 100%;
            margin-top: 5px;

        }
        #seccion-menu-lateral  a{
            border-radius: 3px;
        }

        #seccion-menu-lateral .active a{

            //border: solid black 2px;
            border-radius: 3px;
            opacity: 0.7;
        }
        .btns-forms{
            text-align: right;
            padding-top: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">

            <h3>Levantamiento Informacion No @{{ infoVivienda.consecutivo }}</h3>
            <section class="col-lg-2 col-sm-4" id="seccion-menu-lateral">
                <ul class="nav nav-tabs" role="tablist">
                    Informacion General
                    <li role="presentation" class="active" ><a  class="red geopark white-text" href="#predio" aria-controls="predio" role="tab" data-toggle="tab" >Predio<span class="glyphicon glyphicon-asterisk red-text" v-bind:class="{'white-text' : predioEditado}" aria-hidden="true"></span> </a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#general" aria-controls="general" role="tab" data-toggle="tab" >General<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> </a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitantes" aria-controls="habitantes" role="tab" data-toggle="tab">Habitante(s)</a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#p-cargos" aria-controls="p-cargos" role="tab" data-toggle="tab">Persona(s) a Cargo</a></li>
                    <li>Vivienda</li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitaciones" aria-controls="habitaciones" role="tab" data-toggle="tab">Habitaciones</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#cocinas" aria-controls="cocinas" role="tab" data-toggle="tab">Cocina(s)</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#u_sanitarias" aria-controls="u_sanitarias" role="tab" data-toggle="tab">Unidad(es) Sanitaria(s)</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#s_publicos" aria-controls="s_publicos" role="tab" data-toggle="tab">Servicios Publicos</a></li>
                    Informacion Final
                    <li role="presentation"><a  class="red geopark white-text" href="#cierre" aria-controls="cierre" role="tab" data-toggle="tab">Cierre</a></li>
                </ul>
            </section>
            <section class="col-lg-10 col-sm-8">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="predio">

                        <form-predio :token="token" :departamentos="departamentos" :idinfo="idInfoVivienda" :idpredio="idPredio" ></form-predio>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitantes">
                        <beneficiarios :token="token" :idinfo="idInfoVivienda" :generos="generos" :niveles="nivelesEducativos"></beneficiarios>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="general">
                        @include('vivienda.parts.form_inicial')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="p-cargos">
                        <personas-cargo :idinfo="idInfoVivienda" :niveles="nivelesEducativos" :generos="generos"></personas-cargo>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitaciones">
                        <table-habitaciones :idinfo="idInfoVivienda" :tipomuro="tipoMuro" :tipopiso="tipoPiso" :tipocubierta="tipoCubierta" :materialpuertas="materialPuertas" :materialventanas="materialVentanas" :estadovivienda="estadoVivienda"></table-habitaciones>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cocinas">
                        <table-cocinas :idinfo="idInfoVivienda" :tipomuro="tipoMuro" :tipopiso="tipoPiso" :tipocubierta="tipoCubierta" :materialpuertas="materialPuertas" :materialventanas="materialVentanas" :estadovivienda="estadoVivienda"></table-cocinas>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="u_sanitarias">
                        <table-unidades-sanitarias :idinfo="idInfoVivienda" :tipomuro="tipoMuro" :tipopiso="tipoPiso" :tipocubierta="tipoCubierta" :materialpuertas="materialPuertas" :materialventanas="materialVentanas" :estadovivienda="estadoVivienda"></table-unidades-sanitarias>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="s_publicos">
                        <servicios-publicos :idinfo="idInfoVivienda"></servicios-publicos>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cierre">
                        <cierre :idinfo="idInfoVivienda"></cierre>
                    </div>
                </div>
            </section>

        </div>





    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-datepicker.min.js','') }} "></script>
    <script src=" {{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

    Vue.component('personas-cargo',{
       template : '#personas-cargo',
        props: ['idinfo','niveles','generos'],
        data : function () {
            return {
                personasCargo : '',
                tiposPersonaCargo : '',
                nuevaPersona : {
                    id : '',
                    fecha_nacimiento : '',
                    id_genero : '',
                    id_tipo : '',
                    id_nivel_educativo : '',
                    id_informacion : ''
                },
                personaToDelete : '',
                loading : false,

            }
        },
        methods : {
            prepareToRemove : function (persona) {
                this.personaToDelete = persona;
            },
            guardarPersona : function () {
                this.$http.post('/vivienda/personacargo/agregar',{idInfo : this.idinfo, persona : this.nuevaPersona }).then((response)=>{
                    if(response.body.estado == 'ok'){
                        this.personasCargo.push(response.body.persona);
                        $("#modal-agregar-persona").modal('hide');
                        notificarOk('', 'Persona agregada correctamente');
                        this.formReset();

                    }else{
                        notificarFail('', 'Error al guardar ' + response.body.error);
                    }

                },(error)=>{

                    notificarFail('', 'Error. ' + error.status+' '+ error.statusText);
                });
            },
            formReset : function () {
                //
            },
            eliminarPersona: function () {
                this.$http.post('/vivienda/personacargo/remove',{persona : this.personaToDelete.id, idInfo: this.idinfo}).then((response)=>{
                    this.loading = false;
                    if(response.body.estado == 'ok'){
                        $("#modal-confirm-delete-persona").modal('hide');
                        notificarOk('', 'Persona removida correctamente');
                        this.personasCargo.splice(this.personasCargo.indexOf(this.personaToDelete),1);
                    }else{
                        $("#modal-confirm-delete-persona").modal('hide');
                        notificarFail('', 'Error en el servidor ' + response.body.error);
                    }
                },(error)=>{
                    $("#modal-confirm-delete-beneficiario").modal('hide');
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                    this.loading = false;
                });
            }
        },
        created(){
            this.$http.post('/gettipopersonascargo').then((response)=>{
                if(response.body.estado == 'ok'){
                    this.tiposPersonaCargo = response.body.data;
                }
            }, (error)=>{
                notificarFail('', 'Error al cargar el tipo de Personas a Cargo ' + error.status+' '+ error.statusText);
            });
        },
        mounted(){
            this.$http.post('/vivienda/personascargo/getpersonas').then((response)=>{
                if(response.body.estado == 'ok'){
                    this.personasCargo = response.body.data;
                }
            }, (error)=>{
                notificarFail('', 'Error al cargar las Personas a Cargo ' + error.status+' '+ error.statusText);
            });

            var component = this;
            $('#fecha_nacimiento_persona').datepicker({
                orientation: 'auto top',
                language : 'es',
                todayBtn : 'linked',
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {

                component.nuevaPersona.fecha_nacimiento = e.target.value;
                //console.log(component.nuevoBeneficiario.fecha_nacimiento)

            });
        },

    });
    Vue.component('beneficiarios',{
            template : '#beneficiarios',
            props : ['idinfo', 'generos', 'niveles'],
            data : function () {
                return {
                    beneficiarios : '',
                    nuevoBeneficiario : {
                        id :'',
                        no_cedula : '',
                        nombres : '',
                        apellidos : '',
                        fecha_nacimiento : '',
                        no_celular : '',
                        correo_electronico : '',
                        ocupacion : '',
                        id_estado_civil : '',
                        id_nivel_educativo : '',
                        id_genero : '',
                        cabeza_hogar : true,
                    },
                    beneficiarioToRemove : '',
                    creandoNuevoBeneficiario : false,
                    loading : false,
                    estadosCiviles : '',





                }
            },
            methods : {
                prepareToRemove : function (beneficiario) {
                    this.beneficiarioToRemove = beneficiario;
                },
                formReset : function () {
                    $("#txt-buscar-beneficiario").removeAttr('disabled','disabled');
                    this.nuevoBeneficiario = {
                        id :'',
                        no_cedula : '',
                        nombres : '',
                        apellidos : '',
                        fecha_nacimiento : '',
                        no_celular : '',
                        correo_electronico : '',
                        ocupacion : '',
                        id_estado_civil : '',
                        id_nivel_educativo : '',
                        id_genero : '',
                        cabeza_hogar : true,
                    }
                },
                buscarBeneficiario : function () {

                    $("#txt-buscar-beneficiario").attr('disabled','disabled');
                    //this.nuevoBeneficiario.no_cedula = cedula;
                    if(this.nuevoBeneficiario.no_cedula != ''){
                        this.loading = true;
                        this.$http.post('/vivienda/habitantes/buscar',{no_cedula : this.nuevoBeneficiario.no_cedula}).then((response)=>{
                            if(response.body.estado == 'ok'){
                                this.nuevoBeneficiario = response.body.data;
                                this.creandoNuevoBeneficiario = false;
                                //this.formReset();
                            }else{
                                this.creandoNuevoBeneficiario = true;
                                notificarFail('', 'Beneficiario no encontrado, se creará uno nuevo ' );
                            }
                            this.loading = false

                        },(error)=>{
                            notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        })

                    }else{
                        notificarFail('', 'Debe ingresar un valor');
                        this.loading = false
                    }

                },
                
                guardarBeneficiario : function () {
                    var esnuevo = true;
                    var id = this.nuevoBeneficiario.id;
                    this.beneficiarios.forEach(function (beneficiario) {
                        if(beneficiario.id == id){
                            esnuevo = false
                        }
                    })

                    if(esnuevo){
                        this.$http.post('/vivienda/habitantes/guardar',{idInfo : this.idinfo, habitante : this.nuevoBeneficiario }).then((response)=>{
                            if(response.body.estado == 'ok'){
                                if(response.body.yaEsHabitante == true){
                                    notificarFail('', 'El beneficiario ya existe en otro proyecto');
                                }
                                this.beneficiarios.push(response.body.habitante);
                                $("#modal-agregar-beneficiario").modal('hide');
                                notificarOk('', 'Habitante agregado correctamente');
                                this.formReset();

                            }else{
                                notificarFail('', 'Error en el servidor ' + response.body.error);
                            }

                        },(error)=>{

                            notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        });
                    }else{
                        notificarFail('', 'El Habitante ya existe en este proyecto');
                    }
                },
                
                eliminarBeneficiario : function () {
                    this.loading = true;
                    this.$http.post('/vivienda/habitantes/remove',{habitante : this.beneficiarioToRemove.id, idInfo: this.idinfo}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){
                            $("#modal-confirm-delete-beneficiario").modal('hide');
                            notificarOk('', 'Beneficiario removido correctamente');
                            this.beneficiarios.splice(this.beneficiarios.indexOf(this.beneficiarioToRemove),1);
                        }else{
                            $("#modal-confirm-delete-beneficiario").modal('hide');
                            notificarFail('', 'Error en el servidor ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-beneficiario").modal('hide');
                        notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                }
                
            },
            created (){
                this.$http.post('/vivienda/habitantes/get', {_token : this.token, idInfo : this.idinfo }).then((response)=>{
                    this.beneficiarios = response.body.data;
                }, (error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getestadosciviles').then((response)=>{
                    this.estadosCiviles = response.body.data;
                }, (error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });




            },
            mounted(){

                var component = this;
                $('.datepickers').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : 'linked',
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {

                    component.nuevoBeneficiario.fecha_nacimiento = e.target.value;
                    //console.log(component.nuevoBeneficiario.fecha_nacimiento)

                });
            }
        });
    Vue.component('form-predio',{
            template : '#form-predio-template',
            props: ['token', 'departamentos','idinfo','idpredio'],
            data : function () {
                return  {
                    predio:{
                        id:'',
                        nombre: '',
                        direccion: '',
                        idVereda : '',
                        latitud: '',
                        longitud : '',
                        msnm : '',
                        idMunicipio : '',
                        idDepartamento : '',
                    },
                    propietarioPredio:{
                        id : '',
                        noCedula : '',
                        nombres: '',
                        apellidos: '',
                        telefono:'',
                        idPredio: '',
                        editado : false
                    },
                    tenenciaPredio :{
                        id : '',
                        area_predio_has :'',
                        pdf :'',
                        id_informacion :this.idinfo,
                        id_opcion : '',
                        id_tipo_tenencia_tierras : ''

                    },
                    municipios : '',
                    veredas : '',
                    predioEditado : false,
                    opcionesTenencia : '',
                    tipoTenencia : '',
                    pdf : '',
                }
            },
            methods:{
                guardarPredio : function () {
                    var fdata = new FormData();
                    fdata.append('pdf', this.pdf);
                    infoEnviar = {
                        idInfo : this.idinfo,
                        predio : this.predio,
                        propietario : this.propietarioPredio,
                        tenencia : this.tenenciaPredio,
                        pdf : this.pdf,
                        fdata : fdata,
                    };
                    this.$http.post('/vivienda/guardarpredio', infoEnviar ).then((response)=>{
                        console.log(response);
                        $("#btn-guardar").button('reset');

                        if(response.body.estado == 'ok'){
                            this.predio.id = response.body.id_predio;
                            this.propietarioPredio.id = response.body.id_propietario;
                            notificarOk('Predio', 'Datos guardados Correctamente');
                        }else{
                            notificarFail('Predio', 'Error al guardar ' + response.body.error);
                        }

                    },(response)=>{
                        $("#btn-guardar").button('reset');
                        notificarFail('Predio', 'Error en el servidor ' + response.status+' '+ response.statusText);

                    });
                },
                changeDepartamento : function (value, municipio) {
                    this.$http.post('/getmunicipios',{ id: value}).then((response)=>{
                        this.municipios = response.body.data
                        this.predio.idMunicipio = municipio;
                    })
                },
                changeMunicipio : function (value, vereda) {
                    this.$http.post('/getveredas',{ id: value}).then((response)=>{
                        this.veredas = response.body.data
                        this.predio.idVereda = vereda;

                    })
                },
                onFileChange : function (e) {
                    var files = e.target.files || e.dataTransfer.files;

                    var file = files[0];
                    this.pdf = file;
                    //console.log(files[0]);
                    /*
                    var reader = new FileReader();
                    var vm = this;
                    reader.onload = (e) => {
                        this.tenenciaPredio.pdf = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    */
                }
            },
            watch: {
                predio: {
                    handler: function (val, oldVal) {
                        this.predioEditado = true;
                    },
                    deep: true,
                    //sync: true,
                }


            },
            mounted(){
                if(this.idpredio != ''){
                    this.$http.post('/vivienda/getpredio',{ idPredio : this.idpredio, idInfo : this.idinfo }).then((response)=>{

                        this.changeDepartamento(response.body.departamento, response.body.municipio);
                        this.changeMunicipio(response.body.municipio,response.body.predio.id_vereda);

                        this.predio.id = response.body.predio.id;
                        this.predio.nombre = response.body.predio.nombre_predio;
                        this.predio.direccion = response.body.predio.direccion;
                        this.predio.latitud = response.body.predio.latitud;
                        this.predio.longitud = response.body.predio.longitud;
                        this.predio.msnm = response.body.predio.msnm;
                        this.predio.idDepartamento = response.body.departamento;

                        this.propietarioPredio.id = response.body.propietario.id;
                        this.propietarioPredio.noCedula = response.body.propietario.no_cedula;
                        this.propietarioPredio.nombres = response.body.propietario.nombres_propietario;
                        this.propietarioPredio.apellidos = response.body.propietario.apellidos_propietario;
                        this.propietarioPredio.telefono = response.body.propietario.no_telefonico;
                        this.propietarioPredio.idPredio = response.body.propietario.id_predio;

                        this.predioEditado = false;
                        this.tenenciaPredio = response.body.tenencia;


                    },(response)=>{
                        notificarFail('Predio', 'Tenemos problemas al cargar la informacion del predio ' + + response.status+' '+ response.statusText);
                    });
                }
            },
            created(){
                 this.$http.post('/getselectspredio').then((response) => {
                     if(response.body.estado == 'ok'){
                         this.opcionesTenencia = response.body.opciones;
                         this.tipoTenencia = response.body.tipo;
                     }else{
                         notificarFail('', 'Error al cargar datos ' + response.body.error);
                     }
                 },(error)=>{
                     notificarFail('', 'Error en el servidor ' + response.status+' '+ response.statusText);
                 });
            }

        });
    Vue.component('table-habitaciones',{
        template : '#table-habitaciones',
        props : ['idinfo','tipomuro', 'tipopiso', 'tipocubierta','materialpuertas', 'materialventanas','estadovivienda'],
        data : function(){
            return{
                habitaciones : '',
                nuevaHabitacion : {
                    id : '',
                    id_informacion : this.idinfo,
                    nombre : '',
                    estructura_viga : false,
                    estructura_columna : false,
                    panete_interno : false,
                    panete_externo : false,
                    estuco : false,
                    pintura : false,
                    cantidad_puertas : 0,
                    cantidad_ventanas : 0,
                    ventanas : false,
                    puertas : false,
                    observaciones : '',
                    piso_deteriorado : false,
                    id_estado_vivienda : null,
                    id_tipo_muro : null,
                    id_tipo_piso : null,
                    id_tipo_cubierta : null,
                    id_material_puertas : null,
                    id_material_ventanas : null,
                    id_tipo_visita : 1,

                },
                habitacionToDelete : '',
                habitacionToEdit :'',
                loading : false,

            }
        },
        methods :{
            guardarHabitacion : function () {
                this.$http.post('/vivienda/habitaciones/guardarhabitacion',{habitacion : this.nuevaHabitacion }).then((response)=>{
                   if(response.body.estado == 'ok'){
                       if(response.body.edicion){
                           notificarOk('', 'Habitación editada correctamente');
                       }else{
                           notificarOk('', 'Habitación agregada correctamente');
                       }

                   }else{
                       notificarFail('', 'ERROR: ' + response.body.error);
                   }
                }, (error)=>{

                });

            },




        },

        mounted(){
            this.$http.post('/vivienda/habitaciones/getallhabitaciones',{idInfo : this.idinfo, tipo_visita : 1}).then((responde)=>{
                if(responde.body.estado == 'ok'){
                    if(responde.body.habitaciones != null){
                        this.nuevaHabitacion = responde.body.habitaciones;
                    }

                }
            },(error)=>{
                notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
            });
        }

    });
    Vue.component('table-unidades-sanitarias',{
        template : '#table-unidades-sanitarias',
        props : ['idinfo','tipomuro', 'tipopiso', 'tipocubierta','materialpuertas', 'materialventanas','estadovivienda'],
        data : function(){
            return{

                ElementosSanitario : '',
                tipoUnidadesSanitarias :'',
                materialesTanqueElevado : '',
                materialesTanqueLavadero : '',
                acabadosTanqueLavadero : '',
                unidadesSanitarias : '',
                nuevaUnidadSanitaria : {
                    id : '',
                    id_informacion : this.idinfo,
                    nombre : '',
                    estructura_viga : false,
                    estructura_columna : false,
                    panete_interno : false,
                    panete_externo : false,
                    estuco : false,
                    pintura : false,
                    cantidad_puertas : 0,
                    cantidad_ventanas : 0,
                    muros_enchapado : false,
                    ventanas : false,
                    puertas : false,
                    observaciones : '',
                    piso_deteriorado : false,
                    id_estado_vivienda : null,
                    id_tipo_muro : null,
                    id_tipo_piso : null,
                    id_tipo_cubierta : null,
                    id_material_puertas : null,
                    id_material_ventanas : null,
                    id_tipo_unidad_sanitaria : null,
                    id_tipo_visita : 1,
                    tanque_elevado : false,
                    tanque_lavadero : false,
                    id_materiales_tanques_elevados : null,
                    id_materiales_tanques_lavaderos : null,
                    id_acabados_tanques_lavaderos : null,
                    elementos : [],

                },
                unidadToDelete : '',
                unidadToEdit :'',
                loading : false,

            }
        },
        methods :{
            guardarUnidadSanitaria : function () {
                this.$http.post('/subsidios/vivienda/diagnostico/usanitaria/guardarunidad',{unidad : this.nuevaUnidadSanitaria }).then((response)=>{
                    if(response.body.estado == 'ok'){
                        if(response.body.edicion){
                            notificarOk('', 'Unidad Sanitaria editada correctamente');
                        }else{
                            this.nuevaUnidadSanitaria.id = response.body.id;
                            notificarOk('', 'Unidad Sanitaria agregada correctamente');
                        }

                    }else{
                        notificarFail('', 'ERROR: ' + response.body.error);
                    }
                }, (error)=>{

                });

            },

        },
        created() {
            this.$http.post('/subsidios/vivienda/diagnostico/usanitaria/getselects').then((response)=>{
               if(response.body.estado == 'ok'){
                    this.ElementosSanitario =  response.body.elementosSanitarios;
                    this.tipoUnidadesSanitarias =  response.body.tipoUnidadesSanitarias;
                    this.materialesTanqueElevado = response.body.materialesTanqueElevado;
                    this.materialesTanqueLavadero = response.body.materialesTanqueLavadero;
                    this.acabadosTanqueLavadero = response.body.acabadosTanque;
               }
            }, (error)=>{
                notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
            });

        },
        mounted(){
            this.$http.post('/subsidios/vivienda/diagnostico/usanitaria/getallunidades',{id : this.idinfo, tipo_visita : 1}).then((responde)=>{
                if(responde.body.estado == 'ok'){
                    if(responde.body.data != ''){
                        this.nuevaUnidadSanitaria = responde.body.data;
                    }

                }
            },(error)=>{
                notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
            });
        }

    });
    Vue.component('table-cocinas',{
            template : '#table-cocinas',
            props : ['idinfo','tipomuro', 'tipopiso', 'tipocubierta','materialpuertas', 'materialventanas','estadovivienda'],
            data : function(){
                return{
                    tipoMuro : '',
                    tipoPiso : '',
                    tipoCubierta : '',
                    materialPuertas : '',
                    materialVentanas : '',
                    estadoVivienda : '',
                    tiposMeson : '',
                    elementosCocina : '',
                    cocinas : '',
                    nuevaCocina : {
                        id : '',
                        id_informacion : this.idinfo,
                        nombre : '',
                        estructura_viga : false,
                        estructura_columna : false,
                        panete_interno : false,
                        panete_externo : false,
                        estuco : false,
                        pintura : false,
                        cantidad_puertas : 0,
                        cantidad_ventanas : 0,
                        muros_enchapado : false,
                        ventanas : false,
                        puertas : false,
                        observaciones : '',
                        piso_deteriorado : false,
                        id_estado_vivienda : null,
                        id_tipo_muro : null,
                        id_tipo_piso : null,
                        id_tipo_cubierta : null,
                        id_material_puertas : null,
                        id_material_ventanas : null,
                        id_tipo_meson : null,
                        id_elemento_cocina : null,
                        id_fuente_energia_cocinas : null,
                        id_tipo_visita : 1,
                        estufa : false,
                        meson : false,
                        lavaplato : false,

                    },
                    cocinaToDelete : '',
                    cocinaToEdit :'',
                    loading : false,

                }
            },
            methods :{
                guardarCocina : function () {
                    this.$http.post('/vivienda/cocinas/guardarcocina',{cocina : this.nuevaCocina }).then((response)=>{
                        if(response.body.estado == 'ok'){
                            if(response.body.edicion){
                                notificarOk('', 'Cocina editada correctamente');
                            }else{
                                this.nuevaCocina.id = response.body.id;
                                notificarOk('', 'Cocina agregada correctamente');
                            }

                        }else{
                            notificarFail('', 'ERROR: ' + response.body.error);
                        }
                    }, (error)=>{

                    });

                },



            },
            created() {
                this.$http.post('/vivienda/cocinas/getselectscocina').then((response)=>{
                    if(response.body.estado == 'ok'){
                        this.tiposMeson =  response.body.tiposMeson;
                        this.elementosCocina = response.body.elementosCocina;
                    }
                }, (error)=>{
                    notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
                });

            },
            mounted(){
                this.$http.post('/vivienda/cocinas/getallcocinas',{idInfo : this.idinfo, tipo_visita : 1}).then((responde)=>{
                    if(responde.body.estado == 'ok'){
                        if(responde.body.cocinas != null){
                            this.nuevaCocina = responde.body.cocinas;
                        }

                    }
                },(error)=>{
                    notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
                });
            }

        });
    Vue.component('servicios-publicos',{
        template : '#servicios-publicos',
        props : ['idinfo'],
        data : function () {
            return {
                servicios : {
                    id :'',
                    id_informacion : this.idinfo,
                    id_fuente_agua : '',
                    id_sistemas_tratamiento_aguas : '',
                    tratamiento_agua : false,
                    id_metodo_disposicion_basura : '',
                    id_gas : '',
                    id_fuente_energia_electrica : '',
                    comunicaciones : [],
                },
                comunicaciones : '',
                aguasResiduales :'',
                electricidad : '',
                fuenteAgua : '',
                gas : '',
                residuosSolidos : '',
            }
        },
        methods:{
            guardarServiciosPublicos : function () {
                this.$http.post('/subsidios/vivienda/diagnostico/servicios/guardarservicios', this.servicios).then((response)=>{
                    if(response.body.estado == 'ok'){
                        notificarOk('', "Servicios Guardados correctamente");
                        if(!response.body.edit){
                            this.servicios.id = response.body.id;
                        }
                    }else{
                        notificarFail('', 'Error en el servidor ' + response.body.error);
                    }

                }, (error)=> {
                    notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
                });

            }

        },
        created(){
          this.$http.post('/getselectsservicios').then((response)=>{
            this.comunicaciones = response.body.comunicaciones;
            this.aguasResiduales = response.body.aguasResiduales;
            this.electricidad = response.body.electricidad;
            this.fuenteAgua = response.body.fuenteAgua;
            this.gas = response.body.gas;
            this.residuosSolidos = response.body.residuosSolidos;


          },(error)=>{
              notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
          });


        },
        mounted(){
            this.$http.post('/subsidios/vivienda/diagnostico/servicios/getallservicios',{id : this.idinfo }).then((response)=>{
                if(response.body.estado == 'ok' ){

                    this.servicios = response.body.data;



                }

            },(error)=>{
                notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
            });
        }
    });
    Vue.component('cierre', {
       template : '#form-cierre',
        props : ['idinfo'],
        data : function () {
            return {
                image: [],
                loading :false,
                images :[],
                subirMas : false,
            }
        },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for(var i = 0; i < files.length; i++){
                    this.createImage(files[i]);

                }

            },
            createImage(file) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.image.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            upload(){
                if(this.image.length > 0){
                    this.loading = true;
                    this.$http.post('/subsidios/vivienda/diagnostico/cierre/agregarimagenes',{images: this.image, id : this.idinfo, tipo : 1 }).then(response => {
                        this.loading = false;
                        this.images.concat(this.image)
                        this.image = []
                    });
                }else{
                    notificarFail("", "Ningun Archivo Seleccionado")
                }

            },
            deleteImage(img){
                this.image.splice(this.image.indexOf(img),1);
            },
            deleteImages(img){
                this.$http.post('/subsidios/vivienda/diagnostico/cierre/borrarimagen',{id : img.id}).then((response)=>{
                    if(response.body.estado == 'ok'){
                        this.images.splice(this.images.indexOf(img),1);

                        notificarOk("", "Imagen borrada del Servidor");
                    }

                },(error)=>{

                })
            }
        },
        mounted(){
           this.$http.post('/subsidios/vivienda/diagnostico/cierre/todasimagenes', {id :this.idinfo, tipo : 1 }).then((response)=>{
               this.images = response.body.data;
           }, (error)=>{

           });
        }
    });
    var app = new Vue({
            el : '#app',
            data : {
                token :"<?php echo csrf_token();?>",
                idInfoVivienda : '{{$info->id}}',
                idPredio : '{{$info->id_predio}}',
                infoVivienda : {
                    id:'{{$info->id}}',
                    fechaEncuesta: '{{ $info->fecha_encuesta }}',
                    consecutivo : '{{$info->consecutivo}}',
                    respondePropietario: '{{$info->responde_propietario}}',
                    programaSocial:'{{$info->beficiarios_prog_inv_social}}',
                    numeroFamiliasVivienda: '{{$info->no_familias_vivienda}}',
                    idPredio : '{{$info->id_predio}}',
                    idDistancioRio: '{{$info->id_distancia_m_rio_quebradas}}',
                    idEstadoVivienda :'{{$info->id_estados_viviendas}}',
                    observacionesObrasRealizar:'{{$info->observaciones_obras_realizar}}',
                    editado : false,
                },

                generalidades:{
                    id: '',
                    idInformacion: this.idInfoVivienda,
                    fechaViveVereda:'',
                    fechaViveVivienda : '',
                    idTipoVehiculo : '',
                    idTipoViaAcceso:'',
                    idEstadoVia:'',
                    idTiempoRecorrido:'',
                    idTipologiaFamilia:'',
                    editado : false
                },
                idVereda :'',
                departamentos : '',
                predioEditado : false,
                tiposVehiculos : '',
                viasAcceso : '',
                estadosVia : '',
                tiemposRecorrido: '',
                tipologiasFamilia : '',
                nivelesEducativos :'',
                generos : '',
                tipoMuro : '',
                tipoPiso : '',
                tipoCubierta: '',
                materialPuertas : '',
                materialVentanas : '',
                estadoVivienda : ''

            },
            methods:{

                guardarGeneral : function () {
                    var infoToSend ={
                        _token : this.token,
                        generalidades : this.generalidades,
                        infoVivienda : this.infoVivienda,
                    };
                    this.$http.post('/vivienda/guardargeneralidades', infoToSend).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Datos guardados Correctamente');
                            this.generalidades.id = response.body.idGeneralidades;

                        }else{
                            notificarFail('', 'Error al guardar ' + response.body.error);
                        }

                    }, (error)=>{
                        notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                    });

                },
                getDepartamentos : function () {
                    this.$http.post('/getdepartamentos',{_token: this.token}).then((response)=>{
                        this.departamentos = response.body.data
                    })
                },
                getTipoVehiculo: function () {
                    this.$http.post('/gettipovehiculo',{_token : this.token}).then((response)=>{
                        this.tiposVehiculos = response.body.data
                    })
                },
                getViaAcceso: function () {
                    this.$http.post('/getviasacceso',{_token : this.token}).then((response)=>{
                        this.viasAcceso = response.body.data
                    })
                },
                getEstadoVias: function () {
                    this.$http.post('/getestadosvia',{_token : this.token}).then((response)=>{
                        this.estadosVia = response.body.data
                    })
                },
                getTiemposRecorrido: function () {
                    this.$http.post('/gettiemposrecorrido',{_token : this.token}).then((response)=>{
                        this.tiemposRecorrido = response.body.data
                    })
                },
                getTipologiaFamilia: function () {
                    this.$http.post('/gettipologiasfamilia',{_token : this.token}).then((response)=>{
                        this.tipologiasFamilia = response.body.data
                    })
                },

            },
            watch: {

            },
            created(){
                this.getDepartamentos();
                this.getTipoVehiculo();
                this.getViaAcceso();
                this.getEstadoVias();
                this.getTiemposRecorrido();
                this.getTipologiaFamilia();

                this.$http.post('/getniveleseducativos').then((response)=>{
                    this.nivelesEducativos = response.body.data;
                }, (error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getgeneros').then((response)=>{
                    this.generos = response.body.data;
                }, (error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/vivienda/getselectsgenericos').then((response)=>{
                    if(response.body.estado == 'ok'){
                        this.tipoMuro = response.body.tipoMuro;
                        this.tipoPiso = response.body.tipoPiso;
                        this.tipoCubierta = response.body.tipoCubierta;
                        this.materialPuertas = response.body.materialPuertas;
                        this.materialVentanas = response.body.materialVentanas;
                        this.estadoVivienda = response.body.estadoVivienda;

                    }else{
                        notificarFail('', 'Error al cargar informacion de Habitaciones' + response.body.error);
                    }
                }, (error)=>{
                    notificarFail('', 'ERROR: '+error.status+' '+ error.statusText);
                })

            },
            mounted(){
                this.$http.post('/vivienda/getgeneralidades', {_token: this.token, idInfo : this.idInfoVivienda}).then((response)=>{
                    if(response.body.generalidades != null){
                        this.generalidades.id = response.body.generalidades.id;
                        this.generalidades.idInformacion = response.body.generalidades.id_informacion;
                        this.generalidades.fechaViveVereda = response.body.generalidades.fecha_vive_vereda;
                        this.generalidades.fechaViveVivienda = response.body.generalidades.fecha_vive_vivienda;
                        this.generalidades.idTipoVehiculo = response.body.generalidades.id_tipo_vehiculo;
                        this.generalidades.idTipoViaAcceso = response.body.generalidades.id_tipo_via_acceso;
                        this.generalidades.idEstadoVia = response.body.generalidades.id_estado_via;
                        this.generalidades.idTiempoRecorrido = response.body.generalidades.id_tiempo_recorrido;
                        this.generalidades.idTipologiaFamilia = response.body.generalidades.id_tipologia_familia;
                    }

                },(response)=>{
                    notificarFail('', 'Tenemos problemas al cargar la informacion general ' + + response.status+' '+ response.statusText);
                });
            }


        });


        $(document).ready(function () {

            $('.datepicker').datepicker({
                orientation: 'auto top',
                language : 'es',
                todayBtn : 'linked',
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {

                switch (e.target.id){
                    case 'fecha_encuesta':
                        app.infoVivienda.fechaEncuesta = $(this).val();
                        break;
                    case 'fecha_vereda':
                        app.generalidades.fechaViveVereda = $(this).val();
                        break;
                    case 'fecha_vivienda':
                        app.generalidades.fechaViveVivienda = $(this).val();
                        break;
                    case 'fecha_nacimiento-beneficiario':
                            //
                        break;

                }
            });

        })
    </script>
@endsection
@include('vivienda.parts.form_predio')
@include('vivienda.parts.table_beneficiarios')
@include('vivienda.parts.table_p_cargo')
@include('vivienda.parts.table_habitaciones')
@include('vivienda.parts.table_cocinas')
@include('vivienda.parts.table_unidad_sanitarias')
@include('vivienda.parts.form_servicios_publicos')
@include('vivienda.parts.form_cierre')
