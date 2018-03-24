<?php //PROVIENE DE WORKS/INDEX.PHP FUNCTION SHOW_WORKS
include("../../conexionbd/conexionbase.php");
include("../../conexionbd/conexionestelar.php");

$idwork=isset($_POST['idwork'])?$_POST['idwork']:NULL;
$imagen=isset($_POST['imagen'])?$_POST['imagen']:NULL;

//echo $idwork." ".$imagen;
$sDirGuardar=$_SERVER["DOCUMENT_ROOT"]."/estelar/estelar_construction/images/";

?>