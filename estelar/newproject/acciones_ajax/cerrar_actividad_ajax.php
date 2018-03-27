<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idactividad=isset($_POST['idactividad'])?$_POST['idactividad']:NULL;

//echo $idactividad;
if($_SESSION['idusuario']&&$idactividad)
{ //cierra la actividad
	mysql_query("update proyectos_actividades set status=2, fechacerrado='".date('Y-m-d')."',horacerrado='".date('H:i:s')."' where idpat='".$idactividad."' ",$conexionestelar) or die(mysql_error());
}
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>