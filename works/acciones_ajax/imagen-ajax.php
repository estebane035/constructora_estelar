<?php
require("../../conexionbd/conexionbase.php");
require("../../conexionbd/conexionestelar.php");
require("../../includes/account.php");

mysql_select_db($database_conexionestelar,$conexionestelar);
//echo "111111";

if (isset($_FILES["file"]))
{
    $file = $_FILES["file"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    //$carpeta = "../../images/";
    $carpeta=$_SERVER["DOCUMENT_ROOT"]."/estelar/images/";	
/*    
    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
    {
      echo "Error, el archivo no es una imagen"; 
    }
    else if ($size > 1024*1024)
    {
      echo "Error, el tamaño máximo permitido es un 1MB";
    }
    else if ($width > 500 || $height > 500)
    {
        echo "Error la anchura y la altura maxima permitida es 500px";
    }
    else if($width < 60 || $height < 60)
    {
        echo "Error la anchura y la altura mínima permitida es 60px";
    }
    else
    {
        $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        echo "<img src='$src'>";
    }
	*/
	  $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
		mysql_query("insert into imagenes_temporales(idusuario,idsesion,imagen) values('".$_SESSION['idusuario']."','".$_SESSION['idsesion']."','".$nombre."')",$conexionestelar) or die(mysql_error());

        echo "<img src='$src'>";
}