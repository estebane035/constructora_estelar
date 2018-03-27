<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idcn=isset($_GET['idcn'])?$_GET['idcn']:NULL;
$name=isset($_POST['name'])?$_POST['name']:NULL;
$name2=isset($_POST['name2'])?$_POST['name2']:NULL;
$telephone=isset($_POST['telephone'])?$_POST['telephone']:NULL;
$email=isset($_POST['email'])?$_POST['email']:NULL;

if($name)
{
mysql_query("update constructoras set nombre='".strtoupper(mysql_real_escape_string($name))."',nombre2='".strtoupper(mysql_real_escape_string($name2))."',telefono='".mysql_real_escape_string($telephone)."',email='".mysql_real_escape_string($email)."',fecharegistro='".date('Y-m-d')."',horaregistro='".date('H:i:s')."' where idconstructora='".$idcn."'",$conexionestelar) or die(mysql_error());
}
mysql_close($conexionestelar);
echo "<script>location.href='../new_constructor.php'</script>";
?>