<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionbase,$conexionbase);

$name=isset($_POST['name'])?$_POST['name']:NULL;
$user=isset($_POST['user'])?$_POST['user']:NULL;
$password=isset($_POST['password'])?$_POST['password']:NULL;
$type=isset($_POST['type'])?$_POST['type']:NULL;
$salario=isset($_POST['salario'])?$_POST['salario']:NULL;
$salario = $type==3?$salario:"NULL";

//if($password)
//{$password=password_hash($password,PASSWORD_BCRYPT);}
//GUARDA USUARIO
mysql_query("insert into usuarios(nombre,idtipousuario,fecharegistro,horaregistro,activo,pago) values('".strtoupper(mysql_real_escape_string($name))."','".$type."','".date('Y-m-d')."','".date('H:i:s')."','1',".$salario.")",$conexionbase) or die(mysql_error());
$idusuario=mysql_insert_id();
//GUARDA CUENTA
mysql_query("insert into cuentas(usuario,password,idusuario,fecharegistro,horaregistro,activo) values('".mysql_real_escape_string($user)."','".mysql_real_escape_string($password)."','".$idusuario."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionbase) or die(mysql_error());

mysql_close($conexionbase);
echo "<script>location.href='../user_new.php'</script>";
?>