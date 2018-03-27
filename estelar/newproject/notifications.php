<?php 
//NOTIFICACIONES REPORT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$sp = isset($_GET['sp'])?$_GET['sp']:NULL ; //bandera para mostrar proyectos abrietos o cerrados

$open = "";
$closed = "";
if($sp)
	{$sp=$sp; $closed ="selected"; } //proyectos cerrados
	else
	{$sp = 1; $open="selected";} //proyectos abiertos

//OBTIENE LISTA DE PROJECTOS
	$proyectos=mysql_query("select idproyecto,nombre from proyectos where activo=1 and status = '".$sp."' order by idproyecto",$conexionestelar) or die(mysql_error());
	$row_proyectos=mysql_fetch_assoc($proyectos);

//OBTIENE LISTADO DE NOTIFICACIONES	
	$cat_notificaciones=mysql_query("select idnotificacion,notificacion,idtiponotificacion,idnp from cat_notificaciones where activo=1 order by idnp,idtiponotificacion",$conexionestelar) or die(mysql_error());
	$row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones);

//obtiene notifaciones por ´rpyecto
	$notificaciones=mysql_query("select count(idnot_act) as notificaciones,idproyecto FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE notificaciones_actividades.activo=1 AND proyectos_actividades.activo=1 GROUP BY proyectos_actividades.idproyecto ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);
	$a_notificaciones[]="";
	do
	{ $a_notificaciones[$row_notificaciones['idproyecto']]=$row_notificaciones['notificaciones'];
	}while($row_notificaciones=mysql_fetch_assoc($notificaciones));


$titulo="NOTIFICATIONS REPORT";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Notifications Report</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
        <table>
        	<tr><td class="negra">Show</td><td><select name="status_proyectos" onChange="cambia_select(this)">
            										<option value="<?php echo "notifications.php"?>" <?php echo $open?>>Open Projects</option>
                                                    <option value="<?php echo "notifications.php?sp=2"?>" <?php echo $closed?>>Closed Projects</option>
                                                </select></td></tr>
        </table><br>
        <table id="tablapadding5center">
        	<thead><th>Project</th><th>Total Notifications</th></thead>	
            <tbody>
			<?php 
			$cf="";
			do
			{  $total="";
				if(isset($a_notificaciones[$row_proyectos['idproyecto']]))
					{$total=$a_notificaciones[$row_proyectos['idproyecto']];}
				
				if($cf){$cf="";}else{$cf="style='background:#ddd'";}
				?>
				<tr <?php echo $cf?>><td style="text-align:left"><?php echo $row_proyectos['nombre']?></td>
                	<td class="cursor" onClick="muestra_detalle_notificacion(<?php echo $row_proyectos['idproyecto']?>)"><?php echo $total?></td>
                </tr>
                <tr id="<?php echo "fila".$row_proyectos['idproyecto']?>"></tr>
			<?php
            }while($row_proyectos=mysql_fetch_assoc($proyectos));?>
        	</tbody>
        </table>
        <br><br><br>
        <div id="detalle_notificaciones">        	
        </div>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    
</body>
<script type="text/javascript" src="js/project.js"></script>
<script type="text/javascript" src="js/project_ajax.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.3.2.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.min.js"></script>
<?php include("../scripts/scriptfechas.php");?>

</html>