@extends('layouts.apps')
@section('estilos')
    <link rel="stylesheet" href="{{asset("css/bootstrap-datepicker3.min.css")}}">
@endsection

<?php //require_once('Connections/CMS.php'); 
///***//**Función para iniciar los datos de una sesion**///***///

$hostname_CMS = "localhost";
$database_CMS = "cmd";
$username_CMS = "root";
$password_CMS = "";
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

//mysql_select_db($database_CMS, $CMS);
$query_info_predios = "SELECT * FROM predios";
$info_predios = mysqli_query($CMS, $query_info_predios) or die(mysqli_error());
$row_info_predios = mysqli_fetch_assoc($info_predios);
$totalRows_info_predios = mysqli_num_rows($info_predios);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Marker Clustering</title>
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
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {

        var locations = [
        <?php
        do{
        ?>  
          {lat: <?php echo $row_info_predios['latitud'];?>, lng: <?php echo $row_info_predios['longitud'];?>},
        <?php   
        } while ($row_info_predios = mysqli_fetch_assoc($info_predios));
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

        // Add a marker clusterer to manage the markers.
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