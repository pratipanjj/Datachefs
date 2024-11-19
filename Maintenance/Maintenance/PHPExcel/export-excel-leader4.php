<?php
  require_once ('../Screen/backend/config.php');
  require_once 'Classes/PHPExcel.php';
  $objPHPExcel = new PHPExcel();
  $activeSheet = $objPHPExcel->getActiveSheet();

  $objPHPExcel->getProperties()->setCreator("EN Admin")
  ->setLastModifiedBy("EN Admin")
  ->setTitle("Maintenance Report")
  ->setSubject("Maintenance Report")
  ->setDescription("Document for Office 2007")
  ->setKeywords("")
  ->setCategory("");

  $BStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

  // Set Text Center
  $activeSheet->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);

  $activeSheet->getColumnDimension('A')->setWidth(20);
  $activeSheet->getColumnDimension('B')->setWidth(20);
  $activeSheet->getColumnDimension('C')->setWidth(25);
  $activeSheet->getColumnDimension('D')->setWidth(15);
  $activeSheet->getColumnDimension('E')->setWidth(15);
  $activeSheet->getColumnDimension('F')->setWidth(25);
  $activeSheet->getColumnDimension('G')->setWidth(15);
  $activeSheet->getColumnDimension('H')->setWidth(15);
  $activeSheet->getColumnDimension('I')->setWidth(20);

  $activeSheet->getStyle('A1:I999')->getAlignment()->setWrapText(true); 

// Add some data
  $activeSheet->setCellValue('A1', 'รอปิดงาน')
              ->setCellValue('A2', 'ชื่อทรัพย์สิน/เครื่องจักร')
              ->setCellValue('B2', 'รหัสทรัพย์สิน/รหัสภายใน')
              ->setCellValue('C2', 'วัน/เวลาที่แจ้ง')
              ->setCellValue('D2', 'ประเภทงาน')
              ->setCellValue('E2', 'ความสำคัญ')
              ->setCellValue('F2', 'รายละเอียดการชำรุด/งานปรับปรุง')
              ->setCellValue('G2', 'ผลกระทบ')
              ->setCellValue('H2', 'ผู้แจ้ง')
              ->setCellValue('I2', 'หน่วยงาน');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
    array(
      'font' => array(
        // 'bold' => true, //ทำหนังสือตัวหน้า
        'size' => 18,
        'name' => 'Arial'
      )
    )
  );

  $i = 3;
  $sql = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_Status = 4 ORDER BY MRA_Priority DESC, MRA_Datetime DESC";
  $result = sqlsrv_query($conn, $sql);

		if (sqlsrv_has_rows($result) != 0){
      // $classMySec = new classMySec();
      while ($row = sqlsrv_fetch_array($result)){
        $ref = $row["MRA_MachineCode"];
				$sqlref = "SELECT RAC_InternalCode FROM RegistrationAssetsControl WHERE RAC_ReferenceNumber = '$ref'";
				$queryref = sqlsrv_query($conn, $sqlref) or die(print_r(sqlsrv_errors(), true));
        $rowref = sqlsrv_fetch_array($queryref);
        
        $activeSheet->setCellValue('A'. $i, $row["MRA_MachineName"]);
        if(empty($rowref["RAC_InternalCode"]) == true){
          $activeSheet->setCellValue('B'. $i, $row["MRA_MachineCode"]);
        }else{
          $activeSheet->setCellValue('B'. $i, $row["MRA_MachineCode"] . ' / ' . $rowref["RAC_InternalCode"]);
        }
        $activeSheet->setCellValue('C'. $i, $row["MRA_Datetime"]);
        $activeSheet->setCellValue('D'. $i, $row["MRA_WorkType"]);
        $activeSheet->setCellValue('E'. $i, $row["MRA_Priority"]);
        $activeSheet->setCellValue('F'. $i, $row["MRA_Description"]);
        $activeSheet->setCellValue('G'. $i, $row["MRA_Effect"]);
        $activeSheet->setCellValue('H'. $i, $row["MRA_Informer"]);
        $activeSheet->setCellValue('I'. $i, $row["MRA_WorkUnitName"]);
        $i++;
      }
    }
  
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="รอปิดงาน.xlsx"');
  header('Cache-Control: max-age=0');

  
  ob_end_clean();
  $objWriter->save('php://output');
?>
