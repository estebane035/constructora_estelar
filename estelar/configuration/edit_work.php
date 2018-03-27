<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$idwork=isset($_GET['idwork'])?$_GET['idwork']:NULL;
//echo $idwork."aaaa";
//OBTIENE LISTA DE ACTIVIDADES
	$work_list=mysql_query("select idwork,work from cat_works where idwork='".$idwork."' limit 0,1 ",$conexionestelar) or die(mysql_error());
	$row_work_list=mysql_fetch_assoc($work_list);

$titulo="EDIT WORK";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Edit Work</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
    	<?php include("../includes/header.php");?>
    </div>
    <div style="clear:both"></div>
    <div id="central_exterior">
	<?php include("../includes/menutitulo.php");?>    
    <div id="central">
<form name="new_work_form" method="post" action="<?php echo "accionesform/work_edit_form.php?idwork=".$idwork?>">
<table>
	<tr><td class="negra">Work</td><td><input type="text" name="name_work" id="name_work" value="<?php echo $row_work_list['work']?>"></td></tr>
</table>
<br><br>
<table>
	<tr><td><input type="button" value="Update Work" onClick="save_new_work()"></td></tr>
</table>
</form>
<br>
<br>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>