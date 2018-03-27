<?php //proviene de accionesajax/detalle_notificaciones_ajax.php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
require("../libs/pdf/mpdf/mpdf.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproject=isset($_GET['idpto'])?$_GET['idpto']:NULL;

//obtiene las notificaciones y activdades
	$notificaciones=mysql_query("select notificaciones_actividades.idpat,notificaciones_actividades.idnot_act,notificaciones_actividades.idnotificacion, actividad,idcontratista,proyectos_actividades.idtrabajador, notificaciones_actividades.fecharegistro, notificaciones_actividades.horaregistro,notificaciones_actividades.status FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE proyectos_actividades.idproyecto='".$idproject."' and notificaciones_actividades.activo=1 and proyectos_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);

//obtiene status de notificaciones
	$status=mysql_query("select idstatus,status from notificationes_status",$conexionestelar) or die(mysql_error());
	$row_status=mysql_fetch_assoc($status);
	$a_status[]="";
	do
	{ $a_status[$row_status['idstatus']]=$row_status['status'];
	}while($row_status=mysql_fetch_assoc($status));

//obtiene contactos de los contratistas
	$contacto_contratistas=mysql_query("select idcontratista,name from contratistas_contactos ",$conexionestelar) or die(mysql_error());
	$row_contacto_contratistas=mysql_fetch_assoc($contacto_contratistas);
	$a_contactos[]="";
	do
	{  if(isset($a_contactos[$row_contacto_contratistas['idcontratista']]))
		{ $a_contactos[$row_contacto_contratistas['idcontratista']]="<br>".$row_contacto_contratistas['name']; }
		else
		{ $a_contactos[$row_contacto_contratistas['idcontratista']]=$row_contacto_contratistas['name'];}	
	}while($row_contacto_contratistas=mysql_fetch_assoc($contacto_contratistas));
//obtiene contactos de trabajdores
	$correos_trabajadores=mysql_query("select idworker,email from worker_contact ",$conexionestelar) or die(mysql_error());
	$row_correos_trabajadores=mysql_fetch_assoc($correos_trabajadores);
	$a_correos[]="";
	do
	{ $a_correos[$row_correos_trabajadores['idworker']]=$row_correos_trabajadores['email'];
	}while($row_correos_trabajadores=mysql_fetch_assoc($correos_trabajadores));

//obtiene catalogo de actividaddes
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());	
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));
//obtiene nombres de trabajadores
	$trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_trabajadores=mysql_fetch_assoc($trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_trabajadores['idusuario']]=$row_trabajadores['nombre'];
	}while($row_trabajadores=mysql_fetch_assoc($trabajadores));
//Obtiene datos del proyecto
	$datos_proyecto=mysql_query("select nombre,descripcion,fechainicio,fechatermino,idconstructora,status from proyectos where idproyecto='".$idproject."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_proyecto=mysql_fetch_assoc($datos_proyecto);
//obtiene nombre de constructora
	$constructora=mysql_query("select idconstructora,nombre from constructoras where idconstructora='".$row_datos_proyecto['idconstructora']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_constructora=mysql_fetch_assoc($constructora);
//obtiene catalogo de notificaciones
	$cat_notificaciones=mysql_query("select idnotificacion, notificacion from cat_notificaciones",$conexionestelar) or die(mysql_error());
	$row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones);
	$a_cat_notficaciones[]="";
	do
	{ $a_cat_notficaciones[$row_cat_notificaciones['idnotificacion']]=$row_cat_notificaciones['notificacion'];
	}while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));


