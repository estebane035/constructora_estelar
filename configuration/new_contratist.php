<?php
//NEW CONTRATIST
include("../conexionbd/conexionbase.php");
include("../conexionbd/conexionestelar.php");
require("../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

//OBTIENE LISTA DE CONTRATISTAS
	$lista_contratistas=mysql_query("select idcontratista,nombre from contratistas",$conexionestelar) or die(mysql_error());
	$row_lista_contratistas=mysql_fetch_assoc($lista_contratistas);
//OBTIENE LISTA DE CONTRATISTAS Y CONTACTOS
	$contractors_list=mysql_query("select contratistas_contactos.idcontacto,contratistas.idcontratista,nombre,name,email,position,telefono from contratistas INNER JOIN contratistas_contactos ON contratistas.idcontratista=contratistas_contactos.idcontratista WHERE contratistas.activo=1 AND contratistas_contactos.activo=1 ORDER BY nombre ",$conexionestelar) or die(mysql_error());
	$row_contractor_list=mysql_fetch_assoc($contractors_list);	
	
$titulo="NEW CONTRACTOR";	
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>New Contractor</title>
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
<form name="new_contratist_form" method="post" action="accionesform/contratist_new_form.php">
<table>
	<tr><td class="negra">Contractor</td><td><select name="name_contractor" id="name_contractor" onChange="agregar_contratista(this)">
												<option value="0"></option>
                                                <?php do{?>
                                                	<option value="<?php echo $row_lista_contratistas['idcontratista']?>"><?php echo $row_lista_contratistas['nombre'];?></option>
                                                <?php }while($row_lista_contratistas=mysql_fetch_assoc($lista_contratistas));?>
                                                <option value="n">-NEW CONTRACTOR-</option>	 
                                             </select></td></tr>
    <tr id="new_contractor"></tr>
</table>
<br><br>
<table id="table_contacts">
	<thead><th>Name</th><th>Email</th><th>Position</th><th>Telephone</th></thead>
    <tr><td><input type="text" name="name" id="name"></td>
    	<td><input type="text" name="email" id="email"></td>
        <td><input type="text" name="position" id="position"></td>
        <td><input type="text" name="telefono" id="telefono"></td>
	</tr>
</table>
<br><br>
<table>
	<tr><td><input type="button" value="Add Contact Contractor" onClick="save_new_contratist()"></td></tr>
</table>
</form>
<br>
<br>
<?php if(mysql_num_rows($contractors_list)){?>
<table id="tablapadding5center">
	<thead><th>Contractor</th><th>Name</th><th>Email</th><th>Position</th><th>Telephone</th><th></th></thead>
    <?php $cf=""; $contractor="";
		do{ if($cf){$cf="";}else{$cf="style='background:#ddd'";}
		?>    		
            <tr <?php echo $cf?>>
            	<?php if($row_contractor_list['idcontratista']!=$contractor){?>
                	<td><?php echo $row_contractor_list['nombre']?></td>
                <?php   $contractor=$row_contractor_list['idcontratista'];
					  } else {?>
                	<td></td>
                <?php }?>
                <td><?php echo $row_contractor_list['name']?></td>
                <td><?php echo $row_contractor_list['email']?></td>
                <td><?php echo $row_contractor_list['position']?></td>
                <td><?php echo $row_contractor_list['telefono']?></td>
                <td><a href="<?php echo "edit_contractor.php?idcto=".$row_contractor_list['idcontacto']?>">Edit</a></td>
            </tr>
    <?php }while($row_contractor_list=mysql_fetch_assoc($contractors_list));?>
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