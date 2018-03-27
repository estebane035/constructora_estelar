<?php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
//obtiene lista de proyectos actuales
	$lista_proyectos=mysql_query("select idproyecto,nombre,descripcion,fechainicio,fechatermino,idconstructora from proyectos where status=1 and activo=1 order by idproyecto desc",$conexionestelar) or die(mysql_error());
	$row_lista_proyectos=mysql_fetch_assoc($lista_proyectos);

//obtiene notifaciones activas por proyecto
	$notificaciones=mysql_query("select count(idnot_act) as notificaciones,idproyecto FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE notificaciones_actividades.status IN(1,3) AND notificaciones_actividades.activo=1 AND proyectos_actividades.activo=1 GROUP BY proyectos_actividades.idproyecto ",$conexionestelar) or die(mysql_error());
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
		<table id="tablapadding5center">
        	<thead><th>Project</th><th>Notifications to be Addressed</th></thead>
            <tbody>
            	<?php $cf=""; 
					do{  
						 if(isset($a_notificaciones[$row_lista_proyectos['idproyecto']]))
						 {  if($cf){$cf="";}else{$cf="style='background:#ddd'";}
							?>
	                		<tr <?php echo $cf?>>
	                        	<td><?php echo $row_lista_proyectos['nombre']?></td>
    	                        <td class="cursor" onClick="detail_notification(<?php echo $row_lista_proyectos['idproyecto']?>)"><?php echo $a_notificaciones[$row_lista_proyectos['idproyecto']]?></td>
        	                </tr>
                            <tr id="<?php echo "fila".$row_lista_proyectos['idproyecto']?>"></tr>
                <?php    }
					  }while($row_lista_proyectos=mysql_fetch_assoc($lista_proyectos));?>
            </tbody>
        </table>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="scripts/supervisor_ajax.js"></script>

</html>