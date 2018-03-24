<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;
$body=isset($_POST['body'])?$_POST['body']:NULL;
$important_note=isset($_POST['important'])?$_POST['important']:NULL;

//echo $idnotificacion." ".$body;
if($idnotificacion&&$body)
{ 
	//inhabilita reistros anteriores
	mysql_query("update cuerpo_notificaciones set activo=2 where idnotificacion='".$idnotificacion."' ",$conexionestelar) or die(mysql_error());
	//guarda registro nuevo
	mysql_query("insert into cuerpo_notificaciones(idnotificacion,cuerpo,important_note,fecharegistro,horaregistro,activo) values('".$idnotificacion."','".mysql_real_escape_string($body)."','".mysql_real_escape_string($important_note)."','".date('Y-m-d')."','".date('H:i:s')."','1') ",$conexionestelar) or die(mysql_error());
}

echo "<script>location.href='../cat_notifications.php'</script>";
?>