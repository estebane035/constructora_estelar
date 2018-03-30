<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$nombre=isset($_POST['nombreproyecto'])?$_POST['nombreproyecto']:NULL;
$descripcion=isset($_POST['descripcionproyecto'])?$_POST['descripcionproyecto']:NULL;
$constructora=isset($_POST['constructoras'])?$_POST['constructoras']:NULL;
$fechainicio=isset($_POST['fechainicio'])?$_POST['fechainicio']:NULL;
$fechatermino=isset($_POST['fechatermino'])?$_POST['fechatermino']:NULL;
$lat=isset($_POST['lat'])?$_POST['lat']:NULL;
$lng=isset($_POST['lng'])?$_POST['lng']:NULL;
$hora_check_in=isset($_POST['hora_check_in'])?$_POST['hora_check_in']:NULL;
$rango=isset($_POST['rango'])?$_POST['rango']:NULL;

$hora_check_in = date("H:i:s", strtotime($hora_check_in));

//consulta si hay actividades temporales que guardar
	$actividades_temporales=mysql_query("select idpat_temp,actividad,idtrabajador,idcontratista from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."' ",$conexionestelar) or die(mysql_error());
	$row_actividades_temporales=mysql_fetch_assoc($actividades_temporales);

if(mysql_num_rows($actividades_temporales))
{
	//guarda proyecto
	mysql_query("insert into proyectos(nombre,descripcion,fechainicio,fechatermino,idconstructora,status,fecharegistro,horaregistro,activo,latitud,longitud,rango,hora_check_in) values('".mysql_real_escape_string($nombre)."','".mysql_real_escape_string($descripcion)."','".mysql_real_escape_string($fechainicio)."','".mysql_real_escape_string($fechatermino)."','".$constructora."','1','".date('Y-m-d')."','".date('H:i:s')."','1',".mysql_real_escape_string($lat).",".mysql_real_escape_string($lng).",".mysql_real_escape_string($rango).",'".$hora_check_in."')",$conexionestelar) or die(mysql_error());
	$idproyecto=mysql_insert_id();
	
	do
	{
		//Guarda actividad
		mysql_query("insert into proyectos_actividades(idusuario,idproyecto,actividad,idcontratista,idtrabajador,status,fecharegistro,horaregistro,idpat_original,activo) values('".$_SESSION['idusuario']."','".$idproyecto."','".$row_actividades_temporales['actividad']."','".$row_actividades_temporales['idcontratista']."','".$row_actividades_temporales['idtrabajador']."','1','".date('Y-m-d')."','".date('H:i:s')."','0','1')",$conexionestelar) or die(mysql_error());
		$idpat=mysql_insert_id();
	
	    $contactos=mysql_query("select idcontacto from proyectos_contratistas_temporal where idpat_temp='".$row_actividades_temporales['idpat_temp']."' ",$conexionestelar) or die(mysql_error());
		$row_contactos=mysql_fetch_assoc($contactos);
		if(mysql_num_rows($contactos))
		{ do
			{  mysql_query("insert into proyectos_contratistas(idpat,idcontacto,activo) values('".$idpat."','".$row_contactos['idcontacto']."','1')",$conexionestelar) or die(mysql_error());
			}while($row_contactos=mysql_fetch_assoc($contactos));
		}
	
	}while($row_actividades_temporales=mysql_fetch_assoc($actividades_temporales));

//borra registros temporales
	mysql_query("delete from proyectos_contratistas_temporal where idpat_temp in(select idpat_temp from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."') ",$conexionestelar) or die(mysql_error());
	mysql_query("delete from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."'",$conexionestelar) or die(mysql_error());
}
mysql_close($conexionbase);
mysql_close($conexionestelar);
echo "<script>location.href='../'</script>";
?>