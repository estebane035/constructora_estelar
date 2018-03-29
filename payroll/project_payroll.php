<?php
if (!isset($_GET["project"]))
{
	echo "Missing variable project";exit;
}

if (is_nan($_GET["project"]))
{
	echo "Variable project is not a number";exit;
}

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

mysql_select_db($database_conexionestelar,$conexionestelar);

$sql_trabajadores = "SELECT  vt.idusuario as id_trabajador FROM proyectos as p INNER JOIN payroll as pr ON PR.id_proyecto = P.idproyecto INNER JOIN vista_trabajadores as vt ON Vt.idusuario = pr.id_trabajador WHERE p.idproyecto = ".$_GET["project"]." GROUP BY vt.idusuario";
$sql_proyecto = "SELECT * FROM proyectos where idproyecto = ".$_GET["project"]." LIMIT 1;";
$consulta=mysql_query($sql_proyecto, $conexionestelar) or die(mysql_error());
$proyecto=mysql_fetch_assoc($consulta);

$date = $_GET['date'];
$dateToTime = strtotime($date);
list($year, $month, $day) = explode('/', $date);
$daysOfPayRoll = array();
if($day <= 15){
  $from = $year."-".$month."-01 00:00:00";
  for($i = 1; $i <= 15; $i++){
    $actualDate = strtotime($year."-".$month."-".$i);
    $daysOfPayRoll[] = date("D", $actualDate)." ".$i;
    $to = $year."-".$month."-".$i." 23:59:59";
  }
}else{
  $from = $year."-".$month."-16 00:00:00";
  for($i = 16; $i <= 31; $i++){
    if(checkdate($month, $i, $year)){
      $actualDate = strtotime($year."-".$month."-".$i);
      $daysOfPayRoll[] = date("D", $actualDate)." ".$i;
      $to = $year."-".$month."-".$i." 23:59:59";
    }
  }
}

$count = count($daysOfPayRoll);

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Constructora Estelar")
->setLastModifiedBy("Constructora Estelar")
->setTitle("Project payroll")
->setSubject("Project payroll")
->setDescription("Project payroll.")
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

$objPHPExcel->getActiveSheet()->setCellValue($columns[0].$row_count, $proyecto["nombre"].' PAYROLL');
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




// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle($proyecto["nombre"].' PAYROLL');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$proyecto["nombre"].'_payroll.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>