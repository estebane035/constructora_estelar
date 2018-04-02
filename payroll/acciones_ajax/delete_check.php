<?php 
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
mysql_select_db($database_conexionestelar,$conexionestelar);
$id = $_POST['id'];
if (!is_null($id) && $id > 0)
{
	mysql_query("DELETE FROM payroll where id = ".$id,$conexionestelar) or die(mysql_error());
	echo "1";
}
else
echo "Invalid key";
?>