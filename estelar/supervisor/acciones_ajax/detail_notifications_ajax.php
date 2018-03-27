<?php //PROVIENE DE SUPERVISOR/CURRENT_PROJECTS.PHP
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproyecto=isset($_POST['idproject'])?$_POST['idproject']:NULL;

//OBTIENE LISTA DE NOTIFICACIONES
	$notificaciones=mysql_query("select notificaciones_actividades.idnot_act,notificaciones_actividades.idpat, idnotificacion, notificaciones_actividades.fecharegistro,notificaciones_actividades.horaregistro,notificaciones_actividades.status,proyectos_actividades.idproyecto,proyectos_actividades.actividad,proyectos_actividades.idtrabajador,proyectos.nombre,proyectos.idconstructora,proyectos.descripcion FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat INNER JOIN proyectos ON proyectos_actividades.idproyecto=proyectos.idproyecto WHERE proyectos_actividades.idproyecto='".$idproyecto."' AND notificaciones_actividades.status IN (1,3) AND proyectos_actividades.status=1 and proyectos.status=1 AND notificaciones_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);

//obtiene listado de trabajadores
	$lista_trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores ",$conexionestelar) or die(mysql_error());
	$row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_lista_trabajadores['idusuario']]=$row_lista_trabajadores['nombre'];
	}while($row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores));
//obtiene listado de notificaciones
	$lista_notificaciones=mysql_query("select idnotificacion,notificacion from cat_notificaciones",$conexionestelar) or die(mysql_error());
	$row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones);
	$a_notificaciones[]="";
	do
	{	$a_notificaciones[$row_lista_notificaciones['idnotificacion']]=$row_lista_notificaciones['notificacion'];
	}while($row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones));

//obtiene status de notificaciones	
	$status=mysql_query("select idstatus,status from notificationes_status ",$conexionestelar) or die(mysql_error());
	$row_status=mysql_fetch_assoc($status);
	$a_status[]="";
	do
	{ $a_status[$row_status['idstatus']]=$row_status['status'];
	}while($row_status=mysql_fetch_assoc($status));

?>
<td>
</td>
<td>
	<table>
    	<thead><th>Notification</th><th>Worker</th><th>Date Send</th><th>Status</th></thead>
        <tbody>
        	<?php 
			do{?>
            	<tr>
                	<td><?php echo $a_notificaciones[$row_notificaciones['idnotificacion']]?></td>
                    <td><?php echo $a_trabajadores[$row_notificaciones['idtrabajador']]?></td>
                    <td><?php echo $row_notificaciones['fecharegistro']?></td>
                    <td><?php echo $a_status[$row_notificaciones['status']]?></td>
                </tr>
            <?php }while($row_notificaciones=mysql_fetch_assoc($notificaciones));?>
        </tbody>
    </table>
</td>
<?php
mysql_free_result($notificaciones);
mysql_free_result($lista_trabajadores);
mysql_free_result($lista_notificaciones);
mysql_free_result($status);
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>
