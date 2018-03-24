<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$email=isset($_POST['email'])?$_POST['email']:NULL;
$idworker=isset($_POST['idworker'])?$_POST['idworker']:NULL;



$valida_registro=mysql_query("select idwcontact from worker_contact where idworker='".$idworker."' and activo=1 limit 0,1",$conexionestelar);
if(mysql_num_rows($valida_registro))
{ mysql_query("update worker_contact set email='".mysql_real_escape_string($email)."' where idworker='".$idworker."' and activo=1 ",$conexionestelar) or die(mysql_error());
}
else
{ mysql_query("insert into worker_contact(idworker,email,activo) values('".$idworker."','".mysql_real_escape_string($email)."','1') ",$conexionestelar) or die(mysql_error());
}

echo $email;
mysql_free_result($valida_registro);
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>