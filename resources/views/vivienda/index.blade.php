@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">
            <div>
                <h3>Beneficios de Vivienda</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>

            </div>
            <table class="table" style="margin-top: 10px;">
                <tr>
                    <th>Consecutivo</th>
                    <th>Fecha Encuesta</th>
                    <th>Predio</th>
                    <th>Beneficiario</th>
                    <th>Opciones</th>
                </tr>
                <tr v-for="info in infoVivienda">
                    <td>@{{ info.consecutivo }}</td>
                    <td>@{{ info.fechaEncuesta }}</td>
                    <td>@{{ info.predio + ' ('+ info.vereda + ' ' + info.municipio + ')' }}</td>
                    <td>@{{ 'CC '+info.documento + ' '+ info.nombres + ' ' + info.apellidos  }}</td>
                    <td><a :href="'/vivienda/'+info.idInfo" class="btn btn-sm btn-default" >Editar</a></td>
                </tr>

            </table>
        </div>

        @include('vivienda.modals.form_create')


    </div>



@endsection
@section('scripts')
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-datepicker.es.min.js"></script>
    <script>


        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
        var app = new Vue({
            el : '#app',
            data : {
                vivienda : {
                    fechaEncuesta: '',
                    respondePropietario: '',
                    programaSocial:'',
                    numeroFamiliasVivienda: '',
                    _token :"<?php echo csrf_token();?>",
                },
                infoVivienda : ''

            },
            methods:{
                guardarInfoVivienda : function () {
                    $("#btn-guardar").button('loading');

                    this.$http.post('/vivienda', this.vivienda).then((response)=>{
                        console.log(response);
                        $("#btn-guardar").button('reset');

                        if(response.body.estado == 'ok'){
                            //Materialize.toast(response.body.mensaje, 4000)
                            window.location.href = '/vivienda/'+response.body.id
                        }else{
                            $.notify({
                                element: '#modal-agregar',
                                //icon: 'glyphicon glyphicon-warning-sign',
                                title: 'Leventamiento Informacion',
                                message: 'Error al guardar ',
                                z_index: 1052,
                            })

                            Materialize.toast(response.body.mensaje, 4000)

                        }

                    },(response)=>{
                        $("#btn-guardar").button('reset');
                        $.notify({
                            element: '#modal-agregar',
                            //icon: 'glyphicon glyphicon-warning-sign',
                            title: 'Leventamiento Informacion',
                            //message: 'Error en el servidor ' + response.status+' '+ response.statusText,
                            message: 'Error en el servidor ',
                            z_index: 1052,
                        })

                    });







                },
                resetForm: function () {
                    this.vivienda.fechaEncuesta = '';
                    this. vivienda.respondePropietario =  '';
                    this.vivienda.programaSocial ='';
                    this.vivienda.numeroFamiliasVivienda = '';
                    $("#btn-guardar").button('reset');
            },


            },
            mounted(){
                this.$http.post('/vivienda/general/getinfo').then((response)=>{
                    this.infoVivienda = response.body.data;
                }, (error)=>{

                });
            }
        });



    $(document).ready(function () {

        $('#fecha_encuesta').datepicker({
            orientation: 'auto top',
            language : 'es',
            todayBtn : true,
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(e) {
            app.vivienda.fechaEncuesta = $(this).val();
        });



    })
    </script>
@endsection