<?php //PROVIENE DE WORKS/INDEX.PHP FUNCTION SHOW_WORKS
include("../../conexionbd/conexionbase.php");
include("../../conexionbd/conexionestelar.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idwork=isset($_POST['idwork'])?$_POST['idwork']:NULL;

//echo $idwork;
//OBTIENE DATOS DEL TRABAJO
	$datos_trabajo=mysql_query("select proyectos.nombre,proyectos.idconstructora,actividad FROM proyectos_actividades INNER JOIN proyectos ON proyectos_actividades.idproyecto=proyectos.idproyecto WHERE proyectos_actividades.idpat='".$idwork."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_trabajo=mysql_fetch_assoc($datos_trabajo);

//OBTIENE DATOS DE LA CONTRUCTORA
	$datos_constructora=mysql_query("select nombre from constructoras where idconstructora='".$row_datos_trabajo['idconstructora']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_constructora=mysql_fetch_assoc($datos_constructora);

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

?>
<table>
	<tr><td>Proyecto</td><td><?php echo $row_datos_trabajo['nombre']?></td></tr>
    <tr><td>Constructora</td><td><?php echo $row_datos_constructora['nombre']?></td></tr>
    <tr><td>Actividad</td><td><?php echo $row_datos_trabajo['actividad']?></td></tr>
</table>
<br>
<table>
	<?php do{
			?>
				<tr>
                	<?php if($row_cat_notificaciones['idtiponotificacion']==1&&$a_not_principal[$row_cat_notificaciones['idnp']]>1)
					{ ?>
                        <td></td>
	                	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
					<?php }
					else
					{   if($row_cat_notificaciones['idtiponotificacion']==1)
						{?>
    	                <td><input type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>"></td>
        	        	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
              <?php 	} 
			  			else
						{ ?>
			  			<td></td>
        	        	<td><input type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>"><?php echo $row_cat_notificaciones['notificacion']?></td>
			  <?php		}	}?>
                </tr>
	<?php }while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));?>
</table>
<br>
<table>
	<tr><td>Observaciones</td></tr>
	<tr><td><textarea name="observaciones" id="observaciones"></textarea></td></tr>
</table><br>
<div id="div_imagen">
<form name="saveimage" id="saveimage" method="post" enctype="multipart/form-data">
<table>
	<tr><td><input type="file" name="imagen" id="imagen"></td></tr>
    <tr><td><input type="button" value="Guardar Imagen" onclick="save_image_work(<?php echo $idwork?>)"></td></tr>
</table>
</form>
</div>
<br>
<table>
	<tr><td><input type="button" value="Actualizar Actividad" onClick="save_activity()"></td></tr>
</table>