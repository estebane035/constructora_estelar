<?php
//INDEX NEW PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
$titulo="Projects Payroll";

mysql_select_db($database_conexionestelar,$conexionestelar);
$consulta_trabajadores=mysql_query("SELECT idusuario as id, nombre FROM vista_trabajadores ",$conexionestelar) or die(mysql_error());

$consulta_proyectos=mysql_query("SELECT idproyecto as id, nombre FROM proyectos ",$conexionestelar) or die(mysql_error());
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
			<table>
				<tr>
					<td>
						<label>Cambiar quincena:</label>
						<input type="text" class="fechas" name="fecha_actual" onchange="cambiarQuincena(this.value)" id="fecha_actual" size="15" value="<?php echo date("Y/m/d"); ?>">
					</td>
					<td width="58%"><div align="center"><h2 id="title"></h2><div></td>
					<td>
						<label>Exportar as:</label>
						<select class="form-control" id="tipoTabla" name="tipo_tabla" required onchange="cambiarLink(this.value)">
					        <option value="1">General Payroll</option>
					        <option value="2">Payroll by Project</option>
					        <option value="3">Payroll by Worker</option>
							<option value="4">Expenses per Project</option>
						</select><br><br>
						<select class="form-control hidden" id="select-proyecto" style="float:right;" onchange="cambiarProyecto(this.value)">
							<?php while ($row=mysql_fetch_assoc($consulta_proyectos)) {?>
								<option value="<?php echo $row["id"] ?>"><?php echo $row["nombre"]; ?></option>
							<?php } ?>
						</select>
						<select class="form-control hidden" id="select-trabajador" style="float:right;" onchange="cambiarTrabajador(this.value)">
							<?php while ($row=mysql_fetch_assoc($consulta_trabajadores)) {?>
								<option value="<?php echo $row["id"] ?>"><?php echo $row["nombre"]; ?></option>
							<?php } ?>
						</select><br><br>
						<div align="right">
							<a target="_blank" href="general_payroll.php?date=<?php echo date("Y/m/d"); ?>" id="a-exportar"><button>Export</button></a>
						</div>
					</td>
				</tr>
			</table><br><br>
			<div class="panel panel-default">
			    <div class="panel-body">
			        <table class="table table-striped cell-border" id="table_payroll">
			            <thead>
			                <tr>
			                    <th>ID</th>
			                    <th>Project</th>
			                    <th>Employee</th>
			                    <th>Check In</th>
			                    <th>Check Out</th>
			                    <th>Total Hrs</th>
			                    <th>Actions</th>
			                </tr>
			            </thead>
			            <tbody>
			            </tbody>
			        </table>
			    </div>
			</div>

			<div style="margin-top: 15px;" class="hidden" id="edit">
				<form>
					Edit
				</form>
			</div>

			<div style="margin-top: 15px;" class="hidden" id="delete">
				<h1>¿Are you sure you want to delete the check in and check out?</h1>
				<button id="btn-delete">Delete</button>
			</div>
    </div><!--div central-->
    <div style="clear:both"></div>
	</div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
	<input type="hidden" id="from" value ="">
	<input type="hidden" id="to" value ="">
</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.js"></script>
<!--script type="text/javascript" src="../scripts/datatables.min.js"></script-->
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/tabla.js"></script>
<script>
  $( function() {
    $( ".fechas" ).datepicker();
  } );
  </script>

<?php //include("../scripts/scriptfechas.php");?>
</html>
