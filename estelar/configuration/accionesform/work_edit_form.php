<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idwork=isset($_GET['idwork'])?$_GET['idwork']:NULL;
$work=isset($_POST['name_work'])?$_POST['name_work']:NULL;

//echo $idwork." ".$work;
mysql_query("update cat_works set work='".strtoupper(mysql_real_escape_string($work))."' where idwork='".$idwork."' ",$conexionestelar) or die(mysql_error());

mysql_close($conexionbase);
echo "<script>location.href='../new_work.php'</script>";
?>