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
        if($hora > $check_date)
          $consulta = "UPDATE payroll SET check_out = now(), total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, '".$check_out_date." ".$row['hora_check_in']."', IF(now() > (DATE_FORMAT(now(), '%Y-%m-%d %H:20:00')), DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s'), (DATE_FORMAT(now(), '%Y-%m-%d %H:00:00'))))) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d') AND id_trabajador = ".$id_trabajador;
          //echo $hora." mayor a ".$check_date.", llegas temprano";
        else
          $consulta = "UPDATE payroll SET check_out = now(), total_horas = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, check_in, IF(now() > (DATE_FORMAT(now(), '%Y-%m-%d %H:20:00')), DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s'), (DATE_FORMAT(now(), '%Y-%m-%d %H:00:00'))))) WHERE DATE_FORMAT(check_in, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d') AND id_trabajador =".$id_trabajador;
          //echo $hora." menor a ".$check_date.", llegas tarde";
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
    $consulta = "INSERT INTO payroll (id_proyecto, id_trabajador, check_in, pago) VALUES(".$id_proyecto.", ".$id_trabajador.", now(), (SELECT pago FROM vista_trabajadores WHERE vista_trabajadores.idusuario = ".$id_trabajador." ))";
    $result = mysql_query($consulta) or die(mysql_error());
    if($result)
      echo 1;
    else
      echo 0;
  }
?>
