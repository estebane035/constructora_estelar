<?php
//INDEX NEW PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
$titulo="Projects Payroll";
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
						<label>Quincena:</label>
		        <select class="form-control" id="quincena" name="quincena" required onchange="">
		            <option value="1">16 al 31 de Marzo 2018</option>
		        </select>
					</td>
					<td width="58%"></td>
					<td>
						<label>Exportar como:</label>
		        <select class="form-control" id="tipoTabla" name="tipo_tabla" required onchange="">
		            <option value="1">General Payroll</option>
		            <option value="2">Payroll by Project</option>
		            <option value="3">Payroll by Worker</option>
								<option value="4">Expenses per Project</option>
		        </select><br><br>
						<div align="right">
							<input type="button" value="Exportar">
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
			                </tr>
			            </thead>
			            <tbody>
			            </tbody>
			        </table>
			    </div>
			</div>
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
<script type="text/javascript" src="js/tabla.js"></script>

<?php //include("../scripts/scriptfechas.php");?>
</html>
