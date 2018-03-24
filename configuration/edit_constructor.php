<?php
//EDIT CONSTRUCTOR
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idcn=isset($_GET['idcn'])?$_GET['idcn']:NULL;

//OBTIENE DATOS DE CONTRUCTOR
	$datos_costructor=mysql_query("select nombre,nombre2,telefono,email from constructoras where idconstructora='".$idcn."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_constructor=mysql_fetch_assoc($datos_costructor);

$titulo="EDIT CONSTRUCTOR";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Edit Constructor</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
		<form name="edit_constructor_form" method="post" action="<?php echo "accionesform/constructor_edit_form.php?idcn=".$idcn?>">
		<table>
			<tr><td>Company</td><td><input type="text" name="name" id="name" value="<?php echo $row_datos_constructor['nombre']?>" ></td></tr>
		    <tr><td>Name</td><td><input type="text" name="name2" id="name2" value="<?php echo $row_datos_constructor['nombre2']?>"></td></tr>
		    <tr><td>Telephone</td><td><input type="text" name="telephone" id="telephone" value="<?php echo $row_datos_constructor['telefono']?>"></td></tr>
		    <tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $row_datos_constructor['email']?>"></td></tr>
		</table>
		<br>
		<table>
			<tr><td><input type="button" value="Update Constructor" onClick="edit_new_constructor()"></td></tr>
		</table>
		</form>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    
</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>