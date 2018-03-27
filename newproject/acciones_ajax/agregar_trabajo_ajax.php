<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);

$descripcion=isset($_POST['descripcion'])?$_POST['descripcion']:NULL;
$contratista=isset($_POST['contratista'])?$_POST['contratista']:NULL;
$trabajador=isset($_POST['trabajador'])?$_POST['trabajador']:NULL;
$contacto=isset($_POST['contactos'])?$_POST['contactos']:NULL;

mysql_query("insert into proyectos_actividades_temporal(idusuario,actividad,idtrabajador,idcontratista) values('".$_SESSION['idusuario']."','".mysql_real_escape_string($descripcion)."','".$trabajador."','".$contratista."')",$conexionestelar) or die(mysql_error());
$idpat=mysql_insert_id();

if($contacto)
{ $contacto=rtrim($contacto,"-");
  $contacto=explode("-",$contacto);
  foreach($contacto as $key=>$valor)
  { //echo $key." ".$valor."<br>";
	mysql_query("insert into proyectos_contratistas_temporal(idpat_temp,idcontacto) values('".$idpat."','".$valor."')",$conexionestelar) or die(mysql_error());
  }  
}

//echo $descripcion."<br>";echo $contratista."<br>";echo $nombre1."<br>";echo $correo1."<br>";echo $posicion1."<br>";echo $nombre2."<br>";echo $correo2."<br>";
//echo $posicion2."<br>";echo $trabajador;

//obtiene trabajados temporales
	$trabajos_temporales=mysql_query("select idpat_temp,actividad,idtrabajador,idcontratista from proyectos_actividades_temporal where idusuario='".$_SESSION['idusuario']."' ",$conexionestelar) or die(mysql_error());
	$row_trabajos_temporales=mysql_fetch_assoc($trabajos_temporales);

//OBTIENE LISTA DE CONTRATISTAS
	$lista_contratistas=mysql_query("select idcontratista,nombre from contratistas where activo=1",$conexionestelar) or die(mysql_error());
	$row_lista_contratistas=mysql_fetch_assoc($lista_contratistas);
	$a_contratistas[]="";
	do
	{ $a_contratistas[$row_lista_contratistas['idcontratista']]=$row_lista_contratistas['nombre'];
	}while($row_lista_contratistas=mysql_fetch_assoc($lista_contratistas));
//OBTIENE LISTA DE TRABAJADORES
	$lista_trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_lista_trabajadores['idusuario']]=$row_lista_trabajadores['nombre'];
	}while($row_lista_trabajadores=mysql_fetch_assoc($lista_trabajadores));
//OBTIENE LISTA DE ACTIVIDADES
	$lista_actividades=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());
	$row_lista_actividades=mysql_fetch_assoc($lista_actividades);
	$a_actividades[]="";
	do
	{ $a_actividades[$row_lista_actividades['idwork']]=$row_lista_actividades['work'];
	}while($row_lista_actividades=mysql_fetch_assoc($lista_actividades));


if(mysql_num_rows($trabajos_temporales))
{
	do
	{ ?>	
		<div id="divdescripcion">
		<table>
    	   	<tr><td class="negra">Work</td></tr>
        	<tr><td><?php echo $a_actividades[$row_trabajos_temporales['actividad']]?></td></tr>
	    </table>
		</div>
		<div id="divcontratista">
        <table>
		   	<tr><td  class="negra">Contractor</td></tr>
            <tr><td><?php echo $a_contratistas[$row_trabajos_temporales['idcontratista']]?></td></tr>
        </table><br />
        <?php 
			//obtiene lista de contactos
			$contactos=mysql_query("select name from proyectos_contratistas_temporal INNER JOIN contratistas_contactos ON proyectos_contratistas_temporal.idcontacto=contratistas_contactos.idcontacto WHERE idpat_temp='".$row_trabajos_temporales['idpat_temp']."' ",$conexionestelar) or die(mysql_error());
			$row_contactos=mysql_fetch_assoc($contactos);
			if(mysql_num_rows($contactos))
			{ ?>
            	<table>
                	<?php do{?>
                    <tr><td><?php echo $row_contactos['name']?></td></tr>
                	<?php }while($row_contactos=mysql_fetch_assoc($contactos));?>
                </table>
            <?php
			}
		?>
		</div>
		<div id="divtrabajadores">
		  	<table>
            	<tr><td class="negra">Worker</td></tr>
                <tr><td><?php echo $a_trabajadores[$row_trabajos_temporales['idtrabajador']]?></td></tr>
            </table><br />	
		</div>
		<div style="clear: both;" ></div>
		<hr style="width:600px; margin-left:20px" align="left" color="#666666">
<?php		
	}while($row_trabajos_temporales=mysql_fetch_assoc($trabajos_temporales));
}
?>
<?php
include("../includes/trabajos.php");
?>
