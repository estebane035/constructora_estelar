<?php //PROVIENE DE WORKS/SHOW_WORKS_DESCRIPTION.PHP
include("../../conexionbd/conexionbase.php");
include("../../conexionbd/conexionestelar.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idnotificacion=isset($_POST['idnot'])?$_POST['idnot']:NULL;

//obtiene nombre de la notificacion seleccionada
	$nombre_notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$idnotificacion."' limit 0,1",$conexionestelar) or die(mysql_error());
	$row_nombre_notificacion=mysql_fetch_assoc($nombre_notificacion);

//obtiene campos de la notificacion
	$campos_notificacion=mysql_query("select notificaciones_campos_asignacion.idcampo_not,notificaciones_campos.campo FROM notificaciones_campos_asignacion INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_asignacion.idnotificacion='".$idnotificacion."' and notificaciones_campos_asignacion.idcampo_not!='1' AND notificaciones_campos_asignacion.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
	
//verifica si la notificacion requiere imagenes
	$verifica_imagen=mysql_query("select idnca from notificaciones_campos_asignacion where idnotificacion='".$idnotificacion."' and idcampo_not=1 and activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());
		
?>
<table>
	<tr><td class="negra">Notifications</td></tr>
</table><br>
<table>
	 <td style="font-size:24px"><input type="radio" name="notificacion" value="<?php echo $idnotificacion?>"></td>
   	 <td><?php echo $row_nombre_notificacion['notificacion']?></td>
</table>
<br>
<table>
	<tr><td><input type="button" value="Show Notificactions" onClick="muestra_notificaciones()"></td></tr>
</table>
<br><br><br>
<?php 
if(mysql_num_rows($campos_notificacion))
{ ?>
	<table>
    <?php
	do
	{?>
    	<tr><td class="negra"><?php echo $row_campos_notificacion['campo']?></td>
        	<td><input type="text" name="<?php echo $row_campos_notificacion['campo']?>"></td>
        </tr>
<?php }while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));?>
	</table>
<?php    
}
?>
<br><br>
<?php 
mysql_close($conexionbase);
mysql_close($conexionestelar);?>