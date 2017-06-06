@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Ordenes de Servicio</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-orden" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <div class="col-lg-6 pull-right" style="text-align: right">
                <form class="form-inline" style="display: inline-block; padding-top: 20px; padding-bottom: 10px; ">
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

            <table v-show="ordenes.length > 0" class="table" style="margin-top: 10px;">
                <tr>
                    <th>Numero</th>
                    <th>Fecha Inicio</th>
                    <th>Presupuesto</th>
                    <th>objeto</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                <tr v-for="info in ordenes">

                    <td>@{{ info.consecutivo }}</td>
                    <td>@{{ info.fecha_inicio }}</td>
                    <td>@{{ info.presupuesto }}</td>
                    <td>@{{ info.objeto }}</td>
                    <td>@{{ info.estado == 1 ? "Activa":"Inactiva" }}</td>
                    <td>
                        <a  class="btn btn-sm btn-default" title="Ver" v-on:click="editOrden(info)" >Editar</a>
                    </td>

                </tr>


            </table>
            <h4 v-if="ordenes.length == 0">No hay datos para mostrar</h4>



        </div>

        @include('ordenes.form_create')



    </div>



@endsection
@section('scripts')
    <script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("js/bootstrap-datepicker.es.min.js")}}"></script>
    <script src="{{asset("js/jquery.priceformat.min.js")}}"></script>

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

                nuevaOrden : {
                    id:'',
                    consecutivo : '',
                    fecha_inicio : '',
                    fecha_final : '',
                    presupuesto : '',
                    objeto : '',
                    observaciones : '',
                    estado : ''
                },
                editarOrden : false,
                itemEditando : '',
                ordenes: '',
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
                getOrdenes: function(page){
                    this.ordenes = '';

                this.$http.post('/ordenes/getpaginateordenes?page='+page,{ buscar : this.buscar}).then((response) => {
                    this.ordenes = response.body.data;
                    this.pagination = response.body.pagination;
                });

                },

                changePage: function (page) {
                    this.pagination.current_page = page;
                    this.getVueItems(page);
                },
                guardarOrden : function () {

                    this.$http.post('/ordenes/guardarorden', this.nuevaOrden).then((response)=>{

                        if(response.body.estado == 'ok'){
                            if(response.body.editado){
                                notificarOk('', "Orden Actualizada correctamente");
                                var index = this.ordenes.indexOf(this.itemEditando);
                                this.ordenes[index] = this.nuevaOrden;
                                $("#modal-agregar-orden").modal('hide');
                                this.formReset();

                            }else{
                                this.nuevaOrden.id = response.body.id;
                                this.ordenes.push(this.nuevaOrden);
                                $("#modal-agregar-orden").modal('hide');
                                this.formReset();
                                notificarOk('', "Orden creada correctamente");
                            }


                        }else{
                            notificarFail('', 'Error:  ' + response.body.mensaje);


                        }

                    },(error)=>{
                        notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                    });

                },
                editOrden : function (item) {
                    this.itemEditando = item
                    this.nuevaOrden = JSON.parse(JSON.stringify(item))

                    $("#modal-agregar-orden").modal('show');
                    this.editarOrden = true
                },


                formReset: function () {
                    this.nuevaOrden = {
                        id:'',
                        consecutivo : '',
                        fecha_inicio : '',
                        fecha_final : '',
                        presupuesto : '',
                        objeto : '',
                        observaciones : '',
                        estado : ''
                    };



                },

                buscarData : function () {
                    if(this.buscar != ''){
                        this.filtrado = true;
                        this.filtroActual = this.buscar
                    }
                    this.$http.post('/ordenes/getpaginateordenes',{ buscar : this.buscar}).then((response)=>{
                        this.ordenes = response.body.data;
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
                $('#fecha_inicio').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaOrden.fecha_inicio = $(this).val();
                });$('#fecha_fin').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaOrden.fecha_final = $(this).val();
                });

                $('.presupuesto').priceFormat({
                    prefix: 'COP$ ',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });







            },


        });



    $(document).ready(function () {



    })
    </script>
@endsection