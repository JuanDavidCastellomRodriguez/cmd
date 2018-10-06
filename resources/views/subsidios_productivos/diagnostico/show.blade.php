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

            <h3>Visita de Diagnostico (Proyecto Productivo) No <b>@{{ infoProductivo.consecutivo }}</b></h3>
            <p><b>Beneficiario: </b> @{{ infoProductivo.beneficiario.nombre +' ('+ infoProductivo.beneficiario.documento +')' }} </p>
            <section class="col-lg-2 col-sm-4" id="seccion-menu-lateral">
                <ul class="nav nav-tabs" role="tablist">
                    Informacion General
                    <li role="presentation" class="active" ><a  class="red geopark white-text" href="#predio" aria-controls="predio" role="tab" data-toggle="tab" >Predio  </a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#general" aria-controls="general" role="tab" data-toggle="tab" >General </a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitantes" aria-controls="habitantes" role="tab" data-toggle="tab">Unidad Familiar</a></li>

                    <li>Informacion Especifica</li>
                    <li role="presentation"><a class="red geopark white-text" href="#p-cargos" aria-controls="p-cargos" role="tab" data-toggle="tab">Mano de Obra</a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#habitaciones" aria-controls="habitaciones" role="tab" data-toggle="tab">Potreros</a></li>
                    <li role="presentation"><a class="red geopark white-text" href="#fortalecimiento" aria-controls="fortalecimiento" role="tab" data-toggle="tab">Fortalecimiento</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#cocinas" aria-controls="cocinas" role="tab" data-toggle="tab">Cultivos</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#s_publicos" aria-controls="s_publicos" role="tab" data-toggle="tab">Bovinos</a></li>
                    <li role="presentation"><a  class="red geopark white-text" href="#e_menores" aria-controls="e_menores" role="tab" data-toggle="tab">Especies Menores</a></li>
                    Informacion Final
                    <li role="presentation"><a  class="red geopark white-text" href="#cierre" aria-controls="cierre" role="tab" data-toggle="tab">Cierre</a></li>
                </ul>
            </section>
            <section class="col-lg-10 col-sm-8">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="predio">
                        <form-predio  :idinfo="idInfoProductivo" :idpredio="idPredio" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></form-predio>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitantes">
                        <beneficiarios  :idinfo="idInfoProductivo" :generos="generos" :niveles="nivelesEducativos" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></beneficiarios>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="general">
                        @include('subsidios_productivos.diagnostico.parts.form_inicial')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="p-cargos">
                        <mano-obra :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></mano-obra>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="habitaciones">
                        <potreros :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></potreros>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="fortalecimiento">
                        <fortalecimiento :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></fortalecimiento>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cocinas">
                        <cultivos :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></cultivos>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="s_publicos">
                        <bovinos :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento" ></bovinos>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="e_menores">
                        <especies :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :nombre="infoProductivo.beneficiario.nombre" :documento="infoProductivo.beneficiario.documento"></especies>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cierre">
                        <cierre :idinfo="idInfoProductivo" :id="infoProductivo.beneficiario.id" :idpredio="idPredio"></cierre>
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

        Vue.component('fortalecimiento',{
            template : '#fortalecimiento-infraestructura',
            props : ['idinfo', 'id', 'nombre', 'documento'],
            data : function () {
                return {
                    fortalecimientos: '',
                    bandera: '',
                    nuevaInfraestructura: {
                        id: '',
                        tipo: '',
                        descripcion: ''
                    },
                    infoProductivo: '',
                    fortalecimientoToDelete: '',
                    fortalecimientoToEdit: ''

                }
            },
            methods: {
                guardarFortalecimiento: function () {
                    this.$http.post('/guardar/fortalecimiento', {id: this.id, idInfo: this.idinfo, fortalecimiento: this.nuevaInfraestructura}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            if (response.body.updated) {
                                index = this.fortalecimientos.indexOf(this.fortalecimientoToEdit);
                                this.fortalecimientos.splice(index,1);
                                this.fortalecimientos.splice(index,0,response.body.data);
                                $("#modal-agregar-fortalecimiento").modal('hide');
                                notificarOk('', 'Fortalecimiento editado correctamente');
                                this.formReset();
                                this.bandera = response.body.bandera;
                            }else {
                                this.fortalecimientos.push(response.body.data);
                                this.bandera = response.body.bandera;
                                this.infoProductivo = response.body.infoProductivo;
                                notificarOk('', 'Fortalecimiento de infraestructura creado exitosamente');
                                this.formReset();
                                $("#modal-agregar-fortalecimiento").modal('hide');    
                                this.bandera = response.body.bandera;
                            }                            
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al guardar los Fortalecimientos ');
                    });
                },

                prepareToDeleteOrEdit: function (tipo, fortalecimiento) {
                    if (tipo == 1) {
                        this.nuevaInfraestructura = JSON.parse( JSON.stringify( fortalecimiento ));
                        this.fortalecimientoToEdit = fortalecimiento;
                    }else if (tipo == 2) {
                        this.fortalecimientoToDelete = fortalecimiento;
                    }
                    
                },

                eliminarFortalecimiento: function () {
                    this.$http.post('/borrar/fortalecimiento', {idInfo: this.idinfo, fortalecimiento: this.fortalecimientoToDelete}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.borrarTemporal(this.fortalecimientoToDelete);
                            notificarOk('', 'Fortalecimiento de infraestructura borrado exitosamente');
                            $("#modal-confirm-delete-fortalecimiento").modal('hide');
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al borrar los Fortalecimientos ' + error.status+' '+ error.statusText);
                    });
                },

                borrarTemporal: function (fortalecimiento) {
                    this.fortalecimientos.splice(this.fortalecimientos.indexOf(fortalecimiento),1);
                },

                formReset: function () {
                    this.nuevaInfraestructura = {
                        id: '',
                        tipo: '',
                        descripcion: ''
                    }
                }
            },
            created (){
                this.$http.post('/get/fortalecimientos', { idInfo : this.idinfo, id: this.id }).then((response)=>{
                        this.fortalecimientos = response.body.data;
                }, (error)=>{
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

            }
        });


        Vue.component('beneficiarios',{
            template : '#beneficiarios',
            props : ['idinfo', 'generos', 'niveles', 'id', 'nombre', 'documento'],
            data : function () {
                return {
                    beneficiarios : '',
                    nuevoBeneficiario : {
                        id :'',
                        no_cedula : '00000',
                        nombres : 'Nombre',
                        apellidos : 'Apellidos',
                        fecha_nacimiento : '2000-01-01',
                        no_celular : '000000',
                        correo_electronico : 'example.com',
                        ocupacion : '',
                        id_estado_civil : '',
                        id_nivel_educativo : '',
                        estudia: '',
                        descripcion_estudio: '',
                        id_genero : '',
                        cabeza_hogar : true,
                        id_tipo_persona_a_cargo: '',
                        id_parentesco: ''
                    },
                    beneficiarioToRemove : '',
                    creandoNuevoBeneficiario : false,
                    loading : false,
                    estadosCiviles : '',
                    tipo_personas: '',
                    bandera: '',
                    infoProductivo: '',
                    parentescos: ''
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
                                if(response.body.yaEsHabitante == true){
                                    notificarFail('', 'El beneficiario ya existe en otro proyecto');
                                }
                                this.beneficiarios.push(response.body.habitante);
                                $("#modal-agregar-beneficiario").modal('hide');
                                notificarOk('', 'Habitante agregado correctamente');
                                this.bandera = response.body.bandera;
                                this.formReset();
                            }else{
                                this.creandoNuevoBeneficiario = true;
                                notificarFail('', 'Beneficiario no encontrado, se creará uno nuevo ' );
                            }
                            this.loading = false

                        },(error)=>{
                          //  notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        })

                    }else{
                        notificarFail('', 'Debe ingresar un valor');
                        this.loading = false
                    }

                },
                guardarBeneficiarioAnterior: function (idBeneficiario) {
                    this.$http.post('/guardar/beneficiarioAnterior', {id: idBeneficiario, idInfo: this.idinfo, tipo: 2}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.tipo_personas = response.body.data;
                            this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                        //notificarFail('', 'Error al cargar el tipo de Personas a Cargo ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporal: function (habitante) {
                    this.beneficiarios.splice(this.beneficiarios.indexOf(habitante),1);
                },

                guardarBeneficiario : function () {
                    var esnuevo = true;
                    var id = this.nuevoBeneficiario.id;
                    /*this.beneficiarios.forEach(function (beneficiario) {
                        if(beneficiario.id == id){
                            esnuevo = false
                        }
                    })*/
                    for (var i = 0; i < this.beneficiarios.length; i++) {
                        if(this.beneficiarios[i].id == id){
                            esnuevo = false;
                        }
                    }

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
                                //notificarFail('', 'Error en el servidor ' + response.body.error);
                            }

                        },(error)=>{

                            //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
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
                            //notificarFail('', 'Error en el servidor ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-beneficiario").modal('hide');
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                }

            },
            created (){
                this.$http.post('/vivienda/habitantes/get', {_token : this.token, idInfo : this.idinfo,tipoSubsidio : 2, id: this.id }).then((response)=>{
                    this.beneficiarios = response.body.data;
                    this.bandera = response.body.bandera;
                    this.infoProductivo = response.body.infoProductivo;
                }, (error)=>{
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getestadosciviles').then((response)=>{
                    this.estadosCiviles = response.body.data;
                }, (error)=>{
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/gettipopersonascargo').then((response)=>{
                if(response.body.estado == 'ok'){
                    this.tipo_personas = response.body.data;
                    }
                }, (error)=>{
                   // notificarFail('', 'Error al cargar el tipo de Personas a Cargo ' + error.status+' '+ error.statusText);
                });

                 this.$http.post('/get_parentesco').then((response)=>{
                if(response.body.estado == 'ok'){
                    this.parentescos = response.body.parentesco;
                    }
                }, (error)=>{
                  //  notificarFail('', 'Error al cargar el tipo de Personas a Cargo ' + error.status+' '+ error.statusText);
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
            props: ['departamentos','idinfo','idpredio', 'id', 'nombre', 'documento'],
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
                        id_tipo_tenencia_tierras : '',
                        otra_tenencia: '',
                        otra_opcion: ''

                    },
                    //municipios : '',
                    //veredas : '',
                    predioEditado : false,
                    opcionesTenencia : '',
                    tipoTenencia : '',
                    pdf : '',
                    bandera: '',
                    infoProductivo: '' 
                }
            },
            methods:{
                guardarPredio : function () {
                    var fdata = new FormData();
                    fdata.append('pdf', this.pdf);
                    infoEnviar = {
                        id: this.id,
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
                        //notificarFail('Predio', 'Error en el servidor ' + response.status+' '+ response.statusText);

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
                },

                resetPredio: function () {
                    this.predio = {
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
                    this.propietarioPredio = {
                        id : '',
                        noCedula : '',
                        nombres: '',
                        apellidos: '',
                        telefono:'',
                        idPredio: '',
                        editado : false
                    },
                    this.tenenciaPredio = {
                        id : '',
                        area_predio_has :'',
                        pdf :'',
                        id_productivo :this.idinfo,
                        id_opcion : '',
                        id_tipo_tenencia_tierras : '',
                        otra_tenencia: '',
                        otra_opcion: ''

                    }
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
                    this.$http.post('/subsidios/productivos/diagnostico/getpredio',{ idPredio : this.idpredio, idInfo : this.idinfo}).then((response)=>{



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
                        //notificarFail('Predio', 'Tenemos problemas al cargar la informacion del predio ' + + response.status+' '+ response.statusText);
                    });
                }else {
                    this.$http.post('/subsidios/productivos/diagnostico/getpredioAnterior',{ idInfo : this.idinfo, id: this.id }).then((response)=>{

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
                        this.bandera = response.body.bandera;
                        this.tenenciaPredio.id = '';
                        this.tenenciaPredio.id_productivo = this.idinfo;
                        this.infoProductivo = response.body.infoProductivo;

                    },(response)=>{
                        //notificarFail('Predio', 'Tenemos problemas al cargar la informacion del predio ' + + response.status+' '+ response.statusText);
                    });

                }
            },
            created(){
                this.$http.post('/getselectspredio').then((response) => {
                    if(response.body.estado == 'ok'){
                        this.opcionesTenencia = response.body.opciones;
                        this.tipoTenencia = response.body.tipo;
                    }else{
                        //notificarFail('', 'Error al cargar datos ' + response.body.error);
                    }
                },(error)=>{
                    //notificarFail('', 'Error en el servidor ' + response.status+' '+ response.statusText);
                });
            }

        });
        Vue.component('mano-obra',{
            template : '#mano-obra',
            props : ['idinfo', 'generos', 'niveles', 'id', 'nombre', 'documento'],
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
                    bandera: '',
                    infoProductivo: '',
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
                    if (this.nuevaMano.actividad_jornal_vendido != '' && this.nuevaMano.actividad_jornal_contratado != '') {
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
                                //notificarFail('', 'Error:  ' + response.body.error);
                            }

                        },(error)=>{
                            this.loading = false;
                            //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        });
                    }else {
                        notificarFail('', 'Por favor, complete todos los campos');
                    }
                    

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
                            //notificarFail('', 'Error: ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-beneficiario").modal('hide');
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                },
                guardarManoAnterior: function (idMano) {
                    this.$http.post('/guardar/manoAnterior', { mano: idMano, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.nuevaMano.id = response.body.id;
                            notificarOk('', 'Mano de Obra agregada correctamente');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                        //notificarFail('', 'Error al cargar el tipo de Personas a Cargo ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporal: function (mano) {
                    this.manosObra.splice(this.manosObra.indexOf(mano),1);
                },

            },
            mounted(){
                this.$http.post('/subsidios/productivos/diagnostico/getmanoobra',{id: this.id, idInfo: this.idinfo}).then((response)=>{
                    this.manosObra = response.body.data;
                    this.bandera = response.body.bandera;
                    this.infoProductivo = response.body.infoProductivo;                    
                },(error)=>{
                   // notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });
            },


        });
        Vue.component('potreros',{
            template : '#potreros',
            props : ['idinfo', 'id', 'nombre', 'documento'],
            data : function () {
                return {

                    loading : false,
                    nuevoPotrero: {
                        id : '',
                        potrero_lote : '',
                        extension_has : 0,
                        rotacional_dias_descanso : 0,
                        rotacional_dias_ocupacion : 0,
                        id_subtipo_cobertura : '',
                        id_tipo_cobertura : '',
                        id_mes : '',
                        id_info_productivo : this.idinfo,
                        id_fuente_hidrica : '',
                        fuente : '',
                        tipoCobertura : '',
                        subtipoCobertura : '',
                        uso : '',
                        observaciones: ''
                    },
                    potreros: '',

                    potreroToRemove : '',
                    tipoCobertura : '',
                    subtipoCobertura : '',
                    fuentesHidricas : '',
                    bandera: '',
                    infoProductivo: ''

                }
            },



            methods : {
                coberturaSelected : function (id, nombre) {
                    this.nuevoPotrero.tipoCobertura = nombre;
                    this.$http.post('/getselectssubtipocobertura',{id : id}).then((response)=>{
                        this.subtipoCobertura = response.body.data;
                    },(error)=>{
                       // notificarFail('', 'Error al obtener los Tipos de Cobertura ' + error.status+' '+ error.statusText);
                    });
                },
                subcoberturaSelected : function (nombre) {
                    this.nuevoPotrero.subtipoCobertura = nombre;

                },
                fuenteSelected : function (nombre) {
                    this.nuevoPotrero.fuente = nombre;

                },
                prepareToRemove : function (potrero) {
                    this.potreroToRemove = potrero;
                },
                formReset : function () {
                    this.nuevoPotrero = {
                        id : '',
                        potrero_lote : '',
                        extension_has : 0,
                        rotacional_dias_descanso : 0,
                        rotacional_dias_ocupacion : 0,
                        id_subtipo_cobertura : '',
                        id_tipo_cobertura : '',
                        id_mes : '',
                        id_info_productivo : this.idinfo,
                        id_fuente_hidrica : '',
                        fuente : '',
                        tipoCobertura : '',
                        subtipoCobertura : '',
                        uso : '',

                    }
                },

                guardarPotrero : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarpotrero',{potrero : this.nuevoPotrero }).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){

                            this.nuevoPotrero.id = response.body.id;
                            this.potreros.push(this.nuevoPotrero);
                            $("#modal-agregar-potrero").modal('hide');
                            notificarOk('', 'Potrero agregado correctamente');
                            this.formReset();

                        }else{
                          //  notificarFail('', 'Error:  ' + response.body.error);
                        }

                    },(error)=>{
                        this.loading = false;
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                    });

                },

                eliminarPotrero : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/borrarpotrero',{potrero : this.potreroToRemove.id}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){
                            $("#modal-confirm-delete-potrero").modal('hide');
                            notificarOk('', 'Potrero borrado correctamente');
                            this.potreros.splice(this.potreros.indexOf(this.potreroToRemove),1);
                        }else{
                            $("#modal-confirm-delete-potrero").modal('hide');
                            //notificarFail('', 'Error: ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-potrero").modal('hide');
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                },
                guardarPotreroAnterior: function (potrero) {
                    this.$http.post('/guardar/potreroAnterior', { potrero: potrero, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.nuevoPotrero.id = response.body.id;
                            notificarOk('', 'Potrero agregado correctamente');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                        //notificarFail('', 'Error al cargar los potreros ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporal: function (potrero) {
                    this.potreros.splice(this.potreros.indexOf(potrero),1);
                }

            },
            mounted(){
                this.$http.post('/subsidios/productivos/diagnostico/getpotreros',{id: this.id, idInfo: this.idinfo}).then((response)=>{
                    this.potreros = response.body.data;
                    this.bandera = response.body.bandera;
                    this.infoProductivo = response.body.infoProductivo;
                    /*if (response.body.bnadera == 1) {
                        for (var i = 0; i < this.potreros.length(); i++) {
                            this.potreros[i].id = '';
                            this.potreros[i].id_info_productivo = this.idinfo;
                        }
                    }*/

                },(error)=>{
                    //notificarFail('', 'Error al obtener los Potreros ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getselectstipocobertura').then((response)=>{
                    this.tipoCobertura = response.body.data;
                },(error)=>{
                    //notificarFail('', 'Error al obtener los Potreros ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getselectstipofuentehidrica').then((response)=>{
                    this.fuentesHidricas = response.body.data;
                },(error)=>{
                  //  notificarFail('', 'Error al obtener los Potreros ' + error.status+' '+ error.statusText);
                });
            },


        });
        Vue.component('cultivos',{
            template : '#cultivos',
            props : ['idinfo', 'id', 'nombre', 'documento'],
            data : function () {
                return {

                    loading : false,
                    cultivos : [],
                    cultivoToRemove : '',
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
                    nuevaSemilla : {
                        variedad : '',
                        densidad : '',
                        certificado_ica : false,
                        //id_procedencia_semilla : '',
                        otra_procedencia: ''
                    },
                    nuevoCultivo : {
                        descripcion_cultivo : '',
                        nombre_producto : '',
                        fecha_establecimiento_cultivo : '',
                        fecha_renovacion : '',
                        id_info_productivo : this.idinfo,
                        id_unidad_producto : '',
                        id_sitio_venta : '',
                        id :'',
                        actividades : {
                            preparacion : [],
                            siembra : [],
                            deshierbado : [],
                            abonado : [],
                            cosecha : []
                        }, // semillas
                        semillas : []

                    },
                    nuevoDetalleCultivo : {
                        semilla : {
                            variedad : '',
                            //id_procedencia_semilla : '',
                            otra_procedencia: '',
                            certificado_ica :'',
                            densidad :'',
                            id_cultivo :'',
                            id :'',

                        },
                        plagas : [],
                        componentes : {
                            prepasiembra : {

                            },
                            establecimiento : {

                            },
                            mantenimiento : {

                            }


                        },
                        ventas : {

                        }
                    },
                    unidadesProducto : '',
                    sitiosVenta : '',
                    cultivoToEdit : '',
                    cultivoToDetalle : '',
                    agregandoPlaga : false,
                    agregandoSemilla : false,
                    editandoSemilla : false,
                    procedenciaSemilla : '',
                    bandera: '',
                    infoProductivo: ''



                }
            },



            methods : {
                coberturaSelected : function (id, nombre) {
                    this.nuevoPotrero.tipoCobertura = nombre;
                    this.$http.post('/getselectssubtipocobertura',{id : id}).then((response)=>{
                        this.subtipoCobertura = response.body.data;
                    },(error)=>{
                       // notificarFail('', 'Error al obtener los Tipos de Cobertura ' + error.status+' '+ error.statusText);
                    });
                },
                subcoberturaSelected : function (nombre) {
                    this.nuevoPotrero.subtipoCobertura = nombre;

                },
                fuenteSelected : function (nombre) {
                    this.nuevoPotrero.fuente = nombre;

                },
                prepareToRemove : function (cultivo) {
                    this.cultivoToRemove = cultivo;
                },
                formReset : function () {
                    this.nuevoCultivo = {
                        descripcion_cultivo : '',
                        nombre_producto : '',
                        fecha_establecimiento_cultivo : '',
                        fecha_renovacion : '',
                        id_info_productivo : this.idinfo,
                        id_unidad_producto : '',
                        id_sitio_venta : '',
                        id :'',
                        actividades : {
                            preparacion : [],
                            siembra : [],
                            deshierbado : [],
                            abonado : [],
                            cosecha : []
                        }, // semillas
                        semillas : []

                    }
                },
                prepareToEdit : function (cultivo) {
                  this.nuevoCultivo = JSON.parse( JSON.stringify( cultivo ));
                  this.cultivoToEdit = cultivo;

                },
                prepareToDetalle : function (cultivo) {
                    //alert(cultivo.id)
                    this.cultivoToDetalle = cultivo;


                },


                guardarCultivo : function () {
                    if( this.nuevoCultivo.semillas.length > 0){
                        this.loading = true;
                        this.$http.post('/subsidios/productivos/diagnostico/guardarcultivo',{cultivo : this.nuevoCultivo }).then((response)=>{
                            this.loading = false;
                            if(response.body.estado == 'ok'){
                                if(response.body.updated){
                                    //this.cultivoToEdit = response.body.cultivo
                                    index = this.cultivos.indexOf(this.cultivoToEdit);
                                    this.cultivos.splice(index,1);
                                    this.cultivos.splice(index,0,response.body.cultivo);
                                    $("#modal-agregar-cultivo").modal('hide');
                                    notificarOk('', 'Cultivo editado correctamente');
                                    this.formReset();
                                }else{
                                    this.cultivos.push(response.body.cultivo);
                                    $("#modal-agregar-cultivo").modal('hide');
                                    notificarOk('', 'Cultivo agregado correctamente');
                                    this.formReset();
                                }


                            }else{
                               // notificarFail('', 'Error:  ' + response.body.error);
                            }

                        },(error)=>{
                            this.loading = false;
                           // notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        });
                    }else{
                        notificarFail('','Debe agregar al menos una semilla')
                    }


                },

                eliminarCultivo : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/borrarcultivo',{potrero : this.cultivoToRemove.id}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){
                            $("#modal-confirm-delete-cultivo").modal('hide');
                            notificarOk('', 'Cultivo borrado correctamente');
                            this.potreros.splice(this.potreros.indexOf(this.potreroToRemove),1);
                        }else{
                            $("#modal-confirm-delete-cultivo").modal('hide');
                          //  notificarFail('', 'Error: ' + response.body.error);
                        }
                    },(error)=>{
                        $("#modal-confirm-delete-cultivo").modal('hide');
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                        this.loading = false;
                    });

                },
                showAgregarPlaga : function (tipo) {
                    //alert("ok!!")
                    if(tipo == '1'){
                        this.agregandoPlaga = true;
                    }else{
                        this.agregandoPlaga = false;
                    }
                },

                borrarSemilla: function (id, semilla) {
                    var idSemilla = id;
                    this.$http.post('/subsidios/productivos/cultivos/borrarSemilla', idSemilla).then((response)=>{this.nuevoCultivo.semillas.splice(this.nuevoCultivo.semillas.indexOf(semilla),1);
                        notificarFail('', response.body.mensaje);
                    },(error)=>{
                        notificarFail('', response.body.descripcion);
                    });
                },

                showAgregarSemilla : function (tipo) {
                    //alert("ok!!")
                    if(tipo == '1'){
                        this.agregandoSemilla = true;
                    }else{
                        this.agregandoSemilla = false;
                    }
                },
                agregarSemilla : function () {
                    if(this.nuevaSemilla.variedad != '' && this.nuevaSemilla.densidad != '' && this.nuevaSemilla.id_procedencia_semilla != '' ){
                        this.nuevoCultivo.semillas.push(this.nuevaSemilla);
                        this.nuevaSemilla = {
                            variedad : '',
                            densidad : '',
                            certificado_ica : false,
                            //id_procedencia_semilla : ''
                            otra_procedencia: ''

                        }
                        this.agregandoSemilla = false;
                    }else{
                        notificarFail('', 'Todos los campos son requeridos')
                    }
                },
                guardarCultivoAnterior: function (cultivo) {
                    this.$http.post('/guardar/cultivoAnterior', { cultivo: cultivo, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Cultivo agregado correctamente');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los cultivos ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporal: function (cultivo) {
                    this.cultivos.splice(this.cultivos.indexOf(cultivo),1);
                }

            },
            mounted(){
                this.$http.post('/subsidios/productivos/diagnostico/getcultivos',{id: this.id, idInfo: this.idinfo}).then((response)=>{
                    this.cultivos = response.body.data;
                    this.bandera = response.body.bandera;
                    this.infoProductivo = response.body.infoProductivo;
                },(error)=>{
                   // notificarFail('', 'Cultivos: Error al obtener los Cultivos ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getselectsunidadproducto').then((response)=>{
                    this.unidadesProducto = response.body.data;
                },(error)=>{
                    //notificarFail('', 'Cultivos: Error al obtener la unidad de los productos ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getselectssitioventa').then((response)=>{
                    this.sitiosVenta = response.body.data;
                },(error)=>{
                   // notificarFail('', 'Cultivos: Error al obtener los sitios de venta ' + error.status+' '+ error.statusText);
                });
                this.$http.post('/getselectsprocedenciasemilla').then((response)=>{
                    this.procedenciaSemilla = response.body.data;
                },(error)=>{
                   // notificarFail('', 'Cultivos: Error al obtener los sitios de venta ' + error.status+' '+ error.statusText);
                });


                var component = this;
                $('#fecha_establecimiento').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : 'linked',
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {

                    component.nuevoCultivo.fecha_establecimiento_cultivo = e.target.value;
                    //console.log(component.nuevoBeneficiario.fecha_nacimiento)

                });
                $('#fecha_renovacion').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : 'linked',
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {

                    component.nuevoCultivo.fecha_renovacion = e.target.value;
                    //console.log(component.nuevoBeneficiario.fecha_nacimiento)

                });
            },


        });

        Vue.component('detalle-cultivo',{
            template : '#detalle-cultivo',
            props : ['idcultivo'],
            data : function () {
                return {

                    loading : false,
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

                    plagas : [],
                    detalles : [],
                    insumos : '',
                    ventas : [],

                    ventas : [],
                    nuevoDetalle : {
                        id_componente_cultivo : '',
                        id_cultivo : this.idcultivo,
                        actividades : '',
                        frecuencia : '',
                        mano_obra : '',
                        id_etapa : ''
                    },
                    nuevaPlaga : {
                        caracteristicas_control : '',
                        frecuencia : '',
                        mano_obra : '',
                        tipo_plaga : '',
                        id_cultivo : this.idcultivo
                    },
                    nuevoInsumo : {
                        insumo : '',
                        cantidad : '',
                        frecuencia : '',
                        id_etapa : '',
                        id_cultivo : this.idcultivo,
                    },
                    nuevaVenta : {
                        cantidad_autoconsumo : '',
                        cantidad_venta : '',
                        cantidad_primera_calidad : '',
                        cantidad_segunda_calidad : '',
                        cantidad_tercera_calidad : '',
                        id_mes : '',
                        id_cultivo : this.idcultivo,

                    },

                    componentesCultivos : '',
                    agregandoActividad : false,
                    agregandoInsumo : false,
                    agregandoPlaga : false,
                    agregandoVenta : false,

                }
            },
            watch : {
                idcultivo : function () {
                    this.$http.post('/subsidios/productivos/diagnostico/getdetallecultivo',{id : this.idcultivo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.plagas = response.body.plagas;
                            this.insumos = response.body.insumos;
                            this.detalles = response.body.detalle;
                            this.ventas = response.body.ventas;

                        }

                    }, (error)=>{
                       // notificarFail('', 'Error al obtener los Detalles del Cultivo ' + error.status+' '+ error.statusText);
                    });

                }
            },


            methods : {
                showAgregar : function (tipo,caso) {
                    //alert("ok!!")
                    if(tipo == 1){
                        this.agregandoActividad = true;
                        this.nuevoDetalle.id_etapa = caso;
                    }else{
                        this.agregandoActividad = false;
                    }


                },
                showAgregarPlaga : function (tipo) {
                    //alert("ok!!")
                    if(tipo == 1){
                        this.agregandoPlaga = true;
                        this.nuevaPlaga.id_cultivo = this.idcultivo;

                    }else{
                        this.agregandoPlaga = false;
                    }


                },
                showAgregarInsumo : function (tipo,caso) {
                    //alert("ok!!")
                    if(tipo == 1){
                        this.agregandoInsumo = true;
                        this.nuevoInsumo.id_etapa = caso;
                    }else{
                        this.agregandoInsumo = false;
                    }


                },

                showAgregarVenta : function (tipo) {
                    //alert("ok!!")
                    if(tipo == 1){
                        this.agregandoVenta = true;
                        this.nuevaVenta.id_cultivo = this.idcultivo;
                    }else{
                        this.agregandoVenta = false;
                    }


                },
                formReset :function () {
                    
                },
                agregarInsumo : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarinsumocultivo',{insumo : this.nuevoInsumo}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){

                            this.insumos.push(response.body.insumo);
                            this.nuevoInsumo.insumo = '';
                            this.nuevoInsumo.cantidad = '';
                            this.nuevoInsumo.frecuencia = '';

                            notificarOk('', 'Insumo creado correctamente');
                        }
                    },(error)=>{
                        this.loading = false;
                        notificarFail('', 'Error al guardar el insumo');
                    });

                },
                agregarActividad : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardardetallecultivo',{detalle : this.nuevoDetalle}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){

                            this.detalles.push(response.body.detalle);
                            this.nuevoDetalle.id_componente_cultivo = '';
                            this.nuevoDetalle.id_cultivo = this.idcultivo;
                            this.nuevoDetalle.actividades = '';
                            this.nuevoDetalle.frecuencia = '';
                            this.nuevoDetalle.mano_obra = '';

                            notificarOk('', 'Actividad creada correctamente');
                        }
                    },(error)=>{
                        this.loading = false;
                        notificarFail('', 'Error al guardar la actividad');
                    });
                },
                eliminarActividad : function (actividad) {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminardetallecultivo',{id : actividad.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.detalles.splice(this.detalles.indexOf(actividad),1);
                            notificarOk('','Actividad eliminada correctamente');
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al guardar la actividad');
                    });
                },
                eliminarInsumo : function (insumo) {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarinsumocultivo',{id : insumo.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.insumos.splice(this.insumos.indexOf(insumo),1);
                            notificarOk('','Insumo eliminado correctamente');
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al guardar el insumo');
                    });

                },
                agregarPlaga : function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarplagacultivo',{plaga : this.nuevaPlaga}).then((response)=>{
                        this.loading = false;
                        if(response.body.estado == 'ok'){

                            this.plagas.push(response.body.plaga);
                            this.nuevaPlaga = {
                                caracteristicas_control : '',
                                frecuencia : '',
                                mano_obra : '',
                                tipo_plaga : '',
                                id_cultivo : this.idcultivo
                            };

                            notificarOk('', 'Plaga creada correctamente');
                        }
                    },(error)=>{
                        this.loading = false;
                        notificarFail('', 'Error al guardar la plaga');
                    });

                },
                eliminarPlaga : function (plaga) {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarplagacultivo',{id : plaga.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.plagas.splice(this.plagas.indexOf(plaga),1);
                            notificarOk('','Plaga eliminada correctamente');
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al eliminar la plaga');
                    });
                },

                agregarVenta : function () {
                    var totalProduccion = this.nuevaVenta.cantidad_autoconsumo + this.nuevaVenta.cantidad_venta;
                    var totalCalidad = this.nuevaVenta.cantidad_primera_calidad + this.nuevaVenta.cantidad_segunda_calidad + this.nuevaVenta.cantidad_tercera_calidad;
                    if(totalProduccion == totalCalidad ){
                        this.loading = true;
                        this.$http.post('/subsidios/productivos/diagnostico/guardarventacultivo',{venta : this.nuevaVenta}).then((response)=>{
                            this.loading = false;
                            if(response.body.estado == 'ok'){

                                this.ventas.push(response.body.venta);
                                this.nuevaVenta = {
                                    cantidad_autoconsumo : '',
                                    cantidad_venta : '',
                                    cantidad_primera_calidad : '',
                                    cantidad_segunda_calidad : '',
                                    cantidad_tercera_calidad : '',
                                    id_mes : '',
                                    id_cultivo : this.idcultivo,
                                };

                                notificarOk('', 'Venta creada correctamente');
                            }else{
                                notificarFail('', 'Error:  ' + response.body.error);
                            }
                        },(error)=>{
                            this.loading = false;
                            notificarFail('', 'Error al guardar la venta');
                        });
                    }else{
                        notificarFail('','La suma de los campos de calidad del producto debe ser igual a la produccion total')
                    }


                },
                eliminarVenta : function (venta) {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarventacultivo',{id : venta.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.ventas.splice(this.ventas.indexOf(venta),1);
                            notificarOk('','Venta eliminada correctamente');
                        }
                    }, (error)=>{
                        notificarFail('', 'Error al eliminar la venta');
                    });
                },

            },
            mounted(){
                this.$http.post('/getselectscomponentescultivos').then((response)=>{
                    this.componentesCultivos = response.body.data;
                },(error)=>{
                    //notificarFail('', 'Error al obtener los Componetes del Cultivo ' + error.status+' '+ error.statusText);
                });

                var componente = this;
                $('#accordion').on('hide.bs.collapse', function () {
                    //alert('esoo!!')
                    componente.agregandoActividad = false;
                    componente.agregandoInsumo = false;
                    componente.nuevoDetalle = {
                        id_componente_cultivo : '',
                        id_cultivo : componente.idcultivo,
                        actividades : '',
                        frecuencia : '',
                        mano_obra : '',
                        id_etapa : ''
                    };
                    componente.nuevoInsumo = {
                        insumo : '',
                        cantidad : '',
                        frecuencia : '',
                        id_etapa : '',
                        id_cultivo : componente.idcultivo,
                    };

                    // do something…
                })
            },


        });

        Vue.component('bovinos', {
            template: '#bovinos',
            props: ['idinfo', 'id', 'nombre','documento'],
            data: function () {
                return {

                    loading: false,
                    nuevoBovino: {
                        id_info_productivo: this.idinfo,
                        id_raza: '',
                        id_tipo_propiedad: '',
                        id_tipo_bovino: '',
                        cantidad: '',
                    },
                    bovinos: [],
                    razas: '',
                    TipoPropiedades: '',
                    tipoBovino: '',
                    bovinoToDelete : '',
                    actividadesManejo : '',
                    nuevoManejo : {
                        cantidad : '',
                        periodicidad : '',
                        id_actividad_manejo : '',
                        id_info_productivo : this.idinfo,
                        producto_actividad : '',
                    },
                    manejoToDelete : '',
                    manejoAnimales : [],
                    ordenios : [],
                    ordenioToDelete : '',
                    nuevoOrdenio : {
                        produccion_dia : '',
                        cantidad_cuaja : '',
                        cantidad_autoconsumo : '',
                        cantidad_venta : '',
                        id_info_productivo : this.idinfo,
                        id_frecuencia_ordenio : '',
                        id_unidades_ordenio : '',
                    },
                    frecuenciasOrdenios : '',
                    unidadesOrdenios : '',
                    banderaB: '',
                    banderaM: '',
                    banderaO: '',
                    infoProductivo: ''


                }
            },

            methods: {

                formReset: function () {
                    this.nuevoBovino = {
                        id_info_productivo : this.idinfo,
                        id_raza : '',
                        id_tipo_propiedad : '',
                        id_tipo_bovino : '',
                        cantidad : '',
                    };
                    this.nuevoManejo = {
                        cantidad : '',
                        periodicidad : '',
                        id_actividad_manejo : '',
                        id_info_productivo : this.idinfo,
                        producto_actividad : '',
                    };
                    this.nuevoOrdenio = {
                        produccion_dia : '',
                        cantidad_cuaja : '',
                        cantidad_autoconsumo : '',
                        cantidad_venta : '',
                        id_info_productivo : this.idinfo,
                        id_frecuencia_ordenio : '',
                        id_unidades_ordenio : '',
                    }
                },
                prepareToDelete : function (bovino) {
                    this.bovinoToDelete = bovino
                },
                prepareToDeleteManejo : function (manejo) {
                    this.manejoToDelete = manejo
                },
                prepareToDeleteOrdenio : function (ordenio) {
                    this.ordenioToDelete = ordenio
                },

                guardarBovino: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarbovino', {bovino: this.nuevoBovino}).then((response) => {
                        this.loading = false;
                        if (response.body.estado == 'ok') {

                            this.bovinos.push(response.body.bovino);
                            $("#modal-agregar-bovino").modal('hide');
                            this.formReset();


                            notificarOk('', 'Bovinos creados correctamente');
                        } else {
                            notificarFail('', 'Error:  ' + response.body.error);
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar los bovinos');
                    });
                },

                eliminarBovino: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarbovino', {id: this.bovinoToDelete.id}).then((response) => {
                        if (response.body.estado == 'ok') {
                            this.bovinos.splice(this.bovinos.indexOf(this.bovinoToDelete), 1);
                            notificarOk('', 'Bovino eliminado correctamente');
                            $("#modal-confirm-delete-bovino").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el bovino');
                    });
                },

                guardarManejoBovino: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarmanejobovino', {manejo: this.nuevoManejo}).then((response) => {
                        this.loading = false;
                        if (response.body.estado == 'ok') {

                            this.manejoAnimales.push(response.body.manejo);
                            $("#modal-agregar-manejo-bovino").modal('hide');
                            this.formReset();


                            notificarOk('', 'Manejo de animales creado correctamente');
                        } else {
                            notificarFail('', 'Error:  ' + response.body.error);
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar el manejo de animales');
                    });
                },

                eliminarManejoBovino: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarmanejobovino', {id: this.manejoToDelete.id}).then((response) => {
                        if (response.body.estado == 'ok') {
                            this.manejoAnimales.splice(this.manejoAnimales.indexOf(this.manejoToDelete), 1);
                            notificarOk('', 'Manejo de animales eliminado correctamente');
                            $("#modal-confirm-delete-manejo-bovino").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el manejo de animales');
                    });
                },

                guardarOrdenioBovino: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/guardarordeniobovino', {ordenio: this.nuevoOrdenio}).then((response) => {
                        this.loading = false;
                        if (response.body.estado == 'ok') {

                            this.ordenios.push(response.body.ordenio);
                            $("#modal-agregar-ordenio-bovino").modal('hide');
                            this.formReset();


                            notificarOk('', 'Registro de Ordeño creado correctamente');
                        } else {
                            //notificarFail('', 'Error:  ' + response.body.error);
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar el registro de ordeño');
                    });
                },

                eliminarOrdenioBovino: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/eliminarordeniobovino', {id: this.ordenioToDelete.id}).then((response) => {
                        if (response.body.estado == 'ok') {
                            this.ordenios.splice(this.ordenios.indexOf(this.ordenioToDelete), 1);
                            notificarOk('', 'Registro de ordeño eliminado correctamente');
                            $("#modal-confirm-delete-ordenio-bovino").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el registro de ordeño');
                    });
                },

                guardarBovinoAnterior: function (bovino) {
                    this.borralTemporalBovino(bovino);
                    this.$http.post('/guardar/bovinoAnterior', { bovino: bovino, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Bovino agregado correctamente');                            
                            //this.bovinos.push(response.body.bovino);
                            //$("#btnBovino").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los bovinos ' + error.status+' '+ error.statusText);
                    });
                },
                borralTemporalBovino: function (bovino) {
                    this.bovinos.splice(this.bovinos.indexOf(bovino),1);
                },

                guardarManejoAnterior: function (manejo) {
                    this.borralTemporalManejo(manejo);
                    this.$http.post('/guardar/manejoAnterior', { manejo: manejo, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Manejo agregado correctamente');
                            //$("#btnManejo").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los manejos ' + error.status+' '+ error.statusText);
                    });
                },
                borralTemporalManejo: function (manejo) {
                    this.manejoAnimales.splice(this.manejoAnimales.indexOf(manejo),1);
                },

                guardarOrdenioAnterior: function (ordenio) {
                    this.borralTemporalOrdenio(ordenio);
                    this.$http.post('/guardar/ordenioAnterior', { ordenio: ordenio, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Ordeño agregado correctamente');
                            //$("#btnOrdenio").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los ordeños ' + error.status+' '+ error.statusText);
                    });
                },
                borralTemporalOrdenio: function (ordenio) {
                    this.ordenios.splice(this.ordenios.indexOf(ordenio),1);
                }

        },



        mounted(){

            this.$http.post('/getselectsbovinos').then((response)=>{
                this.razas = response.body.razas;
                this.TipoPropiedades = response.body.propiedades;
                this.tipoBovino = response.body.tipos;
                this.actividadesManejo = response.body.actividades;
                this.frecuenciasOrdenios = response.body.frecuencia;
                this.unidadesOrdenios = response.body.unidades;


            },(error)=>{
               // notificarFail('', 'Error al obtener las razas de los bovinos ' + error.status+' '+ error.statusText);
            });

            this.$http.post('/subsidios/productivos/diagnostico/getbovinos', {id: this.id, idInfo: this.idinfo}).then((response) => {
                if (response.body.estado == 'ok') {
                    this.bovinos = response.body.data;
                    this.manejoAnimales = response.body.manejo;
                    this.ordenios = response.body.ordenio;
                    this.banderaB = response.body.banderaB;
                    this.banderaM = response.body.banderaM;
                    this.banderaO = response.body.banderaO;
                    this.infoProductivo = response.body.infoProductivo;
                }

            }, (error) => {
               // notificarFail('', 'Error al obtener los bovinos ' + error.status + ' ' + error.statusText);
            });

        },



        });

        Vue.component('especies', {
            template: '#especies',
            props: ['idinfo', 'id', 'nombre', 'documento'],
            data: function () {
                return {

                    TipoProducciones : [],
                    tipoProduccionCerdo: [],
                    TipoCorrales : [],
                    EstadoCorrales : [],
                    TipoAves : [],
                    TipoPeces : [],
                    TiposReproduccion : [],
                    loading: false,
                    aves : [],
                    cerdos : [],
                    peces: [],
                    otras : [],

                    nuevaAve : {
                        id_info_productivo : this.idinfo
                    },
                    nuevoCerdo : {
                        id_info_productivo : this.idinfo
                    },
                    nuevoPeces : {
                        id_info_productivo : this.idinfo
                    },
                    nuevaOtras:{
                        id_info_productivo : this.idinfo
                    },
                    images:[],
                    aveToDelete : '',
                    cerdoToDelete : '',
                    pecesToDelete : '',
                    otraToDelete : '',
                    banderaA: '',
                    banderaC: '',
                    banderaP: '',
                    banderaO: '',
                    infoProductivo: ''


                }
            },

            methods: {

                formReset: function () {
                    this.nuevaAve = {
                        id_info_productivo : this.idinfo
                    };
                    this.nuevoCerdo = {
                        id_info_productivo : this.idinfo
                    };
                    this.nuevoPeces = {
                        id_info_productivo : this.idinfo
                    };
                    this.nuevaOtras= {
                        id_info_productivo : this.idinfo
                    };
                },
                //Aves
                prepareToDeleteAve : function (ave) {
                    this.aveToDelete = ave
                },
                guardarAveEspecies: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/especies/guardaraveespecies', this.nuevaAve).then((response) => {
                        this.loading = false;
                        if (response.body.estado === 'ok') {

                            this.aves.push(response.body.ave);
                            $("#modal-agregar-ave-especies").modal('hide');
                            this.formReset();


                            notificarOk('', 'Registro de aves creado correctamente');
                        } else {
                            //notificarFail('', 'Error:  ' + response.body.error);
                            notificarFail('', 'Por favor diligencie todos los campos.');
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar el registro de aves');
                    });
                },
                eliminarAveEspecies: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/especies/eliminaraveespecies', {id: this.aveToDelete.id}).then((response) => {
                        if (response.body.estado === 'ok') {
                            this.aves.splice(this.aves.indexOf(this.aveToDelete), 1);
                            notificarOk('', 'Registro de aves eliminado correctamente');
                            $("#modal-confirm-delete-ave-especies").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el registro de aves');
                    });
                },

                //Cerdos
                guardarCerdoEspecies: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/especies/guardarcerdoespecies', this.nuevoCerdo).then((response) => {
                        this.loading = false;
                        if (response.body.estado === 'ok') {

                            this.cerdos.push(response.body.cerdo);
                            $("#modal-agregar-cerdo-especies").modal('hide');
                            this.formReset();


                            notificarOk('', 'Registro de cerdos creado correctamente');
                        } else {
                            //notificarFail('', 'Error:  ' + response.body.error);
                            notificarFail('', 'Por favor diligencie todos los campos.');
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar el registro de cerdos');
                    });
                },
                eliminarCerdoEspecies: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/especies/eliminarcerdoespecies', {id: this.cerdoToDelete.id}).then((response) => {
                        if (response.body.estado === 'ok') {
                            this.cerdos.splice(this.cerdos.indexOf(this.cerdoToDelete), 1);
                            notificarOk('', 'Registro de cerdos eliminado correctamente');
                            $("#modal-confirm-delete-cerdo-especies").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el registro de cerdos');
                    });
                },
                prepareToDeleteCerdo : function (cerdo) {
                    this.cerdoToDelete = cerdo
                },

                //Peces
                guardarPecesEspecies: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/especies/guardarpecesespecies', this.nuevoPeces).then((response) => {
                        this.loading = false;
                        if (response.body.estado === 'ok') {

                            this.peces.push(response.body.peces);
                            $("#modal-agregar-peces-especies").modal('hide');
                            this.formReset();


                            notificarOk('', 'Registro de peces creado correctamente');
                        } else {
                            //notificarFail('', 'Error:  ' + response.body.error);
                            notificarFail('', 'Por favor diligencie todos los campos');
                        }
                    }, (error) => {
                        this.loading = false;
                        notificarFail('', 'Error al guardar el registro de cerdos');
                    });
                },
                eliminarPecesEspecies: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/especies/eliminarpecesespecies', {id: this.pecesToDelete.id}).then((response) => {
                        if (response.body.estado === 'ok') {
                            this.peces.splice(this.peces.indexOf(this.pecesToDelete), 1);
                            notificarOk('', 'Registro de peces eliminado correctamente');
                            $("#modal-confirm-delete-peces-especies").modal('hide');
                        }
                    }, (error) => {
                        notificarFail('', 'Error al eliminar el registro de peces');
                    });
                },
                prepareToDeletePeces : function (peces) {
                    this.pecesToDelete = peces
                },

                //Otras
                guardarOtrasEspecies: function () {
                    this.loading = true;
                    this.$http.post('/subsidios/productivos/diagnostico/especies/guardarotrasespecies', this.nuevaOtras).then((response) => {
                        this.loading = false;
                        if (response.body.estado === 'ok') {

                            this.otras.push(response.body.otras);
                            $("#modal-agregar-otras-especies").modal('hide');
                            this.formReset();


                            notificarOk('', 'Registro de otras especies creado correctamente');
                        } else {
                            //notificarFail('', 'Error:  ' + response.body.error);
                            notificarFail('', 'Por favor diligencie todos los campos.');
                        }
                    }, (error) => {
                        this.loading = false;
                        //notificarFail('', 'Error al guardar el registro de otras especies' + error.status + ' ' + error.statusText);
                        notificarFail('', 'Error al guardar el registro de otras especies');
                    });
                },
                eliminarOtrasEspecies: function () {
                    this.$http.post('/subsidios/productivos/diagnostico/especies/eliminarotrasespecies', {id: this.otrasToDelete.id}).then((response) => {
                        if (response.body.estado === 'ok') {
                            this.otras.splice(this.otras.indexOf(this.otrasToDelete), 1);
                            notificarOk('', 'Registro de otras especies eliminado correctamente');
                            $("#modal-confirm-delete-otras-especies").modal('hide');
                        }
                    }, (error) => {
                       // notificarFail('', 'Error al eliminar el registro de otras especies' + error.status + ' ' + error.statusText);
                    });
                },
                prepareToDeleteOtras : function (otras) {
                    this.otrasToDelete = otras
                },

                guardarAvesAnterior: function (ave) {
                    this.borrarTemporalAves(ave);
                    this.$http.post('/guardar/aveAnterior', { ave: ave, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Ave agregada correctamente');
                            //$("#btnOrdenio").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar las aves ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporalAves: function (ave) {
                    this.aves.splice(this.aves.indexOf(ave),1);
                },

                guardarCerdoAnterior: function (cerdo) {
                    this.borrarTemporalCerdo(cerdo);
                    this.$http.post('/guardar/cerdoAnterior', { cerdo: cerdo, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Cerdo agregado correctamente');
                            //$("#btnOrdenio").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los cerdos ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporalCerdo: function (cerdo) {
                    this.cerdos.splice(this.cerdos.indexOf(cerdo),1);
                },

                guardarPezAnterior: function (pez) {
                    this.borrarTemporalPez(pez);
                    this.$http.post('/guardar/pezAnterior', { pez: pez, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Pez agregado correctamente');
                            //$("#btnOrdenio").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar los peces ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporalPez: function (pez) {
                    this.peces.splice(this.peces.indexOf(pez),1);
                },

                guardarOtraAnterior: function (otra) {
                    this.borrarTemporalOtra(otra);
                    this.$http.post('/guardar/otraAnterior', { otra: otra, idInfo: this.idinfo}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            notificarOk('', 'Otra especie agregada correctamente');
                            //$("#btnOrdenio").attr('disabled','disabled');
                            //this.bandera = response.body.bandera;
                        }
                    }, (error)=>{
                       // notificarFail('', 'Error al cargar las otras especies ' + error.status+' '+ error.statusText);
                    });
                },
                borrarTemporalOtra: function (otra) {
                    this.otras.splice(this.otras.indexOf(otra),1);
                }




            },



            mounted(){

                this.$http.post('/getselectsespecies').then((response)=>{
                    this.tipoProduccionCerdo = response.body.tipo_produccion_cerdo;
                    this.TipoProducciones = response.body.tipo_produccion_ave;
                    this.TipoCorrales = response.body.tipo_corral;
                    this.EstadoCorrales = response.body.estado_corral;
                    this.TipoAves = response.body.tipo_aves;
                    this.TipoPeces = response.body.tipo_peces;
                    this.TiposReproduccion = response.body.tipos_reproduccion;



                },(error)=>{
                   // notificarFail('', 'Error al obtener las opciones del formulario ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/subsidios/productivos/diagnostico/especies/todaslasespecies', {id: this.id, idInfo: this.idinfo}).then((response) => {
                    if (response.body.estado === 'ok') {
                        this.aves = response.body.aves;
                        this.cerdos = response.body.cerdos;
                        this.peces = response.body.peces;
                        this.otras = response.body.otras;
                        this.infoProductivo = response.body.infoProductivo;
                        this.banderaA = response.body.banderaA;
                        this.banderaC = response.body.banderaC;
                        this.banderaP = response.body.banderaP;
                        this.banderaO = response.body.banderaO;

                    }

                }, (error) => {
                    //notificarFail('', 'Error al obtener los datos de las especies ' + error.status + ' ' + error.statusText);
                });

            },



        });

        Vue.component('cierre', {
            template : '#form-cierre',
            props : ['idinfo', 'id', 'idpredio'],
            data : function () {
                return {
                    image: [],
                    loading :false,
                    images :[],
                    subirMas : false,
                    obs : '',
                    subirMasArchivos: false,
                    archivo: null,
                    idPredio: this.idpredio

                }
            },
            methods: {
                procesarFiles (e){
                    this.archivo = e.target.files
                    //alert('procesado')
                    //console.log(this.nuevoPlan.archivo)       
                 },
                subirArchivos(){
                    if(this.subirMasArchivos == true && this.archivo.length > 0){
                        this.loading = true;
                        var archivos = new FormData()
                            for(var i = 0 ;i<this.archivo.length; i++){
                                let file = this.archivo[i] 
                                archivos.append('files['+i+']',file)
                            }
                            archivos.append('id_beneficiario', this.id)
                            archivos.append('idPredio', this.idPredio)
                            archivos.append('tipo_subsidio', 2)
                        this.$http.post('/guardarArchivos', archivos).then((response)=>{
                            notificarOk("Archivos guradados exitosamente");
                            this.loading = false;
                            this.cierre.archivo = null;
                            //this.pagination = response.body.pagination;

                        }, (error)=>{
                            notificarFail('', 'Error:  ' + response.body.error);
                        });

                    }
                },

                guardarObs () {
                    this.$http.post('/subsidios/productivos/diagnostico/cierre/save-cierre',{obs: this.obs, id: this.idinfo }).then((response)=>{
                        if(response.body.estado ==='ok'){

                            notificarOk("", "Observaciones guardadas");
                        }else{
                           // notificarFail("",""+response.body.error)
                        }

                    },(error)=>{
                       // notificarFail("",""+error)
                    })

                },
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
                        this.$http.post('/subsidios/productivos/diagnostico/cierre/agregarimagenes',{images: this.image, id : this.idinfo, tipo : 2 }).then(response => {
                            this.loading = false;
                        for(index in response.body.fotos){
                            this.images.push(response.body.fotos[index]);
                            console.log(index)
                        }
                        this.image = []
                        notificarOk('', 'Imagen(es) Subidas')
                        this.subirMas = false;
                    });
                    }else{
                        notificarFail("", "Ningun Archivo Seleccionado")
                    }

                },
                deleteImage(img){
                    this.image.splice(this.image.indexOf(img),1);
                },
                deleteImages(img){
                    this.$http.post('/subsidios/productivos/diagnostico/cierre/borrarimagen',{id : img.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                        this.images.splice(this.images.indexOf(img),1);

                        notificarOk("", "Imagen borrada del Servidor");
                    }

                },(error)=>{

                    })
                }
            },
            mounted(){
                this.$http.post('/subsidios/productivos/diagnostico/cierre/info-cierre', {id :this.idinfo, tipo : 2 }).then((response)=>{
                    this.images = response.body.data;
                    this.obs = response.body.obs;
            }, (error)=>{

                });

            }
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
                    beneficiario : {
                        id: {{$info->Subsidio->Beneficiario->id}},
                        nombre : "{{ $info->Subsidio->Beneficiario->nombres .' '.$info->Subsidio->Beneficiario->apellidos}}",
                        documento : "{{ $info->Subsidio->Beneficiario->no_cedula }}"
                    },
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
                    observaciones_proyecto : '',
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
                tipoProyectos : '',
                infoProductivoAnterior: '',
                bandera: ''

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
                          //  notificarFail('', 'Error al guardar ' + response.body.error);
                        }

                    }, (error)=>{
                        //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
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
                resetGeneral: function () {
                    this.generalidades = {
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
                        observaciones_proyecto : ''
                    }
                }

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
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getgeneros').then((response)=>{
                    this.generos = response.body.data;
                }, (error)=>{
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });

                this.$http.post('/getselectstipoproyectos').then((response)=>{
                    this.tipoProyectos = response.body.data;
                }, (error)=>{
                    //notificarFail('', 'Error en el servidor ' + error.status+' '+ error.statusText);
                });



            },
            mounted(){//ok revision
                this.$http.post('/subsidios/productivos/diagnostico/getgeneralidades', {_token: this.token, idInfo : this.idInfoProductivo, id: this.infoProductivo.beneficiario.id}).then((response)=>{
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
                        this.bandera = response.body.bandera;
                        this.infoProductivoAnterior = response.body.infoProductivo;
                        if (response.body.bandera == 1) {
                            this.generalidades.id = '';
                            this.generalidades.idProductivo = this.idInfoProductivo;
                        }
                    }

                },(response)=>{
                   // notificarFail('', 'Tenemos problemas al cargar la informacion general ' + + response.status+' '+ response.statusText);
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
@include('subsidios_productivos.diagnostico.parts.table_potreros')
@include('subsidios_productivos.diagnostico.cultivos.table_cultivos')
@include('subsidios_productivos.diagnostico.cultivos.detalle.form_detalle')
@include('subsidios_productivos.diagnostico.bovinos.table_bovinos')
@include('subsidios_productivos.diagnostico.especies_menores.table_especies_menores')
@include('subsidios_productivos.diagnostico.parts.form_cierre')
@include('subsidios_productivos.diagnostico.fortalecimiento_estructura.table_fortalecimiento')