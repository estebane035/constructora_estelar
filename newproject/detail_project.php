<?php
//DETAIL PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproject=isset($_GET['idp'])?$_GET['idp']:NULL;

//Obtiene datos del proyecto
	$datos_proyecto=mysql_query("select nombre,descripcion,fechainicio,fechatermino,idconstructora,status,latitud,longitud,rango,hora_check_in from proyectos where idproyecto='".$idproject."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_proyecto=mysql_fetch_assoc($datos_proyecto);
//obtiene nombre de constructora
	$constructora=mysql_query("select idconstructora,nombre from constructoras where idconstructora='".$row_datos_proyecto['idconstructora']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_constructora=mysql_fetch_assoc($constructora);
//obtiene total de trabajadores del proyecto
	$total_trabajadores=mysql_query("select count(distinct(idtrabajador)) as trabajadores from proyectos_actividades where idproyecto='".$idproject."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_total_trabajadores=mysql_fetch_assoc($total_trabajadores);
//obtiene total de actividades del proyecto
	$total_actividades=mysql_query("select count(idpat) as actividades from proyectos_actividades where idproyecto='".$idproject."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_total_actividades=mysql_fetch_assoc($total_actividades);
//obtiene notifaciones del prpyecto
	$total_notificaciones=mysql_query("select count(idnot_act) as notificaciones,idproyecto FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE notificaciones_actividades.activo=1 AND proyectos_actividades.activo=1 AND proyectos_actividades.idproyecto='".$idproject."' ",$conexionestelar) or die(mysql_error());
	$row_total_notificaciones=mysql_fetch_assoc($total_notificaciones);

//obtiene lista contratistas
	$lista_contratistas=mysql_query("select idcontratista,nombre from contratistas ",$conexionestelar) or die(mysql_error());
	$row_lista_constratistas=mysql_fetch_assoc($lista_contratistas);
	$a_contratistas[]="";
	do
	{ $a_contratistas[$row_lista_constratistas['idcontratista']]=$row_lista_constratistas['nombre'];
	}while($row_lista_constratistas=mysql_fetch_assoc($lista_contratistas));

//obtiene lista trabajadores
	$lista_trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_lista_trabajadores['idusuario']]=$row_lista_trabajadores['nombre'];
	}while($row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores));

//obtiene lista de notificaciones
	$lista_notificaciones=mysql_query("select idnotificacion,notificacion from cat_notificaciones",$conexionestelar) or die(mysql_error());
	$row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones);
	$a_notificaciones[]="";
	do
	{ $a_notificaciones[$row_lista_notificaciones['idnotificacion']]=$row_lista_notificaciones['notificacion'];
	}while($row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones));

//obtien lista de actividaes del proyecto
	$lista_actividades=mysql_query("select idpat,actividad,idtrabajador,status from proyectos_actividades where idproyecto='".$idproject."' and activo=1",$conexionestelar) or die(mysql_error());
	$row_lista_actividades=mysql_fetch_assoc($lista_actividades);

//obtiene catalogo de trabajos
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));

//Obtien catalog de statis de poyecto
	$status=mysql_query("select idstatus,status from proyectos_status",$conexionestelar) or die(mysql_error());
	$row_status=mysql_fetch_assoc($status);
	$a_status[]="";
	do
	{ $a_status[$row_status['idstatus']]=$row_status['status'];
	}while($row_status=mysql_fetch_assoc($status));

//obtiene status de notificaciones
	$status_not=mysql_query("select idstatus,status from notificationes_status ",$conexionestelar) or die(mysql_error());
	$row_status_not=mysql_fetch_assoc($status_not);
	$a_status_not[]="";
	do
	{ $a_status_not[$row_status_not['idstatus']]=$row_status_not['status'];
	}while($row_status_not=mysql_fetch_assoc($status_not));

$titulo="PROJECT DETAIL";
?>
<!DOCTYPE>
<html>
<head>
    <style>
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>
<meta charset="utf-8" />
<title>Project Detail</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../libs/datepicker/jquery.timepicker.css" />
</head>

