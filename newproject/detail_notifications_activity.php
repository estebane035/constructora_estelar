<?php
//DETAIL NOTIFICATION ACTIVITY, PROVIEDNE DE DETAIL PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idactividad=isset($_GET['idpat'])?$_GET['idpat']:NULL;

//obtiene notificaciones totales
	$notificacion=mysql_query("select idnot_act,idnotificacion,fecharegistro,horaregistro,status,fechaprogreso,horaprogreso,fechacerrado,horacerrado from notificaciones_actividades where idpat='".$idactividad."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificacion=mysql_fetch_assoc($notificacion);
	
//obtiene lista de notificaciones
	$lista_notificaciones=mysql_query("select idnotificacion,notificacion from cat_notificaciones",$conexionestelar) or die(mysql_error());
	$row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones);
	$a_notificaciones[]="";
	do
	{ $a_notificaciones[$row_lista_notificaciones['idnotificacion']]=$row_lista_notificaciones['notificacion'];
	}while($row_lista_notificaciones=mysql_fetch_assoc($lista_notificaciones));

//obtiene status de notificaciones
	$status_not=mysql_query("select idstatus,status from notificationes_status ",$conexionestelar) or die(mysql_error());
	$row_status_not=mysql_fetch_assoc($status_not);
	$a_status_not[]="";
	do
	{ $a_status_not[$row_status_not['idstatus']]=$row_status_not['status'];
	}while($row_status_not=mysql_fetch_assoc($status_not));

//obtiene catalogo de trabajos
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));
//obtiene lista trabajadores
	$lista_trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_lista_trabajadores['idusuario']]=$row_lista_trabajadores['nombre'];
	}while($row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores));

//obtien lista de actividaes del proyecto
	$lista_actividades=mysql_query("select idpat,actividad,idtrabajador,status from proyectos_actividades where idpat='".$idactividad."' and activo=1",$conexionestelar) or die(mysql_error());
	$row_lista_actividades=mysql_fetch_assoc($lista_actividades);



?>

<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Detail Notificactions Activity</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
</head>

<body>
<table>
	<tr><td class="titulopagina">Detail Notifications Activity</td></tr>
</table><br><br>
<table>
	<tr><td class="negra">Activity</td><td><?php echo $a_works[$row_lista_actividades['actividad']]?></td></tr>
    <tr><td class="negra">Worker</td><td><?php echo $a_trabajadores[$row_lista_actividades['idtrabajador']]?></td></tr>
</table>
<br><br>
<?php if(mysql_num_rows($notificacion))
{ do{
		$date_status="";
		if($row_notificacion['status']==2){$date_status=$row_notificacion['fechacerrado'];}
		if($row_notificacion['status']==3){$date_status=$row_notificacion['fechaprogreso'];}
		//obtiene valores de campos extra
		$campos_notificacion=mysql_query("SELECT notificaciones_campos_valores.valor,notificaciones_campos.campo FROM notificaciones_campos_valores INNER JOIN notificaciones_campos_asignacion ON notificaciones_campos_valores.idnca=notificaciones_campos_asignacion.idnca INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_valores.idnot_act='".$row_notificacion['idnot_act']."' AND notificaciones_campos_valores.activo=1 ",$conexionestelar) or die(mysql_error());
		$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
	?>
		<hr style="width:600px;" align="left" color="#666666">
        <table id="tablapadding5">
		  	<tr><td class="negra">Notification</td><td><?php echo $a_notificaciones[$row_notificacion['idnotificacion']]?></td></tr>
        </table>
        <table id="tablapadding5" style="margin-left:30px">    
		    <?php if(mysql_num_rows($campos_notificacion))
		  		  { do {?>
					     <tr><td class="negra"><?php echo $row_campos_notificacion['campo']?></td><td><?php echo $row_campos_notificacion['valor']?></td></tr>
					<?php }while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));
				  }?>                   
		</table>
		<table id="tablapadding5" style="margin-left:30px">
		  	<tr><td class="negra">Date</td><td><?php echo $row_notificacion['fecharegistro']?></td><td class="negra">Hour</td><td><?php echo $row_notificacion['horaregistro']?></td></tr>
		</table>
		<table id="tablapadding5" style="margin-left:30px">
			<tr><td class="negra">Status</td><td><?php echo $a_status_not[$row_notificacion['status']]?></td></tr>
		    <tr><td class="negra">Date Status</td><td><?php echo $date_status?></td></tr>
		</table><br>
<?php }while($row_notificacion=mysql_fetch_assoc($notificacion));
}?>
</body>
</html>