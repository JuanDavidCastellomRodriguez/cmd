@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="../css/bootstrap-datepicker3.min.css">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Subsidios Proyectos Productivos</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-subsidio" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <table class="table" style="margin-top: 10px;">
                <tr>
                    <th>Consecutivo</th>
                    <th>Fecha</th>
                    <th>Vereda</th>
                    <th>Beneficiario</th>
                    <th>Valor</th>
                    <th>Ejecutado</th>
                    <th>Diagnostico</th>
                    <th>Visitas</th>
                </tr>
                <tr v-for="info in subsidios">
                    <td>@{{ (("000000" + info.consecutivo).slice(-6)) }}</td>
                    <td>@{{ info.fecha_inicio }}</td>
                    <td>@{{ info.vereda }}</td>
                    <td>@{{ info.beneficiario }}</td>
                    <td>@{{ info.valor }}</td>
                    <td>@{{ info.porcentaje_ejecucion+' %' }}</td>
                    <td>
                        <a :href="'/subsidios/productivos/diagnostico/'+info.id_info_productivo" v-if="info.id_info_productivo != null" class="btn btn-sm btn-default" >Ver</a>
                        <a  v-if="info.id_info_productivo == null" v-on:click="nuevoDiagnostico.subsidio = info.id" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-agregar-diagnostico" >Ver</a>
                    </td>
                    <td>
                        <a :href="'/subsidios/productivos/visitas/'+info.id" class="btn btn-sm btn-default" title="Ver Visitas Realizadas" >Ver</a>

                    </td>

                </tr>

            </table>
        </div>

        @include('subsidios_productivos.form_create')
        @include('subsidios_productivos.modals.form_create')

        @{{ $data }}

    </div>



