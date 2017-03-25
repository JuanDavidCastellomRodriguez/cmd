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
    <div class="row contenedor" style="height:100%">
        <div class="col s8" id="panel-izquierdo" style="height:100%" >

            <img src="img/geopark_fondo_1.jpg" height="100%">

        </div>
        <div class="col s4" id="panel-derecho">
            <div class="row" style="margin-top: 20px">
                <div class="col s6" id="logo cmd">
                    <img src="img/logouniminuto.png" style="width: 60%">

                </div>
                <div class="col s6" id="logo_gp">
                    <img src="img/geopark.png" >
                </div>
            </div>

            <form id="form_login" v-on:submit.prevent="loginUser()">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">perm_identity</i>
                        <input id="email" type="email" class="validate" required v-model="userInfo.email">
                        <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">lock_outline</i>
                        <input id="password" type="password" class="validate" required v-model="userInfo.password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <button class="waves-effect waves-light red btn" type="submit" >Ingresar</button>
            </form>

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
        height:100%;
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

</style>
<script>

    var app = new Vue({
        el : '.contenedor',
        data:{
            userInfo: {
                email : '',
                password : '',
                _token : "<?php echo csrf_token();?>"
            }
        },
        methods:{
            loginUser: function(){
                this.$http.post('/login', this.userInfo).then((response)=>{
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