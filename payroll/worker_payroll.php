<?php
if (!isset($_GET["worker"]))
{
	echo "Missing variable worker";exit;
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

/*$sql = "SELECT p.idproyecto as id, p.nombre, IFNULL((SELECT SUM(HOUR(total_horas)) FROM payroll where id_proyecto = p.idproyecto),0) as horas, IFNULL((SELECT SUM(IFNULL(HOUR(total_horas)*pago,0))  FROM payroll where id_proyecto = p.idproyecto),0) as total FROM proyectos as p";
$consulta=mysql_query($sql, $conexionestelar) or die(mysql_error());*/

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

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);

$row_count = 2;
//$objPHPExcel->getActiveSheet()->mergeCells("B".$row_count.":E".$row_count);
$objPHPExcel->getActiveSheet()->mergeCells("B".$row_count.":G".$row_count);
$objPHPExcel->getActiveSheet()->getStyle("B".$row_count.":G".$row_count)->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, 'Nombre trabajador PAYROLL');




// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Nombre trabajador PAYROLL');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nombretrabajador_payroll.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>