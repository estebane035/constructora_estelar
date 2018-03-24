<?php 
mysql_select_db($database_conexionbase,$conexionbase);
//se inicializa la sesion
session_start();
if(!isset($_SESSION['idusuario']))
	{header("location:../includes/close_session/");}
	else
	{ //obtiene datos de los valores de la sesion
		$datos_acceso=mysql_query("select idsesion,ip,navegador,llave,ultima_actividad FROM control_sesiones WHERE idusuario='".$_SESSION['idusuario']."' and idsesion='".$_SESSION['idsesion']."' limit 0,1 ",$conexionbase) or die(header("location:../includes/close_sesion/"));
		$row_datos_acceso=mysql_fetch_assoc($datos_acceso);		
		//actualiza datos de sesion
		mysql_query("update control_sesiones set ultima_actividad='".$_SERVER['REQUEST_TIME']."' where idsesion='".$_SESSION['idsesion']."' ",$conexionbase) or die(mysql_error());
		mysql_free_result($datos_acceso);
		//obtiene nombre de usuario
		$nombre_usuario=mysql_query("select nombre from usuarios where idusuario='".$_SESSION['idusuario']."' limit 0,1 ",$conexionbase) or die(mysql_error());
		$row_nombre_usuario=mysql_fetch_assoc($nombre_usuario);
	}
?>