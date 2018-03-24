<?php //proviene de accionesajax/detalle_notificaciones_ajax.php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
require("../libs/pdf/mpdf/mpdf.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproject=isset($_GET['idpto'])?$_GET['idpto']:NULL;

//obtiene las notificaciones y activdades
	$notificaciones=mysql_query("select notificaciones_actividades.idnotificacion, actividad,idcontratista,proyectos_actividades.idtrabajador, observaciones, location, notificaciones_actividades.fecharegistro, notificaciones_actividades.horaregistro FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE proyectos_actividades.idproyecto='".$idproject."' and notificaciones_actividades.activo=1 and proyectos_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);

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

//echo $idproject;
$html="<main><table>
		<thead><th>Notification</th><th>Sent Date</th><th>Send Name</th><th>Send Mail</th><th>Receives Name</th><th>Comments</th><th>Location</th></thead>
    	<tbody></tbody></table></main>";
/*
		 do{
					$receives_name="";
					$email="";
					if(isset($a_correos[$row_notificaciones['idtrabajador']]))
						{$email=$a_correos[$row_notificaciones['idtrabajador']];}
					if(isset($a_contactos[$row_notificaciones['idcontratista']]))
						{$receives_name=$a_contactos[$row_notificaciones['idcontratista']];}	
			
        $html."<tr>
                	<td>".$a_works[$row_notificaciones['idnotificacion']]."</td>
                    <td>".$row_notificaciones['fecharegistro']."</td>
                    <td>".$a_trabajadores[$row_notificaciones['idtrabajador']]."</td>
                    <td>".$email."</td>
                    <td>".$receives_name."</td>
                    <td>".$row_notificaciones['observaciones']."</td>
                    <td>".$row_notificaciones['location']."</td>
                </tr>";
         }while($row_notificaciones=mysql_fetch_assoc($notificaciones));
$html.="</tbody>
</table>";
*/
$mpdf= new mPDF('c','A4');
$mpdf->writeHTML($html);
$mpdf->Output('NotificationsReport.pdf','I');
?>