@endsection
@section('scripts')
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/bootstrap-datepicker.es.min.js"></script>
    <script>


        Vue.http.interceptors.push((request, next)  => {
            //request.headers['Authorization'] = auth.getAuthHeader()
            next((response) => {
                if(response.status == 401 ) {
                    window.location.reload();
                }
            });
        });
        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
        var app = new Vue({
            el : '#app',
            data : {

                esNuevoBeneficiario : false,
                nuevoBeneficiario : {
                    no_cedula : '',
                    nombres : '',
                    apellidos : '',
                    no_celular : '',
                    fecha_nacimiento : ''
                },
                beneficiario : '',
                nuevoSubsidio : {
                    id_beneficiario : '',
                    id_tipo_subsidio : 2,
                    id_vereda : '',
                    fecha_inicio : '',
                    valor : 0,
                    id_info_vivienda : null,
                    id_info_productivo : null,
                    porcentaje_ejecucion : 0,
                    entregado : false,
                    obras_en_construccion : false,
                    observaciones : ''


                },
                subsidios : '',
                departamentos : '',
                municipios : '',
                veredas : '',
                loading : false,
                nuevoDiagnostico : {
                    fechaEncuesta: '',
                    respondePropietario: '',
                    programaSocial:'',
                    numeroFamiliasVivienda: '',
                    subsidio : ''

                },



            },
            methods:{
                guardarSubsidio : function () {
                    var data = '';
                    if(this.nuevoSubsidio.id_beneficiario != ''){
                        data = {
                            subsidio :this.nuevoSubsidio
                        }
                    }else{
                        data = {
                            subsidio : this.nuevoSubsidio,
                            beneficiario : this.nuevoBeneficiario
                        }
                    }
                    this.$http.post('/subsidios/guardarsubsidio', data).then((response)=>{

                        if(response.body.estado == 'ok'){
                            this.nuevoSubsidio.id = response.body.id;
                            this.nuevoSubsidio.id_beneficiario = response.body.idBeneficiario;
                            this.nuevoSubsidio.vereda = response.body.vereda;
                            this.nuevoSubsidio.beneficiario = response.body.beneficiario;
                            this.nuevoSubsidio.consecutivo = response.body.consecutivo;
                            this.subsidios.push(this.nuevoSubsidio);
                            $("#modal-agregar-subsidio").modal('hide');
                            this.formReset();
                            notificarOk('', "Subsidio  creado correctamente");

                        }else{
                            notificarFail('', 'Error:  ' + response.body.error);


                        }

                    },(error)=>{
                        notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                    });

                },

                guardarDiagnostico : function () {
                    this.$http.post('/vivienda', this.nuevoDiagnostico).then((response)=>{
                        if(response.body.estado == 'ok'){
                            window.location.href = '/vivienda/'+response.body.id
                        }else{
                            notificarFail('', 'Error:  ' + response.body.error);
                        }
                    },(error)=>{
                        notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                    });

                },

                buscarBeneficiario : function (cedula) {
                    //this.formReset();
                    $("#txt-buscar-beneficiario").attr('disabled','disabled');
                    this.beneficiario = '';
                    this.nuevoBeneficiario.no_cedula = cedula;
                    if(cedula != ''){
                        this.loading = true;
                        this.$http.post('/beneficiarios/buscarbeneficiario',{no_cedula : cedula}).then((response)=>{
                            if(response.body.estado == 'ok'){
                                if(response.body.data != null){
                                    this.nuevoSubsidio.id_beneficiario = response.body.data.id;
                                    this.esNuevoBeneficiario = false
                                    this.beneficiario = response.body.data.nombres + ' '+ response.body.data.apellidos
                                }else{
                                    this.esNuevoBeneficiario = true;
                                    notificarFail('', 'Beneficiario no encontrado, se creará uno nuevo ' );
                                }
                            }else{
                                notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                            }
                            this.loading = false

                        },(error)=>{
                            notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                        })
                    }else{
                        notificarFail('', 'Debe ingresar un valor');
                        this.loading = false
                    }
                },
                formReset: function () {
                    this.nuevoSubsidio = {
                        id_beneficiario : '',
                        id_tipo_subsidio : 2,
                        id_vereda : '',
                        fecha_inicio : '',
                        valor : 0,
                        id_info_vivienda : null,
                        id_info_productivo : null,
                        porcentaje_ejecucion : null,
                        entregado : false,
                        obras_en_construccion : false,
                    };

                    this.nuevoBeneficiario = {
                        no_cedula : '',
                            nombres : '',
                            apellidos : '',
                            no_celular : '',
                            fecha_nacimiento : ''
                    }

                },

                getDepartamentos : function () {
                    this.$http.post('/getdepartamentos',{_token: this.token}).then((response)=>{
                        this.departamentos = response.body.data
                    })
                },
                changeDepartamento : function (value, municipio) {
                    this.$http.post('/getmunicipios',{_token: this.token, id: value}).then((response)=>{
                        this.municipios = response.body.data
                        //this.predio.idMunicipio = municipio;
                    })
                },
                changeMunicipio : function (value, vereda) {
                    this.$http.post('/getveredas',{_token: this.token, id: value}).then((response)=>{
                        this.veredas = response.body.data
                        //this.predio.idVereda = vereda;

                    })
                },

                abrirDiagnostico : function (id) {
                    this.$http.post('/subsidios/vivienda/existediagnostico',id).then((response)=>{
                       if(response.body.estado == 'ok' ){

                           if(response.body.existe){
                               window.open()
                           }
                       }else{

                       }

                    }, (error)=>{


                    });
                }

            },
            created(){
                this.getDepartamentos()
            },
            mounted(){
                $('#fecha_subsidio').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevoSubsidio.fecha_inicio = $(this).val();
                });

                $('#fecha_nacimiento-beneficiario').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevoBeneficiario.fecha_nacimiento = $(this).val();
                });

                $('#fecha_encuesta').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevoDiagnostico.fechaEncuesta = $(this).val();
                });



                this.$http.post('/subsidios/getinfo',{tipoSubsidio: 2}).then((response)=>{
                    this.subsidios = response.body.data;
                }, (error)=>{

                });




            },


        });



    $(document).ready(function () {



    })
    </script>
@endsection