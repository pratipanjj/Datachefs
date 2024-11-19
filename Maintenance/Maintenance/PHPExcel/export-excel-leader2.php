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
  $activeSheet->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $activeSheet->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);

  $activeSheet->getColumnDimension('A')->setWidth(20);
  $activeSheet->getColumnDimension('B')->setWidth(20);
  $activeSheet->getColumnDimension('C')->setWidth(25);
  $activeSheet->getColumnDimension('D')->setWidth(25);
  $activeSheet->getColumnDimension('E')->setWidth(15);
  $activeSheet->getColumnDimension('F')->setWidth(20);
  $activeSheet->getColumnDimension('G')->setWidth(25);
  $activeSheet->getColumnDimension('H')->setWidth(15);
  $activeSheet->getColumnDimension('I')->setWidth(15);
  $activeSheet->getColumnDimension('J')->setWidth(25);
  $activeSheet->getColumnDimension('K')->setWidth(25);
  

  $activeSheet->getStyle('A1:I999')->getAlignment()->setWrapText(true); 

// Add some data
  $activeSheet->setCellValue('A1', 'แจ้งซ่อมใหม่')
              ->setCellValue('A2', 'ชื่อทรัพย์สิน/เครื่องจักร')
              ->setCellValue('B2', 'รหัสทรัพย์สิน/รหัสภายใน')
              ->setCellValue('C2', 'วัน/เวลาที่แจ้ง')
              ->setCellValue('D2', 'วัน/เวลาที่อยากให้เสร็จ')
              ->setCellValue('E2', 'ประเภทงาน')
              ->setCellValue('F2', 'ความสำคัญ')
              ->setCellValue('G2', 'รายละเอียดการชำรุด/งานปรับปรุง')
              ->setCellValue('H2', 'ผลกระทบ')
              ->setCellValue('I2', 'ผู้แจ้ง')
              ->setCellValue('J2', 'หน่วยงาน')
              ->setCellValue('K2', 'ช่างที่รับงาน');

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
  $sql = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_Status = 2 ORDER BY MRA_Priority DESC, MRA_Datetime DESC";  
  $result = sqlsrv_query($conn, $sql);
  if (sqlsrv_has_rows($result) != 0){
    while ($row = sqlsrv_fetch_array($result)){
      $id1 = $row["MRA_ID"];
				$sql1 = "SELECT MJ_DatetimeFinish, MJ_EngineerCode, MJ_EngineerCode2 FROM MaintenanceJoblist WHERE MRA_ID = '$id1' AND MJ_Status = 2";
				$result1 = sqlsrv_query($conn, $sql1) or die(print_r(sqlsrv_errors(), true));
				$rows = sqlsrv_fetch_array($result1);

				$code1 = $rows["MJ_EngineerCode"];
				$code2 = $rows["MJ_EngineerCode2"];

				$sql2 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code1}%'";
				$result2 = sqlsrv_query($conn, $sql2) or die(print_r(sqlsrv_errors(), true));
				$name1 = sqlsrv_fetch_array($result2);

				$sql3 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code2}%'";
				$result3 = sqlsrv_query($conn, $sql3) or die(print_r(sqlsrv_errors(), true));
				$name2 = sqlsrv_fetch_array($result3);

				$ref = $row["MRA_MachineCode"];
				$sqlref = "SELECT RAC_InternalCode FROM RegistrationAssetsControl WHERE RAC_ReferenceNumber = '$ref'";
				$queryref = sqlsrv_query($conn, $sqlref);
				$rowref = sqlsrv_fetch_array($queryref);

				$activeSheet->setCellValue('A'. $i, $row["MRA_MachineName"]);

				if(empty($rowref["RAC_InternalCode"]) == true){
					$activeSheet->setCellValue('B'. $i, $row["MRA_MachineCode"]);
				}
				else
				{
					$activeSheet->setCellValue('B'. $i, $row["MRA_MachineCode"] . ' / ' . $rowref["RAC_InternalCode"]);
				}

        $activeSheet->setCellValue('C'. $i, $row["MRA_Datetime"]);
				if($rows["MJ_DatetimeFinish"] != null ){
          $activeSheet->setCellValue('D'. $i, $rows["MJ_DatetimeFinish"]);
				}else{
          $activeSheet->setCellValue('D'. $i, "-");
				}
        $activeSheet->setCellValue('E'. $i, $row["MRA_WorkType"]);
        $activeSheet->setCellValue('F'. $i, $row["MRA_Priority"]);
        $activeSheet->setCellValue('G'. $i, $row["MRA_Description"]);
        $activeSheet->setCellValue('H'. $i, $row["MRA_Effect"]);
        $activeSheet->setCellValue('I'. $i, $row["MRA_Informer"]);
        $activeSheet->setCellValue('J'. $i, $row["MRA_WorkUnitName"]);
        $activeSheet->setCellValue('K'. $i, $name1["E_LocalFirstName"] . ' , ' . $name2["E_LocalFirstName"]);
        $i++;
    }
  }







  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="กำลังดำเนินการ.xlsx"');
  header('Cache-Control: max-age=0');

  ob_end_clean();
  $objWriter->save('php://output');
?>