//echo $idproject;
$html="
    <main>
	<div>
	<table align='right'><tr><td><img src='../logos/estelar.png' style='background-size:contain; background-repeat:no-repeat' width='200px' /></td></tr></table>
     </div>
	 <div style='clear:both'></div>
	 <table align='center'><tr><td class='titulopagina'>Notifications Project Report</td></tr></table>
	 <br>
	  
	  <table>
   		<tr><td class='negra'>Name Project</td><td>".$row_datos_proyecto['nombre']."</td></tr>
	    <tr><td class='negra'>Description</td><td>".$row_datos_proyecto['descripcion']."</td></tr>        
	  	<tr><td class='negra'>Constructora</td><td>".$row_constructora['nombre']."</td></tr>
	</table>
	<table>
	   	<tr><td class='negra'>Start Date</td><td>".$row_datos_proyecto['fechainicio']."</td><td class='negra'>Finish Date</td><td>".$row_datos_proyecto['fechatermino']."</td></tr>
	</table><br>
      <table id='tablapadding5center'>
        <thead><tr><th>Notification</th><th>Sent Date</th><th>Send Name</th><th>Send Mail</th><th>Receives Name</th><th>Comments</th><th>Location</th><th>Status</th></tr></thead>
        <tbody>";
 do{
					$receives_name="";
					$email="";
					if(isset($a_correos[$row_notificaciones['idtrabajador']]))
						{$email=$a_correos[$row_notificaciones['idtrabajador']];}
					if(isset($a_contactos[$row_notificaciones['idcontratista']]))
						{$receives_name=$a_contactos[$row_notificaciones['idcontratista']];}	
					//obtiene si la notificacion tiene location
					$location=mysql_query("SELECT notificaciones_campos_valores.valor FROM notificaciones_campos_valores INNER JOIN notificaciones_campos_asignacion ON notificaciones_campos_valores.idnca=notificaciones_campos_asignacion.idnca INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_valores.idnot_act='".$row_notificaciones['idnot_act']."' AND notificaciones_campos_valores.activo=1 AND notificaciones_campos.idcampo_not=2 ",$conexionestelar) or die(mysql_error());
					$row_location=mysql_fetch_assoc($location);
					//obtiene si la notificacion tiene algun campo extra, lo tomara como comentario
					$comment=mysql_query("SELECT notificaciones_campos_valores.valor FROM notificaciones_campos_valores INNER JOIN notificaciones_campos_asignacion ON notificaciones_campos_valores.idnca=notificaciones_campos_asignacion.idnca INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_valores.idnot_act='".$row_notificaciones['idnot_act']."' AND notificaciones_campos_valores.activo=1 AND notificaciones_campos.idcampo_not NOT IN (1,2) ",$conexionestelar) or die(mysql_error());
					$row_comment=mysql_fetch_assoc($comment);
					//obtiene el contacto del contratista
					$contacto = mysql_query("select contratistas_contactos.name FROM contratistas_contactos INNER JOIN proyectos_contratistas ON contratistas_contactos.idcontacto = proyectos_contratistas.idcontacto WHERE proyectos_contratistas.idpat = '".$row_notificaciones['idpat']."' and proyectos_contratistas.activo = 1 ",$conexionestelar) or die(mysql_error());
					$row_contacto = mysql_fetch_assoc($contacto);
			
        $html.="<tr>
                	<td>".$a_cat_notficaciones[$row_notificaciones['idnotificacion']]."</td>
                    <td>".$row_notificaciones['fecharegistro']."</td>
                    <td>".$a_trabajadores[$row_notificaciones['idtrabajador']]."</td>
                    <td>".$email."</td>
                    <td>".$row_contacto['name']."</td>
                    <td>".$row_comment['valor']."</td>
                    <td>".$row_location['valor']."</td>
					<td>".$a_status[$row_notificaciones['status']]."</td>
                </tr>";
				mysql_free_result($location);
				mysql_free_result($comment);
			}while($row_notificaciones=mysql_fetch_assoc($notificaciones));			
$html.="</tbody>          
      </table>
    </main>
";


$mpdf= new mPDF('c','A4-L');
$css = file_get_contents('../css/estelar.css');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);
$mpdf->Output('NotificationsReport.pdf','I');
?>