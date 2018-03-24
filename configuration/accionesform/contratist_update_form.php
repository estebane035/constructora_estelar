<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idcontacto=isset($_GET['idcto'])?$_GET['idcto']:NULL;
$name1=isset($_POST['namec'])?$_POST['namec']:NULL;
$email1=isset($_POST['emailc'])?$_POST['emailc']:NULL;
$position1=isset($_POST['positionc'])?$_POST['positionc']:NULL;
$telefono1=isset($_POST['telefonoc'])?$_POST['telefonoc']:NULL;

//echo sizeof($name);
if($name1)
{ 
	//OBTIENE ID DE CONTRATISTS
	$datos_contratista=mysql_query("select idcontratista from contratistas_contactos where idcontacto='".$idcontacto."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_contratista=mysql_fetch_assoc($datos_contratista);	
	mysql_query("update contratistas_contactos set name='".mysql_real_escape_string($name1)."',email='".mysql_real_escape_string($email1)."',position='".mysql_real_escape_string($position1)."',telefono='".mysql_real_escape_string($telefono1)."' where idcontacto='".$idcontacto."' ",$conexionestelar) or die(mysql_error());

}
mysql_close($conexionestelar);
echo "<script>location.href='../new_contratist.php'</script>";

?>