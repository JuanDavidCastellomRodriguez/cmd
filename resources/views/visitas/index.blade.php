@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h2 v-if="subsidio.tipo_subsidio == 1">Subsidio de Vivienda No @{{ (("000000" + subsidio.consecutivo).slice(-6)) }}</h2>
                <h2 v-if="subsidio.tipo_subsidio == 2">Subsidio Proyecto Productivo No @{{ (("000000" + subsidio.consecutivo).slice(-6)) }}</h2>
                <section class="row">
                    <article class="col-lg-6 col-sm-12">
                        <h4>Beneficiario: @{{ subsidio.beneficiario }}</h4>
                    </article>
                    <article class="col-lg-6 col-sm-12">
                        <h4>Vereda: @{{ subsidio.vereda }}</h4>
                    </article>
                    <article class="col-lg-6 col-sm-12">
                        <h4>Observaciones: @{{subsidio.observaciones}}</h4>
                    </article>
                </section>


                <h3>Visitas Realizadas</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-visita" >
                    Nueva Visita
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
                <tr v-for="visita in visitas">
                    <td>@{{ (("000000" + visita.consecutivo).slice(-6)) }}</td>
                    <td>@{{ visita.fecha_inicio }}</td>
                    <td>@{{ visita.vereda }}</td>
                    <td>@{{ visita.beneficiario }}</td>
                    <td>@{{ visita.valor }}</td>
                    <td>@{{ visita.porcentaje_ejecucion+' %' }}</td>
                    <td>
                        <a :href="'/vivienda/'+info.id_info_productivo" v-if="info.id_info_productivo != null" class="btn btn-sm btn-default" >Ver</a>
                        <a  v-if="info.id_info_productivo == null" v-on:click="nuevoDiagnostico.subsidio = info.id" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-agregar-diagnostico" >Ver</a>
                    </td>
                    <td>
                        <a :href="'/subsidio/visitas/'+info.id" class="btn btn-sm btn-default" title="Ver Visitas Realizadas" >Ver</a>

                    </td>

                </tr>

            </table>
        </div>

        @{{ $data }}
@include('visitas.form_create_visita')
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
                subsidio :{
                    id :'{{ $subsidio->id }}',
                    consecutivo :'{{ $subsidio->consecutivo }}',
                    beneficiario : '{{ $subsidio->Beneficiario->nombres.' '.$subsidio->Beneficiario->apellidos }}',
                    vereda : '{{$subsidio->Vereda->vereda .' ('.$subsidio->Vereda->Municipio->municipio.' - '.$subsidio->Vereda->Municipio->Departamento->departamento.')'}}',
                    valor : parseInt('{{$subsidio->valor}}') ,
                    concertado : ('{{$subsidio->concertado}}' == 1),
                    entregado : ('{{$subsidio->entregado}}' == 1 ),
                    obras_en_construccion : ('{{$subsidio->obras_en_construccion}}' == 1 ),
                    porcentaje_ejecucion : parseInt('{{$subsidio->porcentaje_ejecucion}}'),
                    observaciones : '{{$subsidio->observaciones}}',
                    tipo_subsidio : parseInt('{{$subsidio->id_tipo_subsidio}}')

                },
                nuevaVisita :{
                    id_subsidio : '{{ $subsidio->id }}',
                    fecha : '',
                    observaciones : '',
                    id_tipo_visita : ''
                },
                visitas : ''

            },
            methods:{
                guardarSubsidio : function () {

                    this.$http.post('/subsidios/guardarsubsidio', data).then((response)=>{

                        if(response.body.estado == 'ok'){
                            //

                            this.formReset();
                            notificarOk('', "Subsidio  creado correctamente");

                        }else{
                            notificarFail('', 'Error:  ' + response.body.error);


                        }

                    },(error)=>{
                        notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                    });

                },


                formReset: function () {


                },



            },
            created(){

            },
            mounted(){
                $('#fecha_visita').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaVisita.fecha = $(this).val();
                });




            },


        });



    $(document).ready(function () {



    })
    </script>
@endsection