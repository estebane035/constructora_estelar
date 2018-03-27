<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idproyecto=isset($_POST['idpto'])?$_POST['idpto']:NULL;

//OBTIENE LISTADO DE NOTIFICACIONES	
	$cat_notificaciones=mysql_query("select idnotificacion,notificacion,idtiponotificacion,idnp from cat_notificaciones where activo=1 order by idnp,idtiponotificacion",$conexionestelar) or die(mysql_error());
	$row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones);
//OBTIENE total de notificaciones del proyecto
	$total_notificaciones=mysql_query("select count(idnot_act) as notificaciones,idnotificacion FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE proyectos_actividades.idproyecto='".$idproyecto."' AND notificaciones_actividades.activo=1 GROUP BY notificaciones_actividades.idnotificacion ",$conexionestelar) or die(mysql_error());
	$row_total_notificaciones=mysql_fetch_assoc($total_notificaciones);
	$a_notificaciones[]="";do
	{ $a_notificaciones[$row_total_notificaciones['idnotificacion']]=$row_total_notificaciones['notificaciones'];
	}while($row_total_notificaciones=mysql_fetch_assoc($total_notificaciones));

//echo $idproyecto;?>
<td>
</td>
<td style="border-bottom:1px solid #333; border-right:1px solid #333">
	<table>
    	<thead><th style="background:#666">Notification</th><th style="background:#666">Total</th></thead>
    	<?php do{
				  if(isset($a_notificaciones[$row_cat_notificaciones['idnotificacion']]))
				  {
			?>
        		<tr>
                	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
                    <td class="cursor" onclick="<?php echo "window.open('notificacion_detail.php?idnot=".$row_cat_notificaciones['idnotificacion']."&idpto=".$idproyecto."','Desglose Notificación','width=800px,height=600,top=150,left=200')"; ?>"><?php echo $a_notificaciones[$row_cat_notificaciones['idnotificacion']]?></td>
                </tr>
        <?php 		}
				}while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));?>
    </table>
    <br />
    <table>
    	<tr><td><a href="<?php echo "notifications_report.php?idpto=".$idproyecto?>" target="_blank">See Report</a></td></tr>
    </table>
</td>

<div style="clear:both"></div>