<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8"/>

    <title>Bienvenidos</title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.css" rel="stylesheet">
</head>
<body>
    <div class="row contenedor">
        <div class="col l8 m8" id="panel-izquierdo">

            <img src="img/geopark_fondo_1.jpg" width="100%">

        </div>
        <div class="col s12 l4 m4 " id="panel-derecho">
            <div class="row" style="margin-top: 20px">
                <div class="col l6 m6 s6" id="logo cmd">
                    <img src="img/logouniminuto.png" style="width: 60%">

                </div>
                <div class="col l6 m6 s6" id="logo_gp">
                    <img src="img/geopark.png" >
                </div>
            </div>

            <form id="form_login" class="row" v-on:submit.prevent="estadoUsuario()">

                    <div class="input-field col s12">
                        <i class="material-icons prefix">perm_identity</i>
                        <input id="email" type="email" class="validate" required v-model="userInfo.email">
                        <label for="email">Email</label>
                    </div>



                    <div class="input-field col s12">
                        <i class="material-icons prefix">lock_outline</i>
                        <input id="password" type="password" class="validate" required v-model="userInfo.password">
                        <label for="password">Password</label>
                    </div>

                <button class="waves-effect waves-light red btn" type="submit" style="margin-top: 20px" >Ingresar</button>
            </form>
            <h6 style="margin-left: 50%;">o</h6>
            <div class="input-field col s12">
                <a class="waves-effect waves-light btn modal-trigger" href="#modal_registrarse">Registrarse</a>  
            </div>                        
        </div>
        <!-- Modal Structure -->
        <div id="modal_registrarse" class="modal">
            <div class="modal-title">
                <h3 style="margin-left: 6%;margin-top: 3%;">Registro</h3>
            </div>
            <div class="modal-content">
                <div class="row">
                    <form class="form" v-on:submit.prevent="createUser()">
                    
                      <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="icon_prefix" type="text" class="validate" required v-model="newUser.nombre">
                            <label for="icon_prefix" >Nombre</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <i class="material-icons prefix">account_circle</i>
                          <input id="icon_prefix2" type="text" class="validate" required v-model="newUser.apellidos">
                          <label for="icon_prefix2" >Apellidos</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <i class="material-icons prefix">email</i>
                            <input id="icon_prefix3" type="email" class="validate" required v-model="newUser.correo">
                          <label for="icon_prefix3" >Correo electronico</label>
                        </div>
                      </div>
                      <div class="row">
                          <div class="input-field col s12 m12">
                            <select class="browser-default" v-model="newUser.tipo_rol" required>
                              <option value="" disabled>Seleccione..</option>
                              <option :value="1">Administrador</option>
                              <option :value="2">Vivienda</option>
                              <option :value="3">Productivos</option>
                              <option :value="4">Informes</option>
                            </select>
                            <label style="top: -55%;">Rol de Usuario</label>
                          </div>
                      </div>    
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="password2" type="password" class="validate" required v-model="newUser.password">
                          <label for="password2" >Contraseña</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Registrarse
                              <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <div class="input-field col s6">
                            <button class="btn waves-effect waves-light red btn modal-close" type="submit" name="action">Cancelar
                            </button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>

    </div>    
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.js"></script>
<script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.3/vue-resource.js"></script>
</html>
<style>

    *{
        font-family: 'Roboto Condensed', sans-serif;
    }

    #panel-derecho{
        float:right;
    }

    #panel-izquierdo{
        position:fixed;
        height: 100%;
        padding:0;
        margin:0;


    }

    #panel-izquierdo img {
        /*height:100%;*/
        width:100%



    }
    .btn{ width:100%}
    #form_login{
        width:90%;
        margin-top : 100px;
        font-size: 16px;



    }

    img {
        width:80%;
    }

    #logo_gp{
        margin-top: 40px;

    }
    @media (max-width: 600px) {
        #panel-izquierdo{
            visibility: hidden;
        }
    }

</style>
<script>
    $(document).ready(function(){
        $('.modal').modal();
    });

    var app = new Vue({
        el : '.contenedor',
        data:{
            userInfo: {
                email : '',
                password : '',
                _token : "<?php echo csrf_token();?>"
            },
            newUser: {
                nombre: '',
                apellidos: '',
                correo: '',
                tipo_rol: 0,
                password: '',
                estado: 0,
                _token : "<?php echo csrf_token();?>"

            },
            usuario_cuestion: '' 
        },
        watch: {
            
        },
        methods:{
            estadoUsuario: function(){
                this.$http.post('/validarestado', this.userInfo).then((response)=>{
                        if(response.body.estado == 'ok'){
                            this.loginUser();
                            //return 'ok'
                        }else{  
                            Materialize.toast(response.body.mensaje, 4000)
                        }

                },(response)=>{

                    Materialize.toast("Se ha presentado un error con el servidor ( "+response.status+' '+ response.statusText+")", 4000)
                })
            },
            loginUser: function(){
                //alert("entre 1. inicie la peticion");
                this.$http.post('/login', this.userInfo).then((response)=>{
                    console.log(response);
                    //alert("entre 2. ya hice la peticion");
                        if(response.ok){
                            //alert("entre 3. si existe y me redirige al home");
                            Materialize.toast(response.body.mensaje, 4000)
                            window.location.href = '/home'
                        }else{
                            //alert("entre 4. algo paso y no me redirige");
                            Materialize.toast(response.body.mensaje, 4000)
                        }

                },(response)=>{

                    Materialize.toast("Se ha presentado un error con el servidor ( "+response.status+' '+ response.statusText+")", 4000)
                })
            },
            createUser: function(){
                this.$http.post('/createUser', this.newUser).then((response)=>{
                    console.log(response)

                        if(response.body.estado == 'ok'){
                            Materialize.toast(response.body.mensaje, 4000)
                            window.location.href = '/home'
                        }else{
                            Materialize.toast(response.body.mensaje, 4000)
                        }

                },(response)=>{

                    Materialize.toast("Se ha presentado un error con el servidor ( "+response.status+' '+ response.statusText+")", 4000)
                })
            }
        }

    });


</script>

</script>