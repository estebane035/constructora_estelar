<?php 
//NOTIFICACIONES REPORT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;

//obtiene nombre de la notificacion
	$nombre_notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$idnotificacion."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_nombre_notificacion=mysql_fetch_assoc($nombre_notificacion);

//obtiene lista de putos de notificacion
	$puntos_notificacion=mysql_query("select idcampo_not,campo from notificaciones_campos where activo=1",$conexionestelar) or die(mysql_error());
	$row_puntos_notificacion=mysql_fetch_assoc($puntos_notificacion);		
	
//obtiene los putos que la notificacion tiene asignadas
	$puntos_asignados=mysql_query("select idcampo_not from notificaciones_campos_asignacion where idnotificacion='".$idnotificacion."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_puntos_asignados=mysql_fetch_assoc($puntos_asignados);
	$a_asignados[]="";
	do
	{ $a_asignados[$row_puntos_asignados['idcampo_not']]=$row_puntos_asignados['idcampo_not'];
	}while($row_puntos_asignados=mysql_fetch_assoc($puntos_asignados));
		
$titulo="POINTS NOTIFICATION";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Points Notification</title>
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
		<form name="point_notification" method="post" action="<?php echo "accionesform/new_point_notification_form.php?idnot=".$idnotificacion?>  ">
		<table>	
        	<tr><td class="negra">New Point</td><td><input type="text" name="point" id="point"></td></tr>
        </table><br>
        <table><tr><td><input type="button" value="Save Point" onClick="guardar_punto_notificacion()"></td></tr></table>
        </form>
        <br><br>
        <table><tr><td class="subtitulo"><?php echo $row_nombre_notificacion['notificacion']?></td></tr></table>
		<hr width="400px" align="left" style="color:#000">        
        <?php if(mysql_num_rows($puntos_notificacion))
		{  ?>
        	<form name="puntos_asignados" method="post" action="<?php echo "accionesform/puntos_notificacion_asignados_form.php?idnot=".$idnotificacion?>">
        	<table>
            <?php 
			do{  $checked="";
				 if(isset($a_asignados[$row_puntos_notificacion['idcampo_not']])){$checked="checked";}
					?>
        		<tr>
                	<td><input type="checkbox" name="puntos[]" value="<?php echo $row_puntos_notificacion['idcampo_not']?>" <?php echo $checked?>></td>
                    <td><?php echo $row_puntos_notificacion['campo']?></td>
                </tr>
        <?php }while($row_puntos_notificacion=mysql_fetch_assoc($puntos_notificacion)); ?>
        	</table><br>
            <table>
            	<tr><td><input type="button" value="Update Points Notification" onClick="puntos_asignados.submit()"></td></tr>
            </table>
            </form>
		<?php
		}?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    
</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
<script type="text/javascript" src="scripts/configuration_ajax.js"></script>

</html>