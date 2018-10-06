@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection

@section('content')



    <!--<div class="col-lg-6 pull-right" style="text-align: right">
        <form class="form-inline" style="display: inline-block; padding-top: 20px; ">
            <div class="form-group">
                <input type="text" required class="form-control" placeholder="Buscar">
            </div>
            <button type="submit" class="btn btn-default">Buscar</button>
        </form>
    </div>


    <br><br><br><br>

    <div id="vue-content">



        <google-map :center="{lat:4.488944444, lng:-72.67322222}" :zoom="11" map-type-id="terrain" style="width: 100%; height: 700px">

            <google-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Hola mundo</h4>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <p>Basic card without any heading elements and border.</p>
                                    <img src="/images/avatar.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </google-info-window>

            <google-marker :key="index"
                           v-for="(m,index) in subsidios"
                           :position="{lat: parseFloat(m.informacion_vivienda.predio.latitud),lng:parseFloat(m.informacion_vivienda.predio.longitud)}"
                           :clickable="true"
                           :draggable="false"
                           :title="m.informacion_vivienda.predio.latitud"
                           @click="toggleInfoWindow(m,index,{lat:parseFloat(m.informacion_vivienda.predio.latitud),lng:parseFloat(m.informacion_vivienda.predio.longitud)})"

                           :opacity="0.8"
            >
            </google-marker>



        </google-map>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.8/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.js"></script>
    <script src="http://localhost/cmd/node_modules/vue2-google-maps/dist/vue-google-maps.js"></script>

    <script>
        Vue.use(VueGoogleMaps, {
            load: {
                key: 'AIzaSyCQe1qi2DEKB2dSysyYi-DFRl3dssbogqQ',
                libraries: 'places',
            },
            // Demonstrating how we can customize the name of the components
            installComponents: false,
        });

        document.addEventListener('DOMContentLoaded', function() {
            Vue.component('google-map', VueGoogleMaps.Map);
            Vue.component('google-marker', VueGoogleMaps.Marker);
            Vue.component('google-info-window', VueGoogleMaps.infoWinOpen);

            Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

            var app  = new Vue({
            //new Vue({

                el: '#vue-content',
                data: {

                    subsidios: [],
                    nuevaConsulta : {

                        buscar : {
                        tipoSubsidio : 1,
                        fase: 1,
                        campo : 1,
                        vereda : 725,
                    }

                        //fecha_inicial :moment(((new Date()).getFullYear()+"-01-01 00:00:00")).format("YYYY-MM-DDTHH:mm"),  //(new Date()).getFullYear()+"-01-01 00:00:00",
                        //fecha_final: moment(((new Date()).getFullYear()+"-12-31 23:59:59")).format("YYYY-MM-DDTHH:mm") ,
                    },

                    iconos : [
                    {
                        path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
                        fillColor: '#FF0000',
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0
                    },
                    {
                        path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
                        fillColor: '#FF8000',
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0
                    },
                    {
                        path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
                        fillColor: '#FFFF00',
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0
                    },

                    {
                        path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
                        fillColor: '#04B486',
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0
                    },

                ],

                colors: ['#FF0000','#FF8000','#FFFF00','#04B486'],


                    infoWinOpen: false,
                    currentMidx: null,
                    infoWindowPos : {
                        lat: 0.0,
                        lng:0.0,
                    },
                    //optional: offset infowindow so it visually sits nicely on top of our marker
                    infoOptions: {
                        pixelOffset: {
                            width: 0,
                            height: -35
                        }
                    },
                    puntoSeleccionado : {
                        subsidios: {}
                    },

                    //buscar: '',

                    //vereda : 725,

                    buscar : {
                        tipoSubsidio : 1,
                        fase: 1,
                        campo : 1,
                        vereda : 725,
                    }
                    

                },

                mounted(){
                    this.obtenerDatosMapa();

                },


                methods:{
                    obtenerDatosMapa:function () {

                        

                        //this.$http.post('/subsidios/getinfo',{tipoSubsidio: 1, buscar : this.buscar}).then((response)=>{
                        //this.$http.post('/subsidios/getinfomapa',{tipoSubsidio: 1, buscar : this.buscar}).then((response)=>{
                        //this.$http.post('/subsidios/getinfomapa',{tipoSubsidio: 1, fase: 1, campo: 1, vereda: 726}).then((response)=>{

                        this.$http.post('/subsidios/getinfomapa',{tipoSubsidio: 1, fase: 1, campo: 1, vereda: 725}).then((response)=>{
                        //this.$http.post('/subsidios/getinfomapa',{params:this.buscar}).then((response)=>{
                        
                        //this.$http.post('/subsidios/getinfomapa', this.vereda).then(response=>{
                        //this.$http.post('/subsidios/getinfomapa').then(response=>{
                        //this.$http.post('/subsidios/getinfomapa', this.buscar).then(response=>{

                        //this.$http.post('/subsidios/getinfomapa',{buscar : this.buscar}).then((response)=>{
                            this.subsidios = response.body.data;
                        }).catch(error=>{
                            console.log(error);
                        });

                    },

                    consultarDatos:function () {
                        //alert('ok');
                        this.obtenerDatosMapa();
                    },
                    toggleInfoWindow: function(m, idx, posicion) {

                        
                        //console.log(posicion);
                        this.infoWindowPos = posicion;
                        this.infoContent = '';

                        //check if its the same marker that was selected if yes toggle
                        if (this.currentMidx == idx) {
                            this.infoWinOpen = !this.infoWinOpen;
                        }
                        //if different marker set infowindow to open and reset current marker index
                        else {
                            this.puntoSeleccionado= m;
                            this.infoWinOpen = true;
                            this.currentMidx = idx;
                        }
                    }

                }

            });
        });

    </script>



    </div>



    </div>




@endsection
@section('scripts')
    <script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("js/bootstrap-datepicker.es.min.js")}}"></script>

    <script>


/*

        Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
        var app = new Vue({
            el : '#app',
            data : {

                subsidios : '',

            },

            methods:{


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



            },

            mounted(){



                this.buscarData();


            },


        });

*/

    </script>-->
@endsection