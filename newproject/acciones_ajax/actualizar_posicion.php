<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");

$latitud=isset($_POST['latitud'])?$_POST['latitud']:NULL;
$longitud=isset($_POST['longitud'])?$_POST['longitud']:NULL;
$id=isset($_POST['id'])?$_POST['id']:NULL;

//echo "UPDATE proyectos SET latitud = '".$latitud."', longitud = '".$longitud."' WHERE idproyecto = ".$id;exit;

mysql_query("UPDATE proyectos SET latitud = '".$latitud."', longitud = '".$longitud."' WHERE idproyecto = ".$id,$conexionestelar) or die(mysql_error());

echo "¡Location updated successfully!";

?>