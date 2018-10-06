@extends('layouts.apps')
@section('content')
	<div class="container" id="app">
		<div class="row" style="margin-top: 60px;">
            <div>
            	<h3>Veredas</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-vereda" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        
        <table class="table" style="margin-top: 10px;">
            <tr>
                <th>Vereda</th>
                <th>Municipio</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="vereda in veredas">
                <td>@{{ vereda.vereda }}</td>
                <td>@{{ vereda.municipio.municipio }}</td>
                <td>
                    <a  class="btn btn-sm btn-default" title="Ver" v-on:click="" >Editar</a>
                </td>               
            </tr>
        </table>


        @include('CrearVereda.form_create')    
	</div>

@endsection
@section('scripts')
<script>
    
	Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
	var app = new Vue({
        el : '#app',
        data : {
        	nuevaVereda: {
	        	municipio_id: '',
	        	campo_id: '',
	        	vereda: ''
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
        	municipios: '',
        	campos: '',
        	loading: false,
        	veredas: '',
        	offset: 4  	
        },        
        methods:{
        	guardarVereda : function() {
        		this.loading = true;
        		this.$http.post('/crear_vereda/nuevaVereda', this.nuevaVereda).then((response)=>{
        			if(response.body.estado == 'ok'){
        				$("#modal-agregar-vereda").modal('hide');
                        this.formReset();
                        notificarOk('', "Vereda creada correctamente");
                        this.loading = false;
                    }else{
                    	notificarFail('', 'Error:  ' + response.body.mensaje);
                    	this.loading = false;
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },

            getVeredas: function(page){
                this.veredas = '';
                this.$http.post('/veredas?page='+page,{ buscar : this.buscar}).then((response) => {
                    this.fases = response.body.data;
                    this.pagination = response.body.pagination;
                });
            },

            changePage: function (page) {
                this.pagination.current_page = page;
                this.getVeredas(page);
            },   

        	formReset: function(){
        		this.municipio_id = '',
        		this.campo_id = '',
        		this.vereda = ''
        	}
        },

        created(){
        	this.$http.post('/getmunicipios', {id: 85}).then((response)=>{
                    this.municipios = response.body.data;
                },(error)=>{

                });
        	this.$http.post('/getcampos').then((response)=>{
                    this.campos = response.body.data;
                },(error)=>{

                });
        	this.$http.post('/obtenerVeredas').then((response)=>{
                    this.veredas = response.body.data;
                    this.pagination = {
                            current_page : response.body.current_page,
                            from : 1,
                            last_page : response.body.last_page,
                            next_page_url : response.body.next_page_url,
                            per_page : response.body.per_page,
                            prev_page_url : response.body.prev_page_url,
                            to : response.body.to,
                            total : response.body.total,
                        }                    
                },(error)=>{

                });
        }
    })    


</script>
@endsection

