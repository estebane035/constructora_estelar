<?php
if (!isset($_GET["id"]))
	header("location: index.php");
//INDEX NEW PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
$titulo="Edit Check";
$id = $_GET["id"];

mysql_select_db($database_conexionestelar,$conexionestelar);
$consulta=mysql_query("SELECT p.id, DATE(p.check_in) as fecha_in, DATE(p.check_out) as fecha_out, TIME(p.check_in) as hora_in, TIME(p.check_out) as hora_out, pr.nombre as nombre_proyecto, v.nombre as nombre_usuario from payroll as p INNER JOIN vista_trabajadores as v ON v.idusuario = p.id_trabajador INNER JOIN proyectos as pr ON pr.idproyecto = p.id_proyecto  where id = ".$id,$conexionestelar) or die(mysql_error());
$row=mysql_fetch_assoc($consulta);
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Payroll</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css">
<!--link href="../css/datatables.min.css" rel="stylesheet" type="text/css"-->
<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../libs/datepicker/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="../libs/datepicker/bootstrap-datepicker.css" />
</head>

<body>
<div id="holder">
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>
    <div id="central" style="margin-right: 40;">
    	<form name="edit_user_form" method="POST" action="acciones_form/edit_check.php">
			<table>
				<tr><td>Project</td><td><input type="text" name="project" id="project" disabled="" value="<?php echo $row['nombre_proyecto'] ?>"></td></tr>
			    <tr><td>User</td><td><input type="text" name="user" id="user" disabled="" value="<?php echo $row['nombre_usuario'] ?>"></td></tr>
			    <tr><td>Check in</td><td><input type="text" class="time" name="check_in" id="check_in" size="9" value="<?php echo $row['hora_in'] ?>"></td></tr>
        		<tr><td>Check out</td><td><input type="text" class="time" name="check_out" id="check_out" size="9" value="<?php echo  $row['hora_out'] ?>"></td></tr>
			</table>
			<br>
			<table>
				<tr><td><input type="submit" value="Update check"></td></tr>
			</table>
			<input type="hidden" name="fecha_in" value="<?php echo  $row['fecha_in'] ?>">
			<input type="hidden" name="fecha_out" value="<?php echo  $row['fecha_out'] ?>">
			<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
		</form>
    </div><!--div central-->
    <div style="clear:both"></div>
	</div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.js"></script>
<!--script type="text/javascript" src="../scripts/datatables.min.js"></script-->
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="../libs/datepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="../libs/datepicker/bootstrap-datepicker.js"></script>
<script>
  $( function() {
    $('#check_in').timepicker();
    $('#check_out').timepicker();
  } );
  </script>
</html>
