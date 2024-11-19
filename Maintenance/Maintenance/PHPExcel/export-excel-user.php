<?php
  require_once ('../Screen/backend/config.php');
  require_once 'Classes/PHPExcel.php';
  $objPHPExcel = new PHPExcel();
  // $activeSheet = $objPHPExcel->getActiveSheet();

  $objPHPExcel->getProperties()->setCreator("EN Admin")
  ->setLastModifiedBy("EN Admin")
  ->setTitle("Maintenance Report")
  ->setSubject("Maintenance Report")
  ->setDescription("Document for Office 2007")
  ->setKeywords("")
  ->setCategory("");

  $BStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

  // Set Text Center
  $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  // Add some data
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('A1:A2')->setCellValue('A1', 'หน่วยงาน')
  ->mergeCells('B1:B2')->setCellValue('B1', 'ผู้รับผิดชอบ')
  ->mergeCells('C1:C2')->setCellValue('C1', 'กำหนดเสร็จ')
  ->mergeCells('D1:D2')->setCellValue('D1', 'วัน / เวลาที่เสร็จ')
  ->mergeCells('E1:E2')->setCellValue('E1', 'สถานะ');

  // Set Width
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

  // compare date, time, datetime function
  function DateTimeDiff($strDateTime1,$strDateTime2)
  {
  return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60 for datetime
  }

  $strSQL = "SELECT MaintenanceJoblist.MJ_DatetimeFinish, MaintenanceEngineerUpdate.MEU_DatetimeFinish, MaintenanceJoblist.MRA_WorkUnitName, MaintenanceJoblist.MJ_EngineerCode, MaintenanceJoblist.MJ_EngineerCode2
  FROM MaintenanceJoblist	INNER JOIN MaintenanceEngineerUpdate ON MaintenanceJoblist.MRA_ID = MaintenanceEngineerUpdate.MRA_ID ";
  $objQuery = sqlsrv_query($conn, $strSQL);
  $i = 3;
  while($row = sqlsrv_fetch_array($objQuery))
  {
  $objPHPExcel->getActiveSheet()->setCellValue('A'. $i, $row["MRA_WorkUnitName"]);

  $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $i, $row["MJ_EngineerCode"].' / '.$row['MJ_EngineerCode2'], PHPExcel_Cell_DataType::TYPE_STRING);

  $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $row["MJ_DatetimeFinish"]);

  $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $row["MEU_DatetimeFinish"]);

  if(DateTimeDiff($row['MJ_DatetimeFinish'],$row['MEU_DatetimeFinish']) <= 0 )
  {
  $state = "เสร็จทันกำหนด";
  }
  elseif(DateTimeDiff($row['MJ_DatetimeFinish'],$row['MEU_DatetimeFinish']) > 0 )
  {
  $state = "เสร็จช้ากว่ากำหนด";
  }

  $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $state);

  $i++;
  }
  sqlsrv_close($conn);

  // Rename sheet
  $objPHPExcel->getActiveSheet()->setTitle('MaintenanceReport');
  
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="ExportExcel.xlsx"');
  header('Cache-Control: max-age=0');
  ob_end_clean();
  $objWriter->save('php://output');
?>
