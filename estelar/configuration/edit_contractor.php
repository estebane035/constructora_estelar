<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idcontacto=isset($_GET['idcto'])?$_GET['idcto']:NULL;
//OBTIENE DATOS DE CONTRATISTA
	$datos_contratista=mysql_query("select contratistas_contactos.name, email,position,telefono,nombre from contratistas_contactos INNER JOIN contratistas ON contratistas_contactos.idcontratista=contratistas.idcontratista WHERE idcontacto='".$idcontacto."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_contratista=mysql_fetch_assoc($datos_contratista);

$titulo="EDIT CONTRACTOR";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Edit Contratist</title>
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
<form name="update_contratist_form" method="post" action=" <?php echo "accionesform/contratist_update_form.php?idcto=".$idcontacto?> ">
<table>
	<tr><td class="negra">Contractor</td><td><?php echo $row_datos_contratista['nombre']?></td></tr>
</table>
<table>
	<tr><td>Name</td><td><input type="text" name="namec" id="namec" value="<?php echo $row_datos_contratista['name']?>"></td></tr>
	<tr><td>Email</td><td><input type="text" name="emailc" id="emailc" value="<?php echo $row_datos_contratista['email']?>"></td></tr>
	<tr><td>Position</td><td><input type="text" name="positionc" id="positionc" value="<?php echo $row_datos_contratista['position']?>"></td></tr>
	<tr><td>Telefono</td><td><input type="text" name="telefonoc" id="telefonoc" value="<?php echo $row_datos_contratista['telefono']?>"></td></tr>            
</table>
<br><br>
<table>
	<tr><td><input type="button" value="Update Contact Contractor" onClick="save_update_contratist()"></td></tr>
</table>
</form>
<br>
<br>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>