@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
    <style scoped>
        img{
        max-height: 100px;
        padding: 5px;
        border-radius: 5px;
    }
    .btn-dlt{
        color: red;
        cursor: pointer;

    }
    </style>
    
@endsection
@section('content')
    <div class="container" id="app">
        <div class="row" style="margin-top: 70px;">
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
                    <article class="col-lg-12 col-sm-12">
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
                    <th>Fecha de Visita</th>
                    <th>Tipo de Visita</th>
                    <th>Tipo de Mejoramiento</th>
                    <th>Observaciones</th>
                </tr>
                <tr v-for="info in visitas">
                    <td>@{{ info.fecha }}</td>
                    <td v-if="info.id_tipo_visita == 1">Visita de Seguimiento</td>
                    <td v-else>Visita de recibo de obra</td>
                    <td v-if="info.id_tipo_mejoramientos == 1">Seguridad</td>
                    <td v-if="info.id_tipo_mejoramientos == 2">Estetica</td>
                    <td v-if="info.id_tipo_mejoramientos == 3">Estructural</td>
                    <td v-if="info.id_tipo_mejoramientos == 5">Saneamiento Basico</td>
                    <td v-if="info.id_tipo_mejoramientos == 6">Hacinamiento</td>
                    <td v-if="info.id_tipo_mejoramientos == 4">@{{ info.otra_mejora }}</td>
                    <td>@{{ info.observaciones }}</td>                    

                </tr>

            </table>
        </div>

        <!--@{{ $data }}-->
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
                    id :{{ $subsidio->id }},
                    id_beneficiario: {{ $subsidio->Beneficiario->id }},
                    consecutivo :{{ $subsidio->consecutivo }},
                    beneficiario : '{{ $subsidio->Beneficiario->nombres.' '.$subsidio->Beneficiario->apellidos }}',
                    vereda : '{{$subsidio->Vereda->vereda .' ('.$subsidio->Vereda->Municipio->municipio.' - '.$subsidio->Vereda->Municipio->Departamento->departamento.')'}}',
                    valor : {{$subsidio->valor}},
                    valor_beneficiario: {{$subsidio->valor_beneficiario}},
                    id_fase: {{$subsidio->id_fase}},
                    id_info_vivienda: parseInt('{{$subsidio->id_info_vivienda}}'),
                    id_vereda: {{$subsidio->id_vereda}},
                    fecha_inicio: '{{$subsidio->fecha_inicio}}',
                    concertado : ('{{$subsidio->concertado}}' == 1),
                    entregado : ('{{$subsidio->entregado}}' == 1 ),
                    obras_en_construccion : ('{{$subsidio->obras_en_construccion}}' == 1 ),
                    porcentaje_ejecucion : parseInt('{{$subsidio->porcentaje_ejecucion}}'),
                    observaciones : '{{$subsidio->observaciones}}',
                    id_tipo_subsidio : parseInt('{{$subsidio->id_tipo_subsidio}}')
                    

                },
                nuevaVisita :{
                    id_subsidio : '{{ $subsidio->id }}',
                    id : '',
                    fecha : '',
                    observaciones : '',
                    id_tipo_visita : '',
                    id_tipo_mejoramiento : '',
                    otra_mejora: '',
                    porcentaje_ejecucion: '',
                    valor: '',
                    valor_beneficiario: ''                   
                },
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
                tipoDeVisitas: '',
                tipoDeMejoras: '',
                visitas : '',
                image: [],
                loading :false,
                images :[],
                subirMas : false,
                registroFoto: false


            },
            watch: {
                
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
                getVueItems: function(page){
                    this.subsidios = '';

                this.$http.post('/subsidios/getinfo?page='+page,{tipoSubsidio: 1, buscar : this.buscar}).then((response) => {
                    this.subsidios = response.body.data;
                    this.pagination = response.body.pagination;
                });

                },

                changePage: function (page) {
                    this.pagination.current_page = page;
                    this.getVueItems(page);
                },
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
                guardarVisita : function (){
                        var data= {
                            visitando : this.nuevaVisita,
                            subsidio : this.subsidio
                        }
                        this.$http.post('/subsidios/vivienda/visitas/guardarvisita',data).then((response)=>{                            
                            notificarFail('', response.body.estado);
                        if(response.body.estado === 'ok'){
                            //this.cierre.id = response.body.id;
                            notificarOk("", "Nueva Visita guardada");
                            this.visitas.push(response.body.id);
                            $("#modal-agregar-visita").modal('hide');
                            this.formReset();
                        }else{
                            notificarFail("", "Error al guardar ");
                        }

                    },(error)=>{
                        notificarFail("",""+error);
                    })
                },

                formReset: function () {
                    this.nuevaVisita = {
                        fecha : '',
                        id_tipo_visita : '',
                        id_tipo_mejoramiento : '',
                        otra_mejora : ''
                    };
                    

                },

                getSelectsTipoVisita: function(){
                    this.$http.post('/getselectstipovisita').then((response) => {
                     if(response.body.estado == 'ok'){
                         this.tipoDeVisitas = response.body.tipovisita;
                         this.tipoDeMejoras = response.body.tipomejora;
                     }else{
                         notificarFail('', 'Error al cargar datos ' + response.body.error);
                     }
                 },(error)=>{
                     notificarFail('', 'Error en el servidor ' + response.status+' '+ response.statusText);
                     
                 });

                },

                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    for(var i = 0; i < files.length; i++){
                        this.createImage(files[i]);
                    }
                },
                createImage(file) {
                    var reader = new FileReader();
                    var vm = this;
                    reader.onload = (e) => {
                        vm.image.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                },
                upload(){
                    var id_subsidio = this.subsidio.id; 
                    var id_tipo_subsidio = this.subsidio.id_tipo_subsidio;
                    if(this.image.length > 0){
                        this.loading = true;
                        this.$http.post('/subsidios/visitas/agregarimagenesvisita',{images: this.image, id: id_subsidio, tipo_subsidio: id_tipo_subsidio}).then(response => {
                            this.loading = false;
                            for(index in response.body.fotos){
                                this.images.push(response.body.fotos[index]);
                                console.log(index)
                            }
                            this.image = []
                            notificarOk('', 'Imagen(es) Subidas')
                            this.subirMas = false;
                        });
                    }else{
                        notificarFail("", "Ningun Archivo Seleccionado")
                    }

                },
                deleteImage(img){
                    this.image.splice(this.image.indexOf(img),1);
                },
                deleteImages(img){
                    this.$http.post('/subsidios/visitas/borrarimagenvisita',{id : img.id}).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.images.splice(this.images.indexOf(img),1);

                            notificarOk("", "Imagen borrada del Servidor");
                        }

                    },(error)=>{
                        notificarFail("",""+error)
                    })
                }



            },
            created(){
                this.getSelectsTipoVisita();

                this.$http.post('/getvisitas', this.subsidio).then((response) => {
                        if(response.body.estado == 'ok'){
                            this.visitas = response.body.data
                        }
                    });

            },
            mounted(){
                /*this.$http.post('/subsidios/visitas/todasimagenesvisita', {id :this.idinfo, tipo : 1 }).then((response)=>{
                        this.images = response.body.data;
                    }, (error)=>{
                        notificarFail("",""+error)
                    });*/

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