<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idusr=isset($_GET['idusr'])?$_GET['idusr']:NULL;
//obtiene datos del usuario
	$datos_usr=mysql_query("select nombre from vista_trabajadores where idusuario='".$idusr."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_usr=mysql_fetch_assoc($datos_usr);
//obtiene los datos de contacto	
	$contacto=mysql_query("select idwcontact,telefono,email,activo from worker_contact where idworker='".$idusr."' and activo=1 limit 0,1",$conexionestelar) or die(mysql_error());
	$row_contacto=mysql_fetch_assoc($contacto);

$a_activo=array("","ACTIVE","INACTIVE");
$titulo="WORKER CONTACT EDIT";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Worker Contact Edit</title>
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
    	<form name="contact_user" method="post" action="<?php echo "accionesform/worker_contact_form.php?idusr=".$idusr?>" >
        <table>
        	<tr><td>Worker</td><td><?php echo $row_datos_usr['nombre']?></td></tr>
            <tr><td>Telephone</td><td><input type="text" name="telephone" id="telephone" value="<?php echo $row_contacto['telefono']?>"></td></tr>
            <tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $row_contacto['email']?>"></td></tr>
            <tr><td>Active</td><td><select name="active" id="active">
    										<?php foreach($a_activo as $key=>$valor)
											{ $selected="";
												if($key==$row_contacto['activo']){$selected="selected";}?>
                                            	<option value="<?php echo $key?>" <?php echo $selected?>><?php echo $valor?></option>
                                            <?php }?>
                                        </select></td></tr> 
        </table><br>
        <table>
        	<tr><td><input type="button" value="Update Contact" onClick="worker_contact_edit()"></td></tr>
        </table>
        </form>    
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
<script type="text/javascript" src="scripts/configuration_ajax.js"></script>
</html>