<?php
//PROVIENE DE WORKS/INDEX.PHP FUNCTION SHOW_WORKS
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
include("../includes/Mobile_Detect.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idwork=isset($_GET['idwork'])?$_GET['idwork']:NULL;
$_SESSION['idwork']=$idwork;

//OBTIENE DATOS DEL TRABAJO
	$datos_trabajo=mysql_query("select proyectos.idproyecto, proyectos.nombre,proyectos.idconstructora,actividad FROM proyectos_actividades INNER JOIN proyectos ON proyectos_actividades.idproyecto=proyectos.idproyecto WHERE proyectos_actividades.idpat='".$idwork."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_trabajo=mysql_fetch_assoc($datos_trabajo);

//OBTIENE DATOS DE LA CONTRUCTORA
	$datos_constructora=mysql_query("select nombre from constructoras where idconstructora='".$row_datos_trabajo['idconstructora']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_datos_constructora=mysql_fetch_assoc($datos_constructora);

//OBTIENE LISTADO DE NOTIFICACIONES
	$cat_notificaciones=mysql_query("select idnotificacion,notificacion,idtiponotificacion,idnp from cat_notificaciones where activo=1 order by idnp,idtiponotificacion",$conexionestelar) or die(mysql_error());
	$row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones);
//obtiene notificaciones principales
	$notificaciones_principales=mysql_query("select idnp,count(idnp) as total from cat_notificaciones where activo=1 group by idnp",$conexionestelar) or die(mysql_error());
	$row_notificaciones_principales=mysql_fetch_assoc($notificaciones_principales);
	$a_not_principal[]="";
	do
	{ $a_not_principal[$row_notificaciones_principales['idnp']]=$row_notificaciones_principales['total'];
	}while($row_notificaciones_principales=mysql_fetch_assoc($notificaciones_principales));
//OBTIENE NOMBRE DE LA ACTIVIDAD ASIGNADA
	$actividad=mysql_query("select work from cat_works where idwork='".$row_datos_trabajo['actividad']."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_actividad=mysql_fetch_assoc($actividad);

	$consulta = "SELECT * FROM payroll WHERE id_trabajador = ".$_SESSION['idusuario']." AND DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d')";
	$payroll = mysql_query($consulta);
	if(mysql_num_rows($payroll)!=0)
		$exist = true;
	else
		$exist = false;
	$payroll = mysql_fetch_assoc($payroll);


$titulo="PROJECT SELECTED";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" /><title>Show Work Description</title>
<?php
$detect=new Mobile_Detect();
if($detect->isMobile()||$detect->isTablet())
{?>
<link href="../css/estelar_mobile.css" rel="stylesheet" type="text/css">
<?php }
else
{?>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<?php
}?>
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
<table id="tablapadding5">
	<tr><td class="negra">Project</td><td class="valor"><?php echo $row_datos_trabajo['nombre']?></td></tr>
    <tr><td class="negra">Constructor</td><td class="valor"><?php echo $row_datos_constructora['nombre']?></td></tr>
    <tr><td class="negra">Do</td><td class="valor"><?php echo $row_actividad['work']?></td></tr>
</table>
<table style="margin-top:15px">
	<tr>
		<td class="btn_check" id="check"><a id="text_check" href="#" onclick="check(<?php echo $row_datos_trabajo['idproyecto'].', '.$_SESSION['idusuario'] ?>);" class="btn_text">Check In</a></td>
	</tr>
</table>
<br><br>
<div id="main_notifications">
<form name="save_works" id="save_works" method="post" action="acciones_form/save_work_form.php">
<table>
	<tr><td class="negra">Notifications</td></tr>
</table><br><br>
<table id="table_notificacions">
	<?php do{
			?>
				<tr id="<?php echo "fila".$row_cat_notificaciones['idnotificacion'];?>">
                	<?php if($row_cat_notificaciones['idtiponotificacion']==1&&$a_not_principal[$row_cat_notificaciones['idnp']]>1)
					{ ?>
                        <td></td>
	                	<td><?php echo $row_cat_notificaciones['notificacion']?></td>
					<?php }
					else
					{   if($row_cat_notificaciones['idtiponotificacion']==1) //si la notificacion es principal
						{?>
    	                <td><input class="radio" type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>" onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>,<?php echo $idwork?>)"></td>
        	        	<td onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>,<?php echo $idwork?>)"><?php echo $row_cat_notificaciones['notificacion']?></td>
              <?php 	}
			  			else // si la notificacion es secundaria, pone celda vacia a la izquierda
						{ ?>
			  			<td></td>
        	        	<td><input class="radio" type="radio" name="notificacion" value="<?php echo $row_cat_notificaciones['idnotificacion']?>" onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>,<?php echo $idwork?>)"><span onClick="notificacion_seleccionada(<?php echo $row_cat_notificaciones['idnotificacion']?>,<?php echo $idwork?>)"><?php echo $row_cat_notificaciones['notificacion']?></span></td>
			  <?php		}	}?>
                </tr>
	<?php }while($row_cat_notificaciones=mysql_fetch_assoc($cat_notificaciones));?>
</table><br><br>
</form>
<input type="hidden" id="check_state" name="check_state" value="<?php
		if($exist){
			if(empty($payroll['check_out']))
				echo '1';
			else
				echo '2';
		}
		else
			echo '0';
?>">
</div><!--div main notifications-->
<!--	<div id="div_imagen">
	 <form method="post" id="formulario" enctype="multipart/form-data">
	    Upload Image: <input type="file" name="file">
	 </form>
	 <div id="respuesta"></div>
	</div>-->
<br>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="scripts/works_ajax.js"></script>
<script type="text/javascript" src="scripts/works.js"></script>
   <script>
    </script>

</html>
