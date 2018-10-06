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
        <td><h4 align="center">CORPORACIÓN EL MINUTO DE DIOS<br>LEVANTAMIENTO DE INFORMACIÓN PROGRAMA DE PROYECTOS PRODUCTIVOS</h4></td>
        <td width="120px" align="center"><img height="60" src="{{asset('img/geopark.png')}}"></td>
    </tr>
</table>
<br>



@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN DEL BENEFICIARIO</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Fecha de nacimiento: </strong><br>{{ @$info_productivo->Subsidio->Beneficiario->fecha_nacimiento }}</td>
        <td valign="top"><strong>Documento identidad: </strong><br>{{ @$info_productivo->Subsidio->Beneficiario->no_cedula }}</td>
        <td valign="top"><strong>Nombre: </strong><br>{{ @$info_productivo->Subsidio->Beneficiario->nombres }}</td>
        
    </tr>
    <tr>
        <td valign="top"><strong>Apellidos: </strong><br>{{ @$info_productivo->Subsidio->Beneficiario->apellidos }}</td>
        <td valign="top"><strong>Numero de celular: </strong><br>{{ @$info_productivo->Subsidio->Beneficiario->no_celular }}</td>
        <td valign="top"><strong>Consecutivo: </strong><br>{{ @$info_productivo->consecutivo }}</td>
    </tr>
</table>
<br>
<br>
@endif


@if(@$info_productivo->TenenciaTierra->id!='')
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN DEL PREDIO</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Tenencia del predio: </strong><br>{{ @$info_productivo->TenenciaTierra->TipoTenenciaTierra->tipo_tenencia }}</td>
        @if ($info_productivo->TenenciaTierra->id_tipo_tenencia_tierras == 5)
            <td valign="top"><strong>Otro tipo de tenencia: </strong><br>{{ @$info_productivo->TenenciaTierra->otra_tenencia }}</td>
        @endif
        
        <td valign="top"><strong>Tipo Documento Predio: </strong><br>{{ @$info_productivo->TenenciaTierra->OpcionTenenciaTierra->opcion_tenencia }}</td>        
    </tr>
    <tr>
        @if ($info_productivo->TenenciaTierra->id_opcion == 4)
            <td valign="top"><br><strong>Otro tipo de documento: </strong><br>{{ @$info_productivo->TenenciaTierra->otra_opcion }}</td>
        @endif       
        <td valign="top"><br><strong>Área del predio en hectáreas: </strong><br>{{ @$info_productivo->TenenciaTierra->area_predio_has }}</td>
        <td valign="top"><br><strong>Nombre del Predio: </strong><br>{{ @$info_productivo->Predio->nombre_predio }}</td>        
    </tr>
    <tr>
        <td valign="top"><br><strong>Dirección del predio: </strong><br>{{ @$info_productivo->Predio->direccion }}</td>
        <td valign="top"><br><strong>Dirección del predio: </strong><br>{{ @$info_productivo->Predio->direccion }}</td>
        <td valign="top"><br><strong>Latitud del predio: </strong><br>{{ @$info_productivo->Predio->latitud }}</td>        
    </tr>
    <tr>
        <td valign="top"><br><strong>Longitud del predio: </strong><br>{{ @$info_productivo->Predio->longitud }}</td>
        <td valign="top"><br><strong>MSNM del predio: </strong><br>{{ @$info_productivo->Predio->msnm }}<br><br></td>
        <td valign="top"><br><strong>Municipio del predio: </strong><br>{{ @$info_productivo->Predio->Vereda->Municipio->municipio }}<br><br></td>        
    </tr>
    <tr>
        <td valign="top"><br><strong>Vereda del predio: </strong><br>{{ @$info_productivo->Predio->Vereda->vereda }}<br><br></td>
        @if ($info_productivo->TenenciaTierra->TipoTenenciaTierra->tipo_tenencia != 1)
            <td valign="top"><br><strong>Documento identidad propietario del predio: </strong><br>{{ @$info_productivo->Predio->PropietariosPredio->no_cedula }}<br><br></td>
            <td valign="top"><br><strong>Nombre propietario del predio: </strong><br>{{ @$info_productivo->Predio->PropietariosPredio->nombres_propietario }}<br><br></td>
            <tr>
                <td valign="top"><br><strong>Apellidos propietario del predio: </strong><br>{{ @$info_productivo->Predio->PropietariosPredio->apellidos_propietario }}<br><br></td>
                <td valign="top"><br><strong>Numero Telefono propietario del predio: </strong><br>{{ @$info_productivo->Predio->PropietariosPredio->no_telefonico }}<br><br></td>
            </tr>
        @endif
    </tr>
