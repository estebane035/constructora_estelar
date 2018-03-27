<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idcontratista=isset($_POST['idcontratista'])?$_POST['idcontratista']:NULL;

//echo $idcontratista;
//obtiene contactos de contratista
	$contactos=mysql_query("select idcontacto,name from contratistas_contactos where idcontratista='".$idcontratista."' and activo=1 ",$conexionestelar) or die(mysql_error());
	$row_contactos=mysql_fetch_assoc($contactos);

if(mysql_num_rows($contactos))
{ do
	{
 ?>
		<tr><td><input type="checkbox" name="contacto_contratista[]" id="contacto_contratista" value="<?php echo $row_contactos['idcontacto']?>"></td>
        	<td><?php echo $row_contactos['name'];?></td>
        </tr>
<?php }while($row_contactos=mysql_fetch_assoc($contactos)); 
}?>