<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idusr=isset($_GET['idusr'])?$_GET['idusr']:NULL;
$telephone=isset($_POST['telephone'])?$_POST['telephone']:NULL;
$email=isset($_POST['email'])?$_POST['email']:NULL;
$activo=isset($_POST['active'])?$_POST['active']:NULL;

//echo $idusr." ".$telephone." ".$email." ".$activo;
//valida registro
	$contacto=mysql_query("select idwcontact,telefono,email,activo from worker_contact where idworker='".$idusr."' and activo=1 limit 0,1",$conexionestelar) or die(mysql_error());
	$row_contacto=mysql_fetch_assoc($contacto);
	
if(mysql_num_rows($contacto))
{ mysql_query("update worker_contact set telefono='".$telephone."',email='".$email."',activo='".$activo."' where idwcontact='".$row_contacto['idwcontact']."' ",$conexionestelar) or die(mysql_error());
}
else
{ mysql_query("insert into worker_contact(idworker,telefono,email,activo) values('".$idusr."','".$telephone."','".$email."','".$activo."') ",$conexionestelar) or die(mysql_error());
}	
mysql_close($conexionbase);
mysql_close($conexionestelar);
echo "<script>location.href='../workers_contact.php'</script>";

?>