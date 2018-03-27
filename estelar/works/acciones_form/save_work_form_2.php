<?php //PROVIENE DE SHOW WORKS DESCRIPTION
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$notificacion=isset($_POST['notificacion'])?$_POST['notificacion']:NULL;
//$campo1=isset($_POST['campo1'])?$_POST['campo1']:NULL;


//echo $notificacion." ".$observaciones;

//obtiene cuerpo de la notficacion
	$correo_notificacion=mysql_query("select cuerpo,important_note from cuerpo_notificaciones where idnotificacion='".$notificacion."' and activo=1 limit 0,1",$conexionestelar) or die(mysql_error());
	$row_correo_notificacion=mysql_fetch_assoc($correo_notificacion);

//obtiene nombre de la notificacion
	$nombre_notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$notificacion."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_nombre_notificacion=mysql_fetch_assoc($nombre_notificacion);
//obtiene nombre del proyecto
	$datos_proyecto=mysql_query("select nombre FROM proyectos INNER JOIN proyectos_actividades ON proyectos.idproyecto=proyectos_actividades.idproyecto WHERE proyectos_actividades.idpat='".$_SESSION['idwork']."' AND proyectos_actividades.activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_proyecto=mysql_fetch_assoc($datos_proyecto);
//obtiene nombre del trabajo
	$nombre_trabajo=mysql_query("select work from cat_works INNER JOIN proyectos_actividades ON cat_works.idwork=proyectos_actividades.actividad where proyectos_actividades.idpat='".$_SESSION['idwork']."' and proyectos_actividades.activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_nombre_trabajo=mysql_fetch_assoc($nombre_trabajo);	

//obtiene listado de las imagenes temporales
	$imagenes_temporales=mysql_query("select imagen from imagenes_temporales where idusuario='".$_SESSION['idusuario']."' and idsesion='".$_SESSION['idsesion']."' ",$conexionestelar) or die(mysql_error());
	$row_imagenes_temporales=mysql_fetch_assoc($imagenes_temporales);
	$bandera_imagenes=0;
	
//obtiene contactos de contratistas
	$contratistas=mysql_query("select contratistas_contactos.email FROM contratistas_contactos INNER JOIN proyectos_contratistas ON contratistas_contactos.idcontacto=proyectos_contratistas.idcontacto WHERE proyectos_contratistas.idpat='".$_SESSION['idwork']."' and proyectos_contratistas.activo=1",$conexionestelar) or die(mysql_error());
	$row_contratistas=mysql_fetch_assoc($contratistas);

//obtiene nombre del usuario que manda la notificacion
	$usuario_notificacion=mysql_query("select nombre from vista_trabajadores where idusuario='".$_SESSION['idusuario']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_usuario_notificacion=mysql_fetch_assoc($usuario_notificacion);

//actualiza la actividad como atendida por el trabajador
//	mysql_query("update proyectos_actividades set status=3 where idpat='".$_SESSION['idwork']."' ",$conexionestelar) or die(mysql_error());
	
//guarda registro de la actividad
	/*mysql_query("insert into notificaciones_actividades(idpat,idusuario,idnotificacion,idtrabajador,fecharegistro,horaregistro,status,activo) values('".$_SESSION['idwork']."','".$_SESSION['idusuario']."','".$notificacion."','".$_SESSION['idusuario']."','".date('Y-m-d')."','".date('H:i:s')."','1','1') ",$conexionestelar) or die(mysql_error());
	$idnot=mysql_insert_id();
	if(mysql_num_rows($imagenes_temporales))
	{   $bandera_imagenes=1;
		 do
		{ mysql_query("insert into imagenes_notificaciones(idnot_act,imagen,activo) values('".$idnot."','".$row_imagenes_temporales['imagen']."','1')",$conexionestelar) or die(mysql_error());		
			$a_imagenes[]=$row_imagenes_temporales['imagen'];
		}while($row_imagenes_temporales=mysql_fetch_assoc($imagenes_temporales));
		mysql_query("delete from imagenes_temporales where idusuario='".$_SESSION['idusuario']."' and idsesion='".$_SESSION['idsesion']."' ",$conexionestelar) or die(mysql_error());
	}	
    */
$cadena_correo="";
//obtiene campos de la notificacion, quitando las notificaciones con imagenes
	/*$campos_notificacion=mysql_query("select notificaciones_campos_asignacion.idnca,notificaciones_campos_asignacion.idcampo_not,notificaciones_campos.campo FROM notificaciones_campos_asignacion INNER JOIN notificaciones_campos ON notificaciones_campos_asignacion.idcampo_not=notificaciones_campos.idcampo_not WHERE notificaciones_campos_asignacion.idnotificacion='".$notificacion."' and notificaciones_campos_asignacion.idcampo_not!='1' AND notificaciones_campos_asignacion.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_campos_notificacion=mysql_fetch_assoc($campos_notificacion);
	do
	{ $campo=isset($_POST["campo".$row_campos_notificacion['idcampo_not']])?$_POST["campo".$row_campos_notificacion['idcampo_not']]:NULL;
		//echo $row_campos_notificacion['campo']." ".$campo."<br>";
		if($campo)
		{ mysql_query("insert into notificaciones_campos_valores(idnot_act,idnca,valor,activo) values('".$idnot."','".$row_campos_notificacion['idnca']."','".strtoupper(mysql_real_escape_string($campo))."','1') ",$conexionestelar) or die(mysql_error());
		  $cadena_correo.=$row_campos_notificacion['campo'].": ".$campo."\n";
		  $cadena_correo.="<tr><td>".$row_campos_notificacion['campo'].":</td><td>".$campo."</td></tr>";
		}
	}while($row_campos_notificacion=mysql_fetch_assoc($campos_notificacion));
	*/

$subject=$row_datos_proyecto['nombre']." ".$row_nombre_notificacion['notificacion'];
$mensaje="
<html>
<body>
	<p>".$row_correo_notificacion['cuerpo']."</p><br><br>
	<table>
		<tr><td>Project:</td><td>".$row_datos_proyecto['nombre']." ".$_SESSION['idwork']."</td></tr>
		<tr><td>Work:</td><td>".$row_nombre_trabajo['work']."</td></tr>
		".$cadena_correo."
		<tr><td>Sent By:</td><td>".$row_usuario_notificacion['nombre']."</td></tr>	
	</table>
	<br><br>
	<p><span style='font-weight:bold;'>Important: </span>".$row_correo_notificacion['important_note']."</p>
	<br><br>
	";
	if($bandera_imagenes==1)
		{  foreach($a_imagenes as $key=>$valor)
			{  $mensaje.="<p><img src='".$_SERVER["DOCUMENT_ROOT"]."/estelar/images/".$valor."'></p>";
			}			
		};
$mensaje.="<br><br>
	<p>Quality Control Dept.</p>
	<p>Estelar Construction Ltd.</p>
	<p>(780) 782-3677</p>
</body>
</html>";	

echo $subject."<br><br>".$mensaje;
// Cabecera que especifica que es un HMTL
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Cabeceras adicionales
$cabeceras .= 'From:quality@estelarconstruction.com' . "\r\n";

$to="contratista1@estelarconstruction.com";
$to2="contratista2@estelarconstruction.com"; 
// enviamos el correo!
if(mysql_num_rows($contratistas))
{
	do	
	{ //echo $row_contratistas['email']."<br>";
		$to="luis.marcial.a.delgado@gmail.com";
		mail($to, $subject, $mensaje, $cabeceras);		
	}while($row_contratistas=mysql_fetch_assoc($contratistas));
}

mail("quality@estelarconstruction.com", $subject, $mensaje, $cabeceras);	

unset($_SESSION['idwork']);
mysql_close($conexionbase);
mysql_close($conexionestelar);
/*
echo "<script>location.href='../'</script>";	*/
?>