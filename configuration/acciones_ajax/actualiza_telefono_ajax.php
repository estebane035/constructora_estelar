<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$telephone=isset($_POST['telefono'])?$_POST['telefono']:NULL;
$idworker=isset($_POST['idworker'])?$_POST['idworker']:NULL;



$valida_registro=mysql_query("select idwcontact from worker_contact where idworker='".$idworker."' and activo=1 limit 0,1",$conexionestelar);
if(mysql_num_rows($valida_registro))
{ mysql_query("update worker_contact set telefono='".mysql_real_escape_string($telephone)."' where idworker='".$idworker."' and activo=1 ",$conexionestelar) or die(mysql_error());
}
else
{ mysql_query("insert into worker_contact(idworker,telefono,activo) values('".$idworker."','".mysql_real_escape_string($telephone)."','1') ",$conexionestelar) or die(mysql_error());
}

echo $telephone;

mysql_free_result($valida_registro);
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>