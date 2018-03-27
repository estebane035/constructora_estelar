<?php //INDEX WORKS
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
include("../includes/Mobile_Detect.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

//OBTIENE LISTA DE PROYECTOS DEL TRABAJADOR
	$proyectos_trabajador=mysql_query("select proyectos_actividades.idpat,proyectos.nombre,proyectos.idconstructora,actividad from proyectos_actividades INNER JOIN proyectos ON proyectos_actividades.idproyecto=proyectos.idproyecto WHERE proyectos_actividades.idtrabajador='".$_SESSION['idusuario']."' AND  proyectos.status=1 AND proyectos_actividades.status=1  ",$conexionestelar) or die(mysql_error());
	$row_proyectos_trabajador=mysql_fetch_assoc($proyectos_trabajador);
	
//OBTIENE LISTADO DE CONSTRUCTORAS
	$lista_constructoras=mysql_query("select idconstructora,nombre from constructoras ",$conexionestelar) or die(mysql_error());
	$row_lista_contructoras=mysql_fetch_assoc($lista_constructoras);
	$a_constructoras[]="";
	do
	{ $a_constructoras[$row_lista_contructoras['idconstructora']]=$row_lista_contructoras['nombre'];
	}while($row_lista_contructoras=mysql_fetch_assoc($lista_constructoras));

//OBTIENE LISTA DE ACTIVIDADES
	$lista_actividades=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_lista_actividades=mysql_fetch_assoc($lista_actividades);
	$a_actividades[]="";
	do
	{ $a_actividades[$row_lista_actividades['idwork']]=$row_lista_actividades['work'];
	}while($row_lista_actividades=mysql_fetch_assoc($lista_actividades));

$titulo="ASSIGNED PROJECTS";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Works To Do</title>
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
<?php 
if(mysql_num_rows($proyectos_trabajador))
{	
	do
	{	?>
    	<div>
    	<table onClick="show_works(<?php echo $row_proyectos_trabajador['idpat']?>)"  id="tablapadding5"  style="cursor:pointer;">
        	<tr><td class="negra">Project:</td><td class="valor"><?php echo $row_proyectos_trabajador['nombre']?></td></tr>
            <tr><td class="negra">Constructor</td><td class="valor"><?php echo $a_constructoras[$row_proyectos_trabajador['idconstructora']]?></td></tr>
        	<tr><td class="negra">Work to Do</td><td class="valor"><?php echo $a_actividades[$row_proyectos_trabajador['actividad']]?></td></tr>
        </table>
        </div>
        <hr style="width:300px;" align="left" color="#666666">
        <br />
		<?php
	}while($row_proyectos_trabajador=mysql_fetch_assoc($proyectos_trabajador));
}?>
<br />
<div id="work_description">
</div>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->

</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="scripts/works_ajax.js"></script>
<?php mysql_free_result($proyectos_trabajador);
mysql_free_result($lista_constructoras);?>
</html>