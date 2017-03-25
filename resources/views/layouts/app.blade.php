<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="materialize/css/materialize.css" rel="stylesheet">
    <link rel="stylesheet" href="css/app-template.css">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">

        <div class="navbar-fixed">
            <nav class="white">
                <div class="nav-wrapper container">
                    <a href="#!" class="brand-logo" style="margin-top: 10px;">
                        <img src="img/geopark.png" alt="Logo Geopark" height="40">
                        <img src="img/uniminuto.png" alt="Logo Uniminuto" height="40">
                    </a>

                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="badges.html" class="red  waves-effect waves-light btn">Subsidio de Vivienda</a></li>
                        <li><a href="collapsible.html" class="red  waves-effect waves-light btn">Proyectos Productivos</a></li>
                        <li><a href="mobile.html" class="red  waves-effect waves-light btn">Planes de Desarrollo</a></li>
                        <li><a href="mobile.html" class="red  waves-effect waves-light btn">Informes</a></li>



                    </ul>

                </div>
            </nav>
        </div>
        <ul class="side-nav" id="mobile-demo" style="z-index: 9999999">
            <li><div class="userView">
                    <div class="background">

                    </div>
                    <a href="#!user"><img src="img/geopark.png" alt="Logo Geopark" height="40">
                        <img src="img/uniminuto.png" alt="Logo Uniminuto" height="40"></a>
                    <a href="#!name"><span class="black-text darken-4 name">@{{ \Illuminate\Support\Facades\Auth::User()->nombre_usuario }}</span></a>
                    <a href="#!email"><span class="black-text email">@{{ \Illuminate\Support\Facades\Auth::User()->email }}</span></a>
                </div></li>
            <li><a href="badges.html" class="red  waves-effect waves-light btn">Subsidio de Vivienda</a></li>
            <li><a href="collapsible.html" class="red  waves-effect waves-light btn">Proyectos Productivos</a></li>
            <li><a href="mobile.html" class="red  waves-effect waves-light btn">Planes de Desarrollo</a></li>
            <li><a href="mobile.html" class="red  waves-effect waves-light btn">Informes</a></li>

        </ul>


        @yield('content')

        <footer class="page-footer red  darken-2">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Footer Content</h5>
                        <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Links</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2017 Copyright Text
                    <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="materialize/js/materialize.js"></script>
    <script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.3/vue-resource.js"></script>
    <script>
        $(".button-collapse").sideNav();
    </script>
    @yield('scripts')
</body>
</html>
