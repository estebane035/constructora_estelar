<?php
$hostname_conexionestelar="localhost";
$database_conexionestelar="estel335_estelar_construction";
$username_conexionestelar="estel335_estelar";
$password_conexionestelar="estel@r1805";
$conexionestelar=mysql_pconnect($hostname_conexionestelar,$username_conexionestelar,$password_conexionestelar) or trigger_error(mysql_error(),E_USER_ERROR);
/*
$hostname_conexionestelar="localhost";
$database_conexionestelar="estelar_construction";
$username_conexionestelar="root";
$password_conexionestelar="";
$conexionestelar=mysql_pconnect($hostname_conexionestelar,$username_conexionestelar,$password_conexionestelar) or trigger_error(mysql_error(),E_USER_ERROR);
*/
?>