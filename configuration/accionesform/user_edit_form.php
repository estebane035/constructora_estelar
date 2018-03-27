<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionbase,$conexionbase);

$idusr=isset($_GET['idusr'])?$_GET['idusr']:NULL;
$name=isset($_POST['name'])?$_POST['name']:NULL;
$user=isset($_POST['user'])?$_POST['user']:NULL;
$password=isset($_POST['password'])?$_POST['password']:NULL;
$type=isset($_POST['type'])?$_POST['type']:NULL;
$active=isset($_POST['active'])?$_POST['active']:NULL;
$salario=isset($_POST['salario'])?$_POST['salario']:NULL;


//if($password)
//{$password=password_hash($password,PASSWORD_BCRYPT);}
//GUARDA USUARIO
if ($type != '3')
	mysql_query("update usuarios set nombre='".mysql_real_escape_string(strtoupper($name))."',idtipousuario='".$type."',activo='".$active."', pago = NULL where idusuario='".$idusr."'",$conexionbase) or die(mysql_error());
else
	mysql_query("update usuarios set nombre='".mysql_real_escape_string(strtoupper($name))."',idtipousuario='".$type."',activo='".$active."', pago = ".$salario." where idusuario='".$idusr."'",$conexionbase) or die(mysql_error());
$idusuario=mysql_insert_id();
//GUARDA CUENTA
mysql_query("update cuentas set usuario='".mysql_real_escape_string($user)."',password='".mysql_real_escape_string($password)."' where idusuario='".$idusr."' ",$conexionbase) or die(mysql_error());

mysql_close($conexionbase);
echo "<script>location.href='../user_new.php'</script>";
?>