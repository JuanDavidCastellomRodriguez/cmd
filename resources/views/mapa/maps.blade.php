@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection

<?php //require_once('Connections/CMS.php'); 
///***//**Función para iniciar los datos de una sesion**///***///

$hostname_CMS = "localhost";
$database_CMS = "cmd";
$username_CMS = "root";
$password_CMS = "root";

$CMS = mysqli_connect($hostname_CMS, $username_CMS, $password_CMS, $database_CMS) or trigger_error(mysql_error(),E_USER_ERROR); 

@session_start();
///***//**Evita el almacenamiento de las páginas en la caché del cliente**///***///
@session_cache_limiter('nocache,private');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if(isset($_GET["id_punto"])){
  $SQL_Elimina = mysqli_query($CMS, "DELETE FROM infraestructura_recursos WHERE id = '$_GET[id_punto]'");
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form2")) {

  ?>
<script type="text/javascript">
  alert('Información guardada con éxito.');
</script>
<?php

  @$insertSQL = "INSERT INTO infraestructura_recursos (nombre_sitio, descripcion, latitud, longitud, tipo_sitio, propiedad_geopark) VALUES ('$_GET[nombre_sitio]', '$_GET[descripcion]', '$_GET[latitud]', '$_GET[longitud]', '$_GET[tipo_sitio]', '$_GET[propiedad_geopark]')";

  @$Result1 = mysqli_query($CMS, $insertSQL) or die(mysqli_error());  

}



if(isset($_GET['id_fase'])){

  if($_GET['id_fase'] != 9999){
    $consulta_fase = ' fases.id = '.$_GET['id_fase'].' and ';
  } else {
    $consulta_fase = '';
  }

  if($_GET['id_campo'] != 9999){
    $consulta_campo = ' campos_veredas.id_campo = '.$_GET['id_campo'].' and ';
  } else {
    $consulta_campo = '';
  }

  if($_GET['id_orden'] != 9999){
    $consulta_orden = ' orden_servicios.id = '.$_GET['id_orden'].' and ';
  } else {
    $consulta_orden = '';
  }

  if($_GET['nombre'] != ''){
    $consulta_nombre = ' beneficiarios.nombres LIKE "%'.$_GET['nombre'].'%" or beneficiarios.apellidos LIKE "%'.$_GET['nombre'].'%" or beneficiarios.no_cedula = "'.$_GET['nombre'].'"';
  } else {
    $consulta_nombre = ' beneficiarios.nombres LIKE "%'.$_GET['nombre'].'%" or beneficiarios.apellidos LIKE "%'.$_GET['nombre'].'%" or beneficiarios.no_cedula = "'.$_GET['nombre'].'"';
  }

  @$_SESSION['id_fase'] = $_GET['id_fase'];
  $_SESSION['id_campo'] = $_GET['id_campo'];
  $_SESSION['id_orden'] = $_GET['id_orden'];
  $_SESSION['nombre'] = $_GET['nombre'];


  //$query_info_predios = "SELECT *, predios.id AS id_predio_seleccionado FROM predios, fase_veredas, campos_veredas, fases, orden_servicios, tipo_subsidios WHERE predios.id_vereda = fase_veredas.id_vereda and fase_veredas.id_fase = fases.id and fases.id_orden_servicio = orden_servicios.id and campos_veredas.id_vereda = predios.id_vereda and ($consulta_fase $consulta_campo $consulta_orden)";

  $query_info_predios = "SELECT beneficiarios.no_cedula,
       beneficiarios.nombres,
       beneficiarios.apellidos,
       predios.id,
       predios.nombre_predio, 
       predios.id AS id_predio_seleccionado,
       predios.latitud,
       predios.longitud
FROM ((((((cmd.predios predios
           INNER JOIN cmd.informacion_viviendas informacion_viviendas
              ON (predios.id = informacion_viviendas.id_predio))
          INNER JOIN cmd.fase_veredas fase_veredas
             ON (predios.id_vereda = fase_veredas.id_vereda))
         INNER JOIN cmd.fases fases ON (fases.id = fase_veredas.id_fase))
        INNER JOIN cmd.orden_servicios orden_servicios
           ON (fases.id_orden_servicio = orden_servicios.id))
       INNER JOIN cmd.campos_veredas campos_veredas
          ON (predios.id_vereda = campos_veredas.id_vereda))
      INNER JOIN cmd.subsidios subsidios
         ON (subsidios.id_info_vivienda = informacion_viviendas.id))
     INNER JOIN cmd.beneficiarios beneficiarios
        ON (subsidios.id_beneficiario = beneficiarios.id)
        WHERE ($consulta_fase $consulta_campo $consulta_orden $consulta_nombre)";

  $info_predios = mysqli_query($CMS, $query_info_predios) or die(mysqli_error());
  $row_info_predios = mysqli_fetch_assoc($info_predios);
  $totalRows_info_predios = mysqli_num_rows($info_predios);

  //WHERE ($consulta_fase $consulta_campo $consulta_orden $consulta_nombre)

  //and informacion_viviendas.id_predio = predios.id and subsidios.id_info_vivienda = informacion_viviendas.id and subsidios.id_beneficiario = beneficiario.id 

  //, informacion_viviendas, subsidios

} else{
  $query_info_predios = "SELECT *, predios.id AS id_predio_seleccionado FROM predios";
  $info_predios = mysqli_query($CMS, $query_info_predios) or die(mysqli_error());
  $row_info_predios = mysqli_fetch_assoc($info_predios);
  $totalRows_info_predios = mysqli_num_rows($info_predios);
}

