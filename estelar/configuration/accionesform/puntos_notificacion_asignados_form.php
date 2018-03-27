<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;
$puntos=isset($_POST['puntos'])?$_POST['puntos']:NULL;
//obtiene lista de putos de notificacion
	$puntos_notificacion=mysql_query("select idcampo_not,campo from notificaciones_campos where activo=1",$conexionestelar) or die(mysql_error());
	$row_puntos_notificacion=mysql_fetch_assoc($puntos_notificacion);		
	
//obtiene los putos que la notificacion tiene asignadas
	$puntos_asignados=mysql_query("select idcampo_not from notificaciones_campos_asignacion where idnotificacion='".$idnotificacion."' ",$conexionestelar) or die(mysql_error());
	$row_puntos_asignados=mysql_fetch_assoc($puntos_asignados);
	$a_asignados[]="";
	do
	{ $a_asignados[$row_puntos_asignados['idcampo_not']]=$row_puntos_asignados['idcampo_not'];
	}while($row_puntos_asignados=mysql_fetch_assoc($puntos_asignados));


//deshabilita todo los puntos asignados
	mysql_query("update notificaciones_campos_asignacion set activo=2 where idnotificacion='".$idnotificacion."' ",$conexionestelar) or die(mysql_error());	
	
//echo $idnotificacion."<br>";
if($_SESSION['idusuario']&&$puntos)
{	
	
	 foreach($puntos as $key)
	 { //echo $key."<br>";
	 	//si el campo ya esta registrado, actualiza su registro como activo
		if(isset($a_asignados[$key]))
			{ mysql_query("update notificaciones_campos_asignacion set activo=1 where idnotificacion='".$idnotificacion."' and idcampo_not='".$key."' ",$conexionestelar) or die(mysql_error());}
		else //si el campo no esta asignado inserta registro de campo
			{ mysql_query("insert into notificaciones_campos_asignacion (idnotificacion,idcampo_not,activo) values('".$idnotificacion."','".$key."','1')",$conexionestelar) or die(mysql_error());}
	 }
}
echo "<script>location.href='../points_notification.php?idnot=".$idnotificacion."'</script>";
?>