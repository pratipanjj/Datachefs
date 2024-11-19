<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Asia/Bangkok');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("HR Admin")
	->setLastModifiedBy("HR Admin")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'เลขประจำตัวพนักงาน')
	->setCellValue('B1', 'ชื่อพนักงาน')
	->setCellValue('C1', 'ส่วนที่สังกัด')
	->setCellValue('D1', 'แผนกที่สังกัด')
	->setCellValue('E1', 'บทเรียนที่สอบ')
	->setCellValue('F1', 'คะแนนสอบ (คิดเป็น %)')
	->setCellValue('G1', 'ผลการทดสอบ')
	->setCellValue('G2', 'ครั้งที่ 1')
	->setCellValue('H2', 'วันที่สอบ ครั้งที่ 1')
	->setCellValue('I2', 'ครั้งที่ 2')
	->setCellValue('J2', 'วันที่สอบ ครั้งที่ 2')
	->setCellValue('K1', 'ประจำปี');

// Write data from MySQL result
require_once ('../../_screen/backend/config.php');

$strSQL = "SELECT * FROM score WHERE 1 ORDER BY sc_id";
$objQuery = mysqli_query($conn, $strSQL);
$i = 3;
while($objResult = mysqli_fetch_array($objQuery))
{
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, " ".$objResult["emp_id"]);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $objResult["emp_name"]);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $objResult["emp_section"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $objResult["emp_department"]);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $objResult["sc_lesson"]);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $objResult["sc_point"]);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $objResult["sc_status1"]);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $objResult["sc_status1_date"]);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $objResult["sc_status2"]);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $objResult["sc_status2_date"]);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $objResult["sc_year"]);
	$i++;
}
mysqli_close($conn);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('My Report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel 2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "TrainingReport.xlsx";
$objWriter->save($strFileName);

// Echo memory peak usage
echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
?>