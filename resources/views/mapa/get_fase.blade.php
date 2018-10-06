<script type="text/javascript">
	
	Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

</script>
<?php 
	$hostname_CMS = "localhost";
	$database_CMS = "cmd";
	$username_CMS = "root";
	$password_CMS = "";
	$CMS = mysqli_connect($hostname_CMS, $username_CMS, $password_CMS, $database_CMS) or trigger_error(mysql_error(),E_USER_ERROR); 

	//if (!empty($_POST["id_orden"])){
		$query_datos_fases = "SELECT * FROM fases WHERE id_orden = '$_POST[id_orden]'";
		$datos_fases = mysqli_query($CMS, $query_datos_fases) or die(mysqli_error());
		$row_datos_fases = mysqli_fetch_assoc($datos_fases);
		echo 'Hola'.$totalRows_datos_fases = mysqli_num_rows($datos_fases);
 ?>
 <option value="">Seleccionar..</option>
   <?php
       do {  
	?>
       <option value="<?php echo $row_datos_fases['id']?>"><?php echo $row_datos_fases['nombre_fase']?></option>
    <?php
		} while ($row_datos_fases = mysqli_fetch_assoc($datos_fases));
		$rows = mysqli_num_rows($datos_fases);
		if($rows > 0) {
			mysqli_data_seek($datos_fases, 0);
			$row_datos_fases = mysqli_fetch_assoc($datos_fases);
		}
	//}
	?>
