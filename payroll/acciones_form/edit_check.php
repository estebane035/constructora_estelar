<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");

$check_in = date($_POST['fecha_in']." ".date("H:i", strtotime($_POST['check_in'])));
$check_out = date($_POST['fecha_out']." ".date("H:i", strtotime($_POST['check_out'])));


mysql_query("UPDATE payroll SET check_in = '".$check_in."', check_out = '".$check_out."', total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, '".$check_in."', '".$check_out."')) WHERE id = ".$_POST["id"],$conexionestelar) or die(mysql_error());
header("location: ../");
?>