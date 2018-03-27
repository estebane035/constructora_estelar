<?php
session_start();

include("../conexionbd/conexionbase.php");

$user=isset($_POST['user'])?$_POST['user']:NULL;
$password=isset($_POST['pass'])?$_POST['pass']:NULL;

if($user&&$password)
{	mysql_select_db($database_conexionbase,$conexionbase);
	$cuenta=mysql_query("select idusuario,password from cuentas where usuario='".mysql_real_escape_string($user)."' limit 0,1 ",$conexionbase) or die(mysql_error());
	$row_cuenta=mysql_fetch_assoc($cuenta);
	//si se encuentra una coincidencia de usuario
	if(mysql_num_rows($cuenta))
	{
		//if(password_verify($password,$row_cuenta['password']))
		if($password==$row_cuenta['password'])
                {    $tipo_usuario=mysql_query("select idtipousuario from usuarios where idusuario='".$row_cuenta['idusuario']."' limit 0,1 ",$conexionbase) or die(mysql_error());
			$row_tipo_usuario=mysql_fetch_assoc($tipo_usuario);
			$_SESSION['idusuario']=$row_cuenta['idusuario'];
			$_SESSION['navegador']=$_SERVER['HTTP_USER_AGENT'];
			$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
			$_SESSION['key']=uniqid(mt_rand(),true);
			$_SESSION['uactividad']=$_SERVER['REQUEST_TIME'];
			$_SESSION['tipousuario']=$row_tipo_usuario['idtipousuario'];
			
			mysql_query("insert into control_sesiones(idusuario,ip,navegador,llave,fecharegistro,horaregistro,ultima_actividad,sesioncerrada,activo) values('".$row_cuenta['idusuario']."','".$_SESSION['ip']."','".$_SESSION['navegador']."','".$_SESSION['key']."','".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['uactividad']."','1','1') ",$conexionbase) or die(mysql_error());
			$_SESSION['idsesion']=mysql_insert_id();
			if($row_tipo_usuario['idtipousuario']==1||$row_tipo_usuario['idtipousuario']==4) //administrador //administrativo
			{ echo "<script>location.href='../newproject/'</script>";}
			if($row_tipo_usuario['idtipousuario']==2)											//supervisor
			{echo "<script>location.href='../supervisor/'</script>";}
			if($row_tipo_usuario['idtipousuario']==3)											//trabajador
			{echo "<script>location.href='../works/'</script>";}
			
		}
		//si la contraseña es incorrecta
		else
		{ mysql_query("insert into intentos_sesion(ip,navegador,usuario,password,fecharegistro,horaregistro) values('".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".$user."','".$password."','".date('Y-m.d')."','".date('H:i:s')."')",$conexionbase) or die(mysql_error());
		  mysql_close($conexionbase);
		  echo "<script>location.href='../'</script>";	
		}
	}
	//SI EL USUARIO NO EXISTE
	else
	{ mysql_query("insert into intentos_sesion(ip,navegador,usuario,password,fecharegistro,horaregistro) values('".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_USER_AGENT']."','".$user."','".$password."','".date('Y-m.d')."','".date('H:i:s')."')",$conexionbase) or die(mysql_error());
		mysql_close($conexionbase);
	  echo "<script>location.href='../'</script>";
	}
}
//SI NO RE REGISTRO NI USUARIO NI CNTRASEÑA
else
{ mysql_close($conexionbase);
	echo "<script>location.href='../'</script>";	
}
//echo $user."<br>".$password;
?>