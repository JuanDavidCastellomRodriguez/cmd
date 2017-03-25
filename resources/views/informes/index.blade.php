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

                <div class=" form-group col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Fecha Inicial</label>
                    <input type="text"   id="fecha_inicial" class="form-control datepickers" required v-model="nuevaConsulta.fechaInicial">
                </div>
                <div class=" form-group col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Fecha Final</label>
                    <input type="text"   id="fecha_final" class="form-control datepickers" required v-model="nuevaConsulta.fechaFinal">
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
                    <select class="form-control" v-model="nuevaConsulta.campo" v-on:change="changeCampo($event.target.value, '')"  required>
                        <option value="9999"  >Todos</option>
                        <option v-for="campo in campos" :value="campo.id">@{{ campo.nombre_campo  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Municipio</label>
                    <select class="form-control" v-model="nuevaConsulta.municipio" v-on:change="changeMunicipio($event.target.value, '')" required >
                        <option value="9999"   >Todos</option>
                        <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-2 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Vereda</label>
                    <select class="form-control" v-model="nuevaConsulta.vereda" required>
                        <option value="9999"   >Todas</option>
                        <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="col-lg-12 col-sm-12" style="margin-bottom: 15px">
                    <button class="btn btn-default" type="submit" >Consultar</button>
                    <label v-show="loading" for="">
                        Consultando...
                        <i class="fa fa-spinner fa-spin"></i>
                    </label>


                </div>
            </form>

            <div class="col-lg-4" style="margin-top: 10px">

                <div class="form-group">
                    <label for="exampleInputName2">Ver grafico por:</label>
                    <select class="form-control" v-model="vistas" required>
                        <option value="1">Subsidio por Visitas de Diagnostico</option>
                        <option value="2">Subsidio por Visitas de Seguimiento</option>
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
            <table class="table table-responsive" v-show="subsidios.length > 0" style="margin-top: 20px">
                <tr>
                    <th>Item</th>
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
                    <td>@{{ subsidio.item }}</td>
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
                    fechaInicial : '',
                    fechaFinal : '',
                    campo : '9999',
                    municipio : '9999',
                    vereda : '9999',
                    tipo : '9999',
                },
                departamentos : '',
                municipios : '',
                veredas : '',
                campos : '',
                vistas : 1,
                tiposSubsidio : '',
                serial : false,
                pie : false,
                serialTwoRows : false,
                loading : false,
                pieChart : null,
                serialchart : null,
                chartSerialTwoRows : null


            },
            watch: {
                vistas: function (val) {
                    switch (val) {
                        case '1' :
                            app.subsidiosByDiagnostico();
                            break;
                        case '2' :
                            app.subsidiosBySeguimiento();
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

                changeMunicipio : function (value, vereda) {
                    this.veredas = '';
                    this.nuevaConsulta.vereda = '9999';
                    this.nuevaConsulta.campo = '9999';
                    this.$http.post('/getveredas',{_token: this.token, id: value}).then((response)=>{
                        this.veredas = response.body.data
                        //this.predio.idVereda = vereda;

                    })
                },

                changeCampo : function (value, vereda) {
                    this.veredas = '';
                    this.nuevaConsulta.vereda = '9999';
                    this.nuevaConsulta.municipio = '9999';
                    this.$http.post('/getveredasbycampo',{id: value}).then((response)=>{
                        this.veredas = response.body.data
                        //this.predio.idVereda = vereda;

                    })
                },


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
                    var p = Object.keys(this.subsidios);
                    for(item in this.subsidiosTabulados){
                        data.push({
                            'country' : this.subsidiosTabulados[item].item,
                            'visits' : this.subsidiosTabulados[item].numeroSubsidio,
                        })
                    }

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
                    this.dibujarSerialTwoRows(data, "Grafico Presupuesto Asignado Vs Ejecutado", 'Asignado','asignado','Ejecutado',"ejecutado")

                },

                subsidiosByVisitaDiagnostico : function () {

                    this.pie = false
                    this.serial = false
                },

                consultarDatos : function () {
                    this.loading = true;
                    this.hiddenGraphics();
                    this.subsidios = '';
                    this.vistas = 1
                    this.$http.post('/informes/getdatareport', this.nuevaConsulta).then((response)=>{
                        if(response.body.data.length > 0){
                            this.subsidios = response.body.data;
                            this.loading = false;
                            var data = [];
                            var p = Object.keys(this.subsidios);
                            p.forEach(function (per) {
                                var items = Object.keys(app.subsidios[per]);
                                items.forEach(function (item) {
                                    var value = app.subsidios[per][item];
                                    data.push({
                                        item :item,
                                        numeroSubsidio : value.numeroSubsidio,
                                        concertados : value.concertados,
                                        entregado: value.entregado,
                                        obras_en_construccion : value.obras_en_construccion,
                                        valor : value.valor,
                                        ejecutado:  value.ejecutado,
                                        visitas_seguimiento :value.visitas_seguimiento,
                                        visitas_entrega : value.visitas_entrega,
                                        visitas_diagnostico : value.visitas_diagnostico,

                                    })
                                })
                            });
                            this.subsidiosTabulados = data;
                            this.vistas = 3;
                            this.subsidiosByAsignados()


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
                dibujarSerialTwoRows : function (data, titulo, cat1, label1, cat2, label2) {
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
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": " [[category]] ("+cat1+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat1,
                            "type": "column",
                            "valueField": label1
                        }, {
                            "balloonText": "[[category]] ("+cat2+"): <b>[[value]]</b>",
                            "fillAlphas": 0.9,
                            "lineAlpha": 0.2,
                            "title": cat2,
                            "type": "column",
                            "valueField": label2
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
                            }]
                    };
                    this.chartSerialTwoRows  = AmCharts.makeChart('chartdiv', chartSerialTwoRowsConfig);
                },


                hiddenGraphics : function () {
                    this.pieChart = null;
                    this.serialchart = null;
                    this.chartSerialTwoRows = null
                }

            },

            created(){


                this.$http.post('/getmunicipios',{ id: 85}).then((response)=>{
                    this.municipios = response.body.data
                    //this.predio.idMunicipio = municipio;
                });
                this.$http.post('/getcampos').then((response)=>{
                    this.campos = response.body.data
                    //this.predio.idMunicipio = municipio;
                });
                this.$http.post('/gettipossubsidios').then((response)=>{
                    this.tiposSubsidio = response.body.data
                    //this.predio.idMunicipio = municipio;
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