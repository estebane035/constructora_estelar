<?php
  require("../../conexionbd/conexionbase.php");
  require("../../conexionbd/conexionestelar.php");
  require("../../includes/account.php");

  mysql_select_db($database_conexionestelar,$conexionestelar);

  $id_proyecto = isset($_POST['id_proyecto'])?$_POST['id_proyecto']:NULL;
  $id_trabajador = isset($_POST['id_trabajador'])?$_POST['id_trabajador']:NULL;

  $consulta = "SELECT * FROM payroll WHERE id_trabajador = ".$id_trabajador." AND DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d')";
  $payroll = mysql_query($consulta) or die(mysql_error());
  if(mysql_num_rows($payroll)!=0){
    $payroll = mysql_fetch_assoc($payroll);
    if(empty($payroll['check_out'])){
      $consulta = "UPDATE payroll SET check_out = now(), total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, check_in, now())) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d') AND id_trabajador = ".$id_trabajador;
      $result = mysql_query($consulta) or die(mysql_error());
      if($result)
        echo 2;
      else
        echo 0;
    }
    else
      echo 3;
  }
  else{
    $consulta = "INSERT INTO payroll (id_proyecto, id_trabajador, check_in) VALUES(".$id_proyecto.", ".$id_trabajador.", now())";
    $result = mysql_query($consulta) or die(mysql_error());
    if($result)
      echo 1;
    else
      echo 0;
  }
?>
