<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{asset('css/colores.css')}}">
    <link rel="stylesheet" href="{{ asset('css/apps-template.css') }}">
    @yield('estilos')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
@include('layouts.menu')
@yield('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.3/vue-resource.js"></script>
<script src="{{ asset('js/bootstrap-notify.js') }} "></script>
<script src="{{ asset('js/bootstrap-validator.js') }}"></script>
@yield('scripts')
<script>
    function notificarOk(titulo, mensaje) {
        $.notify({

            title: titulo,
            message: mensaje,
            z_index: 1055,

        },{
            type : 'success'
        });
    }
    function notificarFail(titulo, mensaje) {
        $.notify({

            title: titulo,
            message: mensaje,
            z_index: 1055,

        },{
            type : 'danger',
        });
    }
</script>
</body>
</html>


