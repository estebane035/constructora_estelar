<?php
if (!isset($_GET["worker"]))
{
	echo "Missing variable worker";exit;
}
if (!isset($_GET["date"]))
{
	echo "Missing variable date";exit;
}
if (is_nan($_GET["worker"]))
{
	echo "Variable worker is not a number";exit;
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

mysql_select_db($database_conexionestelar,$conexionestelar);

$id_worker = $_GET["worker"];
$consulta = "SELECT nombre FROM vista_trabajadores WHERE idusuario = ".$id_worker;
$resultado = mysql_query($consulta);
$worker = mysql_fetch_assoc($resultado);
$worker_name = $worker['nombre'];
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

$consulta = "SELECT payroll.id_proyecto, proyectos.nombre FROM payroll, proyectos WHERE payroll.id_proyecto = proyectos.idproyecto AND payroll.check_in BETWEEN '".$from."' AND '".$to."' AND payroll.id_trabajador = ".$id_worker." GROUP BY payroll.id_proyecto";
$resultado = mysql_query($consulta);
$projects = array();
while($row = mysql_fetch_assoc($resultado))
	$projects[] = $row;

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Constructora Estelar")
->setLastModifiedBy("Constructora Estelar")
->setTitle("Worker payroll")
->setSubject("Worker payroll")
->setDescription("Worker payroll.")
->setKeywords("Payroll")
->setCategory("Payroll");

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
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
$columns = array("B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R");
$act = 'P';
if($count > 13){
  if($count == 14){
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
    $columns[] = "S";
    $act = 'S';
  }
  if($count == 15){
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
    $columns[] = "S";
    $columns[] = "T";
    $act = 'T';
  }
  if($count == 16){
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
    $columns[] = "S";
    $columns[] = "T";
    $columns[] = "U";
    $act = 'U';
  }
}
else{
  $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
  $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
  $act = 'R';
}

$row_count = 2;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, 'Export date: ');
$objPHPExcel->getActiveSheet()->mergeCells("C2:H2");
$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_count, date('l jS \of F Y h:i:s A'));
$objPHPExcel->getActiveSheet()->getStyle("B2:H2")->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, $worker_name.' PAYROLL');
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
$column = 1;
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
foreach($projects as $project){
	$objPHPExcel->getActiveSheet()->setCellValue($columns[0].$row_count, $project['nombre']);
	$consulta = "SELECT DATE_FORMAT(check_in, '%Y-%m-%d') AS date, cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)) AS total_horas, pago, (cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)) * pago) AS total FROM payroll WHERE check_in BETWEEN '".$from."' AND '".$to."' AND id_trabajador = ".$id_worker." AND id_proyecto = ".$project['id_proyecto'];
	$resultado = mysql_query($consulta);
	$checks = array();
	while($row = mysql_fetch_assoc($resultado))
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
		$objPHPExcel->getActiveSheet()->setCellValue($columns[$checkOfDay].$row_count, $check['total_horas']);
	}
	$sum_total += $total;
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 1].$row_count, $total_horas);
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 2].$row_count, $pago);
  $objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 3].$row_count, $total);
  $row_count += 1;
}
$objPHPExcel->getActiveSheet()->getStyle($columns[0]."4:".$act.($row_count-1))->applyFromArray(
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
$row_count += 1;
$objPHPExcel->getActiveSheet()->getStyle($columns[$count + 2].$row_count.":".$columns[$count + 3].$row_count)->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 2].$row_count, "Total Payroll");
$objPHPExcel->getActiveSheet()->setCellValue($columns[$count + 3].$row_count, $sum_total);
// Renombrar Hoja

$objPHPExcel->getActiveSheet()->setTitle($worker_name.' PAYROLL');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$worker_name.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>