$query_datos_infraestructura_recursos = "SELECT * FROM infraestructura_recursos";
$datos_infraestructura_recursos = mysqli_query($CMS, $query_datos_infraestructura_recursos) or die(mysqli_error());
$row_datos_infraestructura_recursos = mysqli_fetch_assoc($datos_infraestructura_recursos);
$totalRows_datos_infraestructura_recursos = mysqli_num_rows($datos_infraestructura_recursos);

$query_infraestructura_recursos = "SELECT * FROM infraestructura_recursos";
$infraestructura_recursos = mysqli_query($CMS, $query_infraestructura_recursos) or die(mysqli_error());
$row_infraestructura_recursos = mysqli_fetch_assoc($infraestructura_recursos);
$totalRows_infraestructura_recursos = mysqli_num_rows($infraestructura_recursos);


$query_tipo_subsidio = "SELECT * FROM tipo_subsidios";
$tipo_subsidio = mysqli_query($CMS, $query_tipo_subsidio) or die(mysqli_error());
$row_tipo_subsidio = mysqli_fetch_assoc($tipo_subsidio);
$totalRows_tipo_subsidio = mysqli_num_rows($tipo_subsidio);

$query_orden_servicio = "SELECT * FROM orden_servicios";
$orden_servicio = mysqli_query($CMS, $query_orden_servicio) or die(mysqli_error());
$row_orden_servicio = mysqli_fetch_assoc($orden_servicio);
$totalRows_orden_servicio = mysqli_num_rows($orden_servicio);

$query_datos_fases = "SELECT * FROM fases";
$datos_fases = mysqli_query($CMS, $query_datos_fases) or die(mysqli_error());
$row_datos_fases = mysqli_fetch_assoc($datos_fases);
$totalRows_datos_fases = mysqli_num_rows($datos_fases);

$query_datos_campos = "SELECT * FROM campos";
$datos_campos = mysqli_query($CMS, $query_datos_campos) or die(mysqli_error());
$row_datos_campos = mysqli_fetch_assoc($datos_campos);
$totalRows_datos_campos = mysqli_num_rows($datos_campos);

?>

<!DOCTYPE html>


<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Bienvenidos</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

    <script language="javascript">
$(document).ready(function(){
   $("#category").change(function () {
      $("#category option:selected").each(function () {
      id_category = $(this).val();
      $.post("subcategories.php", { id_category: id_category }, function(data){
        $("#subcategory").html(data);
      });     
        });
   })
});

function obtenerFase(val){
    $.ajax({
        type: "POST",
        url: "fases/listabyorden",
        data:'id_orden='+val,
        success: function(data){
        $("#id_fase").html(data);
        }
        });   
    }

