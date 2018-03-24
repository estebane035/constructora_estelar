<?php //proviene de accionesajax/detalle_notificaciones_ajax.php
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
require("../includes/account.php");
require("../libs/pdf/mpdf/mpdf.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
$idproject=isset($_GET['idpto'])?$_GET['idpto']:NULL;

//obtiene las notificaciones y activdades
	$notificaciones=mysql_query("select notificaciones_actividades.idnotificacion, actividad,idcontratista,proyectos_actividades.idtrabajador, observaciones, location, notificaciones_actividades.fecharegistro, notificaciones_actividades.horaregistro FROM notificaciones_actividades INNER JOIN proyectos_actividades ON notificaciones_actividades.idpat=proyectos_actividades.idpat WHERE proyectos_actividades.idproyecto='".$idproject."' and notificaciones_actividades.activo=1 and proyectos_actividades.activo=1 ",$conexionestelar) or die(mysql_error());
	$row_notificaciones=mysql_fetch_assoc($notificaciones);

//obtiene contactos de los contratistas
	$contacto_contratistas=mysql_query("select idcontratista,name from contratistas_contactos ",$conexionestelar) or die(mysql_error());
	$row_contacto_contratistas=mysql_fetch_assoc($contacto_contratistas);
	$a_contactos[]="";
	do
	{  if(isset($a_contactos[$row_contacto_contratistas['idcontratista']]))
		{ $a_contactos[$row_contacto_contratistas['idcontratista']]="<br>".$row_contacto_contratistas['name']; }
		else
		{ $a_contactos[$row_contacto_contratistas['idcontratista']]=$row_contacto_contratistas['name'];}	
	}while($row_contacto_contratistas=mysql_fetch_assoc($contacto_contratistas));
//obtiene contactos de trabajdores
	$correos_trabajadores=mysql_query("select idworker,email from worker_contact ",$conexionestelar) or die(mysql_error());
	$row_correos_trabajadores=mysql_fetch_assoc($correos_trabajadores);
	$a_correos[]="";
	do
	{ $a_correos[$row_correos_trabajadores['idworker']]=$row_correos_trabajadores['email'];
	}while($row_correos_trabajadores=mysql_fetch_assoc($correos_trabajadores));

//obtiene catalogo de actividaddes
	$cat_works=mysql_query("select idwork,work from cat_works",$conexionestelar) or die(mysql_error());	
	$row_cat_works=mysql_fetch_assoc($cat_works);
	$a_works[]="";
	do
	{ $a_works[$row_cat_works['idwork']]=$row_cat_works['work'];
	}while($row_cat_works=mysql_fetch_assoc($cat_works));
//obtiene nombres de trabajadores
	$trabajadores=mysql_query("select idusuario,nombre from vista_trabajadores",$conexionestelar) or die(mysql_error());
	$row_trabajadores=mysql_fetch_assoc($trabajadores);
	$a_trabajadores[]="";
	do
	{ $a_trabajadores[$row_trabajadores['idusuario']]=$row_trabajadores['nombre'];
	}while($row_trabajadores=mysql_fetch_assoc($trabajadores));

//echo $idproject;
$html='<header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <h1>INVOICE 3-2-1</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Design</td>
            <td class="desc">Creating a recognizable design solution based on the companys existing visual identity</td>
            <td class="unit">$40.00</td>
            <td class="qty">26</td>
            <td class="total">$1,040.00</td>
          </tr>
          <tr>
            <td class="service">Development</td>
            <td class="desc">Developing a Content Management System-based Website</td>
            <td class="unit">$40.00</td>
            <td class="qty">80</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="service">SEO</td>
            <td class="desc">Optimize the site for search engines (SEO)</td>
            <td class="unit">$40.00</td>
            <td class="qty">20</td>
            <td class="total">$800.00</td>
          </tr>
          <tr>
            <td class="service">Training</td>
            <td class="desc">Initial training sessions for staff responsible for uploading web content</td>
            <td class="unit">$40.00</td>
            <td class="qty">4</td>
            <td class="total">$160.00</td>
          </tr>
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="4">TAX 25%</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$6,500.00</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
';


$mpdf= new mPDF('c','A4');
$mpdf->writeHTML($html);
$mpdf->Output('NotificationsReport.pdf','I');
?>