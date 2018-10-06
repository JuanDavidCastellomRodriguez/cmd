@extends('layouts.app')
@section('title', 'Mapa')
@section('content')
    <div id="vue-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mapa de Accidentes</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus icon-minus4 icon-plus4"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <form  class="form " v-on:submit.prevent="consultarDatos">
                                <div class="form-body">
                                    <fieldset class="form-group form-group-xs col-sm-6">
                                        <label for="fecha_ini" class="col-md-4 ">Fecha Inicial</label>
                                        <div class="col-md-8">
                                            <input type="datetime-local" v-model="nuevaConsulta.fecha_inicial" required  class="form-control" id="fecha_ini" placeholder="Fecha Inicial">
                                        </div>

                                    </fieldset>
                                    <fieldset class="form-group form-group-xs col-sm-6">
                                        <label for="fecha_fin" class="col-md-4">Fecha Final</label>
                                        <div class="col-md-8">
                                            <input type="datetime-local" v-model="nuevaConsulta.fecha_final" required class="form-control " id="fecha_fin" placeholder="Email Address">
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="form-actions right">
                                    <button class="btn btn-success">Buscar</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <gmap-map
                                    :center="{lat:5.331684, lng:-72.392546}"
                                    :zoom="14"
                                    map-type-id="terrain"
                                    class="col-sm-12 height-500">

                                <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">@{{ puntoSeleccionado.lugar.direccion }}</h4>
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
                                </gmap-info-window>

                                <gmap-marker
                                        :key="index"
                                        v-for="(m, index) in accidentes"
                                        :position="{lat:parseFloat(m.lugar.latitud),lng:parseFloat(m.lugar.longitud)}"
                                        :clickable="true"
                                        :draggable="false"
                                        :title="m.direccion"
                                        @click="toggleInfoWindow(m,index,{lat:parseFloat(m.lugar.latitud),lng:parseFloat(m.lugar.longitud)})"
                                        :icon="iconos[m.gravedad_id-1]"
                                        :opacity="0.8"

                                >

                                </gmap-marker>

                            </gmap-map>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('scripts')
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>

    <script>
        Vue.use(VueGoogleMaps, {
            load: {
                key: 'AIzaSyCMzQ8697NbNKkkb6x0ZgQhBVWtoKEKOM8',
                libraries: 'places',
            }
        });
        var app  = new Vue({
            el : '#vue-content',
            data:{
                accidentes : [],
                nuevaConsulta : {
                    fecha_inicial :moment(((new Date()).getFullYear()+"-01-01 00:00:00")).format("YYYY-MM-DDTHH:mm"),  //(new Date()).getFullYear()+"-01-01 00:00:00",
                    fecha_final: moment(((new Date()).getFullYear()+"-12-31 23:59:59")).format("YYYY-MM-DDTHH:mm") ,
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
                    lugar: {}
                },



            },
            mounted(){
            this.getPuntos();

            },


            methods:{
                getPuntos:function () {
                    this.$http.get('/mapas/puntos', {params:this.nuevaConsulta}).then(response=>{
                        this.accidentes = response.data;
                    }).catch(error=>{
                        console.log(error);
                    });

                },

                consultarDatos:function () {
                    //alert('ok');
                    this.getPuntos();
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
        })
    </script>

@endsection