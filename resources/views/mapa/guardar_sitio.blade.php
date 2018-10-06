<?php 
$insertSQL = sprintf("INSERT INTO infraestructura_recursos (nombre_sitio, descripcion, latitud, longitud, tipo_sitio, propiedad_geopark) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre_sitio'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['latitud'], "text"),
                       GetSQLValueString($_POST['longitud'], "date"),
                       GetSQLValueString($_POST['tipo_sitio'], "text"),
                       GetSQLValueString($_POST['propiedad_geopark'], "text"));

  $Result1 = mysqli_query($insertSQL, $CMS) or die(mysqli_error());

  ?>