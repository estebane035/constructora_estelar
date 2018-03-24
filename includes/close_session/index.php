<?php
require("../../conexionbd/conexionbase.php");

session_start();
if(isset($_SESSION['idusuario']))
{ mysql_select_db($database_conexionbase,$conexionbase);
  mysql_query("update control_sesiones set sesioncerrada=2,ultima_actividad='".$_SERVER['REQUEST_TIME']."' where idsesion='".$_SESSION['idsesion']."' ",$conexionbase) or die(mysql_error());
}
unset($_SESSION['idusuario']);
unset($_SESSION['idsesion']);
unset($_SESSION['navegador']);
unset($_SESSION['ip']);
unset($_SESSION['key']);
unset($_SESSION['uactividad']);
unset($_SESSION['tipousuario']);
session_destroy();
header("location:../../");
exit;?>