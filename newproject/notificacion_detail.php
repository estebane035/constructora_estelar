<?php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idproject=isset($_GET['idpto'])?$_GET['idpto']:NULL;
$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;

//echo $idproyecto." ".$idnotificacion;
//Obtiene datos del proyecto
	$datos_proyecto=mysql_query("select nombre,descripcion,fechainicio,fechatermino,idconstructora,status from proyectos where idproyecto='".$idproject."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_proyecto=mysql_fetch_assoc($datos_proyecto);
//obtiene nombre de constructora
	$constructora=mysql_query("select idconstructora,nombre from constructoras where idconstructora='".$row_datos_proyecto['idconstructora']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_constructora=mysql_fetch_assoc($constructora);
//obtiene total de trabajadores del proyecto
	$total_trabajadores=mysql_query("select count(distinct(idtrabajador)) as trabajadores from proyectos_actividades where idproyecto='".$idproject."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_total_trabajadores=mysql_fetch_assoc($total_trabajadores);
//obtiene las notificaciones y activdades
	$notificaciones=mysql_query("select idnot_act,actividad,proyectos_actividades.idtrabajador,notificaciones_actividades.fecharegistro,notificaciones_actividades.horaregistro FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE notificaciones_actividades.idnotificacion='".$idnotificacion."' and proyectos_actividades.idproyecto='".$idproject."' and notificaciones_actividades.activo=1 and proyectos_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);
//obtiene nombre de la notificacion
	$nombre_notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$idnotificacion."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_nombre_notificacion=mysql_fetch_assoc($nombre_notificacion);
//obtiene catalogo de actividaddes
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());	
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));
//obtiene nombres de trabajadores
	$trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_trabajadores=mysql_fetch_assoc($trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_trabajadores['idusuario']]=$row_trabajadores['nombre'];
	}while($row_trabajadores=mysql_fetch_assoc($trabajadores));
?>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
<table>
   	<tr><td class="negra">Name</td><td><?php echo $row_datos_proyecto['nombre']?></td></tr>
    <tr><td class="negra">Description</td><td><?php echo $row_datos_proyecto['descripcion']?></td></tr>        
  	<tr><td class="negra">Contractor</td><td><?php echo $row_constructora['nombre']?></td></tr>
</table>
<table>
   	<tr><td class="negra">Start Date</td><td><?php echo $row_datos_proyecto['fechainicio']?></td><td class="negra">Finish Date</td><td><?php echo $row_datos_proyecto['fechatermino']?></td></tr>
</table><br>
<table>
   	<tr><td class="subtitulo">Notfication:</td><td><?php echo $row_nombre_notificacion['notificacion']?></td></tr>
</table>
<hr style="width:700px;" align="left" color="#222"><br>
<?php 
do
{   //obtiene los campos de la notificacion
	$campos_notificacion=mysql_query("SELECT notificaciones_campos_valores.valor,notificaciones_campos.campo FROM notificaciones_campos_valores INNER JOIN notificaciones_campos_asignacion ON notificaciones_campos_valores.idnca=notificaciones_campos_asignacion.idnca INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_valores.idnot_act='".$row_notificaciones['idnot_act']."' AND notificaciones_campos_valores.activo=1 ",$conexionestelar) or die(mysql_error());
		$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
	?>
	<table>
    	<tr><td class="negra">Work</td><td><?php echo $a_works[$row_notificaciones['actividad']]?></td><td style="width:15px"></td>
            <td class="negra">Worker</td><td><?php echo $a_trabajadores[$row_notificaciones['idtrabajador']]?></td></tr>
    </table>
    <table id="tablapadding5" style="margin-left:30px">    
		    <?php if(mysql_num_rows($campos_notificacion))
		  		  { do {?>
					     <tr><td class="negra"><?php echo $row_campos_notificacion['campo']?></td><td><?php echo $row_campos_notificacion['valor']?></td></tr>
					<?php }while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));
				  }?>                   
	</table>
    <table style="margin-left:30px">
    	<tr>
        	<td class="negra">Date</td><td><?php echo $row_notificaciones['fecharegistro']?></td><td style="width:15px"></td>
            <td class="negra">Hour</td><td><?php echo $row_notificaciones['horaregistro']?></td>
        </tr>
    </table><br />
    <hr style="width:500px;" align="left" color="#666666">
<?php 
}while($row_notificaciones=mysql_fetch_assoc($notificaciones));?>
<?php 
mysql_free_result($datos_proyecto);
mysql_free_result($constructora);
mysql_free_result($total_trabajadores);
mysql_free_result($notificaciones);
mysql_free_result($nombre_notificacion);
mysql_free_result($cat_works);
mysql_free_result($trabajadores);
mysql_close($conexionbase);
mysql_close($conexionestelar);
?>