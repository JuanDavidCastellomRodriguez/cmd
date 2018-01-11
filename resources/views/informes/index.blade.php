@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="../css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="{{asset('/amcharts/plugins/export/export.css')}}">

@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 10px;">

            <h3>Subsidios</h3>

            <form class="form" v-on:submit.prevent="consultarDatos()" style="margin-bottom: 20px">

                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Orden de Servicio</label>
                    <select class="form-control" v-model="nuevaConsulta.ordenServicio" v-on:change="changeOrden($event.target.value)"  required>
                        <option value=""  >Seleccione...</option>
                        <option v-for="orden in ordenes" :value="orden.id">@{{ orden.consecutivo + orden.objeto  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Fase</label>
                    <select class="form-control" v-model="nuevaConsulta.fase"  id="fase" required>
                        <option value="9999"  >Todos</option>
                        <option v-for="fase in fases" :value="fase.id">@{{ fase.nombre_fase  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>

                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Tipo Subsidio</label>
                    <select class="form-control" v-model="nuevaConsulta.tipo"   required>
                        <option value="9999"  >Todos</option>
                        <option v-for="tipo in tiposSubsidio" :value="tipo.id">@{{ tipo.tipo_subsidio  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Campos</label>
                    <select class="form-control" v-model="nuevaConsulta.campo" id="campo"  required>
                        <option value="9999"  >Todos</option>
                        <option v-for="campo in campos" :value="campo.id">@{{ campo.nombre_campo  }}</option>
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

                <div class="col-lg-2 col-sm-12 form-group form-inline" style="margin-top: 25px">
                    <a class="btn btn-default" href="mapa/">Ver mapa
                        <label v-show="loading" >
                            <i class="fa fa-spinner fa-spin"></i>
                        </label>
                    </a>
                </div>

            </form>

            <div class="col-lg-12" style="margin-top: 10px">

                <div class="form-group">
                    <label for="exampleInputName2">Ver grafico por:</label>
                    <select class="form-control" v-model="vistas" required>
                        <option value="1">Inversion Total</option>
                        <option value="2">Subsidio Asignados</option>
                        <option value="3">Subsidio Asignados</option>
                        <option value="4">Subsidio Concertados</option>
                        <option value="5">Subsidio Entregados</option>
                        <option value="6">Presupuesto Asignado</option>
                        <option value="8">Presupuesto Ejecutado</option>
                        <option value="7">Asignado Vs Ejecutado</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>

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
                    <th>Subsidios</th>
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
                subsidiosBloqueOVereda: ''




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
                        default : '0'
                            break;
                    }
                },

            },
            methods:{


                subsidiosByValor : function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].valor,
                        })
                    }
                    this.dibujarSerial(data, "Grafico Presupuesto Asignado")

                },
                subsidiosByEjecutado : function () {
                    var data = [];
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].ejecutado,
                        })
                    }
                    this.dibujarSerial(data, "Grafico Presupuesto Ejecutado")

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
                    //this.pie = true
                },
                subsidiosByEntregados(){
                    this.hiddenGraphics();
                    var data = [];
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].entregado,
                        })
                    }

                    this.dibujarPie(data, "Grafico Subsidios Entregados")
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
                    console.log(dataBloques);
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
                }

            },

            created(){

                /*this.$http.post('/getcampos').then((response)=>{
                    this.campos = response.body.data
                    //this.predio.idMunicipio = municipio;
                });*/
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