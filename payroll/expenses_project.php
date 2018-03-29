<?php
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

$sql = "SELECT p.idproyecto as id, p.nombre, IFNULL((SELECT SUM(cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))) FROM payroll where id_proyecto = p.idproyecto),0) as horas, IFNULL((SELECT SUM(IFNULL(cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2))*pago,0))  FROM payroll where id_proyecto = p.idproyecto),0) as total FROM proyectos as p";
$consulta=mysql_query($sql, $conexionestelar) or die(mysql_error());
$row_proyectos=mysql_fetch_assoc($consulta);

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Constructora Estelar")
->setLastModifiedBy("Constructora Estelar")
->setTitle("Expenses per project")
->setSubject("Expenses per project")
->setDescription("All of the expenses per project.")
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
$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, 'ALL PROJECTS EXPENSES');

do
{
	$row_count += 2;
	//$objPHPExcel->getActiveSheet()->mergeCells("B".$row_count.":E".$row_count);
	$objPHPExcel->getActiveSheet()->mergeCells("B".$row_count.":C".$row_count);
	$objPHPExcel->getActiveSheet()->getStyle("B".$row_count.":C".$row_count)->applyFromArray(
	        array(
	            'fill' => array(
	                'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                'color' => array('rgb' => 'a9a0a0')
	            ),
	            'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
	        )

	);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, $row_proyectos["nombre"]);

	$row_count += 1;
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, 'Hours:');
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_count, $row_proyectos["horas"]);

	$row_count += 1;
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_count, 'Total:');
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_count, $row_proyectos["total"]);

	$row_count -=2;
	$objPHPExcel->getActiveSheet()->mergeCells("E".$row_count.":G".$row_count);
	$objPHPExcel->getActiveSheet()->getStyle("E".$row_count.":G".$row_count)->applyFromArray(
	        array(
	            'fill' => array(
	                'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                'color' => array('rgb' => '77e2fb')
	            ),
	            'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
	        )
	);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_count, 'Workers');

	$row_count += 1;
	$sql_workers = "SELECT vt.nombre, SUM(IFNULL(cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)),0)) as horas, SUM(IFNULL(cast(time_to_sec(total_horas) / (60 * 60) as decimal(10, 2)),0) * pr.pago) as total FROM vista_trabajadores as vt INNER JOIN payroll as pr ON pr.id_trabajador = vt.idusuario INNER JOIN proyectos as p ON p.idproyecto = pr.id_proyecto WHERE p.idproyecto = ".$row_proyectos["id"]." GROUP BY vt.idusuario";
	$consulta_workers=mysql_query($sql_workers, $conexionestelar) or die(mysql_error());
	while($row_workers = mysql_fetch_assoc($consulta_workers))
	{
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_count, $row_workers["nombre"]);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_count, $row_workers["horas"]." Hours");
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_count, $row_workers["total"]);
		$row_count += 1;
	}

	$row_count += 2;
} while($row_proyectos=mysql_fetch_assoc($consulta));




// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Expenses per project');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="expenses.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>