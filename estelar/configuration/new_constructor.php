<?php
//NEW CONSTRUCTOR
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

//OBTIENE LISTA DE CONTRUCNTORAS
	$lista_constructoras=mysql_query("select idconstructora,nombre,nombre2,telefono,email from constructoras",$conexionestelar) or die(mysql_error());
	$row_lista_constructoras=mysql_fetch_assoc($lista_constructoras);

$titulo="NEW CONSTRUCTOR";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>New Constructor</title>
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
<form name="new_constructor_form" method="post" action="accionesform/constructor_new_form.php">
<table>
	<tr><td>Company</td><td><input type="text" name="name" id="name"></td></tr>
    <tr><td>Name</td><td><input type="text" name="name2" id="name2"></td></tr>
    <tr><td>Telephone</td><td><input type="text" name="telephone" id="telephone"></td></tr>
    <tr><td>Email</td><td><input type="text" name="email" id="email"></td></tr>
</table>
<br>
<table>
	<tr><td><input type="button" value="Save Constructor" onClick="save_new_constructor()"></td></tr>
</table>
</form>
<br>
<br>
<?php if(mysql_num_rows($lista_constructoras)){?>
<table id="tablapadding5center">
	<thead><th>Company</th><th>Name</th><th>Telephone</th><th>Email</th><th></th></thead>
    <?php $cf=""; 
		do{ if($cf){$cf="";}else{$cf="style='background:#ddd'";}?>
    		<tr <?php echo $cf?>>
            	<td><?php echo $row_lista_constructoras['nombre']?></td>            	
                <td><?php echo $row_lista_constructoras['nombre2']?></td>
                <td><?php echo $row_lista_constructoras['telefono']?></td>
                <td><?php echo $row_lista_constructoras['email']?></td>
                <td><a href="<?php echo "edit_constructor.php?idcn=".$row_lista_constructoras['idconstructora']?>">Edit</a></td>
            </tr>
    <?php }while($row_lista_constructoras=mysql_fetch_assoc($lista_constructoras));?>
</table>
<?php }?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>