<?php
//INDEX NEW PROJECT
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
//OBTIENE LISTA DE CONSTRUCTORAS
	$constructoras=mysql_query("select idconstructora,nombre from constructoras where activo=1",$conexionestelar) or die(mysql_error());
	$row_constructoras=mysql_fetch_assoc($constructoras);
//borra registros temporales
	mysql_query("delete from proyectos_contratistas_temporal where idpat_temp in(select idpat_temp from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."') ",$conexionestelar) or die(mysql_error());
	mysql_query("delete from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."'",$conexionestelar) or die(mysql_error());

$titulo="NEW PROJECT";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>New Project</title>
<link href="../css/estelar.css" rel="stylesheet" type="text/css">
<link href="css/projects.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css">
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
	<form name="newprojectform" method="post" action="<?php echo "acciones_form/new_project_form.php"?>">
	<table>
    	<tr><td class="negra">Name</td><td><input type="text" name="nombreproyecto" id="nombreproyecto"></td></tr>
        <tr><td class="negra">Description</td><td><textarea name="descripcionproyecto" id="descripcionroyecto"></textarea></td></tr>
        <tr><td class="negra">Constructor</td><td><select name="constructoras" id="constructoras">
        								<option value="0"></option>
                                        <?php do{?>
                                        		<option value="<?php echo $row_constructoras['idconstructora']?>"><?php echo $row_constructoras['nombre']?></option>
                                        <?php }while($row_constructoras=mysql_fetch_assoc($constructoras));?>
                                    </select>
        						</td></tr>
        <tr><td class="negra">Start Date</td><td><input type="text" class="fechas" name="fechainicio" id="fechainicio" size="9"></td></tr>
        <tr><td class="negra">Finish Date</td><td><input type="text" class="fechas" name="fechatermino" id="fechatermino" size="9"></td></tr>                        
    </table><br><br>
    <table>
    	<tr><td>WORKS TO DO</td></tr>
    </table>
    <hr style="width:700px;" align="left" color="#666666">
    <br><br>
    <div id="trabajos">
    	<?php include("includes/trabajos.php");?>
    </div>
    <br><br><br><br><br><br><br>
    <table>
    	<tr><td><input type="button" value="Save" onClick="guardar_proyecto()"></td></tr>
    </table>
    </form>
    </div><!--div central-->
    <div style="clear:both"></div>
	</div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->
</body>
<script type="text/javascript" src="../scripts/estelar.js"></script>
<script type="text/javascript" src="js/project_ajax.js"></script>
<script type="text/javascript" src="js/project.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.js"></script>
<script>
  $( function() {
    $( ".fechas" ).datepicker();
  } );
  </script>

<?php //include("../scripts/scriptfechas.php");?>
</html>