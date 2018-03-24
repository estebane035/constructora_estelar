<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$notification=isset($_POST['notification'])?$_POST['notification']:NULL;
$tipo=isset($_POST['tipo'])?$_POST['tipo']:NULL;
$notificacion_p=isset($_POST['notificacion_p'])?$_POST['notificacion_p']:NULL;

//echo $notification." ".$tipo." ".$notificacion_p;
if($notification&&$notification)
{ //inserta nueva notificacion
	//si la notificacion es principal
	if($tipo==1)
	{ mysql_query("insert into notificaciones_principal(notificacion,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($notification))."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());
		$idnp=mysql_insert_id();
		mysql_query("insert into cat_notificaciones(notificacion,idtiponotificacion,idnp,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($notification))."','".$tipo."','".$idnp."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());
	}
	//si es una notificacion princial
	else
	{ mysql_query("insert into cat_notificaciones(notificacion,idtiponotificacion,idnp,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($notification))."','".$tipo."','".$notificacion_p."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());
	}
}

mysql_close($conexionbase);
mysql_close($conexionestelar);
echo "<script>location.href='../cat_notifications.php'</script>";
?>