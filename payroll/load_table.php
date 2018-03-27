<?php
  require("../conexionbd/conexionbase.php");
  require("../conexionbd/conexionestelar.php");
  require("../includes/account.php");

  mysql_select_db($database_conexionestelar,$conexionestelar);
  $consulta = "SELECT payroll.id, proyectos.nombre AS nombre_proyecto, vista_trabajadores.nombre AS nombre_trabajador,
  payroll.check_in, payroll.check_out, payroll.total_horas FROM payroll, proyectos, vista_trabajadores
  WHERE payroll.id_proyecto = proyectos.idproyecto AND payroll.id_trabajador = vista_trabajadores.idusuario
  ORDER BY check_in DESC";
  //echo $consulta;
  $resultado = mysql_query($consulta);
  $filas = array();
  $i=0;
  while($registro = mysql_fetch_assoc($resultado)){
      $filas[$i] = $registro;
      $i++;
  }
  print json_encode($filas);
?>
