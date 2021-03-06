@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="../css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="{{asset('/amcharts/plugins/export/export.css')}}">

@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 60px;">

            <h3>Informes de Beneficios</h3>

            <form class="form" v-on:submit.prevent="consultarDatos()" style="margin-bottom: 20px">

                <div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Orden de Servicio</label>
                    <select class="form-control" v-model="nuevaConsulta.ordenServicio" v-on:change="changeOrden($event.target.value)"  required>
                        <option value=""  >Seleccione...</option>
                        <option v-for="orden in ordenes" :value="orden.id">@{{ orden.consecutivo + orden.objeto  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <!--<div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Fase</label>
                    <select class="form-control" v-model="nuevaConsulta.fase"  id="fase" required>
                        <option value="9999"  >Todos</option>
                        <option v-for="fase in fases" :value="fase.id">@{{ fase.nombre_fase  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>-->

                <div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Tipo de Beneficio</label>
                    <select class="form-control" v-model="nuevaConsulta.tipo"   required>
                        <option value="9999"  >Todos</option>
                        <option v-for="tipo in tiposSubsidio" :value="tipo.id">@{{ tipo.tipo_subsidio  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Campos</label>
                    <select class="form-control" v-model="nuevaConsulta.campo" id="campo"  required @change="getMunicipioByCampo($event.target.value)">
                        <option value="9999"  >Todos</option>
                        <option v-for="campo in campos" :value="campo.id">@{{ campo.nombre_campo  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Municipio</label>
                    <select class="form-control" v-model="nuevaConsulta.municipio" id="municipio"  required @change="getVeredaByMunicipio($event.target.value)">
                        <option value="9999"  >Todos</option>
                        <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-3 col-md-2">
                    <label for="exampleInputName2">Vereda</label>
                    <select class="form-control" v-model="nuevaConsulta.vereda" id="vereda"  required>
                        <option value="9999"  >Todos</option>
                        <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="col-lg-2 col-sm-12 form-group form-inline" style="margin-top: 25px">
                    <button class="btn btn-default " type="submit" >Consultar
                        <label v-show="loading" >
                            <i class="fa fa-spinner fa-spin"></i>
                        </label>
                    </button>
                </div>



            </form>
            <!--<div class="col-lg-2 col-sm-12 form-group form-inline" style="margin-top: 25px">
                    <button class="btn btn-default " type="submit" @click="pruebaExcel">Exportar excel
                        
                    </button>
                </div>-->

            <div class="col-lg-10" style="margin-top: 10px">

                <div class="form-group">
                    <label for="exampleInputName2">Ver grafico por:</label>
                    <select class="form-control" v-model="vistas" required>
                        <option value="1">Inversion Total</option>
                        <option value="2">Beneficios Asignados</option>
                        <!--<option value="3">Subsidio Asignados</option>-->
                        <!--<option value="4">Beneficios Concertados</option>-->
                        <option value="5">Beneficios Entregados</option>
                        <option value="6">Presupuesto Asignado</option>
                        <option value="8">Presupuesto Ejecutado</option>
                        <option value="7">Asignado Vs Ejecutado</option>
                        <option value="9">Tipo de mejoramiento de vivienda</option>
                        <option value="10">Estado de la vivienda</option>
                        <!--<option value="11">Tipo de proyecto productivo</option>-->
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12" style="margin-top: 35px;" v-show="nuevaConsulta.ordenServicio != ''">
                <button class="btn btn-default " type="submit" >Generar Excel</button>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div  id="chartdiv"   style=" height: 500px;"></div>

            </div>
            <table class="table table-responsive" v-show="subsidios != '' " style="margin-top: 20px">
                <tr>
                    <th>Bloque</th>
                    <th>Fase</th>
                    <th>Vereda</th>
                    <th>Beneficio</th>
                    <th>Concertados</th>
                    <th>Entregados</th>
                    <th>Obra en construccion</th>
                    <th>P Asignado</th>
                    <th>P Ejecutado</th>
                    <th>V Diagnostico</th>
                    <th>V Seguimiento</th>
                    <th>V Entrega</th>
                </tr>
                <tr v-for="subsidio in subsidiosTabulados">
                    <td>@{{ subsidio.bloque }}</td>
                    <td>@{{ subsidio.item }}</td>
                    <td>@{{ subsidio.vereda }}</td>
                    <td>@{{ subsidio.numeroSubsidio }}</td>
                    <td>@{{ subsidio.concertados }}</td>
                    <td>@{{ subsidio.entregado }}</td>
                    <td>@{{ subsidio.obras_en_construccion }}</td>
                    <td style="text-align: right" >@{{ '$'+subsidio.valor.toFixed(2)  }}</td>
                    <td style="text-align: right">@{{ '$'+subsidio.ejecutado.toFixed(2)}}</td>
                    <td>@{{ subsidio.visitas_diagnostico }}</td>
                    <td>@{{ subsidio.visitas_seguimiento }}</td>
                    <td>@{{ subsidio.visitas_entrega }}</td>
                </tr>
            </table>

        </div>




    </div>



@endsection
@section('scripts')
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/bootstrap-datepicker.es.min.js"></script>
    <script src="{{asset('/amcharts/amcharts.js')}}"></script>
    <script src="{{asset('/amcharts/pie.js')}}"></script>
    <script src="{{asset('/amcharts/serial.js')}}"></script>
    <script src="{{asset('/amcharts/plugins/export/export.js')}}"></script>
    <script src="{{asset('/amcharts/lang/es.js')}}"></script>
    <script src="{{asset('/amcharts/themes/light.js')}}"></script>
    <script>


        Vue.http.interceptors.push((request, next)  => {
            //request.headers['Authorization'] = auth.getAuthHeader()
            //app.loading = true;
            next((response) => {
                //app.loading = false;
                if(response.status == 401 ) {
                    window.location.reload();
                }
            });
        });
        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
        var app = new Vue({
            
            el : '#app',
            data : {
                subsidios : '',
                subsidiosTabulados : '',
                nuevaConsulta : {
                    ordenServicio : '',
                    campo : '9999',
                    tipo : '9999',
                    fase : '9999',
                    municipio: '9999',
                    vereda: '9999',
                    municipio: '9999',
                    vereda: '9999'
                },
                ordenes : '',
                fases : '',
                campos : '',
                vistas : 1,
                tiposSubsidio : '',
                serial : false,
                pie : false,
                serialTwoRows : false,
                loading : false,
                pieChart : null,
                serialchart : null,
                chartSerialTwoRows : null,
                subsidiosBloqueFase : '',
                subsidiosBloqueFaseVereda: '',
                datosGrafico : '',
                camposGrafico : [],
                subsidiosBloqueOVereda: '',
                municipios: '',
                veredas: '',
                generateExcel: 0




            },
            watch: {
                vistas: function (val) {
                    switch (val) {
                        case '1' :
                            //app.subsidiosByDiagnostico();
                            if(this.nuevaConsulta.campo == '9999'){
                                app.subsidiosByBloqueFaseWithValor();
                            }else{
                                app.subsidiosByVeredaFaseWithValor();
                            }

                            break;
                        case '2' :
                            //app.subsidiosBySeguimiento();
                            if(app.nuevaConsulta.campo == '9999'){
                                app.subsidiosByBloqueFaseWithSubsidios();
                            }else{
                                app.subsidiosByVeredaFaseWithSubsidios();
                            }

                            break;
                        case '3' :
                            app.subsidiosByAsignados();

                            break;
                        case '4' :
                            app.subsidiosByConcertados();
                            break;
                        case '5' :
                            app.subsidiosByEntregados()
                            break;
                        case '6' :
                            app.subsidiosByValor()
                            break;
                        case '7' :
                            app.subsidiosAsignadoEjecutado()
                            break;
                        case '8' :
                            app.subsidiosByEjecutado()
                            break;
                        case '9' :
                            app.subsidiosByTipomejoramiento()
                            break;
                        case '10' :
                            app.subsidiosByEstadovivienda()
                            break;
                        default : '0'
                            break;
                    }
                },

            },
            methods:{
                pruebaExcel: function () {
                    this.$http.post('/exportExcel').then((response)=>{
                        notificarOk("Excel generado...")
                    }, (error)=>{
                       notificarFail("Error"+ error) 
                    });
                },

                subsidiosByValor : function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].vereda,
                            'visits' : this.subsidiosTabulados[item].valor,
                        })
                    }
                    this.dibujarSerial(data, "Grafico Presupuesto Asignado")

                    if (this.generateExcel) {
                        this.$http.post('/exportExcel', {data: data, op: 2}).then((response)=>{
                            notificarOk("Excel generado...")
                        },(error)=>{
                            notificarFail("Error"+ error) 
                        });
                        
                    }
                    this.$http.post('/exportExcel', {data: data, op: 2, title: "Grafico Presupuesto Asignado"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });

                },
                subsidiosByEjecutado : function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].vereda,
                            'visits' : this.subsidiosTabulados[item].ejecutado,
                        })
                    }
                    this.dibujarSerial(data, "Grafico Presupuesto Ejecutado")

                    this.$http.post('/exportExcel', {data: data, op: 2, title: "Grafico Presupuesto Ejecutado"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });
                },

                subsidiosByAsignados(){
                    this.hiddenGraphics();
                    var data = [];

                    var asignadoVivienda = 0;
                    var asignadoProductivos = 0;

                    $.each(this.subsidiosBloqueOVereda, function (bloque,subs) {

                        asignadoVivienda += subs.subsidiosVivienda;
                        asignadoProductivos += subs.subsidiosProyectos;
                    });
                    data.push({
                        'country': 'Subsidios Vivienda',
                        'visits' : asignadoVivienda

                    });
                    data.push({
                        'country': 'Subsidios Productivos',
                        'visits' : asignadoProductivos

                    });




                    this.dibujarPie(data, "Grafico Subsidios Asignados")

                    this.$http.post('/exportExcel', {data: data, op: 1, title: "Grafico Beneficios Asignados"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });
                    //this.pie = true
                },
                subsidiosByEntregados(){
                    //console.log(this.subsidiosTabulados);
                    this.hiddenGraphics();
                    var data = [];
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].vereda,
                            'visits' : this.subsidiosTabulados[item].entregado,
                        })
                    }

                    this.dibujarPie(data, "Grafico Subsidios Entregados")

                    this.$http.post('/exportExcel', {data: data, op: 2, title: "Grafico Beneficios Entregados"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });
                    //this.pie = true
                },
                subsidiosByConcertados(){
                    this.hiddenGraphics();
                    var data = [];
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].concertados,
                        })
                    }

                    this.dibujarPie(data, "Grafico Subsidios Concertados")
                    //this.pie = true
                },

                subsidiosByDiagnostico(){
                    this.hiddenGraphics();
                    var data = [];
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].visitas_diagnostico,
                        })
                    }

                    this.dibujarPie(data, "Grafico Visitas de Diagnostico")
                    //this.pie = true
                },
                subsidiosBySeguimiento(){
                    this.hiddenGraphics();
                    var data = [];
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].visitas_seguimiento,
                        })
                    }

                    this.dibujarPie(data, "Grafico Visitas de Seguimiento")
                    //this.pie = true
                },

                subsidiosAsignadoEjecutado :function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'asignado' : this.subsidiosTabulados[item].valor,
                            'ejecutado' : this.subsidiosTabulados[item].ejecutado,
                        })
                    }
                    var dataBloques = [];
                    var bloques = [];
                    $.each(this.subsidiosBloqueOVereda, function (bloque,subs) {

                                    var tempo = {};
                                    bloques.push(bloque);
                                    tempo['country'] = bloque
                                    tempo['asignado'] =subs.valor;
                                    tempo['ejecutado'] =subs.ejecutado;

                                    //console.log(tempo)
                                    dataBloques.push(tempo)



                    });
                    jQuery.unique(bloques);
                    //console.log(dataBloques);
                    this.dibujarSerialTwoRows(dataBloques, bloques, "Grafico Presupuesto Asignado Vs Ejecutado", 'Asignado','asignado','Ejecutado',"ejecutado")

                    



                },

                subsidiosByVisitaDiagnostico : function () {

                    this.pie = false
                    this.serial = false

                },

                subsidiosByBloqueFaseWithValor: function () {

                    var bloques = [];
                    var dataBloques = [];
                    $.each(this.subsidios, function (x,value) {
                        $.each(value,function (fase, v) {
                            var tempo = {'category': fase};
                            $.each (v,function (key,d) {
                                $.each(d,function (bloque, subs) {
                                    bloques.push(bloque);
                                    tempo[bloque] =subs.valor;
                                })
                            })
                            dataBloques.push(tempo)
                            //console.log(tempo)

                        })
                    });
                    jQuery.unique(bloques);

                    this.dibujarSerialBloqueFase("Inversion Total Por Bloque",dataBloques,bloques, "Pesos Colombianos")
                },

                subsidiosByVeredaFaseWithValor: function () {

                    var veredas = [];
                    var dataBloques = [];
                    var bloqueActual = '' ;
                    $.each(this.subsidios, function (bloque,subFase) {
                        bloqueActual = bloque;
                        $.each(subFase,function (fase, subVereda) {
                            var tempo = {'category': fase};
                            $.each(subVereda,function (vereda, subItem) {
                                veredas.push(vereda);
                                tempo[vereda] = subItem.valor
                            })
                            dataBloques.push(tempo)
                        })
                    });
                    console.log(dataBloques)
                    jQuery.unique(veredas);

                    this.dibujarSerialBloqueFase("Inversion Total Por Bloque",dataBloques,veredas, "Pesos Colombianos")

                    this.$http.post('/exportExcel', {data: dataBloques, vereda: veredas, op: 1, title: "Inversion Total"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });
                },


                subsidiosByBloqueFaseWithSubsidios: function () {

                    var bloques = [];
                    var dataBloques = [];
                    $.each(this.subsidios, function (x,value) {
                        $.each(value,function (fase, v) {
                            var tempo = {'category': fase};
                            $.each (v,function (key,d) {
                                $.each(d,function (bloque, subs) {
                                    bloques.push(bloque);
                                    tempo[bloque] =subs.entregado;
                                })
                            })
                            dataBloques.push(tempo)
                            //console.log(tempo)

                        })
                    });
                    jQuery.unique(bloques);

                    this.dibujarSerialBloqueFase("Subsidios Total Por Bloque",dataBloques,bloques,"Cantidad de Subsidios")
                },

                subsidiosByEstadovivienda:function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'estado_bueno1' : this.subsidiosTabulados[item].estado_bueno1,
                            'estado_bueno2' : this.subsidiosTabulados[item].estado_bueno2,
                            'estado_malo' : this.subsidiosTabulados[item].estado_malo,
                            'estado_regular' : this.subsidiosTabulados[item].estado_regular,
                        })
                    }
                    var dataBloques = [];
                    var bloques = [];
                    $.each(this.subsidiosBloqueOVereda, function (bloque,subs) {

                                    var tempo = {};
                                    bloques.push(bloque);
                                    tempo['country'] = bloque
                                    tempo['estado_malo'] =subs.estado_malo;
                                    tempo['estado_regular'] =subs.estado_regular;
                                    tempo['estado_bueno1'] =subs.estado_bueno1;
                                    tempo['estado_bueno2'] =subs.estado_bueno2;

                                    //console.log(tempo)
                                    dataBloques.push(tempo)



                    });
                    jQuery.unique(bloques);
                    console.log(dataBloques);
                    this.dibujarSerialFourRows(dataBloques, bloques, "Grafico Estado General de la vivienda", 'Mala','estado_malo', 'Regular','estado_regular','Buena sin acabados','estado_bueno1','Buena con acabados',"estado_bueno2")

                },

                subsidiosByTipomejoramiento:function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'hacinamiento' : this.subsidiosTabulados[item].hacinamiento,
                            'saneamiento' : this.subsidiosTabulados[item].saneamiento,
                            'seguridad' : this.subsidiosTabulados[item].seguridad,
                            
                        })
                    }
                    var dataBloques = [];
                    var bloques = [];
                    $.each(this.subsidiosBloqueOVereda, function (bloque,subs) {

                                    var tempo = {};
                                    bloques.push(bloque);
                                    tempo['country'] = bloque
                                    tempo['hacinamiento'] =subs.hacinamiento;
                                    tempo['saneamiento'] =subs.saneamiento;
                                    tempo['seguridad'] =subs.seguridad;

                                    //console.log(tempo)
                                    dataBloques.push(tempo)



                    });
                    jQuery.unique(bloques);
                    console.log(dataBloques);
                    this.dibujarSerialThreeRows(dataBloques, bloques, "Grafico Tipo de mejoramiento", 'Hacinamiento','hacinamiento', 'Saneamiento Básico','saneamiento','Seguridad, Estructura y estética','seguridad')

                },


                subsidiosByVeredaFaseWithSubsidios: function () {

                    var veredas = [];
                    var dataBloques = [];
                    var bloqueActual = '' ;
                    $.each(this.subsidios, function (bloque,subFase) {
                        bloqueActual = bloque;
                        $.each(subFase,function (fase, subVereda) {
                            var tempo = {'category': fase};
                            $.each(subVereda,function (vereda, subItem) {
                                veredas.push(vereda);
                                tempo[vereda] = subItem.entregado
                            })
                            dataBloques.push(tempo)
                        })
                    });
                    console.log(dataBloques)
                    jQuery.unique(veredas);

                    this.dibujarSerialBloqueFase("Subsidios Total "+bloqueActual,dataBloques,veredas,"Cantidad de Subsidios")
                    this.$http.post('/exportExcel', {data: dataBloques, vereda: veredas, op: 1, title: "Beneficios Asignados"}).then((response)=>{
                        notificarOk("Excel generado...")
                    },(error)=>{
                        notificarFail("Error"+ error) 
                    });
                },




                consultarDatos : function () {
                    this.loading = true;
                    this.hiddenGraphics();
                    this.subsidios = '';
                    this.vistas = 1
                    this.$http.post('/informes/getdatareport', this.nuevaConsulta).then((response)=>{
                        if(response.body.data != ""){
                            this.subsidios = response.body.data;
                            this.subsidiosBloqueOVereda = response.body.dataBloque;
                            this.loading = false;
                            var data = [];
                            var bloques = [];
                            var dataBloques = [];
                            if(this.nuevaConsulta.campo == '9999'){
                                $.each(response.body.data, function (x,value) {
                                    //console.log('-->'+value);
                                    $.each(value,function (fase, v) {
                                        var tempo = {'category': fase};
                                        $.each (v,function (key,d) {

                                            $.each(d,function (bloque, subs) {
                                                bloques.push(bloque);
                                                tempo[bloque] =subs.valor;
                                                data.push({
                                                    bloque : bloque,
                                                    item :fase,
                                                    numeroSubsidio : subs.numeroSubsidio,
                                                    concertados : subs.concertados,
                                                    entregado: subs.entregado,
                                                    obras_en_construccion : subs.obras_en_construccion,
                                                    valor : subs.valor,
                                                    ejecutado:  subs.ejecutado,
                                                    visitas_seguimiento :subs.visitas_seguimiento,
                                                    visitas_entrega : subs.visitas_entrega,
                                                    visitas_diagnostico : subs.visitas_diagnostico,
                                                })
                                            })


                                        })
                                        dataBloques.push(tempo)
                                        //console.log(tempo)

                                    })
                                });
                                this.subsidiosBloqueFase = data;
                                //this.datosGrafico = response.body.grafico;
                                this.datosGrafico = dataBloques;
                                jQuery.unique(bloques);
                                this.camposGrafico = bloques;
                                //console.log(bloques)
                                this.subsidiosByBloqueFaseWithValor()


                            }else{

                                $.each(response.body.data, function (bloque,itemfases) {
                                    $.each(itemfases,function (fase, itemveredas) {
                                        $.each (itemveredas,function (vereda,item) {
                                            data.push({
                                                item : fase,
                                                bloque :bloque,
                                                vereda: vereda,
                                                numeroSubsidio : item.numeroSubsidio,
                                                concertados : item.concertados,
                                                entregado: item.entregado,
                                                obras_en_construccion : item.obras_en_construccion,
                                                valor : item.valor,
                                                ejecutado:  item.ejecutado,
                                                visitas_seguimiento :item.visitas_seguimiento,
                                                visitas_entrega : item.visitas_entrega,
                                                visitas_diagnostico : item.visitas_diagnostico,
                                            });



                                        })

                                    })
                                });
                                this.subsidiosBloqueFaseVereda = data
                                this.subsidiosByVeredaFaseWithValor()

                            }


                            this.subsidiosTabulados = data;
                            this.vistas = 1;




                        }else{
                            notificarFail('', 'No hay Datos para Mostrar!')
                        }

                    },(error)=>{
                        notificarFail('','ERROR: ')
                        this.loading = false;
                    });


                },

                dibujarPie : function (data , titulo) {

                    var charPieConfig =  {
                        "type": "pie",
                        "theme": "light",
                        "dataProvider": data,
                        "valueField": "visits",
                        "titleField": "country",
                        "outlineAlpha": 0.4,
                        "depth3D": 15,
                        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                        "angle": 30,
                        "export": {
                            "enabled": true
                        },
                        'titles' :  [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo,
                            }]
                    };
                    this.pieChart = AmCharts.makeChart('chartdiv',charPieConfig)

                },
                dibujarSerial : function (data , titulo) {

                    var charSerialConfig =  {
                        "type": "serial",
                        "theme": "light",
                        "language": "es",
                        "marginRight": 70,
                        "dataProvider": data,
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": "<b>[[category]]: [[value]]</b>",
                            //"fillColorsField": "color",
                            "autoColor": true,
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "type": "column",
                            "valueField": "visits"
                        }],
                        "chartCursor": {
                            "categoryBalloonEnabled": false,
                            "cursorAlpha": 0,
                            "zoomable": false
                        },
                        "categoryField": "country",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "labelRotation": 45
                        },
                        "export": {
                            "enabled": true,
                        },
                        'titles' : [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo,
                            }],
                        "valueAxes": [ {
                            "title": "Pesos Colombianos",
                            "minimum": 0
                        } ],

                    };

                    this.charSerial = AmCharts.makeChart('chartdiv',charSerialConfig);
                },
                dibujarSerialTwoRows : function (data, bloques, titulo, cat1, label1, cat2, label2) {

                    var chartSerialTwoRowsConfig =  {
                        "theme": "light",
                        "type": "serial",
                        "dataProvider": data,
                        "valueAxes": [{
                            "stackType": "3d",
                            "unit": "",
                            "position": "left",
                            "title": "Valor en Pesos Colombianos",
                            "minimum" : 0
                        }],
                        "legend": {
                            "enabled": true,
                            "useGraphSettings": true,
                        },
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": " [[category]] ("+cat1+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat1,
                            "type": "column",
                            "valueField": label1,
                            "labelText": "[[value]]",
                            "labelPosition": "center"
                        }, {
                            "balloonText": "[[category]] ("+cat2+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat2,
                            "type": "column",
                            "valueField": label2,
                            "labelText": "[[value]]",

                        }],
                        "plotAreaFillAlphas": 0.1,
                        "depth3D": 60,
                        "angle": 30,
                        "categoryField": "country",
                        "categoryAxis": {
                            "gridPosition": "start"
                        },
                        "export": {
                            "enabled": true
                        },
                        'titles' : [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo,
                            }],

                    };
                    this.chartSerialTwoRows  = AmCharts.makeChart('chartdiv', chartSerialTwoRowsConfig);
                },


                dibujarSerialFourRows : function (data, bloques, titulo, cat1, label1, cat2, label2, cat3, label3, cat4, label4) {

                    var chartSerialFourRowsConfig =  {
                        "theme": "light",
                        "type": "serial",
                        "dataProvider": data,
                        "valueAxes": [{
                            "stackType": "3d",
                            "unit": "",
                            "position": "left",
                            "title": "Cantidad",
                            "minimum" : 0
                        }],
                        "legend": {
                            "enabled": true,
                            "useGraphSettings": true,
                        },
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": " [[category]] ("+cat1+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat1,
                            "type": "column",
                            "valueField": label1,
                            "labelText": "[[value]]",
                            "labelPosition": "center"
                        }, {
                            "balloonText": "[[category]] ("+cat2+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat2,
                            "type": "column",
                            "valueField": label2,
                            "labelText": "[[value]]",

                        }, {
                            "balloonText": "[[category]] ("+cat3+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat3,
                            "type": "column",
                            "valueField": label3,
                            "labelText": "[[value]]",

                        }, {
                            "balloonText": "[[category]] ("+cat4+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat4,
                            "type": "column",
                            "valueField": label4,
                            "labelText": "[[value]]",

                        }],
                        "plotAreaFillAlphas": 0.1,
                        "depth3D": 60,
                        "angle": 30,
                        "categoryField": "country",
                        "categoryAxis": {
                            "gridPosition": "start"
                        },
                        "export": {
                            "enabled": true
                        },
                        'titles' : [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo,
                            }],

                    };
                    this.chartSerialFourRows  = AmCharts.makeChart('chartdiv', chartSerialFourRowsConfig);
                },


                dibujarSerialThreeRows : function (data, bloques, titulo, cat1, label1, cat2, label2, cat3, label3) {

                    var chartSerialThreeRowsConfig =  {
                        "theme": "light",
                        "type": "serial",
                        "dataProvider": data,
                        "valueAxes": [{
                            "stackType": "3d",
                            "unit": "",
                            "position": "left",
                            "title": "Cantidad",
                            "minimum" : 0
                        }],
                        "legend": {
                            "enabled": true,
                            "useGraphSettings": true,
                        },
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": " [[category]] ("+cat1+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat1,
                            "type": "column",
                            "valueField": label1,
                            "labelText": "[[value]]",
                            "labelPosition": "center"
                        }, {
                            "balloonText": "[[category]] ("+cat2+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat2,
                            "type": "column",
                            "valueField": label2,
                            "labelText": "[[value]]",

                        }, {
                            "balloonText": "[[category]] ("+cat3+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat3,
                            "type": "column",
                            "valueField": label3,
                            "labelText": "[[value]]",

                        }],
                        "plotAreaFillAlphas": 0.1,
                        "depth3D": 60,
                        "angle": 30,
                        "categoryField": "country",
                        "categoryAxis": {
                            "gridPosition": "start"
                        },
                        "export": {
                            "enabled": true
                        },
                        'titles' : [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo,
                            }],

                    };
                    this.chartSerialThreeRows  = AmCharts.makeChart('chartdiv', chartSerialThreeRowsConfig);
                },

                dibujarSerialBloqueFase :function (titulo,data, bloques,medida) {
                    var graphs = []
                    var i = 1;
                    $.each(bloques,function (key , value) {
                        graphs.push({
                            "balloonText": "[[title]] EN LA  [[category]]:[[value]]",
                            "fillAlphas": 1,
                            "id": "AmGraph-"+i,
                            "title": value,
                            "type": "column",
                            "valueField": value,
                            "showAllValueLabels": true,
                            "visibleInLegend" :true,
                            "labelText": "[[value]]",
                            "labelPosition": "center"
                        })
                        i++;
                    });



                    var serialBloqueFase = {
                        "type": "serial",
                        "categoryField": "category",
                        "startDuration": 1,
                        "theme": "default",
                        "angle": 30,
                        "depth3D": 30,
                        "categoryAxis": {
                            "gridPosition": "start"
                        },
                        "trendLines": [],
                        "graphs": graphs,
                        "guides": [],
                        "valueAxes": [
                            {
                                "id": "ValueAxis-1",
                                "title": medida
                            },

                        ],

                        "balloon": {
                                "fixedPosition": false,
                                "showBullet": true
                            },
                        "legend": {
                            "enabled": true,
                            "useGraphSettings": true
                        },
                        "titles": [
                            {
                                "id": "Title-1",
                                "size": 15,
                                "text": titulo
                            }
                        ],
                        "dataProvider": data,
                        "export": {
                            "enabled": true
                        },
                    }
                    this.chartSerialTwoRows  = AmCharts.makeChart('chartdiv', serialBloqueFase);

                },

                changeOrden :function (id) {
                    this.$http.post('/fases/listabyorden',{id : id}).then((response)=>{
                        this.fases = response.body.data;
                    },(error)=>{

                    });
                },


                hiddenGraphics : function () {
                    this.pieChart = null;
                    this.serialchart = null;
                    this.chartSerialTwoRows = null
                },

                getVeredaByMunicipio: function (id_municipio) {
                    this.$http.post('/getveredas', {id: id_municipio}).then((response)=>{
                        this.veredas = response.body.data;
                        //this.predio.idMunicipio = municipio;
                    }, (error)=>{

                    });
                },
                getMunicipioByCampo: function (id_campo) {
                    this.$http.post('/getmunicipiosbycampo', {id: id_campo}).then((response)=>{
                        this.municipios = response.body.data;
                        //this.predio.idMunicipio = municipio;
                    }, (error)=>{

                    });
                }

            },

            created(){

                this.$http.post('/getmunicipios', {id: 85}).then((response)=>{
                    this.municipios = response.body.data
                    //this.predio.idMunicipio = municipio;
                });
                this.$http.post('/gettipossubsidios').then((response)=>{
                    this.tiposSubsidio = response.body.data
                    //this.predio.idMunicipio = municipio;
                });
                this.$http.post('/ordenes/lista').then((response)=>{
                    this.ordenes = response.body.data;
                },(error)=>{

                });

                this.$http.post('/campos/listabyfase').then((response)=>{
                    this.campos = response.body.data;
                },(error)=>{

                });



            },
            mounted(){
                $('#fecha_inicial').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaConsulta.fechaInicial = $(this).val();
                });

                $('#fecha_final').datepicker({
                    orientation: 'auto top',
                    language : 'es',
                    todayBtn : true,
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function(e) {
                    app.nuevaConsulta.fechaFinal = $(this).val();
                });


            },


        });















    </script>
    <style>
        #chart-serial-two-row > div > div > a{
            z-index: -99999;
            font-size: 0px;
            width: 0;
            height: 0;
            overflow: hidden;
        }

        #chartdivs > div > div > a{
            z-index: -99999;
            font-size: 0px;
            width: 0;
            height: 0;
            overflow: hidden;
        }

        #chartdiv > div > div > a{
            z-index: -99999;
            font-size: 0px;
            width: 0;
            height: 0;
            overflow: hidden;
        }
    </style>
@endsection