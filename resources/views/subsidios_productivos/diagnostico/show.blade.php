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

            <h3>Visita de Diagnostico No @{{ infoProductivo.consecutivo }}</h3>
            <section class="col-lg-2 col-sm-4" id="seccion-menu-lateral">
                <ul class="nav nav-tabs" role="tablist">
                    Informacion General
                    <li role="presentation" class="active" ><a  class="red geopark white-text" href="#predio" aria-controls="predio" role="tab" data-toggle="tab" >Predio<span class="glyphicon glyphicon-asterisk red-text" v-bind:class="{'white-text' : predioEditado}" aria-hidden="true"></span> </a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#general" aria-controls="general" role="tab" data-toggle="tab" >General<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> </a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitantes" aria-controls="habitantes" role="tab" data-toggle="tab">Unidad Familiar</a></li>

                    <li>Informacion Especifica</li>
                    <li role="presentation"><a class="red geopark white-text" href="#p-cargos" aria-controls="p-cargos" role="tab" data-toggle="tab">Mano de Obra</a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitaciones" aria-controls="habitaciones" role="tab" data-toggle="tab">Potreros</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#cocinas" aria-controls="cocinas" role="tab" data-toggle="tab">Cultivos</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#u_sanitarias" aria-controls="u_sanitarias" role="tab" data-toggle="tab">Ventas</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#s_publicos" aria-controls="s_publicos" role="tab" data-toggle="tab">Bovinos</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#e_menores" aria-controls="e_menores" role="tab" data-toggle="tab">Especies Menores</a></li>
                    Informacion Final
                    <li role="presentation"><a  class="red geopark white-text" href="#cierre" aria-controls="cierre" role="tab" data-toggle="tab">Cierre</a></li>
                </ul>
            </section>
            <section class="col-lg-10 col-sm-8">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="predio">
                        <form-predio  :idinfo="idInfoProductivo" :idpredio="idPredio" ></form-predio>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitantes">
                        <beneficiarios  :idinfo="idInfoProductivo" :generos="generos" :niveles="nivelesEducativos"></beneficiarios>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="general">
                        @include('subsidios_productivos.diagnostico.parts.form_inicial')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="p-cargos">
                        <mano-obra :idinfo="idInfoProductivo"></mano-obra>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitaciones">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="cocinas">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="u_sanitarias">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="s_publicos">
                        Servicios Publicos
                    </div>
                    <div role="tabpanel" class="tab-pane" id="e_menores">
                        Servicios Publicos
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cierre">
                        Cierre
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
                        this.$http.post('/vivienda/habitantes/buscar',{no_cedula : this.nuevoBeneficiario.no_cedula, tipoSubsidio : 2}).then((response)=>{
                            if(response.body.estado == 'ok'){
                                this.nuevoBeneficiario = response.body.habitante;
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
                        this.$http.post('/vivienda/habitantes/guardar',{idInfo : this.idinfo, habitante : this.nuevoBeneficiario,tipoSubsidio : 2 }).then((response)=>{
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
                    this.$http.post('/vivienda/habitantes/remove',{habitante : this.beneficiarioToRemove.id, idInfo: this.idinfo, tipoSubsidio : 2}).then((response)=>{
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
                this.$http.post('/vivienda/habitantes/get', {_token : this.token, idInfo : this.idinfo,tipoSubsidio : 2 }).then((response)=>{
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
            props: ['departamentos','idinfo','idpredio'],
            data : function () {
                return  {
                    predio:{
                        id:'',
                        nombre: '',
                        direccion: '',
                        //idVereda : '',
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
                        id_productivo :this.idinfo,
                        id_opcion : '',
                        id_tipo_tenencia_tierras : ''

                    },
                    //municipios : '',
                    //veredas : '',
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
                    this.$http.post('/subsidios/productivos/diagnostico/guardarpredio', infoEnviar ).then((response)=>{
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
                    this.$http.post('/subsidios/productivos/diagnostico/getpredio',{ idPredio : this.idpredio, idInfo : this.idinfo }).then((response)=>{



                        this.predio.id = response.body.predio.id;
                        this.predio.nombre = response.body.predio.nombre_predio;
                        this.predio.direccion = response.body.predio.direccion;
                        this.predio.latitud = response.body.predio.latitud;
                        this.predio.longitud = response.body.predio.longitud;
                        this.predio.msnm = response.body.predio.msnm;


                        if(response.body.propietario != null ){
                            this.propietarioPredio.id = response.body.propietario.id;
                            this.propietarioPredio.noCedula = response.body.propietario.no_cedula;
                            this.propietarioPredio.nombres = response.body.propietario.nombres_propietario;
                            this.propietarioPredio.apellidos = response.body.propietario.apellidos_propietario;
                            this.propietarioPredio.telefono = response.body.propietario.no_telefonico;
                            this.propietarioPredio.idPredio = response.body.propietario.id_predio;
                        }


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
        Vue.component('mano-obra',{
            template : '#mano-obra',
            props : ['idinfo', 'generos', 'niveles'],
            data : function () {
                return {

                    loading : false,
                    nuevaMano: {
                        id : '',
                        jornal_vendido : 0,
                        actividad_jornal_vendido : '',
                        jornal_contratado : 0,
                        actividad_jornal_contratado : '',
                        id_mes : '',
                        id_info_productivo : this.idinfo,
                        mes : ''
                    },
                    manosObra: '',
                    meses : [
                        {
                            id : 1,
                            mes : 'Enero'

                        },
                        {
                            id : 2,
                            mes : 'Febrero'

                        },
                        {
                            id : 3,
                            mes : 'Marzo'

                        },
                        {
                            id : 4,
                            mes : 'Abril'

                        },
                        {
                            id : 5,
                            mes : 'Mayo'

                        },
                        {
                            id : 6,
                            mes : 'Junio'

                        },
                        {
                            id : 7,
                            mes : 'Julio'

                        },
                        {
                            id : 8,
                            mes : 'Agosto'

                        },
                        {
                            id : 9,
                            mes : 'Septiembre'

                        },
                        {
                            id : 10,
                            mes : 'Octubre'

                        },
                        {
                            id : 11,
                            mes : 'Noviembre'

                        },
                        {
                            id : 12,
                            mes : 'Diciembre'

                        }

                    ],
                    mesToRemove : '',






                }
            },



            methods : {
                mesSelected : function (mes) {
                    this.nuevaMano.mes = mes
                },
                prepareToRemove : function (mes) {
                    this.mesToRemove = mes;
                },
                formReset : function () {
                    this.nuevaMano = {
                        id : '',
                        jornal_vendido : 0,
                        actividad_jornal_vendido : '',
                        jornal_contratado : 0,
                        actividad_jornal_contratado : '',
                        id_mes : '',
                        id_info_productivo : this.idinfo,
                        mes : ''
                    }
                },

                guardarManoObra : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarmanoobra',{idInfo : this.idinfo, mano : this.nuevaMano }).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){

                            this.nuevaMano.id = response.body.id;
                            this.manosObra.push(this.nuevaMano);
                            $("#modal-agregar-mano-obra").modal('hide');
                            notificarOk('', 'Mano de Obra agregada correctamente');
                            this.formReset();

                        }else{
                            notificarFail('', 'Error:  ' + response.body.error);
                        }

                    },(error)=>{
                        this.loading = false;
                        notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                    });

                },

                eliminarMes : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/borrarmanoobra',{mes : this.mesToRemove.id}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){
                            $("#modal-confirm-delete-mano-obra").modal('hide');
                            notificarOk('', 'Mano de Obra removida correctamente');
                            this.manosObra.splice(this.manosObra.indexOf(this.mesToRemove),1);
                        }else{
                            $("#modal-confirm-delete-mano-obra").modal('hide');
                            notificarFail('', 'Error: ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-beneficiario").modal('hide');
                        notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                }

            },
            mounted(){
                this.$http.post('/subsidios/productivos/diagnostico/getmanoobra',{idInfo: this.idinfo}).then((response)=>{
                    this.manosObra = response.body.data;
                },(error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });
            },


        });


    var app = new Vue({
            el : '#app',
            data : {

                idInfoProductivo : '{{$info->id}}',
                idPredio : '{{$info->id_predio}}',
                infoProductivo : {
                    id:'{{$info->id}}',
                    fechaEncuesta: '{{$info->fecha_encuesta}}',
                    consecutivo : '{{$info->consecutivo}}',
                    respondePropietario: '{{$info->responde_propietario}}',
                    programaSocial:'{{$info->beficiarios_prog_inv_social}}',
                    numeroFamiliasVivienda: '{{$info->no_familias_vivienda}}',
                    idPredio : '{{$info->id_predio}}',
                    idDistancioRio: '',
                    idEstadoVivienda :'',
                    observacionesObrasRealizar:'',
                    editado : false,
                },

                generalidades:{
                    id: '',
                    idInformacion: this.idInfoProductivo,
                    fechaViveVereda:'',
                    fechaViveVivienda : '',
                    idTipoVehiculo : '',
                    idTipoViaAcceso:'',
                    idEstadoVia:'',
                    idTiempoRecorrido:'',
                    idTipologiaFamilia:'',
                    editado : false,
                    id_tipo_proyecto: '',
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
                estadoVivienda : '',
                tipoProyectos : ''

            },
            methods:{

                guardarGeneral : function () {// ok revision
                    var infoToSend ={
                        generalidades : this.generalidades,
                        infoProductivo : this.infoProductivo,
                    };
                    this.$http.post('/subsidios/productivos/diagnostico/guardargeneralidades', infoToSend).then((response)=>{
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

                getTipoVehiculo: function () {
                    this.$http.post('/gettipovehiculo').then((response)=>{
                        this.tiposVehiculos = response.body.data
                    })
                },
                getViaAcceso: function () {
                    this.$http.post('/getviasacceso').then((response)=>{
                        this.viasAcceso = response.body.data
                    })
                },
                getEstadoVias: function () {
                    this.$http.post('/getestadosvia').then((response)=>{
                        this.estadosVia = response.body.data
                    })
                },
                getTiemposRecorrido: function () {
                    this.$http.post('/gettiemposrecorrido').then((response)=>{
                        this.tiemposRecorrido = response.body.data
                    })
                },
                getTipologiaFamilia: function () {
                    this.$http.post('/gettipologiasfamilia').then((response)=>{
                        this.tipologiasFamilia = response.body.data
                    })
                },

            },
            watch: {

            },
            created(){

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

                this.$http.post('/getselectstipoproyectos').then((response)=>{
                    this.tipoProyectos = response.body.data;
                }, (error)=>{
                    notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });



            },
            mounted(){//ok revision
                this.$http.post('/subsidios/productivos/diagnostico/getgeneralidades', {_token: this.token, idInfo : this.idInfoProductivo}).then((response)=>{
                    if(response.body.generalidades != null){
                        this.generalidades.id = response.body.generalidades.id;
                        this.generalidades.idProductivo = response.body.generalidades.id_info_productivo;
                        this.generalidades.fechaViveVereda = response.body.generalidades.fecha_vive_vereda;
                        this.generalidades.fechaViveVivienda = response.body.generalidades.fecha_vive_vivienda;
                        this.generalidades.idTipoVehiculo = response.body.generalidades.id_tipo_vehiculo;
                        this.generalidades.idTipoViaAcceso = response.body.generalidades.id_tipo_via_acceso;
                        this.generalidades.idEstadoVia = response.body.generalidades.id_estado_via;
                        this.generalidades.idTiempoRecorrido = response.body.generalidades.id_tiempo_recorrido;
                        this.generalidades.idTipologiaFamilia = response.body.generalidades.id_tipologia_familia;
                        this.generalidades.id_tipo_proyecto = response.body.generalidades.id_tipo_proyecto;
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
                        app.infoProductivo.fechaEncuesta = $(this).val();
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
@include('subsidios_productivos.diagnostico.parts.form_predio')
@include('subsidios_productivos.diagnostico.parts.table_beneficiarios')
@include('subsidios_productivos.diagnostico.parts.table_mano_obra')