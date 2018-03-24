<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$name=isset($_POST['name'])?$_POST['name']:NULL;
$name2=isset($_POST['name2'])?$_POST['name2']:NULL;
$telephone=isset($_POST['telephone'])?$_POST['telephone']:NULL;
$email=isset($_POST['email'])?$_POST['email']:NULL;

if($name)
{
mysql_query("insert into constructoras(nombre,nombre2,telefono,email,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($name))."','".strtoupper(mysql_real_escape_string($name2))."','".mysql_real_escape_string($telephone)."','".mysql_real_escape_string($email)."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());
}
mysql_close($conexionestelar);
echo "<script>location.href='../new_constructor.php'</script>";
?>