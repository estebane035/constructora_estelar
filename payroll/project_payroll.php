<?php
if (!isset($_GET["date"]))
{
  echo "Missing variable date";exit;
}
session_start();
if(!isset($_SESSION['idusuario']))
  header("location:../includes/close_session/");

switch ($_SESSION['tipousuario']) {
  case '2':
    header("location: ../supervisor/");
    break;
  case '3':
    header("location: ../works/");
    break;
  case '4':
    header("location: ../newproject/");
    break;
}

require_once  "../PHPExcel/PHPExcel.php";
require("../conexionbd/conexionbase.php");
require("../conexionbd/conexionestelar.php");
include 'colors.php';

mysql_select_db($database_conexionestelar,$conexionestelar);

$date = $_GET['date'];
$dateToTime = strtotime($date);
list($year, $month, $day) = explode('/', $date);
$daysOfPayRoll = array();
if($day <= 15){
  $from = $year."-".$month."-01";
  for($i = 1; $i <= 15; $i++){
    $actualDate = strtotime($year."-".$month."-".$i);
    $daysOfPayRoll[] = date("D", $actualDate)." ".$i;
    $to = $year."-".$month."-".$i;
  }
}else{
  $from = $year."-".$month."-16";
  for($i = 16; $i <= 31; $i++){
    if(checkdate($month, $i, $year)){
      $actualDate = strtotime($year."-".$month."-".$i);
      $daysOfPayRoll[] = date("D", $actualDate)." ".$i;
      $to = $year."-".$month."-".$i;
    }
  }
}

$count = count($daysOfPayRoll);

$consulta = "SELECT payroll.id_trabajador, vista_trabajadores.nombre FROM payroll, vista_trabajadores WHERE payroll.id_proyecto = ".$_GET["project"]." AND payroll.id_trabajador = vista_trabajadores.idusuario AND payroll.check_in BETWEEN '".$from."' AND '".$to."' GROUP BY payroll.id_trabajador";
$resultado = mysql_query($consulta);
$workers = array();
while($row = mysql_fetch_assoc($resultado))
  $workers[] = $row;

$consulta = "SELECT idproyecto, nombre FROM proyectos WHERE idproyecto = ".$_GET["project"];
$resultado = mysql_query($consulta);
$projects = array();
while($row = mysql_fetch_assoc($resultado))
  $projects[] = $row;
foreach($projects as &$project)
  $project['color'] = randomColor(100, 255);
unset($project);

//print_r($projects);

$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Constructora Estelar")
->setLastModifiedBy("Constructora Estelar")
->setTitle("Project Payroll")
->setSubject("Project Payroll")
->setDescription("Project payroll for all worker's.")
->setKeywords("Payroll")
->setCategory("Payroll");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
$columns = array("B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S");
$act = 'Q';
if($count > 13){
  if($count == 14){
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
    $columns[] = "T";
    $act = 'T';
  }
  if($count == 15){
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
    $columns[] = "T";
    $columns[] = "U";
    $act = 'U';
  }
  if($count == 16){
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
    $columns[] = "T";
    $columns[] = "U";
    $columns[] = "V";
    $act = 'V';
  }
}
else{
  $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
  $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
  $act = 'S';
}

$row_count = 2;

$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_count, 'Export date: ');
$objPHPExcel->getActiveSheet()->mergeCells("D2:I2");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_count, date('l jS \of F Y h:i:s A'));
$objPHPExcel->getActiveSheet()->getStyle("C2:I2")->applyFromArray(
        array(
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
              )
            )
        )
);



$row_count += 2;
$objPHPExcel->getActiveSheet()->mergeCells($columns[0].$row_count.":".$act.$row_count);
$objPHPExcel->getActiveSheet()->getStyle($columns[0].$row_count.":".$act.$row_count)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bcbbde')
        ),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      )
    )
);

