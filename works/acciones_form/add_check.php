<?php
  date_default_timezone_set('America/Edmonton');
  require("../../conexionbd/conexionbase.php");
  require("../../conexionbd/conexionestelar.php");
  require("../../includes/account.php");

  mysql_select_db($database_conexionestelar,$conexionestelar);

  $id_proyecto = isset($_POST['id_proyecto'])?$_POST['id_proyecto']:NULL;
  $id_trabajador = isset($_POST['id_trabajador'])?$_POST['id_trabajador']:NULL;

  $consulta = "SELECT now() - INTERVAL 1 HOUR as date";
  $resultado = mysql_query($consulta);
  $now = mysql_fetch_assoc($resultado);
  $now = $now['date'];

  //$consulta = "SELECT * FROM payroll WHERE id_trabajador = ".$id_trabajador." AND DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT('".$now."', '%Y-%c-%d')";
  $consulta = "SELECT * FROM payroll WHERE id_trabajador = ".$id_trabajador." AND check_out IS NULL";
  $payroll = mysql_query($consulta) or die(mysql_error());
  if(mysql_num_rows($payroll)!=0){
    $payroll = mysql_fetch_assoc($payroll);
    if(empty($payroll['check_out'])){
      //Calcular la fecha
        $consulta = "SELECT hora_check_in FROM proyectos WHERE idproyecto = ".$id_proyecto;
        $resultado = mysql_query($consulta);
        $row = mysql_fetch_assoc($resultado);
        //echo $row['hora_check_in'];
        $hora = date_create($row['hora_check_in']);
        $hora = date_format($hora, 'H:i:s');
        $check_date = date_create($payroll['check_in']);
        $check_out_date = date_create($payroll['check_in']);
        $check_out_date = date_format($check_out_date, 'Y-m-d');
        $check_date = date_format($check_date, 'H:i:s');
        /*$check_date = strtotime( '-6 hour', strtotime($check_date));
        $check_date = date('H:i:s', $check_date);
        if($hora == $check_date)
          echo "Horas iguales";*/
        if($hora > $check_date && $id_proyecto != '0')
          //$consulta = "UPDATE payroll SET check_out = '".$now."' - INTERVAL 13 MINUTE, total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, '".$check_out_date." ".$row['hora_check_in']."', '".$now."' - INTERVAL 13 MINUTE)) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT('".$now."', '%Y-%c-%d') AND id_trabajador = ".$id_trabajador;
          $consulta = "UPDATE payroll SET check_out = '".$now."' - INTERVAL 13 MINUTE, total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, '".$check_out_date." ".$row['hora_check_in']."', '".$now."' - INTERVAL 13 MINUTE)) WHERE check_out IS NULL AND id_trabajador = ".$id_trabajador;
          //echo $hora." mayor a ".$check_date.", llegas temprano";
        else
          //$consulta = "UPDATE payroll SET check_out = '".$now."' - INTERVAL 13 MINUTE, total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, check_in, '".$now."' - INTERVAL 13 MINUTE)) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT('".$now."', '%Y-%c-%d') AND id_trabajador =".$id_trabajador;
          $consulta = "UPDATE payroll SET check_out = '".$now."' - INTERVAL 13 MINUTE, total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, check_in, '".$now."' - INTERVAL 13 MINUTE)) WHERE check_out IS NULL AND id_trabajador =".$id_trabajador;
          //echo $hora." menor a ".$check_date.", llegas tarde";
      //echo $consulta;
      //Registrar salida
      //$consulta = "UPDATE payroll SET check_out = now(), total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, check_in, now())) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d') AND id_trabajador = ".$id_trabajador;
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
    $consulta = "SELECT * FROM payroll WHERE id_trabajador = ".$id_trabajador." AND DATE_FORMAT(check_out, '%Y-%c-%d') = DATE_FORMAT('".$now."', '%Y-%c-%d')";
    $result = mysql_query($consulta) or die(mysql_error());
    if(mysql_num_rows($result)>1)
      echo 3;
    else{
      $consulta = "INSERT INTO payroll (id_proyecto, id_trabajador, check_in, pago) VALUES(".$id_proyecto.", ".$id_trabajador.", '".$now."' + INTERVAL 13 MINUTE, (SELECT pago FROM vista_trabajadores WHERE vista_trabajadores.idusuario = ".$id_trabajador." ))";
      $result = mysql_query($consulta) or die(mysql_error());
      if($result)
        echo 1;
      else
        echo 0;
    }
  }
?>
