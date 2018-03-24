<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$hostname_conexionbase="localhost";
$database_conexionbase="estelar_base";
$username_conexionbase="root";
$password_conexionbase="";
$conexionbase=mysql_pconnect($hostname_conexionbase,$username_conexionbase,$password_conexionbase) or trigger_error(mysql_error(),E_USER_ERROR);
/*
$hostname_conexionbase="localhost";
$database_conexionbase="estelar_base";
$username_conexionbase="root";
$password_conexionbase="";
$conexionbase=mysql_pconnect($hostname_conexionbase,$username_conexionbase,$password_conexionbase) or trigger_error(mysql_error(),E_USER_ERROR);
*/
?>