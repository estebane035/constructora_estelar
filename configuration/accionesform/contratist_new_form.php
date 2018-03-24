<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$contractor=isset($_POST['name_contractor'])?$_POST['name_contractor']:NULL;
$name=isset($_POST['name'])?$_POST['name']:NULL;
$email=isset($_POST['email'])?$_POST['email']:NULL;
$position=isset($_POST['position'])?$_POST['position']:NULL;
$telefono=isset($_POST['telefono'])?$_POST['telefono']:NULL;

$contractor_new=isset($_POST['contractor_new'])?$_POST['contractor_new']:NULL;
echo $contractor_new;
if($contractor)
{
	if($contractor=="n")
	{
		mysql_query("insert into contratistas(nombre,fecharegistro,horaregistro,activo) values('".strtoupper(mysql_real_escape_string($contractor_new))."','".date('Y-m-d')."','".date('H:i:s')."','1')",$conexionestelar) or die(mysql_error());
		$idcontractor=mysql_insert_id();
	}
	else
		{$idcontractor=$contractor;}
 //echo $valor." ".$email[$key]." ".$position[$key]."<br>";
		mysql_query("insert into contratistas_contactos(idcontratista,name,email,position,telefono,activo) values('".$idcontractor."','".mysql_real_escape_string($name)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($position)."','".mysql_real_escape_string($telefono)."','1')",$conexionestelar) or die(mysql_error());
	

}
mysql_close($conexionestelar);
echo "<script>location.href='../new_contratist.php'</script>";
?>