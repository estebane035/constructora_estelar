<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$point=isset($_POST['point'])?$_POST['point']:NULL;
$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;

if($_SESSION['idusuario'])
{
mysql_query("insert into notificaciones_campos(campo,activo) values('".strtoupper(mysql_real_escape_string($point))."','1')",$conexionestelar) or die(mysql_error());
}
mysql_close($conexionbase);
echo "<script>location.href='../points_notification.php?idnot=".$idnotificacion."'</script>";
?>