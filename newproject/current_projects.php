<?php
//CURRENT PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

//obtiene lista de proyectos actuales
	$lista_proyectos=mysql_query("select idproyecto,nombre,descripcion,fechainicio,fechatermino,idconstructora from proyectos where status=1 and activo=1 order by idproyecto desc",$conexionestelar) or die(mysql_error());
	$row_lista_proyectos=mysql_fetch_assoc($lista_proyectos);
//obtiene lista de constructoras
	$lista_constructoras=mysql_query("select idconstructora,nombre from constructoras",$conexionestelar) or die(mysql_error());
	$row_lista_constructoras=mysql_fetch_assoc($lista_constructoras);
	$a_constructoras[]="";
	do
	{ $a_constructoras[$row_lista_constructoras['idconstructora']]=$row_lista_constructoras['nombre'];
	}while($row_lista_constructoras=mysql_fetch_assoc($lista_constructoras));

//obtiene lista de trabaadores
	$nombres_trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_nombres_trabajadores=mysql_fetch_assoc($nombres_trabajadores);
	$a_n_trabajadores[]="";
	do
	{ $a_n_trabajadores[$row_nombres_trabajadores['idusuario']]=$row_nombres_trabajadores['nombre'];
	}while($row_nombres_trabajadores=mysql_fetch_assoc($nombres_trabajadores));

//obtiene total los trabajadores asigndos a cada proyecto
	$trabajadores=mysql_query("select distinct(idtrabajador) as trabajador,idproyecto from proyectos_actividades where activo=1 ",$conexionestelar) or die(mysql_error());
	$row_trabajadores=mysql_fetch_assoc($trabajadores);
	$a_trabajadores[]="";
	if(mysql_num_rows($trabajadores))
	{
		do
		{   if(isset($a_trabajadores[$row_trabajadores['idproyecto']]))
			{$a_trabajadores[$row_trabajadores['idproyecto']].=" - ".$a_n_trabajadores[$row_trabajadores['trabajador']];}
			else
			{$a_trabajadores[$row_trabajadores['idproyecto']]=$a_n_trabajadores[$row_trabajadores['trabajador']];}
		}while($row_trabajadores=mysql_fetch_assoc($trabajadores));
	}
//obtiene notifaciones por ´rpyecto
	$notificaciones=mysql_query("select count(idnot_act) as notificaciones,idproyecto FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE notificaciones_actividades.activo=1 AND proyectos_actividades.activo=1 GROUP BY proyectos_actividades.idproyecto ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);
	$a_notificaciones[]="";
	do
	{ $a_notificaciones[$row_notificaciones['idproyecto']]=$row_notificaciones['notificaciones'];
	}while($row_notificaciones=mysql_fetch_assoc($notificaciones));

$titulo="CURRENT PROJECTS";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Current Projects</title>
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
	<?php if(mysql_num_rows($lista_proyectos))
	{?>
    <table id="tablapadding5center">
    	<thead><th>Project</th><th>Description</th><th>Start Date</th><th>Finish Date</th><th>Prime Contractor</th><th>Workers</th><th>Notifications</th><th></th></thead>
        <tbody>
        	<?php do{
						$t_trabajadores="";
						if(isset($a_trabajadores[$row_lista_proyectos['idproyecto']]))
							{$t_trabajadores=$a_trabajadores[$row_lista_proyectos['idproyecto']];}
						$t_notificaciones="";
						if(isset($a_notificaciones[$row_lista_proyectos['idproyecto']]))
							{$t_notificaciones=$a_notificaciones[$row_lista_proyectos['idproyecto']];}
				?>
        	<tr>
            	<td><?php echo $row_lista_proyectos['nombre']?></td>
                <td><?php echo $row_lista_proyectos['descripcion']?></td>
                <td><?php echo $row_lista_proyectos['fechainicio']?></td>
                <td><?php echo $row_lista_proyectos['fechatermino']?></td>
                <td><?php echo $a_constructoras[$row_lista_proyectos['idconstructora']]?></td>
                <td><?php echo $t_trabajadores?></td>
                <td><?php echo $t_notificaciones?></td>
                <td><a href="<?php echo "detail_project.php?idp=".$row_lista_proyectos['idproyecto']?>">See Detail</a></td>
            </tr>
            <?php }while($row_lista_proyectos=mysql_fetch_assoc($lista_proyectos));?>
        </tbody>
    </table>
    <?php }?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
</html>
