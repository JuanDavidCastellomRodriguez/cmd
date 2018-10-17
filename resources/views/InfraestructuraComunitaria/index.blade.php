@extends('layouts.apps')
@section('content')
<div class="container" id="app">
	<div class="row" style="margin-top: 60px;">
        <div>
        	<h3>Infraestructura Comunitaria</h3>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-obra">
                Nuevo
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    
    <table class="table" style="margin-top: 10px;">
        <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>No. orden</th>
            <th>Ubicación</th>
            <th>Valor inversion</th>
            <th>Recibe</th>
            <th>Imagenes</th>
        </tr>
        <tr v-for="obra in obras">
            <td>@{{ obra.fecha }}</td>
            <td>@{{ obra.nombre_obra }}</td>
            <td>@{{ obra.descripcion }}</td>               
            <td>@{{ obra.orden }}</td>
            <td>@{{ obra.municipio_vereda }}</td>
            <td>@{{ obra.valor_inversion }}</td>
            <td>@{{ obra.recibe }}</td>
            <td style="width: 134px;">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#imagenes" v-on:click="pasarParametro(obra.id)">
                    Ver Imagenes                        
                </button>
            </td>
        </tr>
    </table>


    @include('InfraestructuraComunitaria.form_create_obra')

    <div class="modal fade" id="imagenes" name="imagenes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Registro Fotografico de Obra</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div v-for="foto in parametros">
                  <img :src="foto.ruta" style="width: 560px;height: 300px; margin-bottom: 20px;">
                  <br>               
                </div>
                <h4 v-if="parametros.length == 0">No hay imagenes para mostrar</h4>             
          </div>          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>  

</div>

@endsection
@section('scripts')
<script src="{{asset("js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("js/bootstrap-datepicker.es.min.js")}}"></script>
<script>

	Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
	var app = new Vue({
        el : '#app',
        data : {
            nuevaObra:{
                municipio_id: '',
                vereda_id: '',
                fecha: '',
                nombre_obra: '',
                nombre_recibe: '',
                identificacion_recibe: '',
                id_orden: '',
                valor: '',
                descripcion: ''
            },
        	image: [],
            loading :false,
            images :[],
            subirMas : false,
            registroFoto: false,
            municipios: '',
            veredas: '',
            obras: '',
            imagenes: '',
            ordenes:'',
            parametros: []
        },        
        methods:{
            pasarParametro: function(id) {
                //this.parametro = id;
                //alert(id);
                this.parametros = []
                for (var i = 0; i < this.imagenes.length; i++) {
                    if (this.imagenes[i].id_infraestructura_comun == id) {
                        this.parametros.push(this.imagenes[i])
                    }
                }
            },
        	guardarObra : function() {
        		this.loading = true;
        		this.$http.post('/nueva_infraestructura_comunitaria', {nuevaObra: this.nuevaObra, images: this.image}).then((response)=>{
        			if(response.body.estado == 'ok'){
        				$("#modal-agregar-obra").modal('hide');
                        this.formReset();
                        notificarOk('', "Infraestructura comunitaria creada correctamente");
                        this.loading = false;
                        this.$http.post('/getObras').then((response)=>{
                            this.obras = response.body.data;
                        },(error)=>{

                        });
                    }else{
                    	notificarFail('Error: no se pudo crear la nueva obra.');
                    	this.loading = false;
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },
            formReset: function () {
                this.nuevaObra = {
                    fecha : '',
                    municipio_id : '',
                    vereda_id : '',
                    valor : '',
                    nombre: '',                    
                },
                this.image = []
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
                
                if(this.image.length > 0){
                    this.loading = true;
                    this.$http.post('/imagenes_obras',{images: this.image}).then(response => {
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
            },
            getVeredas: function(municipio_id){
                this.$http.post('/getveredas',{ id : municipio_id}).then((response) => {
                    this.veredas = response.body.data;
                });
            },



        },

        created(){
        	this.$http.post('/getmunicipios', {id: 85}).then((response)=>{
                    this.municipios = response.body.data;
                },(error)=>{

                });

            this.$http.post('/getordenes').then((response)=>{
                    this.ordenes = response.body.ordenes;
                },(error)=>{

                });

            this.$http.post('/getObras').then((response)=>{
                    this.obras = response.body.data;
                },(error)=>{

                });
            this.$http.post('/getImagenes').then((response)=>{
                    this.imagenes = response.body.data;
                },(error)=>{

                });
        },
        mounted(){
            /*this.$http.post('/subsidios/visitas/todasimagenesvisita', {id :this.idinfo, tipo : 1 }).then((response)=>{
                    this.images = response.body.data;
                }, (error)=>{
                    notificarFail("",""+error)
                });*/

            $('#fecha_aprobacion').datepicker({
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