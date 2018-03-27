<div id="menulogo">
	<div id="menu">
		<?php 
			if($_SESSION['tipousuario']==1) //administrador
			{ ?>
	        	<table style=" margin-top:15px; width:90%">
	            	<tr><td class="menutd"><a href="../newproject/" class="menu_a">New Project</a></td>
	                	<td class="menutd"><a href="../newproject/current_projects.php"  class="menu_a">Current Projects</a></td>
	                    <td class="menutd"><a href="../newproject/notifications.php"  class="menu_a">Notifications</a></td>
    	                <td class="menutd"><a href="../configuration/user_new.php"  class="menu_a">Users</a></td>
	                    <td class="menutd"><a href="../configuration/new_constructor.php"  class="menu_a">Prime Contractor</a></td>
	                    <td class="menutd"><a href="../configuration/new_contratist.php"  class="menu_a">Contractors</a></td>
        	            <td class="menutd"><a href="../configuration/new_work.php"  class="menu_a">Works</a></td>
            	        <td class="menutd"><a href="../configuration/workers_contact.php"  class="menu_a">Worker Contact</a></td>
                        <td class="menutd"><a href="../configuration/cat_notifications.php"  class="menu_a">Notifications List</a></td>
	                </tr>
    	        </table>
		<?php	}
			if($_SESSION['tipousuario']==4) //administrartivo 
			{ ?>
	        	<table style="margin-top:15px">
	            	<tr><td class="menutd"><a href="../newproject/" class="menu_a">New Project</a></td>
	                	<td class="menutd"><a href="../newproject/current_projects.php" class="menu_a">Current Projects</a></td>
	                    <td class="menutd"><a href="../newproject/notifications.php" class="menu_a">Notifications</a></td></tr>
	            </table>
		<?php	}
			if($_SESSION['tipousuario']==2) //SUPERVISOR
			{ ?>
	        	 <table style="margin-top:15px">
	            	<tr><td class="menutd"><a href="../supervisor/" class="menu_a">Projects to be Revised</a></td>
                    <td class="menutd"><a href="../supervisor/current_projects.php" class="menu_a">Current Projects</a></td></tr>
	            </table>
		<?php	}
			if($_SESSION['tipousuario']==3) //TRABAJADOR
			{ ?>
	        	<table style="margin-top:15px">
	            	<tr><td class="menutd"><a href="../works/" class="menu_a">Main Menu</a></td></tr>
	            </table>
		<?php	}
		?>
	</div>
	<div id="logo">
		<table><tr><td><img src="../logos/estelar_n.png" style="background-size:contain; background-repeat:no-repeat" width="200px" /></td></tr></table>
	</div>
</div>
<div style="clear:both"></div>
<?php include("sesionusuario.php");?>
