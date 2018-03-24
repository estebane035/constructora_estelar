<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

//OBTIENE LISTA DE ACTIVIDADES
	$work_list=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_work_list=mysql_fetch_assoc($work_list);

$titulo="NEW WORK";
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>New Work</title>
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
<form name="new_work_form" method="post" action="accionesform/work_new_form.php">
<table>
	<tr><td class="negra">Work</td><td><input type="text" name="name_work" id="name_work"></td></tr>
</table>
<br><br>
<table>
	<tr><td><input type="button" value="Save Work" onClick="save_new_work()"></td></tr>
</table>
</form>
<br>
<br>
<?php if(mysql_num_rows($work_list)){?>
<table id="tablapadding5center">
	<thead><th>Contratist</th><th></th></thead>
    <?php $cf=""; $contractor="";
		do{ if($cf){$cf="";}else{$cf="style='background:#ddd'";}
		?>    		
            <tr <?php echo $cf?>>
                <td><?php echo $row_work_list['work']?></td>
                <td><a href="<?php echo "edit_work.php?idwork=".$row_work_list['idwork']?>">Edit</a></td>
            </tr>
    <?php }while($row_work_list=mysql_fetch_assoc($work_list));?>
</table>
<?php }?>
    </div><!--div central-->
    <div style="clear:both"></div>
    </div><!--div central_exterior-->
    <div style="clear:both"></div>
  </div> <!--div holder-->    

</body>
<script type="text/javascript" src="scripts/configuration.js"></script>
</html>