</table>
@endif


@if(@$info_productivo->Generalidade->id!='')
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="3"><strong>INFORMACIÓN GENERAL</strong></td>
    </tr>
    <tr>
        <td valign="top"><strong>Fecha encuesta: </strong><br>{{ @$info_productivo->fecha_encuesta }}</td>
        <td valign="top"><strong>Número de familias que viven en la vivienda: </strong><br>{{ @$info_productivo->no_familias_vivienda }}
        <br><br></td>
        <td valign="top"><strong>¿Atiende el propietario de la vivienda? </strong><br>
            @if(@$info_productivo->responde_propietario == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
    </tr>
    <tr>
        <td valign="top"><strong>¿Beneficiario de programa de Inversión Social? </strong><br>
            @if(@$info_productivo->beficiarios_prog_inv_social == 1) {{ 'Si' }}
            @else {{ 'No' }}
            @endif
            <br><br>
        </td>
        <td valign="top"><strong>Tipo de proyecto: </strong><br>{{ @$info_productivo->Generalidade->TipoProyecto->tipo_proyecto }}</td>
        <td valign="top"><strong>Tipo de familia: </strong><br>{{ @$info_productivo->Generalidade->TipologiasFamilia->tipologia_familia }}</td>
        
    </tr>
    <tr>
        <td valign="top"><strong>Fecha Llegada a Vereda</strong><br>
            {{ @$info_productivo->Generalidade->fecha_vive_vereda }}
        </td>
        <td valign="top"><strong>Fecha Llegada a Vivienda</strong><br>
            {{ @$info_productivo->Generalidade->fecha_vive_vivienda }}
            <br><br>
        </td>
        <td valign="top"><strong>Medio de Transporte: </strong><br>{{ @$info_productivo->Generalidade->TiposVehiculo->tipo_vehiculo }}</td>        
    </tr>
    <tr>
        <td valign="top"><strong>Vía de Acceso</strong><br>
            {{ @$info_productivo->Generalidade->TiposViasAcceso->tipo_via_acceso }}
        </td>
        <td valign="top"><strong>Estado de la Vía</strong><br>
            {{ @$info_productivo->Generalidade->EstadosVia->estado_via }}
            <br><br>
        </td>
        <td valign="top"><strong>Tiempo de Recorrido: </strong><br>{{ @$info_productivo->Generalidade->TiemposRecorrido->tiempo_recorrido }}</td>        
    </tr>
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
    @foreach (@$info_productivo->HabitantesViviendas as $habitante)
        <tr>
            <td>{{ @$habitante->nombres }} {{ @$habitante->apellidos }}</td>
            <td>{{ @$habitante->fecha_nacimiento }}</td>
            <td>{{ @$habitante->no_cedula }}</td>
            <td>{{ @$habitante->no_celular }}</td>
            <td>{{ @$habitante->EstadoCivil->estado_civil }}</td>
            <td>{{ @$habitante->NivelEducativo->nivel_educativo }}</td>
            <td>{{ @$habitante->ocupacion }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="7">
            <strong>INFORMACIÓN FLUJO MANO DE OBRA</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Mes</strong></td>
        <td><strong>Jornal vendido</strong></td>
        <td><strong>Actividad J. Vendido</strong></td>
        <td><strong>Jornal contratado</strong></td>
        <td><strong>Actividad J. Contratado</strong></td>
    </tr>
    @foreach (@$info_productivo->FlujoManoObra as $flujo)
        <tr>
            <td>{{ @$flujo->Mes->mes }}</td>
            <td>{{ @$flujo->jornal_vendido }}</td>
            <td>{{ @$flujo->actividad_jornal_vendido }}</td>
            <td>{{ @$flujo->jornal_contratado }}</td>
            <td>{{ @$flujo->actividad_jornal_contratado }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>














<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="8">
            <strong>INFORMACIÓN DE LOS POTREROS</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Nombre</strong></td>
        <td><strong>Extension(Ha)</strong></td>
        <td><strong>Descanso(dias)</strong></td>
        <td><strong>Ocupacion(dias)</strong></td>
        <td><strong>Fuente hidrica</strong></td>
        <td><strong>Tipo de cobertura</strong></td>
        <td><strong>Uso</strong></td>
        <td><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_productivo->InformacionLote as $lote)
        <tr>
            <td>{{ @$lote->potrero_lote }}</td>
            <td>{{ @$lote->extension_has }}</td>
            <td>{{ @$lote->rotacional_dias_descanso }}</td>
            <td>{{ @$lote->rotacional_dias_ocupacion }}</td>
            <td>{{ @$lote->FuentesAgua->fuente_agua }}</td>
            <td>{{ @$lote->SubtipoCobertura->TipoCobertura->tipo_cobertura }}</td>
            <td>{{ @$lote->uso }}</td>
            <td>{{ @$lote->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="7">
            <strong>INFORMACIÓN FORTALECIMIENTO DE INFRAESTRUCTURA AGROPECUARIA</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong>Tipo de Infraestructura</strong></td>
        <td colspan="5"><strong>Descripcion</strong></td>
    </tr>
    @foreach (@$info_productivo->FortalecimientoInfraestructura as $fortalecimiento)
        <tr>
            <td colspan="2">{{ @$fortalecimiento->tipo }}</td>
            <td colspan="5">{{ @$fortalecimiento->descripcion }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="6">
            <strong>INFORMACIÓN DE LAS ACTIVIDADES AGRICOLAS</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Producto</strong></td>
        <td><strong>Descripcion</strong></td>
        <td><strong>Fecha establecimiento</strong></td>
        <td><strong>Fecha renovacion</strong></td>
        <td><strong>Unidad producto</strong></td>
        <td><strong>Sitio de venta</strong></td>
    </tr>
    @foreach (@$info_productivo->Cultivo as $cultivo)
        <tr>
            <td>{{ @$cultivo->nombre_producto }}</td>
            <td>{{ @$cultivo->descripcion_cultivo }}</td>
            <td>{{ @$cultivo->fecha_establecimiento_cultivo }}</td>
            <td>{{ @$cultivo->fecha_renovacion }}</td>
            <td>{{ @$cultivo->UnidadProducto->unidad_producto.' ('. @$cultivo->UnidadProducto->descripcion_unidad.')' }}</td>
            <td>{{ @$cultivo->SitioVenta->sitio_venta }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4">
            <strong>INFORMACIÓN DE BOVINOS</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Tipo</strong></td>
        <td><strong>Raza</strong></td>
        <td><strong>Tenencia</strong></td>
        <td><strong>Cantidad</strong></td>
    </tr>
    @foreach (@$info_productivo->Bovino as $bovino)
        <tr>
            <td>{{ @$bovino->TipoBovino->tipo_animal }}</td>
            <td>{{ @$bovino->Raza->raza }}</td>
            <td>{{ @$bovino->TipoPropiedad->tipo_propiedad }}</td>
            <td>{{ @$bovino->cantidad }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="4">
            <strong>INFORMACIÓN DEL MANEJO DE ANIMALES</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Actividad</strong></td>
        <td><strong>Producto</strong></td>
        <td><strong>Periodicidad</strong></td>
        <td><strong>Cantidad</strong></td>
    </tr>
    @foreach (@$info_productivo->RegActividadManejoAnimale as $manejo)
        <tr>
            <td>{{ @$manejo->ActividadManejo->nombre_actividad }}</td>
            <td>{{ @$manejo->producto_actividad }}</td>
            <td>{{ @$manejo->periodicidad }}</td>
            <td>{{ @$manejo->cantidad }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="6">
            <strong>INFORMACIÓN DE ORDEÑO</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Unidad</strong></td>
        <td><strong>Frecuencia</strong></td>
        <td><strong>Prod. diaria</strong></td>
        <td><strong>Cant. Autoconsumo</strong></td>
        <td><strong>Cant. Cuaja</strong></td>
        <td><strong>Cant. Venta</strong></td>
    </tr>
    @foreach (@$info_productivo->RegOrdenio as $ordenio)
        <tr>
            <td>{{ @$ordenio->UnidadOrdenio->unidades_ordenio }}</td>
            <td>{{ @$ordenio->FrecuenciaOrdenio->frecuencia }}</td>
            <td>{{ @$ordenio->produccion_dia }}</td>
            <td>{{ @$ordenio->cantidad_autoconsumo }}</td>
            <td>{{ @$ordenio->cantidad_cuaja }}</td>
            <td>{{ @$ordenio->cantidad_venta }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="8">
            <strong>INFORMACIÓN DE ESPECIES MENORES (AVES)</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Tipo</strong></td>
        <td><strong>Cantidad</strong></td>
        <td><strong>Produccion</strong></td>
        <td><strong>Comida(Kg)</strong></td>
        <td><strong>Tipo produccion</strong></td>
        <td><strong>Tipo corral</strong></td>
        <td><strong>Estado corral</strong></td>
        <td><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_productivo->ProduccionAve as $ave)
        <tr>
            <td>{{ @$ave->TipoAve->tipo_ave }}</td>
            <td>{{ @$ave->cantidad_polluelos }}</td>
            <td>{{ @$ave->kg_comida }}</td>
            <td>{{ @$ave->TipoProduccionAve->tipo_produccion_aves }}</td>
            <td>{{ @$ave->TipoCorral->tipo_corral }}</td>
            <td>{{ @$ave->EstadoInstalacion->estado_instalaciones }}</td>
            <td>{{ @$ave->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="7">
            <strong>INFORMACIÓN DE ESPECIES MENORES (CERDOS)</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Metodo reproduccion</strong></td>
        <td><strong>Tipo produccion</strong></td>
        <td><strong>Tipo corral</strong></td>
        <td><strong>Estado corral</strong></td>
        <td><strong>Cantidad animales</strong></td>
        <td><strong>Kg producidos</strong></td>
        <td><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_productivo->ProduccionCerdo as $cerdo)
        <tr>
            <td>{{ @$cerdo->MetodoReproduccion->metodo_reproduccion }}</td>
            <td>{{ @$cerdo->TipoProduccion->tipo_produccion }}</td>
            <td>{{ @$cerdo->TipoCorral->tipo_corral }}</td>
            <td>{{ @$cerdo->EstadoInstalacion->estado_instalaciones }}</td>
            <td>{{ @$cerdo->cantidad_animales }}</td>
            <td>{{ @$cerdo->kg_producidos }}</td>
            <td>{{ @$cerdo->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="6">
            <strong>INFORMACIÓN DE ESPECIES MENORES (PECES)</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Tipo produccion</strong></td>
        <td><strong>Especie</strong></td>
        <td><strong>Cantidad estanques</strong></td>
        <td><strong>Produccion (Kg)</strong></td>
        <td><strong>Cantidad comida (Kg)</strong></td>
        <td><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_productivo->ProduccionPece as $pez)
        <tr>
            <td>{{ @$pez->TipoProduccion->tipo_produccion }}</td>
            <td>{{ @$pez->EspeciePeces->especie }}</td>
            <td>{{ @$pez->cantidad_estanques }}</td>
            <td>{{ @$pez->kg_producidos }}</td>
            <td>{{ @$pez->kg_comida }}</td>
            <td>{{ @$pez->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
    <tr>
        <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000" colspan="7">
            <strong>INFORMACIÓN DE OTRAS ESPECIES MENORES</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong>Especie</strong></td>
        <td colspan="2"><strong>Cantidad animales</strong></td>
        <td colspan="3"><strong>Observaciones</strong></td>
    </tr>
    @foreach (@$info_productivo->ProduccionEspeciesMenore as $otra)
        <tr>
            <td colspan="2">{{ @$otra->especie }}</td>
            <td colspan="2">{{ @$otra->cantidad_animales }}</td>
            <td colspan="3">{{ @$otra->observaciones }}</td>
        </tr>
    @endforeach
</table>
<br>
<br>
<table align="center" width="100%">
<tr>
    <td style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000"><strong>CIERRE REGISTRO FOTOGRAFICO</strong></td>
</tr>
    <tr>
        <td colspan="6" valign="top"><strong>Observaciones: </strong><br>{{ @$info_productivo->observaciones_proyecto }}</td>
    </tr>
    <tr>
        <td style="padding-left: 50px; padding-top: 50px;">
            <center>
                @foreach (@$info_productivo->Fotografias as $fotografia)

                    <img width="230px" src="{{ asset(@$fotografia->ruta) }}" style="margin-left: 10px;">

                @endforeach
            </center>
        </td>
    </tr>
</table>

<table align="center" width="100%">
<tr>
    <td colspan="6" style="color: #ffffff; padding: 2px;" align="center" bgcolor="#000000"><strong>VISITAS REALIZADAS</strong></td>
</tr>
    @foreach ($info_productivo->Subsidio->Visitas as $visita)
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
                        @foreach (@$info_productivo->Subsidio->picture as $foto)
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


@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif


@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif


@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif


@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif



@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif



@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif



@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif



@if(@$info_productivo->Subsidio->Beneficiario->no_cedula!='')

@endif


    