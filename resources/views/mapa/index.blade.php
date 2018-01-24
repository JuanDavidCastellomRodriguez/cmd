@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')



    <div id="root">
        <google-map :center="{lat:4.488944444, lng:-72.67322222}" :zoom="7" style="width: 100%; height: 500px">


            <google-marker v-for="m in subsidios" :position="{lat: parseFloat(m.informacion_vivienda.predio.latitud),lng:parseFloat(m.informacion_vivienda.predio.longitud)}" :clickable="true" :draggable="false" @click="center=m.position"></google-marker>



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

            Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

            var app  = new Vue({
            //new Vue({
                el: '#root',
                data: {

                    subsidios: [],
                    nuevaConsulta : {
                        //fecha_inicial :moment(((new Date()).getFullYear()+"-01-01 00:00:00")).format("YYYY-MM-DDTHH:mm"),  //(new Date()).getFullYear()+"-01-01 00:00:00",
                        //fecha_final: moment(((new Date()).getFullYear()+"-12-31 23:59:59")).format("YYYY-MM-DDTHH:mm") ,
                    },

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
                        lugar: {}
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
                        //this.$http.post('/subsidios/getinfomapa', this.vereda).then(response=>{
                        //this.$http.post('/subsidios/getinfomapa').then(response=>{
                        //this.$http.post('/subsidios/getinfomapa', this.buscar).then(response=>{

                        this.$http.post('/subsidios/getinfomapa',{buscar : this.buscar}).then((response)=>{
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

    </script>
@endsection