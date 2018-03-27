<?php //PROVIENE DE SUPERVISOR/INDEX.PHP
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$notificacion=isset($_POST['notificacion'])?$_POST['notificacion']:NULL;

//echo $notificacion." ".$actividad;
//marca como status de cerrado la notificacion
	mysql_query("update notificaciones_actividades set supervisor='".$_SESSION['idusuario']."',fechacerrado='".date('Y-m-d')."',horacerrado='".date('H:i:s')."',status=2 where idnot_act='".$notificacion."' ",$conexionestelar) or die(mysql_error());

//obtiene datos de la actividad original y trabajador
	$datos_notificacion=mysql_query("select proyectos_actividades.idpat,proyectos_actividades.idproyecto,proyectos_actividades.idpat_original,proyectos_actividades.idtrabajador FROM proyectos_actividades INNER JOIN notificaciones_actividades ON proyectos_actividades.idpat=notificaciones_actividades.idpat WHERE notificaciones_actividades.idnot_act='".$notificacion."' AND notificaciones_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_datos_notificacion=mysql_fetch_assoc($datos_notificacion);

//cierra la actividad actual (status cerrado)
	//mysql_query("update proyectos_actividades set status=2 where idpat='".$row_datos_notificacion['idpat']."' ",$conexionestelar) or die(mysql_error());
	
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>