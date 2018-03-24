<?php //PROVIENE DE WORKS/SHOW_WORKS_DESCRIPTION.PHP //acciones_ajax/notificacion_seleccionada.php
include("../../conexionbd/conexionbase.php");
include("../../conexionbd/conexionestelar.php");

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

?>
<table>
	<tr><td class="negra">Notifications</td></tr>
</table><br>
<table id="table_notificacions">
	<?php do{
			?>
				<tr id="<?php echo "fila".$row_cat_notificaciones['idnotificacion'];?>">
                	<?php if($row_cat_notificaciones['idtiponotificacion']==1&&$a_not_principal[$row_cat_notificaciones['idnp']]>1)
					{ ?>
                        <td></td>
	                	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
					<?php }
					else
					{   if($row_cat_notificaciones['idtiponotificacion']==1) //si la notificacion es principal
						{?>
    	                <td><input type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>" onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>)"></td>
        	        	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
              <?php 	} 
			  			else // si la notificacion es secundaria, pone celda vacia a la izquierda
						{ ?>
			  			<td></td>
        	        	<td><input type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>" onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>)"><?php echo $row_cat_notificaciones['notificacion']?></td>
			  <?php		}	}?>
                </tr>
	<?php }while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));?>
</table>

<?php 
mysql_close($conexionbase);
mysql_close($conexionestelar);?>