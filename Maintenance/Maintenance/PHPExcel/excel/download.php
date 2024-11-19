<?php

  require_once 'Classes/PHPExcel.php';
  $objPHPExcel = new PHPExcel();
  $activeSheet = $objPHPExcel->getActiveSheet();

    // set column width
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6.15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.86);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9.50);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(21.29);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22.30);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6.50);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13.58);
  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16.62);
  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13.96);
  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.58);

  
  $objPHPExcel->getActiveSheet()
              ->getPageSetup()
              ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  $objPHPExcel->getActiveSheet()
              ->getPageSetup()
              ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  $objPHPExcel->getActiveSheet()
              ->getPageSetup()
              ->setScale(73);

// $objPHPExcel->getActiveSheet()
//             ->getPageSetup()->setPaperSize($PAGESETUP_PAPER_SIZE_A4);

  // $objPHPExcel->getActiveSheet()
  //             ->getPageSetup()
  //             ->setPrintArea('A1:J46');

  // การ set ข้อความขึ้นมาเองเป็นการจำลอง
  $activeSheet->setCellValue('A18', '1')
              ->setCellValue('B18', '411-030-22 เนื้อกุ้งขาวหัก 123-308 ตัว/ถุง')
              ->setCellValue('F18', '01')
              ->setCellValue('G18', '30.00 กก.')
              ->setCellValue('H18', '205.00')
              ->setCellValue('I18', '')
              ->setCellValue('J18', '6,150.00');

  // การ set ข้อความหัวกระดาษ Header
  // $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&R&H&10**เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากรด้วยวิธีการทางอิเล็กทรอนิกส์**');
  $objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.8);
  $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.92);
  $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.41);
  $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.7);


  //-------------------------------------------------------------------------------------------------------------------------------------------------------

  // print_r($_POST);
  if(isset($_POST['save'])){
    $count = $_POST['count'];
    $count = intval($count);
    // $NV = $_POST['NV'];
    // $IV = $_POST['IV'];
    
    // echo($NV);
    // echo($IV);

    // echo($count)."<br>";
    // echo (gettype($count));

    $num=0;
    $countpageNV = intval($count/15)+1;
    $countpageIV = intval($count/11)+1;

    // -----------------------------------------------------NV------------------------------------------------------------------------------
    if(isset($_POST['NV'])){
      for($i=0 ; $i<$countpageNV ; $i++){
        // echo($i)."<br>";

        $num = $i * 46;
        // echo ($num)."<br>";
        $activeSheet->setCellValue('A'.($num+1), 'บริษัท มารีนโกลด์โปรดักส์ จำกัด')
                    ->setCellValue('A'.($num+2), '57/37 หมู่ที่ 4 ถนนเอกชัย ต.โคกขาม อ.เมืองสมุทรสาคร จ.สมุทรสาคร 74000')
                    ->setCellValue('A'.($num+3), '0-3486-4091-4 แฟกซ์:0-3483-4486-7,0-3486-4100')
                    ->setCellValue('G'.($num+3), 'ใบส่งสินค้า/ใบแจ้งหนี้')
                    ->setCellValue('A'.($num+4), 'เลขประจำตัวผู้เสียภาษี')
                    ->setCellValue('D'.($num+4), '0745543001278')
                    ->setCellValue('E'.($num+4), 'สำนักงานใหญ่')
                    ->setCellValue('A'.($num+6), 'ลูกค้า')
                    ->setCellValue('G'.($num+6), 'เลขที่ใบกำกับ')
                    ->setCellValue('G'.($num+8), 'วันที่')
                    ->setCellValue('G'.($num+10), 'เครดิต ... วัน')
                    ->setCellValue('H'.($num+10), 'ครบกำหนด')
                    ->setCellValue('A'.($num+11), 'เลขประจำตัวผู้เสียภาษี')
                    ->setCellValue('A'.($num+12), 'โทร')
                    ->setCellValue('G'.($num+12), 'เลขที่ใบสั่งขาย')
                    ->setCellValue('I'.($num+12), 'วันที่')
                    ->setCellValue('A'.($num+13), 'อ้างอิง')
                    ->setCellValue('G'.($num+13), 'พนักงานขาย')
                    ->setCellValue('A'.($num+14), 'ขนส่งโดย')
                    ->setCellValue('G'.($num+14), 'เขตการขาย')
                    ->setCellValue('A'.($num+16), 'No.')
                    ->setCellValue('B'.($num+16), 'รหัสสินค้า/รายละเอียด')
                    ->setCellValue('F'.($num+16), 'คลัง')
                    ->setCellValue('G'.($num+16), 'จำนวน')
                    ->setCellValue('H'.($num+16), 'หน่วยละ')
                    ->setCellValue('I'.($num+16), 'ส่วนลด')
                    ->setCellValue('J'.($num+16), 'จำนวนเงิน');
        
        //column ล่าง -> แสดงช่วงสุดท้ายของข้อมูล หากมีหลายหน้าจะปรากฏหน้าสุดท้ายเพียงหน้าเดียว
        if($countpageNV == ($i+1) ){
          $activeSheet->setCellValue('A'.($num+34), 'หมายเหตุ')
                      ->setCellValue('H'.($num+34), 'รวมเป็นเงิน')
                      ->setCellValue('H'.($num+35), 'หัก  ส่วนลด')
                      ->setCellValue('H'.($num+36), 'ยอดหลังหักส่วนลด')
                      ->setCellValue('H'.($num+37), 'หัก  เงินมัดจำ  #')
                      ->setCellValue('H'.($num+38), '~TXT1')
                      ->setCellValue('H'.($num+39), 'จำนวนภาษีมูลค่าเพิ่ม')
                      ->setCellValue('H'.($num+40), '~TXT2')
                      ->setCellValue('A'.($num+42), 'ได้รับสินค้าตามรายการข้างบนนี้ไว้ถูกต้อง')
                      ->setCellValue('F'.($num+42), 'เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากรด้วยวิธีการทางอิเล็กทรอนิกส์')
                      ->setCellValue('A'.($num+43), 'และอยู่ในสภาพเรียบร้อยทุกประการ')
                      ->setCellValue('F'.($num+43), 'ในนาม')
                      ->setCellValue('G'.($num+43), 'บริษัท มารีนโกลด์โปรดักส์ จำกัด')
                      ->setCellValue('A'.($num+45), 'ผู้รับสินค้า __________________')
                      ->setCellValue('E'.($num+45), 'วันที่ ___/___/___')
                      ->setCellValue('F'.($num+45), 'ผู้ส่งสินค้า __________________');

          $objPHPExcel->getActiveSheet()->getStyle('I'.($num+34).':'.'J'.($num+41))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $objPHPExcel->getActiveSheet()->getStyle('A'.($num+42).':'.'J'.($num+46))->applyFromArray(
            array(
              'borders'=>array(
                'outline'=>array(
                  'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
              )
            )
          );
          $objPHPExcel->getActiveSheet()->getStyle('A'.($num+34).':'.'J'.($num+41))->applyFromArray(
            array(
              'borders'=>array(
                'outline'=>array(
                  'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
              )
            )
          );

        }
                    
        // set roe height
        $objPHPExcel->getActiveSheet()->getRowDimension($num+1)->setRowHeight(28.44);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+2)->setRowHeight(23.94);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+3)->setRowHeight(35.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+4)->setRowHeight(23.94);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+5)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+6)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+7)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+8)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+9)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+10)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+11)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+12)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+13)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+14)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+15)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+16)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+17)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+18)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+19)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+20)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+21)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+22)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+23)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+24)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+25)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+26)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+27)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+28)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+29)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+30)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+31)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+32)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+33)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+34)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+35)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+36)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+37)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+38)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+39)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+40)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+41)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+42)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+43)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+44)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+45)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+46)->setRowHeight(9.69);

        // เส้นตาราง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+33))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+33))->applyFromArray(
          array(
            'borders'=>array(
              'outline'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN
              )
            )
          )
        );
      
        // หัวตาราง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+16))->applyFromArray(
          array(
            'borders'=>array(
              'outline'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN
              )
            ),
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            ),
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 10,
              'name' => 'Arial'
            )
          )
        );
      
        // เลือก font และ size ตั้งค่าA1 
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+1).':'.'A'.($num+1))->applyFromArray(
          array(
            'font' => array(
              'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 14,
              'name' => 'Arial'
            )
          )
        );
        // เลือก font และ size ตั้งค่าA1 
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+2).':'.'A'.($num+3))->applyFromArray(
          array(
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 12,
              'name' => 'Arial'
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('G'.($num+3).':'.'G'.($num+3))->applyFromArray(
          array(
            'font' => array(
              'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 12,
              'name' => 'Arial'
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+4).':'.'J'.($num+46))->applyFromArray(
          array(
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 10,
              'name' => 'Arial'
            )
          )
        );
        // จัดข้อมูลให้อยู่กึ่งกลาง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+18).':'.'A'.($num+32))->applyFromArray(
          array(
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('F'.($num+18).':'.'F'.($num+32))->applyFromArray(
          array(
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('G'.($num+18).':'.'J'.($num+32))->applyFromArray(
          array(
            // ตัวอักษรอยู่ขวาเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 
            )
          )
        );
      
        // กึ่งกลางเซลล์ จากบนล่าง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+1).':'.'J'.($num+46))->applyFromArray(
          array(
          'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
          )
        );

        // ผสานเซลล์
        for($j = 16 ; $j<=33 ; $j++){
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($num+$j).':'.'E'.($num+$j));
        }
      }
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="NV.xlsx"');
      header('Cache-Control: max-age=0');
    
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
    }

    // -----------------------------------------------------IV------------------------------------------------------------------------------

    else if(isset($_POST['IV'])){ //IV
      for($i=0 ; $i<$countpageIV ; $i++){
        $num = $i * 45;
        $activeSheet->setCellValue('A'.($num+1), 'บริษัท มารีนโกลด์โปรดักส์ จำกัด')
                    ->setCellValue('A'.($num+2), '57/37 หมู่ที่ 4 ถนนเอกชัย ต.โคกขาม อ.เมืองสมุทรสาคร จ.สมุทรสาคร 74000')
                    ->setCellValue('A'.($num+3), '0-3486-4091-4 แฟกซ์:0-3483-4486-7,0-3486-4100')
                    ->setCellValue('G'.($num+3), 'ใบกำกับภาษี/ใบส่งสินค้า/ใบแจ้งหนี้')
                    ->setCellValue('A'.($num+4), 'เลขประจำตัวผู้เสียภาษี')
                    ->setCellValue('D'.($num+4), '0745543001278')
                    ->setCellValue('E'.($num+4), 'สำนักงานใหญ่')
                    ->setCellValue('A'.($num+6), 'ลุกค้า')
                    ->setCellValue('G'.($num+6), 'เลขที่ใบกำกับ')
                    ->setCellValue('G'.($num+8), 'วันที่')
                    ->setCellValue('G'.($num+10), 'เครดิต ... วัน')
                    ->setCellValue('H'.($num+10), 'ครบกำหนด')
                    ->setCellValue('A'.($num+11), 'เลขประจำตัวผู้เสียภาษี')
                    ->setCellValue('A'.($num+12), 'โทร')
                    ->setCellValue('G'.($num+12), 'เลขที่ใบสั่งขาย')
                    ->setCellValue('I'.($num+12), 'วันที่')
                    ->setCellValue('A'.($num+13), 'อ้างอิง')
                    ->setCellValue('G'.($num+13), 'พนักงานขาย')
                    ->setCellValue('A'.($num+14), 'ขนส่งโดย')
                    ->setCellValue('G'.($num+14), 'เขตการขาย')
                    ->setCellValue('A'.($num+16), 'No.')
                    ->setCellValue('B'.($num+16), 'รหัสสินค้า/รายละเอียด')
                    ->setCellValue('F'.($num+16), 'คลัง')
                    ->setCellValue('G'.($num+16), 'จำนวน')
                    ->setCellValue('H'.($num+16), 'หน่วยละ')
                    ->setCellValue('I'.($num+16), 'ส่วนลด')
                    ->setCellValue('J'.($num+16), 'จำนวนเงิน');
        
        //column ล่าง -> แสดงช่วงสุดท้ายของข้อมูล หากมีหลายหน้าจะปรากฏหน้าสุดท้ายเพียงหน้าเดียว
        if($countpageIV == ($i+1) ){
          $activeSheet->setCellValue('A'.($num+30), 'หมายเหตุ')
                      ->setCellValue('H'.($num+30), 'รวมเป็นเงิน')
                      ->setCellValue('H'.($num+31), 'หัก  ส่วนลด')
                      ->setCellValue('H'.($num+32), 'ยอดหลังหักส่วนลด')
                      ->setCellValue('H'.($num+33), 'หัก  เงินมัดจำ  #')
                      ->setCellValue('H'.($num+34), '~TXT1')
                      ->setCellValue('H'.($num+36), 'สินค้ายกเลิกภาษีมูลค่าเพิ่ม')
                      ->setCellValue('H'.($num+37), 'มูลค้าสิรค้าอัตรา')
                      ->setCellValue('H'.($num+38), 'จำนวนภาษีมูลค้าเพิ่ม')
                      ->setCellValue('H'.($num+39), 'จำนวนเงินรวมทั้งสิ้น')
                      ->setCellValue('A'.($num+41), 'ได้รับสินค้าตามรายการข้างบนนี้ไว้ถูกต้อง')
                      ->setCellValue('F'.($num+41), 'เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากรด้วยวิธีการทางอิเล็กทรอนิกส์')
                      ->setCellValue('A'.($num+42), 'และอยู่ในสภาพเรียบร้อยทุกประการ')
                      ->setCellValue('F'.($num+42), 'ในนาม')
                      ->setCellValue('G'.($num+42), 'บริษัท มารีนโกลด์โปรดักส์ จำกัด')
                      ->setCellValue('A'.($num+44), 'ผู้รับสินค้า __________________')
                      ->setCellValue('E'.($num+44), 'วันที่ ___/___/___')
                      ->setCellValue('F'.($num+44), 'ผู้ส่งสินค้า __________________');

          $objPHPExcel->getActiveSheet()->getStyle('I'.($num+30).':'.'J'.($num+40))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $objPHPExcel->getActiveSheet()->getStyle('A'.($num+41).':'.'J'.($num+45))->applyFromArray(
            array(
              'borders'=>array(
                'outline'=>array(
                  'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
              )
            )
          );
          $objPHPExcel->getActiveSheet()->getStyle('A'.($num+30).':'.'J'.($num+40))->applyFromArray(
            array(
              'borders'=>array(
                'outline'=>array(
                  'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
              )
            )
          );

        }
                    
        // set roe height
        $objPHPExcel->getActiveSheet()->getRowDimension($num+1)->setRowHeight(28.44);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+2)->setRowHeight(23.94);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+3)->setRowHeight(35.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+4)->setRowHeight(23.94);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+5)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+6)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+7)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+8)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+9)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+10)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+11)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+12)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+13)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+14)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+15)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+16)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+17)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+18)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+19)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+20)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+21)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+22)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+23)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+24)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+25)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+26)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+27)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+28)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+29)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+29)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+30)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+31)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+32)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+33)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+34)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+35)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+36)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+37)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+38)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+39)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+40)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+41)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+42)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+43)->setRowHeight(9.69);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+44)->setRowHeight(23.19);
        $objPHPExcel->getActiveSheet()->getRowDimension($num+45)->setRowHeight(9.69);

        // เส้นตาราง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+29))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+29))->applyFromArray(
          array(
            'borders'=>array(
              'outline'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN
              )
            )
          )
        );
      
        // หัวตาราง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+16).':'.'J'.($num+16))->applyFromArray(
          array(
            'borders'=>array(
              'outline'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN
              )
            ),
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            ),
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 10,
              'name' => 'Arial'
            )
          )
        );
      
        // เลือก font และ size ตั้งค่าA1 
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+1).':'.'A'.($num+1))->applyFromArray(
          array(
            'font' => array(
              'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 14,
              'name' => 'Arial'
            )
          )
        );
        // เลือก font และ size ตั้งค่าA1 
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+2).':'.'A'.($num+3))->applyFromArray(
          array(
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 12,
              'name' => 'Arial'
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('G'.($num+3).':'.'G'.($num+3))->applyFromArray(
          array(
            'font' => array(
              'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 12,
              'name' => 'Arial'
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+4).':'.'J'.($num+45))->applyFromArray(
          array(
            'font' => array(
              // 'bold' => true, //ทำหนังสือตัวหน้า
              'size' => 10,
              'name' => 'Arial'
            )
          )
        );
        // จัดข้อมูลให้อยู่กึ่งกลาง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+18).':'.'A'.($num+32))->applyFromArray(
          array(
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('F'.($num+18).':'.'F'.($num+29))->applyFromArray(
          array(
            // ตัวอักษรอยู่กึ่งกลางเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle('G'.($num+18).':'.'J'.($num+29))->applyFromArray(
          array(
            // ตัวอักษรอยู่ขวาเซลล์
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 
            )
          )
        );
      
        // กึ่งกลางเซลล์ จากบนล่าง
        $objPHPExcel->getActiveSheet()->getStyle('A'.($num+1).':'.'J'.($num+45))->applyFromArray(
          array(
          'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
          )
        );

        // ผสานเซลล์
        for($j = 16 ; $j<=29 ; $j++){
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($num+$j).':'.'E'.($num+$j));
        }
      }
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="IV.xlsx"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
    }
  }  

  //-------------------------------------------------------------------------------------------------------------------------------------------------------



  // print_r($_POST);
  // if(isset($_POST['save'])){
  //   $count = $_POST['count'];
  //   $activeSheet->setCellValue('E7', 'สวัสดีจ้า');
  // }

  // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  // header('Content-Disposition: attachment;filename="WORK.xlsx"');
  // header('Cache-Control: max-age=0');

  // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  // $objWriter->save('php://output');
?>