$objPHPExcel->getActiveSheet()->setCellValue($columns[0].$row_count, 'PROYECT PAYROLL '.$from." to ".$to);
$row_count+=1;
$objPHPExcel->getActiveSheet()->getStyle($columns[0].$row_count.":".$act.$row_count)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '88949B')
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
        )

);
//Titulos de las columnas
$objPHPExcel->getActiveSheet()->setCellValue($columns[0].$row_count, "#");
$objPHPExcel->getActiveSheet()->setCellValue($columns[1].$row_count, "Employee");
$column = 2;
$j=0;
for($j=0;$j<$count;$j++){
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$column].$row_count, $daysOfPayRoll[$j]);
  $column+=1;
}
$objPHPExcel->getActiveSheet()->setCellValue($columns[$column].$row_count, "Total Hrs");
$column += 1;
$objPHPExcel->getActiveSheet()->setCellValue($columns[$column].$row_count, "Rate x Hrs");
$column += 1;
$objPHPExcel->getActiveSheet()->setCellValue($columns[$column].$row_count, "Payment");
$row_count+=1;
$sum_total = 0;
foreach($workers as $worker){
  $objPHPExcel->getActiveSheet()->setCellValue($columns[0].$row_count, $worker['id_trabajador']);
  $objPHPExcel->getActiveSheet()->setCellValue($columns[1].$row_count, $worker['nombre']);
  $consulta = "SELECT id_proyecto, DATE_FORMAT(check_in, '%Y-%m-%d') AS date, IF((cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)))>=5, (cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))) -0.5, cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))) AS total_horas, pago, (IF((cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)))>=5, (cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))) -0.5, cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))) * pago) AS total FROM payroll WHERE id_proyecto = ".$_GET["project"]." AND check_in BETWEEN '".$from."' AND '".$to."' AND id_trabajador = ".$worker['id_trabajador'];
  $result = mysql_query($consulta);
  $checks = array();
  while($row = mysql_fetch_assoc($result))
    $checks[] = $row;
  $total_horas = 0;
  $pago = 0;
  $total = 0;
  foreach($checks as $check){
    $total_horas += $check['total_horas'];
    $pago = $check['pago'];
    $total += $check['total'];
    $checkOfDay = date("d", strtotime($check['date']));
    if($checkOfDay > 15)
      $checkOfDay -= 15;
      foreach($projects as $project){
        if($project['idproyecto'] == $check['id_proyecto'])
          $color = $project['color'];
        }
      $objPHPExcel->getActiveSheet()->getStyle($columns[$checkOfDay + 1].$row_count)->applyFromArray(
              array(
                  'fill' => array(
                      'type' => PHPExcel_Style_Fill::FILL_SOLID,
                      'color' => array('rgb' => $color)
                  ),
                  'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
              )
      );
    $objPHPExcel->getActiveSheet()->setCellValue($columns[$checkOfDay + 1].$row_count, $check['total_horas']);
  }
  $sum_total += $total;
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 2].$row_count, $total_horas);
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 3].$row_count, $pago);
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 4].$row_count, $total);
  $row_count += 1;
}
$row_count += 1;
$objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 3].$row_count, "Total Payroll");
$objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 4].$row_count, $sum_total);

foreach($projects as $project){
  //print_r($project);
  $objPHPExcel->getActiveSheet()->getStyle($columns[0].$row_count)->applyFromArray(
          array(
              'fill' => array(
                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => $project['color'])
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
          )
  );
  $objPHPExcel->getActiveSheet()->setCellValue($columns[1].$row_count, $project['nombre']);
  $row_count+=1;
}

$objPHPExcel->getActiveSheet()->getStyle("B4:v".($row_count-1))->applyFromArray(
        array(
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
              )
            )
        )
);

//SELECT py.nombre, SUM(IFNULL(HOUR(pr.total_horas),0)) as horas, SUM(IFNULL(HOUR(pr.total_horas),0) * pr.pago) as total FROM proyectos AS py INNER JOIN payroll as pr ON pr.id_proyecto = py.idproyecto WHERE pr.id_trabajador = 8 GROUP BY py.nombre

/*$row_count += 1;
do{

}while($j < $count);*/

$objPHPExcel->getActiveSheet()->setTitle('Project Payroll');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$projects[0]['nombre'].'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>
