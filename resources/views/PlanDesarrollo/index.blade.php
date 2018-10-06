@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection
@section('content')
	<div class="container" id="app">
		<div class="row" style="margin-top: 60px;">
            <div>
            	<h3>Planes de Desarrollo</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-plan" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>        
        <table class="table" style="margin-top: 10px;" v-show="planes.length > 0">
            <tr>
                <th>Plan de Desarrollo</th>
                <th>Fecha Aprobacion</th>
                <th>Municipio</th>
                <th>Vereda</th>
                <th>Accion</th>
            </tr>
            <tr v-for="plan in planes">
                <td>@{{ plan.titulo }}</td>
                <td>@{{ plan.fecha }}</td>                
                <td>@{{ plan.municipio }}</td>
                <td>@{{ plan.vereda }}</td>
                <td style="width: 134px;">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#documentos" v-on:click="pasarParametro(plan.id)">
                        Ver documentos                        
                    </button>
                </td>               
            </tr>
        </table>
        <h4 v-if="planes.length == 0">No hay datos para mostrar</h4>


        @include('PlanDesarrollo.form_create')
        
        <div class="modal fade" id="documentos" name="documentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <table>
                        <tr v-for="archivo in parametros">
                            <td>
                                <span class="glyphicon glyphicon-duplicate"><a :href="archivo.ruta"> @{{ archivo.nombres }}</a></span>
                            </td>                            
                        </tr>
                    </table>
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
            archivo: [],
        	nuevoPlan: {
	        	titulo: '',
	        	fecha: '',
                municipio_id: '',
	        	vereda_id: '',
                archivo: null 
        	},            
            subirMas : false,
        	loading: false,
            municipios: '',
        	veredas: '',
            planes: '',
            parametros: [],
            archivos: ''
        },        
        methods:{
            pasarParametro: function(id) {
                //this.parametro = id;
                this.parametros = []
                for (var i = 0; i < this.archivos.length; i++) {
                    if (this.archivos[i].id_plan == id) {
                        this.parametros.push(this.archivos[i])
                    }
                }
            },

        	guardarPlan : function() {
        		this.loading = true;
                var data = new FormData()
                for(var i = 0 ;i<this.nuevoPlan.archivo.length; i++){
                    let file = this.nuevoPlan.archivo[i] 
                    data.append('files['+i+']',file)
                }
                data.append('titulo',this.nuevoPlan.titulo)
                data.append('fecha',this.nuevoPlan.fecha)
                data.append('municipio_id',this.nuevoPlan.municipio_id)
                data.append('vereda_id',this.nuevoPlan.vereda_id)
                
        		this.$http.post('/guardarplan', data).then((response)=>{
        			if(response.body.estado == 'ok'){
                        this.formReset();
        				$("#modal-agregar-plan").modal('hide');
                        
                        this.planes.push(response.body.data);
                        notificarOk('', response.body.mensaje);
                        this.loading = false;

                        this.$http.post('/getplanes').then((response)=>{
                            this.planes = response.body.data;
                            this.archivos = response.body.archivos;
                        },(error)=>{
                    
                        });

                    }else{
                    	notificarFail('', 'Error:  ' + response.body.mensaje);
                    	this.loading = false;
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },

            procesarFiles (e){
                this.nuevoPlan.archivo = e.target.files
                //alert('procesado')
                //console.log(this.nuevoPlan.archivo)       
             },
            getVeredas: function(municipio_id){
                this.$http.post('/getveredas',{ id : municipio_id}).then((response) => {
                    this.veredas = response.body.data;
                });
            },

            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                console.log(files)
                if (!files.length)
                    return;
                for(var i = 0; i < files.length; i++){
                    this.createFile(files[i]);

                }

            },
            createFile(file) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.nuevoPlan.archivo.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            
            deleteFile(file){
                this.archivo.splice(this.archivo.indexOf(file),1);
            },
            
        	formReset: function(){
        		this.nuevoPlan = {
                    titulo: '',
                    fecha: '',
                    municipio_id: '',
                    vereda_id: ''
                }
        	}
        },

        created(){
            this.$http.post('/getmunicipios', {id: 85}).then((response)=>{
                    this.municipios = response.body.data;
                },(error)=>{

                });

            this.$http.post('/getplanes').then((response)=>{
                    this.planes = response.body.data;
                    this.archivos = response.body.archivos;
                    //console.log(this.archivos.length);
                },(error)=>{
                    
                });
        },
        mounted(){
            $('#fecha_aprobacion').datepicker({
                orientation: 'auto top',
                language : 'es',
                todayBtn : true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                app.nuevoPlan.fecha = $(this).val();
            }); 

        }
    })    


</script>
@endsection