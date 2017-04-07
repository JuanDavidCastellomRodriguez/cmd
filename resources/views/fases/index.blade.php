@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Fases de los Subsidios</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-subsidio" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <div class="col-lg-6 pull-right" style="text-align: right">
                <form class="form-inline" style="display: inline-block; padding-top: 20px; ">
                    <div class="form-group">
                        <label v-show="filtrado">Filtro:  @{{ $data.filtroActual }}   <span class="glyphicon glyphicon-remove" v-on:click="limpiarFiltro()" aria-hidden="true"></span> </label>
                        <input type="text" required class="form-control" v-model="buscar" placeholder="Buscar">
                    </div>
                    <button type="submit" class="btn btn-default" v-on:click.prevent="buscarData()">Buscar</button>
                </form>
            </div>
            <div class="col-lg-6" style="padding-left: 0">

                <nav v-if="pagination.last_page > 1">
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

            <table v-show="fases.length > 0" class="table" style="margin-top: 10px;">
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Vereda</th>
                    <th>Orden de Servicio</th>
                    <th>Opciones</th>
                </tr>
                <tr v-for="info in fases">

                    <td>@{{ info.fecha_fase }}</td>
                    <td>@{{ info.nombre_fase }}</td>
                    <td>@{{ info.vereda }}</td>
                    <td>@{{ info.orden }}</td>
                    <td>
                        <a  class="btn btn-sm btn-default" title="Ver" >Ver</a>
                    </td>

                </tr>


            </table>
            <h4 v-if="fases.length == 0">No hay datos para mostrar</h4>



        </div>

        @include('fases.form_create')



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
                nuevaFase : {
                    fecha_fase : '',
                    nombre_fase : '',
                    observaciones : '',
                    id_vereda : '',
                    id_orden_servicio : ''
                },

                fases: '',
                loading : false,
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
                getFases: function(page){
                    this.fases = '';

                this.$http.post('/fases?page='+page,{ buscar : this.buscar}).then((response) => {
                    this.fases = response.body.data;
                    this.pagination = response.body.pagination;
                });

                },

                changePage: function (page) {
                    this.pagination.current_page = page;
                    this.getVueItems(page);
                },
                guardarSubsidio : function () {

                    this.$http.post('/subsidios/guardarsubsidio', this.nuevaFase).then((response)=>{

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



                formReset: function () {
                    this.nuevaFase = {
                        fecha_fase : '',
                        nombre_fase : '',
                        observaciones : '',
                        id_vereda : '',
                        id_orden_servicio : ''
                    };



                },

                buscarData : function () {
                    if(this.buscar != ''){
                        this.filtrado = true;
                        this.filtroActual = this.buscar
                    }
                    this.$http.post('/fases/getpaginatefases',{ buscar : this.buscar}).then((response)=>{
                        this.fases = response.body.data;
                        this.pagination = {
                            current_page : response.body.current_page,
                            from : 1,
                            last_page : response.body.last_page,
                            next_page_url : response.body.next_page_url,
                            per_page : response.body.per_page,
                            prev_page_url : response.body.prev_page_url,
                            to : response.body.to,
                            total : response.body.total,
                        }

                    }, (error)=>{

                    });
                },
                limpiarFiltro : function () {
                    this.buscar = '';
                    this.filtroActual = '';
                    this.filtrado = false;
                    this.buscarData();
                }

            },
            created(){
                //this.getFases()
                this.buscarData();
            },
            mounted(){
                $('#fecha_fase').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaFase.fecha_fase = $(this).val();
                });








            },


        });



    $(document).ready(function () {



    })
    </script>
@endsection