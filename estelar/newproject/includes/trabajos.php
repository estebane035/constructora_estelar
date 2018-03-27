<?php
//OBTIENE LISTA DE CONTRATISTAS
	$contratistas=mysql_query("select idcontratista,nombre from contratistas where activo=1",$conexionestelar) or die(mysql_error());
	$row_contratistas=mysql_fetch_assoc($contratistas);
//OBTIENE LISTA DE TRABAJADORES
	$trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores where activo=1",$conexionestelar) or die(mysql_error());
	$row_trabajadores=mysql_fetch_assoc($trabajadores);
//OBTIENE LISTA DE TRABAJOS
	$actividades=mysql_query("select idwork,work from cat_works where activo=1",$conexionestelar) or die(mysql_error());
	$row_actividades=mysql_fetch_assoc($actividades);
?>
<div id="divdescripcion">
	<table>
       	<tr><td class="negra">Work</td></tr>
        <tr><td><select name="descripciontrabajo" id="descripciontrabajo">
        			<option value="0"></option>
                    <?php do{?>
                    	<option value="<?php echo $row_actividades['idwork']?>"><?php echo $row_actividades['work']?></option>
                    <?php }while($row_actividades=mysql_fetch_assoc($actividades));?>
                </select></td></tr>
    </table>
</div>
<div id="divcontratista">
<table>
   	<tr><td class="negra">Contractor</td></tr>
    <tr><td><select name="contratista" id="contratista" onchange="muestra_contactos_contratistas(this)">
       								<option value="0"></option>
                                    <?php do{?>
                                        		<option value="<?php echo $row_contratistas['idcontratista']?>"><?php echo $row_contratistas['nombre']?></option>
                                      <?php }while($row_contratistas=mysql_fetch_assoc($contratistas))?>
                                 </select>
                             </td></tr>
</table><br />
<table id="tabla_contactos_contratista">
</table>
</div>
<div id="divtrabajadores">
  	<table><tr><td class="negra">Workers List</td></tr></table><br>
    <table>
       	<?php do{?>
            		<tr><td><input type="radio" name="trabajador" id="trabajador" value="<?php echo $row_trabajadores['idusuario']?>"></td>
                      	<td><?php echo $row_trabajadores['nombre']?></td></tr>
          <?php }while($row_trabajadores=mysql_fetch_assoc($trabajadores));?>
    </table>
</div>
<div style="clear: both;" ></div>
<table><tr><td><input type="button" value="Add Work" onClick="agregar_trabajo()"></td></tr></table>