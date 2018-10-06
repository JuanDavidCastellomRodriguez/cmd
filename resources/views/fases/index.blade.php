@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">


@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Fases de los Beneficios</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-fase" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <!--<div class="col-lg-6 pull-right" style="text-align: right">
                <form class="form-inline" style="display: inline-block; padding-top: 20px;  margin-bottom: 10px;">
                    <div class="form-group">
                        <label v-show="filtrado">Filtro:  @{{ $data.filtroActual }}   <span class="glyphicon glyphicon-remove" v-on:click="limpiarFiltro()" aria-hidden="true"></span> </label>
                        <input type="text" required class="form-control" v-model="buscar" placeholder="Buscar">
                    </div>
                    <button type="submit" class="btn btn-default" v-on:click.prevent="buscarData()">Buscar</button>
                </form>
            </div>-->
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
                    <th>Orden de Servicio</th>
                    <th>Opciones</th>
                </tr>
                <tr v-for="info in fases">

                    <td>@{{ info.fecha_fase }}</td>
                    <td>@{{ info.nombre_fase }}</td>
                    <td>@{{ info.orden.consecutivo }}</td>
                    <td>
                        @{{ info.veredas_fase.pivot = '' }}
                        <a  class="btn btn-sm btn-default" title="Ver" v-on:click="editFase(info)" >Ver/Editar</a>
                    </td>

                </tr>


            </table>
            <h4 v-if="fases.length == 0">No hay datos para mostrar</h4>



        </div>

        @include('fases.form_create')



    </div>

    <style>

        .twitter-typeahead{

        }
        .tt-query {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        }
        .tt-hint {
            color: #999999;
        }
        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 422px;
        }
        .tt-suggestion {
            font-size: 16px;  /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }
        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }
        .tt-suggestion p {
            margin: 0;
        }
    </style>

@endsection
@section('scripts')
    <script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("js/bootstrap-datepicker.es.min.js")}}"></script>
    <script src="{{asset("js/typeahead.js")}}"></script>

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
                    id:'',
                    fecha_fase : '',
                    nombre_fase : '',
                    observaciones : '',
                    id_orden_servicio : '',
                    veredas_fase: [],
                    estado : ''
                },

                fases: '',
                municipios:'',
                ordenes:'',
                //veredasFase: [],
                veredas : '',
                veredasComplete : '',
                veredaToAdd : '',
                loading : false,
                //loadingVereda: false,

                editarFase : false,
                itemEditando : '',

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
                filtroActual : '',




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
                guardarFase : function () {

                    this.$http.post('/fases/guardarfase', this.nuevaFase).then((response)=>{

                        if(response.body.estado == 'ok'){
                            if(!response.body.editado){
                                this.nuevaFase.id = response.body.id;
                                this.fases.push(this.nuevaFase);
                                $("#modal-agregar-fase").modal('hide');
                                this.formReset();
                                notificarOk('', "Fase creada correctamente");
                            }else{
                                notificarOk('', "Fase Actualizada correctamente");
                                var index = this.fases.indexOf(this.itemEditando);
                                this.fases[index] = this.nuevaFase;
                                $("#modal-agregar-fase").modal('hide');
                                this.formReset();
                                //this.editarFase = false;

                            }


                        }else{
                            notificarFail('', 'Error:  ' + response.body.mensaje);


                        }

                    },(error)=>{
                        notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                    });

                },
                editFase : function (item) {
                    this.itemEditando = item
                    this.nuevaFase = JSON.parse(JSON.stringify(item))
                    $("#modal-agregar-fase").modal('show');
                    this.editarFase = true
                },



                formReset: function () {
                    this.nuevaFase = {
                        fecha_fase : '',
                        nombre_fase : '',
                        observaciones : '',
                        id_vereda : '',
                        id_orden_servicio : '',
                        veredas_fase : [],
                    };
                    this.editarFase = false;



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
                },
                getVeredas : function (id) {
                    this.loading = true;
                    this.veredas = '';
                    this.$http.post('/getveredas', {id: id}).then((response)=>{
                        this.loading = false;
                        this.veredas = response.body.data;
                        this.veredasComplete = new Bloodhound({
                            local: this.veredas,
                            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('vereda'),
                            queryTokenizer: Bloodhound.tokenizers.whitespace,
                            //identify: function(obj) { return obj.value; },
                        });
                        $('#autocomplete').typeahead('destroy');
                        $('#autocomplete').typeahead({
                                hint: false,
                                highlight: true, /* Enable substring highlighting */
                                minLength: 1, /* Specify minimum characters required for showing result */
                                //display:"label",
                                //limit:10,

                            },
                            {
                                name: 'Veredas',
                                source: this.veredasComplete.ttAdapter(),
                                displayKey: 'vereda',
                            }).on('typeahead:selected', function(event, data){
                                app.veredaToAdd = data;

                            //console.log(data)

                        })
                    },(error)=>{
                        this.loading = false;
                    });
                },
                agregarVereda : function () {
                    if(this.veredaToAdd != ''){
                        this.nuevaFase.veredas_fase.push(this.veredaToAdd)
                        this.veredaToAdd = ''
                        $('#autocomplete').typeahead('val','')
                    }else {
                        notificarFail("", "Selecione una vereda")
                    }

                },
                eliminarVereda : function (vereda) {
                    this.nuevaFase.veredas_fase.splice(this.nuevaFase.veredas_fase.indexOf(vereda),1)

                }

            },
            created(){
                //this.getFases()
                this.buscarData();
                this.$http.post('/ordenes/lista').then((response)=>{
                    this.ordenes = response.body.data;
                },(error)=>{

                });

                this.$http.post('/ordenes/lista').then((response)=>{
                    this.ordenes = response.body.data;
                },(error)=>{

                });

                this.$http.post('/getmunicipios', {id: 85}).then((response)=>{
                    this.municipios = response.body.data;
                },(error)=>{

                });



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