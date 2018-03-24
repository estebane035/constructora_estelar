<?php
//INDEX NEW USER
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionbase,$conexionbase);

$idusr=isset($_GET['idusr'])?$_GET['idusr']:NULL;
//OBTIENE CUENTAS GUARDADAS
	$cuenta=mysql_query("select usuarios.idusuario,nombre,idtipousuario,usuario,password,usuarios.activo from usuarios INNER JOIN cuentas ON usuarios.idusuario=cuentas.idusuario WHERE usuarios.idusuario='".$idusr."' LIMIT 0,1 ",$conexionbase) or die(mysql_error());
	$row_cuenta=mysql_fetch_assoc($cuenta);
//OBTIENE LISTA DE TIPOS DE USUARIOS
	$lista_tipousuarios=mysql_query("select idtipousuario,tipousuario from tipos_usuarios where activo=1",$conexionbase) or die(mysql_error());
	$row_lista_tipousuarios=mysql_fetch_assoc($lista_tipousuarios);
	do
	{ $a_tipousuario[$row_lista_tipousuarios['idtipousuario']]=$row_lista_tipousuarios['tipousuario'];
	}while($row_lista_tipousuarios=mysql_fetch_assoc($lista_tipousuarios));

$a_activo=array("","ACTIVE","INACTIVE");
$titulo="EDIT USER";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Edit User</title>
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
<form name="edit_user_form" method="post" action="<?php echo "accionesform/user_edit_form.php?idusr=".$idusr?>" >
<table>
	<tr><td>Name</td><td><input type="text" name="name" id="name" value="<?php echo $row_cuenta['nombre']?>"></td></tr>
    <tr><td>User</td><td><input type="text" name="user" id="user" value="<?php echo $row_cuenta['usuario']?>"></td></tr>
    <tr><td>Password</td><td><input type="text" name="password" id="password" value="<?php echo $row_cuenta['password']?>"></td></tr>
    <tr><td>Type</td><td><select name="type" id="type">
    						<option value="0"></option>
                            <?php foreach($a_tipousuario as $key=>$valor)
							{ $seledted="";
								if($key==$row_cuenta['idtipousuario']){$seledted="selected";}?>
                            	<option value="<?php echo $key?>" <?php echo $seledted?>><?php echo $valor?></option>
                            <?php }?>
    					 </select></td></tr>
    <tr><td>Active</td><td><select name="active" id="active">
    										<?php foreach($a_activo as $key=>$valor)
											{ $selected="";
												if($key==$row_cuenta['activo']){$selected="selected";}?>
                                            	<option value="<?php echo $key?>" <?php echo $selected?>><?php echo $valor?></option>
                                            <?php }?>
                                        </select></td></tr>                     
</table>
<br>
<table>
	<tr><td><input type="button" value="Update User" onClick="save_edit_user()"></td></tr>
</table>
</form>
<br>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>