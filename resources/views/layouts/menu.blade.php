<nav class="navbar navbar-default white navbar-fixed-top" style="padding-top: 20px;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style="margin-bottom: 10px;">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="https://www.geo-park.com" target="_blank">
                <img src="{{asset('img/geopark.png')}} " alt="Logo Geopark" height="45" >
            </a>
            <a href="https://www.minutodedios.org" target="_blank">
                <img src="{{asset('img/logouniminuto.png')}}" alt="Logo Uniminuto" height="50">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="#">Link</a></li>-->
                <li><a href="{{url('/home')}}" style="padding: 6px 12px 6px 12px" class="btn btn-default  red geopark white-text">Inicio</a></li>
                

                @if (Auth::User()->id_perfil == 1 || Auth::User()->id_perfil == 2)
                    <li><a href="{{url('/subsidios/vivienda')}}" style="padding: 6px 12px 6px 12px" class="btn btn-default  red geopark white-text">Vivienda</a></li>
                @endif 
                @if (Auth::User()->id_perfil == 1 || Auth::User()->id_perfil == 3)               
                <li><a href="{{ url('/subsidios/productivos/')}}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px">Productivos</a></li>
                @endif                
                <li><a href="{{ url('/PlanDesarrollo') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px">Planes de Desarrollo</a></li>
                @if (Auth::User()->id_perfil == 1 || Auth::User()->id_perfil == 2 || Auth::User()->id_perfil == 3 || Auth::User()->id_perfil == 4)
                <li><a href="{{ url('/subsidios/informes') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Informes</a></li>
                <li><a href="{{ url('/subsidios/mapa') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Cartografía</a></li>
                @endif
                @if (Auth::User()->id_perfil == 1 || Auth::User()->id_perfil == 2 || Auth::User()->id_perfil == 3)
                <li><a href="{{ url('/infraestructura_comunitaria')}}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px">Infraestructura comunitaria</a></li>
                <li><a href="{{ url('/fases') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Fases</a></li>
                <li><a href="{{ url('/ordenes') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Ordenes</a></li>
                <li><a href="{{ url('/crear_vereda') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Veredas</a></li>
                @endif
                @if (Auth::User()->id_perfil == 1)
                <li><a href="{{ url('/gestion_usuarios') }}" class="btn btn-default red geopark white-text" style="padding: 6px 12px 6px 12px" >Usuarios</a></li>
                @endif
                <li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" title="Cerrar Sesion" style="padding: 6px 12px 6px 12px" class="btn btn-default red geopark white-text">

                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        </button>
                    </form>
                    </li>

            </ul>

        </div><!-- /.navbar-collapse -->

        <br>

    </div><!-- /.container-fluid -->
</nav>