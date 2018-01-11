@section('estilos')
    <link rel="stylesheet" href="../css/estilos.css">
@endsection

<table align="center" width="90%">
    <tr>
        <td><img height="100" src="{{asset('img/logouniminuto.png')}}"></td>
        <td><h3 align="center">CORPORACIÓN EL MINUTO DE DIOS<br>LEVANTAMIENTO DE INFORMACIÓN PROGRAMA DE MEJORAMIENTO DE VIVIENDA</h3></td>
        <td><img height="90" src="{{asset('img/geopark.png')}}"></td>
    </tr>
</table>
<br>
<table align="center" width="90%">
    <tr>
        <td><strong>Municipio: </strong>{{ @$info_vivienda->Predio->Vereda->Municipio->municipio }}</td>
        <td><strong>Vereda: </strong>{{ @$info_vivienda->Predio->Vereda->vereda }}</td>
        <td><strong>Nombre del predio: </strong>{{ @$info_vivienda->Predio->nombre_predio }}</td>
    </tr>
    <tr>
        <td colspan="3"><strong>Fecha: </strong>{{ @$info_vivienda->fecha_encuesta }}</td>
    </tr>
</table>
<br>
<h3 align="center">PERSONAS QUE HABITAN LA VIVIENDA</h3>
<table align="center" width="90%">
    <tr>
        <td><strong>Nombre de quienes habitan la vivienda</strong></td>
        <td><strong>Edad</strong></td>
        <td><strong>Cédula</strong></td>
        <td><strong>No. telefónico</strong></td>
        <td><strong>Estado civil</strong></td>
        <td><strong>Nivel educativo</strong></td>
        <td><strong>Ocupación</strong></td>
    </tr>
    @foreach (@$info_vivienda->HabitantesViviendas as $habitante)
        <tr>
            <td>{{ @$habitante->nombres }} {{ @$habitante->apellidos }}</td>
            <td>{{ @$habitante->fecha_nacimiento }}</td>
            <td>{{ @$habitante->no_cedula }}</td>
            <td>{{ @$habitante->no_celular }}</td>
            <td>{{ @$habitante->Estados_civil->estado_civil }}</td>
            <td>{{ @$habitante->Nivel_educativo->nivel_educativo }}</td>
            <td>{{ @$habitante->ocupacion }}</td>
        </tr>
    @endforeach
</table>
<br>
<h3 align="center">PERSONAS A CARGO</h3>
<table align="center" width="90%">
    <tr>
        <td><strong>Edad</strong></td>
        <td><strong>Género</strong></td>
        <td><strong>Nivel educativo</strong></td>
        <td><strong>Tipo</strong></td>
        <td><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_vivienda->PersonasCargo as $personascargo)
        <tr>
            <td>{{ @$personascargo->fecha_nacimiento }}</td>
            <td>{{ @$personascargo->Genero->genero }}</td>
            <td>{{ @$personascargo->Nivel_educativo->nivel_educativo }}</td>
            <td>{{ @$personascargo->Tipo_personas_cargo->tipo_persona }}</td>
            <td>{{ @$personascargo->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<h3 align="center">Registro fotográfico</h3>
<center>
    @foreach (@$info_vivienda->Fotografias as $fotografia)

        <img width="30%" src="{{ asset(@$fotografia->ruta) }}">

    @endforeach
</center>
