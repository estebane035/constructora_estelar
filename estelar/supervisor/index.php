<?php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
//OBTIENE LISTA DE NOTIFICACIONES
	$notificaciones=mysql_query("select notificaciones_actividades.idnot_act,notificaciones_actividades.idpat, idnotificacion, notificaciones_actividades.fecharegistro,notificaciones_actividades.horaregistro,notificaciones_actividades.status,proyectos_actividades.idproyecto,proyectos_actividades.actividad,proyectos_actividades.idtrabajador,proyectos.nombre,proyectos.idconstructora,proyectos.descripcion FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat INNER JOIN proyectos ON proyectos_actividades.idproyecto=proyectos.idproyecto WHERE notificaciones_actividades.status IN (1,3) AND proyectos_actividades.status in (1,3) and proyectos.status=1 AND notificaciones_actividades.activo=1",$conexionestelar) or die(mysql_error());

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
//obtiene listado de constructoras
	$lista_constructoras=mysql_query("select idconstructora,nombre from constructoras",$conexionestelar) or die(mysql_error());
	$row_lista_constructoras=mysql_fetch_assoc($lista_constructoras);
	$a_constructoras[]="";
	do
	{ $a_constructoras[$row_lista_constructoras['idconstructora']]=$row_lista_constructoras['nombre'];
	}while($row_lista_constructoras=mysql_fetch_assoc($lista_constructoras));

//obtiene catalogo de travbajos(actividades)
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));
//obtiene status de notificaciones	
	$status=mysql_query("select idstatus,status from notificationes_status ",$conexionestelar) or die(mysql_error());
	$row_status=mysql_fetch_assoc($status);
	$a_status[]="";
	do
	{ $a_status[$row_status['idstatus']]=$row_status['status'];
	}while($row_status=mysql_fetch_assoc($status));

$titulo="PORJECTS TO BE REVISED";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Work Supervision</title>
<link href="css/supervisor.css" rel="stylesheet" type="text/css">
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="holder">
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
<?php 

if(mysql_num_rows($notificaciones))
{ do{
		//obtiene valores de campos extra
		$campos_notificacion=mysql_query("SELECT notificaciones_campos_valores.valor,notificaciones_campos.campo FROM notificaciones_campos_valores INNER JOIN notificaciones_campos_asignacion ON notificaciones_campos_valores.idnca=notificaciones_campos_asignacion.idnca INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_valores.idnot_act='".$row_notificaciones['idnot_act']."' AND notificaciones_campos_valores.activo=1 ",$conexionestelar) or die(mysql_error());
		$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
                //obtiene comentarios registrados
		$comentarios=mysql_query("select comentario,fecharegistro from comentarios_notificaciones where idnot_act='".$row_notificaciones['idnot_act']."' and activo=1 order by idcomentario desc ",$conexionestelar) or die(mysql_error());
		$row_comentarios=mysql_fetch_assoc($comentarios);
	?>
	<div id="<?php echo "notificacion".$row_notificaciones['idnot_act'];?>">
		<div id="datosnotificacion">
    	<table>
			<tr><td class="negra">Notification</td><td><?php echo $a_notificaciones[$row_notificaciones['idnotificacion']]?></td></tr>
	        <tr><td class="negra">Work</td><td><?php echo $a_works[$row_notificaciones['actividad']] ?></td></tr>            
			<tr><td class="negra">Worker</td><td><?php echo $a_trabajadores[$row_notificaciones['idtrabajador']]?></td></tr>
            <?php if(mysql_num_rows($campos_notificacion))
			{ do {?>
            		<tr><td class="negra"><?php echo $row_campos_notificacion['campo']?></td><td><?php echo $row_campos_notificacion['valor']?></td></tr>
			<?php }while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));
			}?>
	        <tr><td class="negra">Date</td><td><?php echo $row_notificaciones['fecharegistro']?></td></tr>
	        <tr><td class="negra">Hour</td><td><?php echo $row_notificaciones['horaregistro']?></td></tr>
		</table>
        </div>
        <div id="datosproyecto">
        	<table>
            	<tr><td class="negra">Project</td><td><?php echo $row_notificaciones['nombre']?></td></tr>
                <tr><td class="negra">Constructor</td><td><?php echo $a_constructoras[$row_notificaciones['idconstructora']];?></td></tr>
                <tr><td class="negra">Description</td><td><?php echo $row_notificaciones['descripcion']?></td></tr>   
                <tr><td class="negra">Status</td><td><?php echo $a_status[$row_notificaciones['status']]?></td></tr>             
            </table>
        </div>
        <div style="clear: both;" ></div>
        <div id="imagenesnotificacion">
        	<?php $imagenes=mysql_query("select imagen from imagenes_notificaciones where idnot_act='".$row_notificaciones['idnot_act']."' and activo=1",$conexionestelar) or die(mysql_error());
				  $row_imagenes=mysql_fetch_assoc($imagenes);				
				if(mysql_num_rows($imagenes))
				{?><br>
            <table>
            	<tr><td class="negra">Images</td>
                	<?php do{?>
                    	<td><img src="<?php echo "../images/".$row_imagenes['imagen']?>" width="70" height="70"></td>
                    <?php }while($row_imagenes=mysql_fetch_assoc($imagenes));?>
                </tr>
            </table><br>
            <?php }?>
        </div>
        <div style="clear: both;" ></div>
        <div id="nuevaactividad">
        	<table>
            	<tr><td class="negra">Further Comments</td>
                	<td><input type="text" name="<?php echo "comments".$row_notificaciones['idnot_act']?>" id="<?php echo "comments".$row_notificaciones['idnot_act']?>"></td>
                    <td><input type="button" onClick="actualizar_actividad(<?php echo $row_notificaciones['idnot_act']?>)" value="In Progress"></td>
                    <td><input type="button" onClick="finaliza_actividad(<?php echo $row_notificaciones['idnot_act']?>)" value="Notification Attended"></td></tr>
            </table>
            <?php if(mysql_num_rows($comentarios))
			{?>
            	<p class="negra" style="font-size:13px">Comments</p>
            	<table style="font-size:13px">
                	<?php do{?>
                    		<tr><td><?php echo $row_comentarios['fecharegistro']?>,</td><td style="max-width:400px"><?php echo $row_comentarios['comentario']?></td></tr>
                    <?php }while($row_comentarios=mysql_fetch_assoc($comentarios));?>
                </table>
            <?php }?>
        </div>
    </div>
    <hr style="width:700px;" align="left" color="#666666">
    <div style="clear: both; height:30px" ></div>
<?php mysql_free_result($campos_notificacion);
	}while($row_notificaciones=mysql_fetch_assoc($notificaciones));
}?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="scripts/supervisor_ajax.js"></script>

</html>