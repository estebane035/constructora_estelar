<?php //PROVIENE DE SUPERVISOR/INDEX.PHP
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$notificacion=isset($_POST['notificacion'])?$_POST['notificacion']:NULL;
$comments=isset($_POST['comments'])?$_POST['comments']:NULL;

//echo $notificacion." ".$actividad;

//verifica el status de la notificacion
	$status=mysql_query("select status from notificaciones_actividades where idnot_act='".$notificacion."' and activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_status=mysql_fetch_assoc($status);

if($row_status['status']==1)
{
//marca como status de cerrado la notificacion
	mysql_query("update notificaciones_actividades set supervisor='".$_SESSION['idusuario']."',fechaprogreso='".date('Y-m-d')."',horaprogreso='".date('H:i:s')."',status=3 where idnot_act='".$notificacion."' ",$conexionestelar) or die(mysql_error());
}

//guarda comentarios de la notificacion
	mysql_query("insert into comentarios_notificaciones(idnot_act,comentario,fecharegistro,horaregistro,activo) values('".$notificacion."','".mysql_real_escape_string($comments)."','".date('Y-m-d')."','".date('H:i:s')."','1') ");

//obtiene datos de la actividad original y trabajador
	$datos_notificacion=mysql_query("select proyectos_actividades.idpat,proyectos_actividades.idproyecto,proyectos_actividades.idpat_original,proyectos_actividades.idtrabajador FROM proyectos_actividades INNER JOIN notificaciones_actividades ON proyectos_actividades.idpat=notificaciones_actividades.idpat WHERE notificaciones_actividades.idnot_act='".$notificacion."' AND notificaciones_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_datos_notificacion=mysql_fetch_assoc($datos_notificacion);

$pat_original="";
	if($row_datos_notificacion['idpat_original']==0)
		{$pat_original=$row_datos_notificacion['idpat'];}
	else
		{$pat_original=$row_datos_notificacion['idpat_original'];}	

//cierra la actividad actual (status cerrado)
//	mysql_query("update proyectos_actividades set status=2 where idpat='".$row_datos_notificacion['idpat']."' ",$conexionestelar) or die(mysql_error());

/*	
//Guarda nueva actividad
	mysql_query("insert into proyectos_actividades(idusuario,idproyecto,actividad,idtrabajador,status,fecharegistro,horaregistro,idpat_original,activo) values('".$_SESSION['idusuario']."','".$row_datos_notificacion['idproyecto']."','".$actividad."','".$row_datos_notificacion['idtrabajador']."','1','".date('Y-m-d')."','".date('H:i:s')."','".$pat_original."','1')",$conexionestelar) or die(mysql_error());
*/
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>