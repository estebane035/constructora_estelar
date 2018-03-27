<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$work=isset($_POST['name_work'])?$_POST['name_work']:NULL;

mysql_query("insert into cat_works(work,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($work))."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());

mysql_close($conexionbase);
echo "<script>location.href='../new_work.php'</script>";
?>