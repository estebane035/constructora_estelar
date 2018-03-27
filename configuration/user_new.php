<?php
//INDEX NEW USER
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionbase,$conexionbase);

//OBTIENE LISTA DE TIPOS DE USUARIOS
	$lista_tipousuarios=mysql_query("select idtipousuario,tipousuario from tipos_usuarios where activo=1",$conexionbase) or die(mysql_error());
	$row_lista_tipousuarios=mysql_fetch_assoc($lista_tipousuarios);
	do
	{ $a_tipousuario[$row_lista_tipousuarios['idtipousuario']]=$row_lista_tipousuarios['tipousuario'];
	}while($row_lista_tipousuarios=mysql_fetch_assoc($lista_tipousuarios));

//OBTIENE CUENTAS GUARDADAS
	$cuentas=mysql_query("select usuarios.idusuario,nombre,idtipousuario,usuario,password from usuarios INNER JOIN cuentas ON usuarios.idusuario=cuentas.idusuario where usuarios.activo=1 and cuentas.activo=1 ",$conexionbase) or die(mysql_error());
	$row_cuentas=mysql_fetch_assoc($cuentas);

$titulo="NEW USER";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>New User</title>
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
<form name="new_user_form" method="post" action="accionesform/user_new_form.php">
<table>
	<tr><td>Name</td><td><input type="text" name="name" id="name"></td></tr>
    <tr><td>User</td><td><input type="text" name="user" id="user"></td></tr>
    <tr><td>Password</td><td><input type="text" name="password" id="password"></td></tr>
    <tr><td>Type</td><td><select name="type" id="type" onchange="cambioTipo(this.value)">
    						<option value="0"></option>
                            <?php foreach($a_tipousuario as $key=>$valor)
							{?>
                            	<option value="<?php echo $key?>"><?php echo $valor?></option>
                            <?php }?>
    					 </select></td></tr>

    <tr style="display: none;" id="tr-salario"><td>Salary</td><td><input type="number" name="salario" id="salario"></td></tr>
</table>
<br>
<table>
	<tr><td><input type="button" value="Save User" onClick="save_new_user()"></td></tr>
</table>
</form>
<br>
<br>
<?php if(mysql_num_rows($cuentas)){?>
<table id="tablapadding5center">
	<thead><th>Name</th><th>User</th><th>Password</th><th>Type</th><th></th></thead>
    <?php $cf=""; 
		do{ if($cf){$cf="";}else{$cf="style='background:#ddd'";}?>
    		<tr <?php echo $cf?>><td><?php echo $row_cuentas['nombre']?></td>
            	<td><?php echo $row_cuentas['usuario']?></td>
                <td><?php echo $row_cuentas['password']?></td>
                <td><?php echo $a_tipousuario[$row_cuentas['idtipousuario']]?></td>
                <td><a href="<?php echo "user_edit.php?idusr=".$row_cuentas['idusuario']?>">Edit</a></td>
            </tr>
    <?php }while($row_cuentas=mysql_fetch_assoc($cuentas));?>
</table>
<?php }?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
<script type="text/javascript" src="scripts/users.js"></script>
</html>