</script>

  </head>
  <body style="margin-top: 20px">

     <div style="position: fixed; z-index: 999; right: 12px; top: 95px;">
      
      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-datos-estado" style="margin-bottom: 15px;">
        Consultar beneficios 
      <span class="" aria-hidden="true"></span>
      </button>

      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-datos-subsidio" style="margin-bottom: 15px;">
        <?php 
        if($totalRows_info_predios>0){
          echo $totalRows_info_predios.' predio(s) encontrado(s).';
        } else {
          echo 'No se han encontrado resultados';
        }
        ?>
      <span class="" aria-hidden="true"></span>
      </button>    

      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-infraestructura" style="margin-bottom: 15px;">
        Infraestructura petrolera y recursos naturales 
      <span class="" aria-hidden="true"></span>
      </button>

      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar" style="margin-bottom: 15px;">
        Agregar 
      <span class="" aria-hidden="true"></span>
      </button>

    </div> 


    <div class="modal fade" tabindex="-1" role="dialog" id="modal-datos-estado" name="modal-datos-estado">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="height: 260px">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Consulta de Beneficios</h4>
            </div>
            
            <form re="form" action="mapa/" style="margin-bottom: 20px">

                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Orden de Servicio</label>
                    <select class="form-control" id="id_orden" name="id_orden" required onChange="obtenerFase(this.value);">
                        <?php 
                        do{
                        ?>
                        <option value="<?php echo $row_orden_servicio['id'];?>"><?php echo $row_orden_servicio['consecutivo'];?></option>
                        <?php 
                        } while ($row_orden_servicio = mysqli_fetch_assoc($orden_servicio));
                        ?>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-3 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Fase</label>
                    <select class="form-control" id="id_fase" name="id_fase" required>
                        
                        <option value="9999">Todos</option>

                        <?php
                        do {  
                        ?>
                          <option value="<?php echo $row_datos_fases['id']?>" <?php if (!(strcmp($row_datos_fases['id'], @$_SESSION['id_fase']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_datos_fases['nombre_fase']?></option>
                        <?php
                        } while ($row_datos_fases = mysqli_fetch_assoc($datos_fases));
                        $rows = mysqli_num_rows($datos_fases);
                        if($rows > 0) {
                          mysqli_data_seek($datos_fases, 0);
                          $row_datos_fases = mysqli_fetch_assoc($datos_fases);
                        }
                        ?>
                        
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>

                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Tipo de Beneficio</label>
                    <select class="form-control" id="id_tipo_subsidio" name="id_tipo_subsidio" required>
                        <option value="9999">Todos</option>
                        <?php do{ ?>
                        <option value="<?php echo $row_tipo_subsidio['id'];?>"><?php echo $row_tipo_subsidio['tipo_subsidio'];?></option>
                        <?php 
                        } while ($row_tipo_subsidio = mysqli_fetch_assoc($tipo_subsidio));
                        ?>
                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Campos</label>
                    <select class="form-control" id="id_campo" name="id_campo" required>
                        <option value="9999">Todos</option>
                        
                        <?php
                        do {  
                        ?>
                          <option value="<?php echo $row_datos_campos['id']?>" <?php if (!(strcmp($row_datos_campos['id'], @$_SESSION['id_campo']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_datos_campos['nombre_campo']?></option>
                        <?php
                        } while ($row_datos_campos = mysqli_fetch_assoc($datos_campos));
                        $rows = mysqli_num_rows($datos_campos);
                        if($rows > 0) {
                          mysqli_data_seek($datos_campos, 0);
                          $row_datos_campos = mysqli_fetch_assoc($datos_campos);
                        }
                        ?>

                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>

                <div class="form-group has-feedback col-lg-12 col-sm-12 col-md-12">
                    <label for="exampleInputName2">Nombre o número de identificación del beneficiario</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                    
                </div>

                <div class="col-lg-2 col-sm-12 form-group form-inline" style="margin-top: 2px">
                    <button class="btn btn-danger" type="submit" >Consultar</button>
                </div>

            </form>
            
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar" name="modal-datos-estado">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="height: 250px">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Agregar infraestructura petrolera y recursos naturales</h4>
            </div>

            <form action="mapa/" re="form" name="form2" id="form2" style="margin-bottom: 20px">

                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Nombre del sitio</label>
                    <input type="nombre_sitio" name="nombre_sitio" class="form-control" placeholder="Nombre del sitio" required="">
                </div>
                <div class="form-group has-feedback col-lg-3 col-sm-6 col-md-3">
                    <label for="exampleInputName2">Tipo de sitio</label>
                    <select class="form-control" id="tipo_sitio" name="tipo_sitio" required>
                        
                        <option value="IP">Infraestructura petrolera</option>
                        <option value="RN">Recurso natural</option>

                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                </div>

                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Latitud</label>
                    <input type="latitud" name="latitud" class="form-control" placeholder="Latitud" required="">
                </div>
                <div class="form-group has-feedback col-lg-3 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Longitud</label>
                    <input type="longitud" name="longitud" class="form-control" placeholder="Longitud" required="">
                </div>

                <div class="form-group has-feedback col-lg-6 col-sm-12 col-md-3">
                    <label for="exampleInputName2">Descripción del sitio</label>
                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                </div>

                <div class="col-lg-3 col-sm-12 form-group has-feedback">
                    <label for="exampleInputName2">¿Propiedad de GeoPark?</label>
                    <select class="form-control" id="propiedad_geopark" name="propiedad_geopark" required>
                        
                        <option value="1">Si</option>
                        <option value="0">No</option>

                    </select>
                </div>

                <div class="col-lg-3 col-sm-12 form-group form-inline" style="margin-top: 25px">
                    <button class="btn btn-danger" type="submit">Guardar</button>
                    <input type="hidden" name="MM_insert" value="form2" />
                </div>

            </form>

            
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id="modal-datos-subsidio" name="modal-datos-estado">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="height: auto;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Resultados de la consulta</h4>
            </div>


            <?php

if($totalRows_info_predios>0){

?>

<table class="table" width="90%" align="center">
              <tr>
                <td width="10%" align="center"><strong>No.</strong></td>
                <?php if(@$row_info_predios['nombres']!=''){ ?>
                <td width="" align="left"><strong>Nombre del beneficiario</strong></td>
                <?php } ?>
                <td width="" align="left"><strong>Nombre del predio</strong></td>
                <td width="" align="left"><strong>Nombre del propietario</strong></td>
                <td width="" align="left"><strong>Latitud</strong></td>
                <td width="" align="left"><strong>Longitud</strong></td>
                
                
              </tr>
              <?php 
        $i = 0;
        do{
        $i++;

        $query_info_propietario = "SELECT * FROM propietarios_predios WHERE id_predio = '$row_info_predios[id_predio_seleccionado]'";
        $info_propietario = mysqli_query($CMS, $query_info_propietario) or die(mysqli_error());
        $row_info_propietario = mysqli_fetch_assoc($info_propietario);
        $totalRows_info_propietario = mysqli_num_rows($info_propietario);
        ?>
                <tr valign="top">
                  <td width="10%" align="center"><?php echo $i;?></td>
                  <?php if(@$row_info_predios['nombres']!=''){ ?>
                  <td align="left"><?php echo @$row_info_predios['nombres'].' '.@$row_info_predios['apellidos']; ?></td>
                  <?php } ?>
                  <td align="left"><?php echo $row_info_predios['nombre_predio']; ?></td>
                  <td align="left"><?php echo $row_info_propietario['nombres_propietario'].' '.$row_info_propietario['apellidos_propietario']; ?></td>
                  <td align="left"><?php echo $row_info_predios['latitud']; ?></td>
                  <td align="left"><?php echo $row_info_predios['longitud']; ?></td>
                  
                  
                </tr>
                <?php } while ($row_info_predios = mysqli_fetch_assoc($info_predios)); ?>
            </table>


<?php

@mysqli_data_seek($info_predios,0);
@$row_info_predios = mysqli_fetch_assoc($info_predios);

} else{ echo 'No se ha encontrado nunguna coincidencia.';}
?>            
            
            
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id="modal-infraestructura" name="modal-datos-estado">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="height: auto;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Infraestructura petrolera y recursos naturales</h4>
            </div>


            <?php

if($totalRows_infraestructura_recursos>0){

?>

<table class="table" width="90%" align="center">
              <tr>
                <td width="10%" align="center"><strong>No.</strong></td>
                <td width="" align="left"><strong>Nombre del sitio</strong></td>
                <td width="" align="center"><strong>Propiedad<br>GeoPark</strong></td>
                <td width="" align="left"><strong>Latitud</strong></td>
                <td width="" align="left"><strong>Longitud</strong></td>
                <td width="" align="left"><strong>Tipo sitio</strong></td>
                <td width="" align="center"><strong>Eliminar</strong></td>
              </tr>
              <?php 
        $i=0;
        do { 
        $i++;
        ?>
                <tr valign="top">
                  <td width="10%" align="center"><?php echo $i;?></td>
                  <td align="left"><?php echo $row_infraestructura_recursos['nombre_sitio']; ?></td>
                  <td align="center"><?php 
                    if($row_infraestructura_recursos['propiedad_geopark'] == 1){
                      echo 'Si';
                    } else {
                      echo 'No';
                    }
                  ?></td>
                  <td align="left"><?php echo $row_infraestructura_recursos['latitud']; ?></td>
                  <td align="left"><?php echo $row_infraestructura_recursos['longitud']; ?></td>
                  <td align="left"><?php 
                    if($row_infraestructura_recursos['tipo_sitio'] == 'RN'){
                      echo 'Recurso Natural';
                    } else {
                      echo 'Infraestructura petrolera';
                    }
                  ?></td>
                  <td align="center">
                  
                    <a href="mapa/?id_punto=<?php echo $row_infraestructura_recursos['id']?>" title="Eliminar sitio" class="btn btn-sm btn-danger">Eliminar</a>
                  
                  </td>
                </tr>
                <?php } while ($row_infraestructura_recursos = mysqli_fetch_assoc($infraestructura_recursos)); ?>
            </table>


<?php

} else{ echo 'No se ha encontrado ningún registro de infraestructura petrolera o recurso natural.';}
?>            
            
            
        </div>
    </div>
</div>


    <div id="map"></div>
    <script>

      // This example displays a marker at the center of Australia.
      // When the user clicks the marker, an info window opens.

      function initMap() {

        <?php
        $i = 0;
        do{
        $i++;

        ?>  

        var punto<?php echo $i?> = {lat:<?php echo $row_datos_infraestructura_recursos['latitud'];?>, lng:<?php echo $row_datos_infraestructura_recursos['longitud'];?>};

        var contentStringpunto<?php echo $i?> = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading"><?php echo $row_datos_infraestructura_recursos['nombre_sitio'];?></h1>'+
            
            '<p><img src="<?php echo $row_datos_infraestructura_recursos['descripcion'];?>"></p>';

            contentStringpunto<?php echo $i?> = contentStringpunto<?php echo $i?>+'</div>';       

        var infowindowpunto<?php echo $i?> = new google.maps.InfoWindow({
          content: contentStringpunto<?php echo $i?>
        });


        <?php   
        } while ($row_datos_infraestructura_recursos = mysqli_fetch_assoc($datos_infraestructura_recursos));

        mysqli_data_seek($datos_infraestructura_recursos, 1);
        ?>

        <?php
        $i = 0;
        do{
        $i++;

        $query_info_propietario = "SELECT * FROM propietarios_predios WHERE id_predio = '$row_info_predios[id_predio_seleccionado]'";
        $info_propietario = mysqli_query($CMS, $query_info_propietario) or die(mysqli_error());
        $row_info_propietario = mysqli_fetch_assoc($info_propietario);
        $totalRows_info_propietario = mysqli_num_rows($info_propietario);

        $query_info_fotografia = "SELECT *, informacion_viviendas.id AS id_info FROM informacion_viviendas, fotografias WHERE informacion_viviendas.id = fotografias.id_informacion and informacion_viviendas.id_predio = '$row_info_predios[id_predio_seleccionado]'";
        $info_fotografia = mysqli_query($CMS, $query_info_fotografia) or die(mysqli_error());
        $row_info_fotografia = mysqli_fetch_assoc($info_fotografia);
        $totalRows_info_fotografia = mysqli_num_rows($info_fotografia);

        ?>  

        var uluru<?php echo $i?> = {lat:<?php echo $row_info_predios['latitud'];?>, lng:<?php echo $row_info_predios['longitud'];?>};

        var contentString<?php echo $i?> = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading"><?php echo $row_info_predios['nombre_predio'];?></h1>'+
            
            '<p><img src="<?php echo $row_info_fotografia['ruta'];?>"></p>';

          <?php  if(@$row_info_predios['apellidos']!=''){ ?>

            contentString<?php echo $i?> = contentString<?php echo $i?> + '<p><strong>Beneficiario:</strong> <?php echo $row_info_predios['nombres'].' '.$row_info_predios['apellidos'];?></p>';
          <?php } ?>

            contentString<?php echo $i?> = contentString<?php echo $i?> + '<p><strong>Propietario:</strong> <?php echo $row_info_propietario['nombres_propietario'].' '.$row_info_propietario['apellidos_propietario'];?></p>';

            <?php 
            if($totalRows_info_fotografia>0){
            ?>
            contentString<?php echo $i?> = contentString<?php echo $i?>+
            '<p><a target="_blank" href="/informes/getdiagnosticovivienda/<?php echo $row_info_fotografia['id_info'];?>">'+
            'Ver información</a></p>';
            <?php
            }
            ?>
            contentString<?php echo $i?> = contentString<?php echo $i?>+'</div>';

        

        var infowindow<?php echo $i?> = new google.maps.InfoWindow({
          content: contentString<?php echo $i?>
        });


        <?php   
        } while ($row_info_predios = mysqli_fetch_assoc($info_predios));

        mysqli_data_seek($info_predios, 1);
        ?>      

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          mapTypeId: 'satellite',
          center: uluru<?php echo $i?>
        });


        <?php
        $i = 0;
        do{
        $i++;
        ?>  

        var markerpunto<?php echo $i?> = new google.maps.Marker({
          position: punto<?php echo $i?>,
          map: map,
          icon: 'http://lareporteria.com/point/infraestructura.png',
          title: '<?php echo $row_datos_infraestructura_recursos['nombre_sitio'];?>'
        });

        markerpunto<?php echo $i?>.addListener('click', function() {
          infowindowpunto<?php echo $i?>.open(map, markerpunto<?php echo $i?>);
        });

        
        


        <?php   
        } while ($row_datos_infraestructura_recursos = mysqli_fetch_assoc($datos_infraestructura_recursos));
        ?>


        <?php
        $i = 0;
        do{
        $i++;
        ?>  

        var marker<?php echo $i?> = new google.maps.Marker({
          position: uluru<?php echo $i?>,
          map: map,
          icon: 'http://lareporteria.com/point/predio.png',
          title: '<?php echo $row_info_predios['nombre_predio'];?>'
        });

        marker<?php echo $i?>.addListener('click', function() {
          infowindow<?php echo $i?>.open(map, marker<?php echo $i?>);
        });

        
        


        <?php   
        } while ($row_info_predios = mysqli_fetch_assoc($info_predios));
        ?>


      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbFCgiKXM2rDJSi9axH9DGEjUgcVPPMpQ&callback=initMap">
    </script>
  </body>
</html>









<!--<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Marker Clustering</title>
    <style>

      #map {
        height: 100%;
      }

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {

        var locations = [
        <?php
        //do{
        ?>  
          {lat: <?php //echo $row_info_predios['latitud'];?>, lng: <?php //echo $row_info_predios['longitud'];?>},
        <?php   
        //} while ($row_info_predios = mysqli_fetch_assoc($info_predios));
        ?>
        ]

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 4.488944444, lng: -72.67322222}
        });

        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        var infowindow = new google.maps.InfoWindow({
          content: labels,
          maxWidth: 200
        });

        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            map: map,
            label: labels[i % labels.length]
          });

          markers.addListener('click', function() {
            infowindow.open(map, markers);
          });

        });

        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
      
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbFCgiKXM2rDJSi9axH9DGEjUgcVPPMpQ&callback=initMap">
    </script>
  </body>
</html>