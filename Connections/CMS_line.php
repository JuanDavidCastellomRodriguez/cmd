<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_CMS = "localhost";
$database_CMS = "imaginas_cmd";
$username_CMS = "imaginas_cmd";
$password_CMS = "imaginas_cmd";
$CMS = mysql_pconnect($hostname_CMS, $username_CMS, $password_CMS) or trigger_error(mysql_error(),E_USER_ERROR); 

///***//**Permite la visualizaci�n de caracteres especiales para consultas e inserci�n de registros**///***///
//mysql_query ("SET NAMES 'utf8'");

///***//**Establece la zona horaria por defecto para Bogot�**///***///
date_default_timezone_set('America/Bogota');

///***//**Almacena en vectores los nombres de los d�as de la semana y los meses del a�o, en espa�ol**///***///
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S�bado");
$meses = array("", "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>