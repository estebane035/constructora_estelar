<?php 
//NOTIFICACIONES REPORT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);


//OBTIENE LISTADO DE NOTIFICACIONES	
	$cat_notificaciones=mysql_query("select idnotificacion,notificacion,idtiponotificacion,idnp from cat_notificaciones where activo=1 order by idnp,idtiponotificacion",$conexionestelar) or die(mysql_error());
	$row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones);
//obtiene notificaciones principales	
	$notificaciones_principales=mysql_query("select idnp,count(idnp) as total from cat_notificaciones where activo=1 group by idnp",$conexionestelar) or die(mysql_error());
	$row_notificaciones_principales=mysql_fetch_assoc($notificaciones_principales);
	$a_not_principal[]="";
	do
	{ $a_not_principal[$row_notificaciones_principales['idnp']]=$row_notificaciones_principales['total'];
	}while($row_notificaciones_principales=mysql_fetch_assoc($notificaciones_principales));

//obtiene lista notificaciones
	$lista_notificaciones=mysql_query("select idnotificacion,notificacion from notificaciones_principal",$conexionestelar) or die(mysql_error());
	$row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones);

//ontiene tipo de notificaciones
	$tipo_notificacion=mysql_query("select idtipo_notificacion,tipo from notificaciones_tipos",$conexionestelar) or die(mysql_error());
	$row_tipo_notificacion=mysql_fetch_assoc($tipo_notificacion);
	
	
$titulo="NOTIFICATIONS LIST";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Notifications List</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
		<form name="cat_notifications" method="post" action="accionesform/save_new_notification.php">
        	<table>
            	<tr><td class="negra">New Notification</td><td><input type="text" name="notification" id="notification"></td></tr>
                <tr><td class="negra">Type</td><td><select name="tipo" id="tipo" onChange="muestra_notificaciones(this)">
                										<option value="0"></option>
                                                        <?php do{?>
                                                        	<option value="<?php echo $row_tipo_notificacion['idtipo_notificacion']?>"><?php echo $row_tipo_notificacion['tipo']?></option>
                                                        <?php }while($row_tipo_notificacion=mysql_fetch_assoc($tipo_notificacion));?>
                								   </select></td></tr>
                <tr style="display:none" id="filanotificaciones"><td class="negra">Main Notification</td><td><select name="notificacion_p" id="notificacion_p">
                													<?php do{?>
                                                                    <option value="<?php echo $row_lista_notificaciones['idnotificacion']?>"><?php echo $row_lista_notificaciones['notificacion']?></option>
                                                                    <?php }while($row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones));?>
                                                                </select></td></tr>                                   
            </table><br>
            <table>
            	<tr><td><input type="button" value="Save Notification" onClick="save_new_notification()"></td></tr>
            </table>
        </form>
        <br><br>
        <table id="tablapadding5center">
        	<thead><th>Notification</th><th></th><th></th></thead>
            <tbody>
	<?php $cf=""; 
		do{ if($cf){$cf="";}else{$cf="style='background:#ddd'";}
			?>
				<tr <?php echo $cf?>>
        	       <td style="text-align:left"><?php echo $row_cat_notificaciones['notificacion']?></td>
                   <td><a href="<?php echo "points_notification.php?idnot=".$row_cat_notificaciones['idnotificacion']?>">Points Notification</a></td>
                   <td><a href="<?php echo "body_notification.php?idnot=".$row_cat_notificaciones['idnotificacion']?>">Body Mail Notification</a></td>
	           </tr>
	<?php }while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));?>
    	</tbody>
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