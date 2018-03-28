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

$sql = "SELECT p.nombre, SUM(HOUR(pr.total_horas)) as total FROM proyectos as p INNER JOIN payroll as pr ON pr.id_proyecto = p.idproyecto;";
$sql2 = "SELECT p.nombre, IFNULL((SELECT SUM(HOUR(total_horas)) FROM payroll where id_proyecto = p.idproyecto),0) as total FROM proyectos as p";

$consulta=mysql_query($sql, $conexionestelar) or die(mysql_error());
$row=mysql_fetch_assoc($consulta);

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

// Agregar Informacion
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Valor 1')
->setCellValue('B1', 'Valor 2')
->setCellValue('C1', 'Total')
->setCellValue('A2', '10')
->setCellValue('C2', '=sum(A2:B2)');

$row = 0; // 1-based index
$col = 0;
while($col < 5) {
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $col."-".$row);
	$col++;
    $row++;
}

$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E05CC2')
            )
        )

);

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>