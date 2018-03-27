<?php
//PROVIENE DE WORKS/INDEX.PHP FUNCTION SHOW_WORKS
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
include("../includes/Mobile_Detect.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idwork=isset($_GET['idwork'])?$_GET['idwork']:NULL;
$_SESSION['idwork']=$idwork;
$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;


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
//OBTIENE NOMBRE DE LA ACTIVIDAD ASIGNADA
	$actividad=mysql_query("select work from cat_works where idwork='".$row_datos_trabajo['actividad']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_actividad=mysql_fetch_assoc($actividad);

//obtiene nombre de la notificacion seleccionada
	$nombre_notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$idnotificacion."' limit 0,1",$conexionestelar) or die(mysql_error());
	$row_nombre_notificacion=mysql_fetch_assoc($nombre_notificacion);

//obtiene campos de la notificacion
	$campos_notificacion=mysql_query("select notificaciones_campos_asignacion.idcampo_not,notificaciones_campos.campo FROM notificaciones_campos_asignacion INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_asignacion.idnotificacion='".$idnotificacion."' and notificaciones_campos_asignacion.idcampo_not!='1' AND notificaciones_campos_asignacion.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
	
//verifica si la notificacion requiere imagenes
	$verifica_imagen=mysql_query("select idnca from notificaciones_campos_asignacion where idnotificacion='".$idnotificacion."' and idcampo_not=1 and activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());


$titulo="PROJECT SELECTED";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" /><title>Show Work Description</title>
<?php 
$detect=new Mobile_Detect();
if($detect->isMobile()||$detect->isTablet())
{?>
<link href="../css/estelar_mobile.css" rel="stylesheet" type="text/css">
<?php }
else
{?>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<?php	
}?>

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
<table>
	<tr><td class="negra">Project</td><td class="valor"><?php echo $row_datos_trabajo['nombre']?></td></tr>
    <tr><td class="negra">Constructor</td><td class="valor"><?php echo $row_datos_constructora['nombre']?></td></tr>
    <tr><td class="negra">Do</td><td class="valor"><?php echo $row_actividad['work']?></td></tr>
</table>
<br>
<div class="separador"></div>
<div id="main_notifications">
<form name="save_works" id="save_works" method="post" action="acciones_form/save_work_form.php">
<table>
	<tr><td class="negra">Notification Selected</td></tr>
</table><br>
<table id="table_notificacions">
	 <td style="font-size:24px"><input type="radio" name="notificacion" value="<?php echo $idnotificacion?>" checked></td>
   	 <td><?php echo $row_nombre_notificacion['notificacion']?></td>
</table>
<br><br>
<table>
	<tr><td class="shownotifications"><a href="<?php echo "show_works_description.php?idwork=".$idwork?>">Show Notifications</a></td></tr>
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
        	<td><input class="cajatexto" type="text" cl name="<?php echo "campo".$row_campos_notificacion['idcampo_not']?>" ></td>
        </tr>
<?php }while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));?>
	</table>
<?php    
}
?>
</form><br><br>
</div><!--div main notifications-->
<div class="separador"></div>
<div class="separador"></div>
<?php if(mysql_num_rows($verifica_imagen))
{?>
	<div id="div_imagen">
	 <form method="post" id="formulario" enctype="multipart/form-data">
	    <span class="negra">Upload Image:</span> <input type="file" name="file" class="btnfile">
	 </form>
	 <div id="respuesta"></div>
	</div>
<?php }?>
<br><br>
<div class="separador"></div>
<table>
	<tr><td><input type="button" class="btnsubmit" value="Send Notification" onClick="save_activity()"></td></tr>
</table>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="scripts/works_ajax.js"></script>
<script type="text/javascript" src="scripts/works.js"></script>
   <script>
    </script>

</html>