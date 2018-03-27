<?php 
//NOTIFICACIONES REPORT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idnotificacion=isset($_GET['idnot'])?$_GET['idnot']:NULL;

//obtiene el nombre de la notificacion
	$notificacion=mysql_query("select notificacion from cat_notificaciones where idnotificacion='".$idnotificacion."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_notificacion=mysql_fetch_assoc($notificacion);
//obtiene registro de notificacion
	$cuerpo=mysql_query("select cuerpo, important_note from  cuerpo_notificaciones where idnotificacion='".$idnotificacion."' and activo=1 limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_cuerpo=mysql_fetch_assoc($cuerpo);	
	
$titulo="BODY NOTIFICATION";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>Body Notification</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
    	<form name="body_notification" method="post" action="<?php echo "accionesform/body_notification_form.php?idnot=".$idnotificacion?>  ">
			<table>
            	<tr><td class="negra" style="padding-bottom:15px">Notification</td><td style="padding-bottom:15px"><?php echo $row_notificacion['notificacion']?></td></tr>				                
            	<tr><td class="negra" style="vertical-align:top">Body</td><td><textarea name="body" id="body" style="width:500px; height:70px"><?php echo $row_cuerpo['cuerpo']?></textarea></td></tr>            
                <tr><td class="negra" style="vertical-align:top">Important Note</td><td><textarea name="important" id="important" style="width:500px; height:70px"><?php echo $row_cuerpo['important_note']?></textarea></td></tr>
            </table><br>
            <table>
            	<tr><td><input type="button" value="Save" onClick="guardar_cuerpo_notificacion()"></td></tr>
            </table>
        </form>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    
</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
<script type="text/javascript" src="scripts/configuration_ajax.js"></script>

</html>