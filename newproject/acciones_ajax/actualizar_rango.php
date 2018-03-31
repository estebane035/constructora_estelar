<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$id=isset($_POST['id'])?$_POST['id']:NULL;
$hora_check_in=isset($_POST['hora_check_in'])?$_POST['hora_check_in']:NULL;
$hora_check_in = date("H:i:s", strtotime($hora_check_in));
$rango=isset($_POST['rango'])?$_POST['rango']:NULL;

$query = "UPDATE proyectos SET hora_check_in = '".$hora_check_in."', rango = ".$rango." WHERE idproyecto = ".$id." LIMIT 1";
mysql_query($query,$conexionestelar) or die(mysql_error());

echo "1";

?>