<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>
    <div id="central">
    <table id="tablapadding5">
    	<tr><td class="negra">Name</td><td><?php echo $row_datos_proyecto['nombre']?></td></tr>
        <tr><td class="negra">Description</td><td><?php echo $row_datos_proyecto['descripcion']?></td></tr>
    	<tr><td class="negra">Prime Contractor</td><td><?php echo $row_constructora['nombre']?></td></tr>
    </table>
    <table id="tablapadding5">
    	<tr><td class="negra">Start Date</td><td><?php echo $row_datos_proyecto['fechainicio']?></td><td class="negra">Finish Date</td><td><?php echo $row_datos_proyecto['fechatermino']?></td></tr>
    </table>
    <table id="tablapadding5">
        <tr><td class="negra">Check in hour</td><td><input onchange="actualizarRango(<?php echo $idproject; ?>);" type="text" class="time" name="hora_check_in" id="hora_check_in" value="<?php echo date('g:i A', strtotime($row_datos_proyecto['hora_check_in'])); ?>"></td><td class="negra">Check in range</td><td><input onchange="actualizarRango(<?php echo $idproject; ?>);" id="rango" type="number" name="rango" value="<?php echo $row_datos_proyecto['rango']; ?>"> Meters</td></tr>
    </table>
    <table id="tablapadding5">
    	<tr><td class="negra">Status</td><td><?php echo $a_status[$row_datos_proyecto['status']]?></td></tr>
    </table>
    <table id="tablapadding5">
    	<tr><td class="negra">Workers</td><td><?php echo $row_total_trabajadores['trabajadores']?></td><td class="negra">Activities</td><td><?php echo $row_total_actividades['actividades']?></td></tr>
    </table>
    <table id="tablapadding5">
    	<tr><td class="negra">Notifications</td><td><?php echo $row_total_notificaciones['notificaciones']?></td></tr>
    </table><br>
    <form name="project" method="post" action="<?php echo "acciones_form/cerrar_proyecto.php?idp=".$idproject?>">
    	<table>
        	<tr><td><input type="button" value="CLOSE PROJECT" onClick="project.submit();"></td></tr>
    	</table>
    </form>
    <br>
    <table>
    	<tr><td class="subtitulo">Location (drag to update)</td></tr>
    </table>
    <hr style="width:700px;" align="left" color="#666666"><br>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="mapa" style="height: 400px;width: 700px;"></div>
    <br>
    <?php if(mysql_num_rows($lista_actividades))
	{	?><br>
		<table>
        	<tr><td class="subtitulo">Activities</td></tr>
        </table>
        <hr style="width:700px;" align="left" color="#666666"><br>
	<?php
		do
		{
		//obtiene lista de contratistas
		$contacto_contratista=mysql_query("select name,email,contratistas_contactos.idcontratista from contratistas_contactos INNER JOIN proyectos_contratistas ON contratistas_contactos.idcontacto=proyectos_contratistas.idcontacto where proyectos_contratistas.idpat='".$row_lista_actividades['idpat']."' and contratistas_contactos.activo=1 and proyectos_contratistas.activo=1 ",$conexionestelar) or die(mysql_error());
		$row_contacto_contratista=mysql_fetch_assoc($contacto_contratista);
		//obtiene notificaciones totales
		$notificacion=mysql_query("select idnot_act,idnotificacion,fecharegistro,horaregistro,status,fechaprogreso,horaprogreso,fechacerrado,horacerrado from notificaciones_actividades where idpat='".$row_lista_actividades['idpat']."' and activo=1 ",$conexionestelar) or die(mysql_error());
		$row_notificacion=mysql_fetch_assoc($notificacion);
		//obtiene notificaciones totales
		$notificacion_closed=mysql_query("select idnot_act,idnotificacion,fecharegistro,horaregistro,status,fechaprogreso,horaprogreso,fechacerrado,horacerrado from notificaciones_actividades where idpat='".$row_lista_actividades['idpat']."' AND status=2 AND activo=1 ",$conexionestelar) or die(mysql_error());
		$row_notificacion_closed=mysql_fetch_assoc($notificacion_closed);

		//obtiene comentarios de la notificacion
		$further_comments=mysql_query("select comentario,fecharegistro from comentarios_notificaciones where idnot_act='".$row_notificacion['idnot_act']."' and activo=1 order by fecharegistro desc ",$conexionestelar) or die(mysql_error());
		$row_futher_comments=mysql_fetch_assoc($further_comments);
		?>
		<div class="div_actividades" id="<?php echo "actividad".$row_lista_actividades['idpat']?>">
        	<div id="div_detalle">
            	<table id="tablapadding5">
                	<tr><td class="negra">Description</td><td><?php echo $a_works[$row_lista_actividades['actividad']]?></td>
                    	<td class="negra">Worker</td><td><?php echo $a_trabajadores[$row_lista_actividades['idtrabajador']]?></td></tr>
                    </tr>
                </table><br>
                <?php if(mysql_num_rows($contacto_contratista))
				{?>
                <table id="tablapadding5" style="margin-left:30px">
                	<tr><td class="negra">Contractor</td><td class="negra" colspan="4" style="text-align:center">Contacts</td></tr>
                    <?php $c=0;
						do{ $nombre_contratista="";
							if($c==0){$nombre_contratista=$a_contratistas[$row_contacto_contratista['idcontratista']];}?>
                    		<tr><td><?php echo $nombre_contratista?></td>
                            	<td class="negra">Name</td><td><?php echo $row_contacto_contratista['name']?></td>
                                <td class="negra">Email</td><td><?php echo $row_contacto_contratista['email']?></td></tr>
                	<?php $c++;}while($row_contacto_contratista=mysql_fetch_assoc($contacto_contratista));?>
                </table>
                <?php }?>
                <br>
                <table id="tablapadding5" style="margin-left:30px">
                	<tr><td class="negra">Total Notifications</td><td><?php echo mysql_num_rows($notificacion)?></td>
                    	<td class="negra">Notification Closed</td><td><?php echo mysql_num_rows($notificacion_closed)?></td>
                        <td><input type="button" value="See Detail Notifications" onclick="<?php echo "window.open('detail_notifications_activity.php?idpat=".$row_lista_actividades['idpat']."','Detail Notificacions Activity', 'width=1000,height=600, top=150,left=200');"?>"></td>
                        <?php if($row_lista_actividades['status']==1){?>
                        <td><input type="button" value="Close Activity" onClick="cerrar_actividad(<?php echo mysql_num_rows($notificacion)?>,<?php echo mysql_num_rows($notificacion_closed)?>,<?php echo $row_lista_actividades['idpat']?>)"></td>
                        <?php } ?>
                        <?php if($row_lista_actividades['status']==2){?>
                        <td style="color:green; font-weight:bold">Actvity Closed</td>
                        <?php } ?>
                </table>
                <hr style="width:500px;" align="left" color="#999">
            </div>
            <div style="clear: both;" ></div>
        </div><div style="clear: both; height:30px" ></div>
    <?php
		}while($row_lista_actividades=mysql_fetch_assoc($lista_actividades));
	}?>
        </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
    <input type="hidden" id="lat" value="<?php echo $row_datos_proyecto['latitud']?>">
    <input type="hidden" id="lng" value="<?php echo $row_datos_proyecto['longitud']?>">
    <input type="hidden" id="id_proyecto" value="<?php echo $idproject?>">
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="js/project_ajax.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.js"></script>
<script type="text/javascript" src="js/mapa_project_detail.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-Oq-WHG-knSvcEN8vdKDkWWPfERDV6TA&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript" src="../libs/datepicker/jquery.timepicker.js"></script>
<script>
  $( function() {
    $('#hora_check_in').timepicker();
  } );
  </script>
</html>
