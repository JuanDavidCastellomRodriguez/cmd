@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Subsidios de Vivienda</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-subsidio" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <div class="col-lg-6 pull-right" style="text-align: right">
                <form class="form-inline" style="display: inline-block; padding-top: 20px; ">
                    <div class="form-group">
                        <label v-show="filtrado" data-toggle="tooltip" data-placement="top" title="Limpiar Filtro" >Filtro:  @{{ $data.filtroActual }}    <span class="glyphicon glyphicon-remove red-text "  v-on:click="limpiarFiltro()"  aria-hidden="true"></span> </label>
                        <input type="text" required class="form-control" v-model="buscar" placeholder="Buscar">
                    </div>
                    <button type="submit" class="btn btn-default" v-on:click.prevent="buscarData()">Buscar</button>
                </form>
            </div>
            <div class="col-lg-6" style="padding-left: 0">

                <nav>
                    <ul class="pagination" >
                        <li v-if="pagination.current_page > 1">
                            <a href="#" aria-label="Previous"
                               @click.prevent="changePage(pagination.current_page - 1)">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber"
                            v-bind:class="[ page == isActived ? 'active' : '']">
                            <a href="#"
                               @click.prevent="changePage(page)">@{{ page }}</a>
                        </li>
                        <li v-if="pagination.current_page < pagination.last_page">
                            <a href="#" aria-label="Next"
                               @click.prevent="changePage(pagination.current_page + 1)">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <table v-show="subsidios.length > 0" class="table" style="margin-top: 10px;">
                <tr>
                    <th>Consecutivo</th>
                    <th>Fecha</th>
                    <th>Vereda</th>
                    <th>Fase</th>
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
                    <td>@{{ info.fase }}</td>
                    <td>@{{ info.beneficiario }}</td>
                    <td>@{{ info.valor }}</td>
                    <td>@{{ info.porcentaje_ejecucion+' %' }}</td>
                    <td>

                        <a :href="'/vivienda/'+info.id_info_vivienda" v-if="info.id_info_vivienda != null" class="btn btn-sm btn-default" title="Ver Diagnostico" >Editar</a>
                        <a  v-if="info.id_info_vivienda == null" v-on:click="nuevoDiagnostico.subsidio = info.id" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-agregar-diagnostico" title="Ver Diagnostico" >Crear</a>
                        <a :href="'/informes/getdiagnosticovivienda/'+info.id_info_vivienda" target="_blank" v-if="info.id_info_vivienda != null" class="btn btn-sm btn-default" title="Ver Diagnostico" >
                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                        </a>

                    </td>
                    <td>
                        <a :href="'/subsidios/vivienda/visitas/'+info.id" class="btn btn-sm btn-default" title="Ver Visitas Realizadas" >Ver</a>
                    </td>

                </tr>


            </table>
            <h4 v-if="subsidios.length == 0">No hay datos para mostrar</h4>



        </div>

        @include('subsidios_vivienda.form_create')
        @include('vivienda.modals.form_create')


    </div>



@endsection
@section('scripts')
    <script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("js/bootstrap-datepicker.es.min.js")}}"></script>

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
                    id_tipo_subsidio : 1,
                    id_fase : '',
                    id_vereda : '',
                    fecha_inicio : '',
                    valor : 0,
                    valor_beneficiario : 0,
                    id_info_vivienda : null,
                    id_info_productivo : null,
                    porcentaje_ejecucion : 0,
                    entregado : false,
                    obras_en_construccion : false,
                    observaciones : ''


                },
                subsidios : '',
                veredas : '',
                fases: '',
                loading : false,
                nuevoDiagnostico : {
                    fechaEncuesta: '',
                    respondePropietario: '',
                    programaSocial:'',
                    numeroFamiliasVivienda: '',
                    subsidio : ''

                },
                pagination : {
                    current_page : 1,
                    from : 1,
                    last_page : '',
                    next_page_url : '',
                    per_page : 10,
                    prev_page_url : '',
                    to : '',
                    total : '',

                },
                offset : 4,
                buscar : '',
                filtrado : false,
                filtroActual : ''



            },
            computed: {
                isActived: function () {

                    return this.pagination.current_page;
                },
                pagesNumber: function () {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                    }
                    var pagesArray = [];
                    while (from <= to) {
                        pagesArray.push(from);
                        from++;
                    }
                    return pagesArray;
                }
            },
            methods:{
                getVueItems: function(page){
                    this.subsidios = '';

                this.$http.post('/subsidios/getinfo?page='+page,{tipoSubsidio: 1, buscar : this.buscar}).then((response) => {
                    this.subsidios = response.body.data;
                    this.pagination = response.body.pagination;
                });

                },

                changePage: function (page) {
                    this.pagination.current_page = page;
                    this.getVueItems(page);
                },
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
                            notificarOk('', "Subsidio de vivienda creado correctamente");

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
                        id_tipo_subsidio : 1,
                        id_fase : '',
                        id_vereda:'',
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


                getFases : function () {
                    this.$http.post('/fases/getfases').then((response)=>{
                        this.fases = response.body.data
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
                },
                buscarData : function () {
                    if(this.buscar != ''){
                        this.filtrado = true;
                        this.filtroActual = this.buscar
                    }
                    this.$http.post('/subsidios/getinfo',{tipoSubsidio: 1, buscar : this.buscar}).then((response)=>{
                        this.subsidios = response.body.data;
                        this.pagination = response.body.pagination;

                    }, (error)=>{

                    });
                },
                limpiarFiltro : function () {
                    this.buscar = '';
                    this.filtroActual = '';
                    this.filtrado = false;
                    this.buscarData();
                },
                obtenerVeredas : function (fase) {
                    this.$http.post('/getveredasbyfase',{id: fase}).then((response)=>{
                        this.veredas = response.body.data;
                        //this.pagination = response.body.pagination;

                    }, (error)=>{

                    });

                }

            },
            created(){
                this.getFases()
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
                this.buscarData();

                $('[data-toggle="tooltip"]').tooltip();







            },


        });



    $(document).ready(function () {



    })
    </script>
@endsection