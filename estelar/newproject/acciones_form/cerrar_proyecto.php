<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproyecto=isset($_GET['idp'])?$_GET['idp']:NULL;

//echo $idproyecto;
if($_SESSION['idusuario']&&$idproyecto)
{  
	//obtien lista de actividaes del proyecto
	$lista_actividades=mysql_query("select idpat from proyectos_actividades where idproyecto='".$idproyecto."' and activo=1",$conexionestelar) or die(mysql_error());
	//obtien lista de actividaes cerradas del proyecto
	$lista_actividades_cerradas=mysql_query("select idpat from proyectos_actividades where idproyecto='".$idproyecto."' and status=2 and activo=1",$conexionestelar) or die(mysql_error());

	if(mysql_num_rows($lista_actividades))
	{   
		if(mysql_num_rows($lista_actividades)==mysql_num_rows($lista_actividades_cerradas))
		{ 
		mysql_query("update proyectos set status=2,fechacerrado='".date('Y-m-d')."',horacerrado='".date('H:i:s')."' where idproyecto='".$idproyecto."'",$conexionestelar) or die(mysql_error());
		  echo "<script>alert('Project Close')</script>";
		  echo "<script>location.href='../current_projects.php'</script>";
		}
		else
		{ echo "<script>alert('all activities must be closed to close project')</script>";
			echo "<script>location.href='../detail_project.php?idp=".$idproyecto."'</script>";
		}
	}
}
?>