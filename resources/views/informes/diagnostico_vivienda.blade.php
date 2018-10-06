@section('estilos')
    <link rel="stylesheet" href="../css/estilos.css">
@endsection

<style type="text/css">
    body{
        font: 12px Lucida, sans-serif;
    }
 
</style>

<table align="center" width="100%">
    <tr>
        <td width="120px" align="center"><img height="100" src="{{asset('img/logouniminuto.png')}}"></td>
        <td><h4 align="center">CORPORACIÓN EL MINUTO DE DIOS<br>LEVANTAMIENTO DE INFORMACIÓN PROGRAMA DE MEJORAMIENTO DE VIVIENDA</h4></td>
        <td width="120px" align="center"><img height="60" src="{{asset('img/geopark.png')}}"></td>
    </tr>
</table>
<br>
@if(@$info_vivienda->Subsidio->Beneficiario->no_cedula!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN DEL BENEFICIARIO</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Fecha de nacimiento: </strong><br>{{ @$info_vivienda->Subsidio->Beneficiario->fecha_nacimiento }}</td>
        <td valign="top"><strong>Documento identidad: </strong><br>{{ @$info_vivienda->Subsidio->Beneficiario->no_cedula }}</td>
        <td valign="top"><strong>Nombre: </strong><br>{{ @$info_vivienda->Subsidio->Beneficiario->nombres }}</td>
        
    </tr>
    <tr>
        <td valign="top"><strong>Apellidos: </strong><br>{{ @$info_vivienda->Subsidio->Beneficiario->apellidos }}</td>
        <td valign="top"><strong>Numero de celular: </strong><br>{{ @$info_vivienda->Subsidio->Beneficiario->no_celular }}</td>
        <td valign="top"><strong>Consecutivo: </strong><br>{{ @$info_vivienda->consecutivo }}</td>
    </tr>
</table>
<br>
<br>
    
@endif

@if(@$info_vivienda->Predio->nombre_predio!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN DEL PREDIO</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Tenencia del predio: </strong><br>{{ @$info_vivienda->TenenciaTierra->TipoTenenciaTierra->tipo_tenencia }}</td>
        <td valign="top"><strong>Otro tipo de tenencia: </strong><br>{{ @$info_vivienda->TenenciaTierra->otra_tenencia }}</td>
        <td valign="top"><strong>Tipo Documento Predio: </strong><br>{{ @$info_vivienda->TenenciaTierra->OpcionTenenciaTierra->opcion_tenencia }}</td>
    </tr>
    <tr>
        <td valign="top"><br><strong>Otro tipo de documento: </strong><br>{{ @$info_vivienda->TenenciaTierra->otra_opcion }}</td>
        <td valign="top"><br><strong>Área del predio en hectáreas: </strong><br>{{ @$info_vivienda->TenenciaTierra->area_predio_has }}</td>
        <td valign="top"><br><strong>Nombre del Predio: </strong><br>{{ @$info_vivienda->Predio->nombre_predio }}</td>
    </tr>
    <tr>
        <td valign="top"><br><strong>Dirección del predio: </strong><br>{{ @$info_vivienda->Predio->direccion }}</td>
        <td valign="top"><br><strong>Latitud del predio: </strong><br>{{ @$info_vivienda->Predio->latitud }}</td>
        <td valign="top"><br><strong>Longitud del predio: </strong><br>{{ @$info_vivienda->Predio->longitud }}</td>
    </tr>
    <tr>
        <td valign="top"><br><strong>MSNM del predio: </strong><br>{{ @$info_vivienda->Predio->msnm }}<br><br></td>
        <td valign="top"><br><strong>Municipio del predio: </strong><br>{{ @$info_vivienda->Predio->Vereda->Municipio->municipio }}<br><br></td>
        <td valign="top"><br><strong>Vereda del predio: </strong><br>{{ @$info_vivienda->Predio->Vereda->vereda }}<br><br></td>
    </tr>
</table>

@endif

@if(@$info_vivienda->Predio->nombre_predio!='')


<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN GENERAL</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Fecha encuesta: </strong><br>{{ @$info_vivienda->fecha_encuesta }}</td>
        <td valign="top"><strong>Número de familias que viven en la vivienda: </strong><br>{{ @$info_vivienda->no_familias_vivienda }}
        <br><br></td>
        <td valign="top"><strong>¿Atiende el propietario de la vivienda? </strong><br>
            @if(@$info_vivienda->responde_propietario == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Beneficiario de programa de Inversión Social? </strong><br>
            @if(@$info_vivienda->beficiarios_prog_inv_social == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Tipo de Familia: </strong><br>{{ @$info_vivienda->Generalidade->TipologiasFamilia->tipologia_familia }}</td>
        <td valign="top"><strong>Fecha Llegada a Vereda</strong><br>
            {{ @$info_vivienda->Generalidade->fecha_vive_vereda }}
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Fecha Llegada a Vivienda</strong><br>
            {{ @$info_vivienda->Generalidade->fecha_vive_vivienda }}
            <br><br>
        </td>
        <td valign="top"><strong>Medio de Transporte: </strong><br>{{ @$info_vivienda->Generalidade->TiposVehiculo->tipo_vehiculo }}</td>
        <td valign="top"><strong>Vía de Acceso</strong><br>
            {{ @$info_vivienda->Generalidade->TiposViasAcceso->tipo_via_acceso }}
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Estado de la Vía</strong><br>
            {{ @$info_vivienda->Generalidade->EstadosVia->estado_via }}
            <br><br>
        </td>
        <td valign="top"><strong>Tiempo de Recorrido: </strong><br>{{ @$info_vivienda->Generalidade->TiemposRecorrido->tiempo_recorrido }}</td>
        <td valign="top"><strong>El subsidio, se relaciona con:</strong><br>
            {{ @$info_vivienda->Generalidade->TipoSubsidio->tipo_subsidio }}
        </td>
    </tr>
    <!--<tr>
        <td valign="top"><strong>Valor del otro subsidio:</strong><br>
            {{ @$info_vivienda->Generalidade->EstadosVia->estado_via }}
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>-->



</table>

@endif




<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="7">
            <strong>PERSONAS QUE HABITAN LA VIVIENDA</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Nombre completo</strong></td>
        <td><strong>Fecha de nacimiento</strong></td>
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

<!--<h3 align="center">PERSONAS A CARGO</h3>
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
</table>-->
<br>


@if(@$info_vivienda->Habitacione->id!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>INFORMACIÓN DE LAS HABITACIONES</strong></td>
    </tr>
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Estructura de la habitación</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Vigas: </strong>
            @if(@$info_vivienda->Habitacione->estructura_viga == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Columnas: </strong>
            @if(@$info_vivienda->Habitacione->estructura_columna == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Otra estructura: </strong>
            @if(@$info_vivienda->Habitacione->estructura_otra == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>¿Cuál?: </strong>{{ @$info_vivienda->Habitacione->otra_estructura }}</td>
    </tr>


    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Muros</strong></td>
    </tr>

    <tr>
        <td valign="top"><strong>Material muros: </strong>
            {{@$info_vivienda->Habitacione->TipoMuro->tipo_muro}} 
            <br><br>
        </td>
        <td valign="top"><strong>Otro material muros: </strong>
            {{@$info_vivienda->Habitacione->descripcion_otro_muro}} 
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>        
    </tr>

    <tr>
        
        <td valign="top"><strong>Estuco: </strong>
            @if(@$info_vivienda->Habitacione->estuco == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pintura: </strong>
            @if(@$info_vivienda->Habitacione->pintura == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Interno: </strong>
            @if(@$info_vivienda->Habitacione->panete_interno == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Externo: </strong>
            @if(@$info_vivienda->Habitacione->panete_externo == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>        
        
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Cubierta</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material cubierta: </strong>
            {{ @$info_vivienda->Habitacione->TipoCubierta->tipo_cubierta }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material cubierta: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otra_cubierta }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Pisos</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material pisos: </strong>
            {{ @$info_vivienda->Habitacione->TipoPiso->tipo_piso }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material pisos: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otro_piso }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Ventanas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material ventanas externas: </strong>
            {{ @$info_vivienda->Habitacione->MaterialesVentana->material_ventanas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de ventanas externas: </strong>
            {{ @$info_vivienda->Habitacione->cantidad_ventanas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material ventanas externas: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otra_ventana }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Material ventanas internas: </strong>
            {{ @$info_vivienda->Habitacione->MaterialesVentanaInterna->material_ventanas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de ventanas internas: </strong>
            {{ @$info_vivienda->Habitacione->cantidad_ventanas_internas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material ventanas internas: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otra_ventana_interna }}
            <br><br>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Puertas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material puertas externas: </strong>
            {{ @$info_vivienda->Habitacione->MaterialesPuerta->material_puertas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de puertas externas: </strong>
            {{ @$info_vivienda->Habitacione->cantidad_puertas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material puertas externas: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otra_puerta }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Material puertas internas: </strong>
            {{ @$info_vivienda->Habitacione->MaterialesPuertaInterna->material_puertas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de puertas internas: </strong>
            {{ @$info_vivienda->Habitacione->cantidad_puertas_internas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material puertas internas: </strong>
            {{ @$info_vivienda->Habitacione->descripcion_otra_puerta_interna }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Observaciones</strong></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Estado de la habitación: </strong>{{ @$info_vivienda->Habitacione->EstadosVivienda->estado_vivienda }}<br><br></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Observaciones: </strong>{{ @$info_vivienda->Habitacione->observaciones }}<br><br></td>
    </tr>
</table>

@endif


@if(@$info_vivienda->Cocina->id!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>INFORMACIÓN DE LA COCINA</strong></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Estructura de la cocina</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Vigas: </strong>
            @if(@$info_vivienda->Cocina->estructura_viga == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Columnas: </strong>
            @if(@$info_vivienda->Cocina->estructura_columna == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Otra estructura: </strong>
            @if(@$info_vivienda->Cocina->estructura_otra == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>¿Cuál?: </strong>{{ @$info_vivienda->Cocina->otra_estructura }}</td>
    </tr>


    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Muros</strong></td>
    </tr>

    <tr>
        <td valign="top"><strong>Material muros: </strong>
            {{@$info_vivienda->Cocina->TipoMuro->tipo_muro}} 
            <br><br>
        </td>
        <td valign="top"><strong>Otro material muros: </strong>
            {{@$info_vivienda->Cocina->descripcion_otro_muro}} 
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>        
    </tr>

    <tr>
        
        <td valign="top"><strong>Estuco: </strong>
            @if(@$info_vivienda->Cocina->estuco == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pintura: </strong>
            @if(@$info_vivienda->Cocina->pintura == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Interno: </strong>
            @if(@$info_vivienda->Cocina->panete_interno == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Externo: </strong>
            @if(@$info_vivienda->Cocina->panete_externo == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>        
        
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Cubierta</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material cubierta: </strong>
            {{ @$info_vivienda->Cocina->TipoCubierta->tipo_cubierta }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material cubierta: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otra_cubierta }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Pisos</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material pisos: </strong>
            {{ @$info_vivienda->Cocina->TipoPiso->tipo_piso }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material pisos: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otro_piso }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Ventanas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material ventanas: </strong>
            {{ @$info_vivienda->Cocina->MaterialesVentana->material_ventanas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de ventanas: </strong>
            {{ @$info_vivienda->Cocina->cantidad_ventanas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material ventanas: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otra_ventana }}
            <br><br>
        </td>
    </tr>
    
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Puertas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material puertas: </strong>
            {{ @$info_vivienda->Cocina->MaterialesPuerta->material_puertas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de puertas: </strong>
            {{ @$info_vivienda->Cocina->cantidad_puertas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material puertas: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otra_puerta }}
            <br><br>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Información específica de la cocina</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Estufa?: </strong>
            @if(@$info_vivienda->Cocina->estufa == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Tipo de fuente de energía: </strong>
            {{ @$info_vivienda->Cocina->ElementosCocina->elemento_cocina }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro tipo de fuente de energía: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otro_material_estufa }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Mesón?: </strong>
            @if(@$info_vivienda->Cocina->meson == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Tipo de mesón: </strong>
            {{ @$info_vivienda->Cocina->TiposMesone->tipo_meson }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro tipo de fuente de energía: </strong>
            {{ @$info_vivienda->Cocina->descripcion_otro_material_meson }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Lavaplatos?: </strong>
            @if(@$info_vivienda->Cocina->lavaplatos == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Observaciones</strong></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Estado de la cocina: </strong>{{ @$info_vivienda->Cocina->EstadosVivienda->estado_vivienda }}<br><br></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Observaciones: </strong>{{ @$info_vivienda->Cocina->observaciones }}<br><br></td>
    </tr>
</table>
@endif


@if(@$info_vivienda->UnidadesSanitaria->id!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>INFORMACIÓN DE LA UNIDAD SANITARIA</strong></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Estructura de la unidad sanitaria</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Vigas: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->estructura_viga == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Columnas: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->estructura_columna == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Otra estructura: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->estructura_otra == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>¿Cuál?: </strong>{{ @$info_vivienda->UnidadesSanitaria->otra_estructura }}</td>
    </tr>


    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Muros</strong></td>
    </tr>

    <tr>
        <td valign="top"><strong>Material muros: </strong>
            {{@$info_vivienda->UnidadesSanitaria->TipoMuro->tipo_muro}} 
            <br><br>
        </td>
        <td valign="top"><strong>Otro material muros: </strong>
            {{@$info_vivienda->UnidadesSanitaria->descripcion_otro_muro}} 
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>        
    </tr>

    <tr>
        
        <td valign="top"><strong>Estuco: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->estuco == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pintura: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->pintura == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Interno: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->panete_interno == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Pañete Externo: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->panete_externo == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>        
        
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Cubierta</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material cubierta: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->TipoCubierta->tipo_cubierta }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material cubierta: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->descripcion_otra_cubierta }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Pisos</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material pisos: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->TipoPiso->tipo_piso }}
            <br><br>
        </td>
        <td valign="top"><strong>Otro material pisos: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->descripcion_otro_piso }}
            
            <br><br>
        </td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Ventanas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material ventanas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->MaterialesVentana->material_ventanas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de ventanas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->cantidad_ventanas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material ventanas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->descripcion_otra_ventana }}
            <br><br>
        </td>
    </tr>
    
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Puertas</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Material puertas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->MaterialesPuerta->material_puertas }}
            <br><br>
        </td>
        <td valign="top"><strong>Número de puertas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->cantidad_puertas }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Otro material puertas: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->descripcion_otra_puerta }}
            <br><br>
        </td>
    </tr>

    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Información específica de la unidad sanitaria</strong></td>
    </tr>
    <tr>
        <td colspan="6" valign="top"><strong>Elementos sanitarios instalados: </strong>        
            @foreach ($info_vivienda->UnidadesSanitaria->Elemento as $elemento)
                @if ($elemento->id_unidades_sanitarias == $info_vivienda->UnidadesSanitaria->id)
                    {{ @$elemento->ElementosSanitario->elementos_sanitarios.', ' }}
                @endif
            @endforeach
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Lavamanos?: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->Elemento->id_elementos_sanitarios == 4) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Orinal de pared y/o de piso: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->Elemento->id_elementos_sanitarios == 5) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Ninguno: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->Elemento->id_elementos_sanitarios == 6) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
    </tr>

    <tr>
        <td valign="top"><strong>Tanque elevado?: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->tanque_elevado == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Material tanque elevado: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->MaterialesTanquesElevado->material_tanque_elevado }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top">
        </td>
    </tr>

    <tr>
        <td valign="top"><strong>Tanque lavadero?: </strong>
            @if(@$info_vivienda->UnidadesSanitaria->tanque_lavadero == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Material tanque elevado: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->MaterialesTanquesLavadero->material_tanque_lavadero }}
            
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Acabados del tanque elevado: </strong>
            {{ @$info_vivienda->UnidadesSanitaria->AcabadosTanque->acabados_tanque }}
            <br><br>
        </td>
    </tr>


    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>Observaciones</strong></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Tipo de unidad sanitaria: </strong>{{ @$info_vivienda->UnidadesSanitaria->TipoUnidadesSanitaria->tipo_unidad_sanitaria }}<br><br></td>
        <td colspan="2"><strong>Estado de la unidad sanitaria: </strong>{{ @$info_vivienda->UnidadesSanitaria->EstadosVivienda->estado_vivienda }}<br><br></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Observaciones: </strong>{{ @$info_vivienda->UnidadesSanitaria->observaciones }}<br><br></td>
    </tr>
</table>
@endif


@if(@$info_vivienda->ServiciosPublico->id!='')

<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4"><strong>SERVICIOS PÚBLICOS</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Fuente de agua: </strong>
            {{ @$info_vivienda->ServiciosPublico->FuentesAgua->fuente_agua }}
            
            <br><br>
        </td>
        <td valign="top"><strong>¿Sistema de tratamiento de agua? </strong>
            @if(@$info_vivienda->ServiciosPublico->tratamiento_agua == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>            
        </td>
        <td colspan="2" valign="top"><strong>Manejo de aguas residuales: </strong>
            {{ @$info_vivienda->ServiciosPublico->SistemaEliminacionAguasGrise->sistema_eliminacion_aguas_grises }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>Manejo de residuos solidos: </strong>
            {{ @$info_vivienda->ServiciosPublico->MetodosDisposicionBasura->metodos_disposicion }}
            
            <br><br>
        </td>
        <td valign="top"><strong>Gas: </strong>
            {{ @$info_vivienda->ServiciosPublico->Gas->gas }}
            <br><br>
        </td>
        <td colspan="2" valign="top"><strong>Electricidad: </strong>
            {{ @$info_vivienda->ServiciosPublico->FuenteEnergiaElectrica->fuente_energia_electrica }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="6" valign="top"><strong>Comunicaciones: </strong>        
            @foreach ($info_vivienda->ServiciosPublico->Comunicaciones as $comunicacion)
                @if ($comunicacion->id_servicios_publicos == $info_vivienda->ServiciosPublico->id)
                    {{ @$comunicacion->MediosComunicaciones->medio_comunicacion.', ' }}
                @endif
            @endforeach
            <br><br>
        </td>
    </tr>
</table>
@endif


@if(@$info_vivienda->Indicadore->id!='')
<table align="center" width="100%">
    <tr>
        <td colspan="4" style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000"><strong>CIERRE LEVENTAMIENTO DE INFORMACION</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Numero de habitaciones: </strong>
            {{ @$info_vivienda->Indicadore->no_habitaciones }}
            
            <br><br>
        </td>
        <td valign="top"><strong>Numero de personas en la vivienda: </strong>
            {{ @$info_vivienda->Indicadore->no_personas_vivienda }}
            <br><br>
        </td>
        <td colspan="2" valign="top"><strong>¿Hacinamiento? </strong>
            @if(@$info_vivienda->Indicadore->hacinamiento == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Saneamiento basico?: </strong>
            @if(@$info_vivienda->Indicadore->saneamiento_basico == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>¿Condiciones de seguridad, estructura y estetica?: </strong>
            @if(@$info_vivienda->Indicadore->condiciones_seguridad == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td colspan="2"><strong>Zona de riesgo: </strong>        
            {{ @$info_vivienda->Indicadore->tipos_riesgos }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Infraestructura petrolera cercana?: </strong>
            @if(@$info_vivienda->Indicadore->infraestructura_cercana == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif            
            <br><br>
        </td>
        <td valign="top"><strong>Lineas de flujo: </strong>
            {{ @$info_vivienda->Indicadore->tipos_infraestructuras }}
            <br><br>
        </td>
        <td colspan="2" valign="top"><strong>Tipo de riesgo de la infraestructura petrolera </strong>
            {{ @$info_vivienda->Indicadore->tipos_riesgos }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿La infraestructura petrolera es propiedad de GeoPark?: </strong>
            @if(@$info_vivienda->Indicadore->propiedad_geopark == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif            
            <br><br>
        </td>
        <td valign="top"><strong>Estado general de la vivienda: </strong>
            @if(@$info_vivienda->Indicadore->estados_vivienda_id == 1) {{ 'Mala' }}
            @elseif(@$info_vivienda->Indicadore->estados_vivienda_id == 2) {{ 'Regular' }}
            @elseif(@$info_vivienda->Indicadore->estados_vivienda_id == 3) {{ 'Buena sin acabados' }}
            @endif {{ 'Buena con acabados' }}
            <br><br>
        </td>
        <td colspan="2" valign="top"><strong>Obra proyectada: </strong>
            {{ @$info_vivienda->Indicadore->obra_proyectada }}
            <br><br>
        </td>
    </tr>    
</table>
<br>
<br>
@endif


<table align="center" width="100%">
<tr>
    <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000"><strong>Registro Fotográfico</strong></td>
</tr>
    <tr>
        <td>
            <center>
                @foreach (@$info_vivienda->Fotografias as $fotografia)

                    <img width="230px" src="{{ asset(@$fotografia->ruta) }}">

                @endforeach
            </center>
        </td>
    </tr>
</table>

<table align="center" width="100%">
<tr>
    <td colspan="6" style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000"><strong>VISITAS REALIZADAS</strong></td>
</tr>
    @foreach ($info_vivienda->Subsidio->Visitas as $visita)
        <tr>
            <td valign="top"><strong>Fecha: </strong>
                {{ @$visita->fecha }}          
                <br><br>
            </td>
            <td valign="top"><strong>Observaciones: </strong>
                {{ @$visita->observaciones }}          
                <br><br>
            </td>
            <td colspan="2" valign="top"><strong>Tipo de visita: </strong>
                @if(@$visita->id_tipo_visita == 1) {{ 'Visita de seguimiento' }}
                @elseif(@$visita->id_tipo_visita == 2) {{ 'Visita de recibo de obra' }}
                @endif
                <br><br>
            </td>
            <td colspan="2" valign="top"><strong>Tipo de mejoramiento: </strong>
                @if(@$visita->id_tipo_mejoramientos == 1) {{ 'Seguridad' }}
                @elseif(@$visita->id_tipo_mejoramientos == 2) {{ 'Estética' }}
                @elseif(@$visita->id_tipo_mejoramientos == 3) {{ 'Estructural' }}
                @elseif(@$visita->id_tipo_mejoramientos == 4) {{ 'Otro' }}
                @elseif(@$visita->id_tipo_mejoramientos == 5) {{ 'Saneamiento basico' }}
                @elseif(@$visita->id_tipo_mejoramientos == 6) {{ 'Hacinamiento' }}
                @endif
                <br><br>
            </td>
        </tr>
        <tr>
            <td colspan="6" valign="top">
                <strong>Registro fotografico: </strong>                
            </td>
        </tr>
        <tr>
            <td colspan="6" valign="top">
                <div style="height: 20px;">
                    <center>
                        @foreach (@$info_vivienda->Subsidio->picture as $foto)
                            @if ($foto->id_visita == $visita->id)
                                <img width="230px" src="{{ asset(@$foto->ruta) }}">
                            @endif                       

                        @endforeach
                    </center>
                </div>
                
            </td>
        </tr>
        
    @endforeach
    
</table>

