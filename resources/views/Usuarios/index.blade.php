@extends('layouts.apps')
@section('content')
	<div class="container" id="app">
		<div class="row" style="margin-top: 50px;">
            <div>
            	<h3>Gestion de Usuarios</h3>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-usuario" >
                    Nuevo
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        
        <table class="table" style="margin-top: 10px;">
            <tr>
                <th>Nombre</th>
                <th>Correo electronico</th>
                <th>Tipo de usuario</th>
                <th>Estado</th>
                <th>Modificar estado</th>
                <th>Editar</th>
            </tr>
            <tr v-for="usuario in usuarios">
                <td>@{{ usuario.nombre_usuario }}</td>
                <td>@{{ usuario.email }}</td>
                <td v-if='usuario.id_perfil == 1'>Administrador</td>
                <td v-if='usuario.id_perfil == 2'>Vivienda</td>
                <td v-if='usuario.id_perfil == 3'>Productivos</td>
                <td v-if='usuario.id_perfil == 4'>Informes</td>
                <td v-if='usuario.estado == 1'>Activo</td>
                <td v-if='usuario.estado == 0'>Inactivo</td>
                <td>
                <a  class="btn btn-sm btn-default" title="Activar" v-on:click="cambiarEstado(1, usuario.id)" v-if="usuario.estado == 0">Activar</a>
                <a  class="btn btn-sm btn-default" title="Desactivar" v-on:click="cambiarEstado(0, usuario.id)" v-if="usuario.estado == 1">Desactivar</a>
                </td>  
                <td>
                <a  class="btn btn-sm btn-default" title="Editar" data-toggle="modal" data-target="#modal-editar-usuario" v-on:click="buscarUsuario(usuario.id)">Editar</a>
                </td>            
            </tr>
        </table>


        @include('Usuarios.form_create')    
        @include('Usuarios.form_edit_user')
	</div>

@endsection
@section('scripts')
<script>
    
    Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
    var app = new Vue({
        el : '#app',
        data : {
            newUser: {
                nombre: '',
                apellidos: '',
                correo: '',
                tipo_rol: 0,
                password: '',
                estado: 0,
                _token : "<?php echo csrf_token();?>"
            },
            editUser: {
                id: '',
                nombre: '',
                correo: '',
                tipo_rol: 0,
                password: ''
            },
            usuarios: '' 
        },
        methods: {
            createUser: function(){
                this.$http.post('/createUser', this.newUser).then((response)=>{
                    if(response.body.estado == 'ok'){
                        $("#modal-agregar-usuario").modal('hide');
                        this.formReset();
                        notificarOk('', "Usuario creado correctamente");

                        this.$http.post('/getusers').then((response)=>{
                            this.usuarios = response.body.data;
                        },(error)=>{

                        });

                    }else{
                        notificarFail('', 'Error:  ' + response.body.mensaje);
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },

            cambiarEstado: function(accion, id){
                var tipo_accion = accion;
                var id_usuario = id;
                this.$http.post('/cambiarestado', { accion: tipo_accion, data: id_usuario}).then((response)=>{
                    if(response.body.estado == 'ok'){
                        notificarOk('', "Cambio de estado exitoso!");

                        this.$http.post('/getusers').then((response)=>{
                            this.usuarios = response.body.data;
                        },(error)=>{

                        });

                    }else{
                        notificarFail('', 'Error:  ' + response.body.mensaje);
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },

            buscarUsuario: function(id){
                var id_usuario = id;
                this.$http.post('/buscarUsuario', { data: id_usuario}).then((response)=>{
                    if(response.body.estado == 'ok'){
                        this.editUser.id = response.body.id;
                        this.editUser.nombre = response.body.nombre_completo;
                        this.editUser.correo = response.body.email;
                        this.editUser.tipo_rol = response.body.tipo_rol;
                        this.editUser.password = response.body.password;
                    }else{
                        notificarFail('', 'Error:  ' + response.body.mensaje);
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },

            editarUsuario: function(){ 
                var id_usuario = this.editUser.id;
                var info_usuario = this.editUser;
                this.$http.post('/editarUsuario', { data: id_usuario, info: info_usuario}).then((response)=>{
                    if(response.body.estado == 'ok'){
                        $("#modal-editar-usuario").modal('hide');
                        notificarOk('', "Usuario editado correctamente");

                    }else{
                        notificarFail('', 'Error:  ' + response.body.mensaje);
                    }
                },(error)=>{
                    notificarFail('', 'Error:  ' + error.status+' '+ error.statusText);
                });
            },
            
            formReset: function(){
                this.newUser = {
                    nombre: '',
                    apellidos: '',
                    correo: '',
                    tipo_rol: 0,
                    password: '',
                    _token: ''
                }
            }
        },
        created(){
            this.$http.post('/getusers').then((response)=>{
                    this.usuarios = response.body.data;
                },(error)=>{

                });
        }
    })
</script>
@endsection
