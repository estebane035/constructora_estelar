<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
//OBTIENE LISTA DE TRABAJADORES
	$workers=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_workers=mysql_fetch_assoc($workers);

$titulo="WORKER CONTACT";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Worker Contact</title>
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
		<table id="tablapadding5center">
        	<thead><th>Worker</th><th>Telephone</th><th>Email</th><th></th></thead>
            <tbody>
            	<?php $cf="";					 
				do{
					if($cf){$cf="";}else{$cf="style='background:#ddd'";}
					$contacto=mysql_query("select idwcontact,telefono,email from worker_contact where idworker='".$row_workers['idusuario']."' and activo=1 limit 0,1",$conexionestelar) or die(mysql_error());
					$row_contacto=mysql_fetch_assoc($contacto);
					?>
            	<tr <?php echo $cf?>>
                	<td><?php echo $row_workers['nombre']?></td>
                    <td><?php echo $row_contacto['telefono']?></td>
                    <td><?php echo $row_contacto['email']?></td>
                    <td><a href="<?php echo "workers_contact_edit.php?idusr=".$row_workers['idusuario'];?>">Edit</a></td>
            	</tr>
                <?php }while($row_workers=mysql_fetch_assoc($workers));?>
            </tbody>
        </table>
        </table>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
<script type="text/javascript" src="scripts/configuration_ajax.js"></script>
</html>