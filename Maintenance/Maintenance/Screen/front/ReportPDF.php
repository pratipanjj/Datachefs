<?php 
require_once ('../backend/config.php');  
require_once ('../../tcpdf/tcpdf.php');

if(isset($_GET["ID"])){
    $WorkID = $_GET["ID"];
    $sql =  "SELECT MaintenanceRepairAdd.MRA_ID,MaintenanceRepairAdd.MRA_Datetime,MaintenanceRepairAdd.MRA_MachineCode,
    MaintenanceRepairAdd.MRA_MachineName,MaintenanceRepairAdd.MRA_WorkType,MaintenanceRepairAdd.MRA_Priority,MaintenanceRepairAdd.MRA_Description,
    MaintenanceRepairAdd.MRA_Effect,MaintenanceRepairAdd.MRA_Informer,MaintenanceRepairAdd.MRA_WorkUnitID,MaintenanceRepairAdd.MRA_WorkUnitName,
    MaintenanceRepairAdd.MRA_Status,MaintenanceJoblist.MJ_EngineerCode,MaintenanceJoblist.MJ_EngineerCode2,
    MaintenanceEngineerUpdate.MEU_DatetimeStart,MaintenanceEngineerUpdate.MEU_DatetimeFinish,MaintenanceEngineerUpdate.MEU_Cause,
    MaintenanceEngineerUpdate.MEU_Method,MaintenanceEngineerImage.MEI_ImageBefore0,MaintenanceEngineerImage.MEI_ImageAfter0,
    MaintenanceCloseJob.MCJ_CloseJob,MaintenanceCloseJob.MCJ_Leader,MaintenanceCloseJob.MCJ_DateTime,MaintenanceRepairCheck.MRC_Speed,
    MaintenanceRepairCheck.MRC_Coordinate,MaintenanceRepairCheck.MRC_Courteous,MaintenanceRepairCheck.MRC_Cleanness,
    MaintenanceRepairCheck.MRC_CleannessDetail,MaintenanceRepairCheck.MRC_Neatness,MaintenanceRepairCheck.MRC_NeatnessDetail,
    MaintenanceRepairCheck.MRC_Risk,MaintenanceRepairCheck.MRC_RiskDetail,MaintenanceRepairCheck.MRC_Checker,MaintenanceRepairCheck.MRC_Datetime,
    MaintenanceRepairCheck.MRC_CleannessDetail,MaintenanceRepairCheck.MRC_NeatnessDetail,MaintenanceRepairCheck.MRC_RiskDetail
    FROM MaintenanceRepairAdd
    LEFT OUTER JOIN MaintenanceJoblist ON MaintenanceJoblist.MRA_ID = MaintenanceRepairAdd.MRA_ID
    LEFT OUTER JOIN MaintenanceEngineerUpdate ON MaintenanceEngineerUpdate.MRA_ID = MaintenanceRepairAdd.MRA_ID
    LEFT OUTER JOIN MaintenanceEngineerImage ON MaintenanceEngineerImage.MEU_ID = MaintenanceEngineerUpdate.MEU_ID
	LEFT OUTER JOIN MaintenanceCloseJob ON MaintenanceCloseJob.MRA_ID = MaintenanceRepairAdd.MRA_ID
	LEFT OUTER JOIN MaintenanceRepairCheck ON MaintenanceRepairCheck.MRA_ID = MaintenanceRepairAdd.MRA_ID
    WHERE MaintenanceRepairAdd.MRA_ID = '$WorkID'
    ORDER BY MaintenanceRepairAdd.MRA_ID";

    $result = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($result);

    $EngineerName1 = '';
    $EngineerName2 = '';
    $EngineerName1 = $row["MJ_EngineerCode"];
    $EngineerName2 = $row["MJ_EngineerCode2"];

    $sql2 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$EngineerName1}%'";
    $result2 = sqlsrv_query($conn, $sql2) or die(print_r(sqlsrv_errors(), true));
    $EngineerName1 = sqlsrv_fetch_array($result2);
    // print_r($EngineerName1);

    $sql3 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$EngineerName2}%'";
    $result3 = sqlsrv_query($conn, $sql3) or die(print_r(sqlsrv_errors(), true));
    $EngineerName2 = sqlsrv_fetch_array($result3);

    class MYTCPDF extends TCPDF {
        public function Header() {
            $headerData = $this->getHeaderData();
            $this->setHeaderFont(array('freeserif', 'B', 12));
            $this->SetFont('freeserif', '', 10);
            $this->writeHTML($headerData['string']);
        }
        public function Footer() {
            $th=mktime(gmdate("H")+7,gmdate("i"),gmdate("m"),gmdate("d"),gmdate("Y"));
            $format="H:i:m";
            $timecount = date($format,$th);
            $this->SetY(-10);
            $this->SetFont('freeserif', '', 10);
            parent::Footer();
            $this->Cell(0, 5, "", 0, 1, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(0, 8,'วันที่พิมพ์ '.date("d-m-Y").' '.$timecount, 0, 1, 'R', 0, '', 0, false, 'T', 'M');
        }
    }
    $pdf = new MYTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='
    <style>
    td{
        height: 20px;
        text-align: center;
    }
    .right {
        position: absolute;
        right: 0px;
        width: 300px;
        border: 3px solid #73AD21;
        padding: 10px;
    }
    </style>
    <table style="height : 70px"; id="cssTable" cellpadding="2">
    <tr> 
        <td rowspan="2" width="124px"><img src="../../img/imgpdf.png"></td> 
        <td width="300px"></td> 
        <td style="font-size:12px" width="112px"></td>
    </tr>
    <tr> 
        <td style="font-size:13px" width="300px"><strong>รายงานการแจ้งซ่อมเครื่องจักร / <br>งานปรับปรุงเครื่องจักรและอุปกรณ์</strong></td>
        <td style="font-size:11px" width="112px">รหัสเอกสาร : EN-F09-08<br>วันที่ประกาศใช้ : 01/04/63</td>
        
    </tr>
    <tr> 
        <td style="font-size:10px">บริษัท มารีนโกลด์ โปรดักส์ จํากัด</td>
        <td></td>   
        <td width="112px"></td>
    </tr>
    </table>', $tc=array(0,0,0), $lc=array(0,0,0));

    $txt = implode("",$_GET);

    $MEU_DatetimeStart = str_replace("/","-",$row["MEU_DatetimeStart"]);
    $MEU_DatetimeFinish = str_replace("/","-",$row["MEU_DatetimeFinish"]);
    $MRA_Datetime = str_replace("/","-",$row["MRA_Datetime"]);
    $MRC_Datetime = str_replace("/","-",$row["MRC_Datetime"]);
    $MCJ_DateTime = str_replace("/","-",$row["MCJ_DateTime"]);

    $MRA_Datetime = new DateTime($MRA_Datetime);
    $DatetimeStart = new DateTime($MEU_DatetimeStart);
    $DatetimeFinish = new DateTime($MEU_DatetimeFinish);
    $DateTimeUserCheckCloseJop = new DateTime($MRC_Datetime);
    
    if ($row["MRA_Priority"] == 5 || $row["MRA_Priority"] == 4){
        $Priority = 'เร่งด่วน';
    }else{
        $Priority = 'ไม่เร่งด่วน';
    }

    if ($row["MRC_Coordinate"] == 'ยังไม่ดีเท่าที่ควร'){
        $Coordinate = 'พอใช้';
    }else{
        $Coordinate = $row["MRC_Coordinate"];
    }

    if($row["MRC_Risk"] == 'ไม่พบความเสี่ยง'){
        $Risk = 'ผ่าน';
    }else{
        $Risk = 'ไม่ผ่าน เนื่องจาก '.$row["MRC_RiskDetail"];
    }

    if (!empty($row["MRC_CleannessDetail"])){
        $CleannessDetail = 'เนื่องจาก '.$row["MRC_CleannessDetail"];
    }else{
        $CleannessDetail = '';
    }

    if (!empty($row["MRC_NeatnessDetail"])){
        $NeatnessDetail = 'เนื่องจาก '.$row["MRC_NeatnessDetail"];
    }else{
        $NeatnessDetail = '';
    }

    $Notthai = strpos($row["MRA_MachineCode"],"?");
    if($Notthai === false){
        $MRA_MachineCode = $row["MRA_MachineCode"];
    }else{
        $MRA_MachineCode = '-';
    }
    $JobYear = $MRA_Datetime->format('Y');

    $pdf->SetCreator('Mindphp');
    $pdf->SetAuthor('Mindphp Developer');
    $pdf->SetTitle('รายงานการแจ้งซ่อมเครื่องจักร / งานปรับปรุงเครื่องจักรและอุปกรณ์');
    $pdf->SetSubject('Mindphp Example');
    $pdf->SetKeywords('Mindphp, TCPDF, PDF, example, guide');
    // $heightTop = 45;
    // $HeaderMargin = 10;

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP , PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();
    // $pdf->Ln(5);

    $pdf->SetFont('freeserif', '', 12);
    $pdf->Ln(3);

    $pdf->MultiCell(70, 10, 'เลขที่งานแจ้งซ่อม/ปรับปรุง : '.$JobYear.'/'.$txt, 1, 'J', 0, 1, 130, 35, true, 0, false, true, 10, 'M', true);
    // -----------------------------------------------------------------------------------------------------------------------

    $datawork = '<table cellpadding="5">
        <tr>
            <td width = "25%"><strong>วันที่ :</strong> '.$MRA_Datetime->format('d-M-Y').'</td>
            <td colspan="4" width = "75%"><strong>เวลา :</strong> '.$MRA_Datetime->format('H:i').'</td>
        </tr>
        <tr>
            <td><strong>หน่วยงาน :</strong> '.$row["MRA_WorkUnitName"].'</td>
            <td width = "15%"><strong>ชื่อเครื่องจักร :</strong></td>
            <td width = "29%">'.$row["MRA_MachineName"].'</td>
            <td colspan="2" width = "31%"><strong>รหัสเครื่องจักร :</strong> '.$MRA_MachineCode.'</td>
        </tr>
        <tr>
            <td><strong>ประเภทงาน :</strong> '.$row["MRA_WorkType"].'</td>
            <td colspan="2" width = "30%"><strong>ความสำคัญของงาน :</strong> '.$Priority.'</td>
            <td width = "13%"><strong>ผลกระทบ :</strong></td>
            <td width = "32%">'.$row["MRA_Effect"].'</td>
        </tr>
        <tr>
            <td width = "33%"><strong>รายละเอียดการชำรุด/งานปรับปรุง :</strong></td>
            <td colspan="4" width = "67%">'.$row["MRA_Description"].'</td>
        </tr>
        <tr>
            <td colspan="5"><strong>ผู้แจ้งซ่อม / ปรับปรุงเครื่องจักร :</strong> '.$row["MRA_Informer"].'</td>
        </tr>
    </table>';

    $jud = '-------------------------------------------------------------------------------------------------------------------------------------<br>';

    $engineer = '<table cellpadding="3">
        <tr>
            <td colspan="2"><strong>ชื่อผู้ปฏิบัติงาน 1 :</strong> '.$EngineerName1["E_LocalFirstName"]." (รหัสพนักงาน ".$row["MJ_EngineerCode"].')</td>
            <td colspan="2"><strong>ชื่อผู้ปฏิบัติงาน 2 :</strong> '.$EngineerName2["E_LocalFirstName"]." (รหัสพนักงาน ".$row["MJ_EngineerCode2"].')</td>
        </tr>
        <tr>
            <td><strong>วันที่เริ่ม :</strong> '.$DatetimeStart->format('d-M-Y').'</td>
            <td><strong>เวลา :</strong> '.$DatetimeStart->format('H:i').'</td>
            <td><strong>วันที่เสร็จ :</strong> '.$DatetimeFinish->format('d-M-Y').'</td>
            <td><strong>เวลา :</strong> '.$DatetimeFinish->format('H:i').'</td>
        </tr>
    </table>';

    $pdf->writeHTMLCell(0, 0, '', '', $datawork, 0, 1, 0, true, 'J', true);

    $pdf->writeHTMLCell(0, 0, '', '', $jud, 0, 1, 0, true, 'J', true);

    // $pdf->MultiCell(55, 5, 'สรุปผลงานแจ้งซ่อม / ปรับปรุง', 1, '', 0, 1, '', '', true);
    $pdf->MultiCell(50, 10, 'สรุปผลงานแจ้งซ่อม / ปรับปรุง', 1, 'J', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln(15);

    $pdf->writeHTMLCell(0, 0, '', '', $engineer, 0, 1, 0, true, 'J', true);
    $pdf->Ln(5);
    
    $work = '<table border="1" cellpadding="5">
        <tr>
            <td><strong>สาเหตุ :</strong> <br>'.$row["MEU_Cause"].'</td>
            <td><strong>วิธีการซ่อม /ปรับปรุง :</strong> <br>'.$row["MEU_Method"].'</td>
        </tr>
        <tr>
            <td><strong>รูปก่อนทำ :</strong><img src="../../image_upload_engineer_before/'.$row["MEI_ImageBefore0"].'"></td>
            <td><strong>รูปหลังทำ :</strong><img src="../../image_upload_engineer_after/'.$row["MEI_ImageAfter0"].'"></td>
        </tr>
    </table>';

    $pdf->writeHTMLCell(0, 0, '', '', $work, 0, 1, 0, true, '', true);
    $pdf->Ln(5);

    $pdf->writeHTMLCell(0, 0, '', '', $jud, 0, 1, 0, true, 'J', true);
    // $pdf->Ln(5);

    $jobwork = '<table border="1" cellpadding="3">
        <tr nobr="true">
            <td width="360px">
                <strong>ผู้ตรวจรับงานซ่อม / ปรับปรุง :</strong> ' .$row["MRA_Informer"]. ' <strong>วันที่ :</strong> ' .$DateTimeUserCheckCloseJop->format('d-M-Y'). '<br>
                <strong>ความเร็ว :</strong> ' .$row["MRC_Speed"]. '<br>
                <strong>การประสานงาน หลังการซ่อม/ปรับปรุง :</strong> '.$Coordinate.'<br>
                <strong>ผลการตรวจความสำอาดของพื้นที่ : </strong>  '.$row["MRC_Cleanness"].$CleannessDetail.'<br>
                <strong>ความเรียบร้อยหลังการซ่อม : </strong>  '.$row["MRC_Neatness"].$NeatnessDetail.'<br>
                <strong>ประสิทธิภาพหลังการซ่อม : </strong>  '.$Risk.'
            </td>
            <td width="185px">
                <strong>ผลการสรุปงาน :</strong> ' .$row["MCJ_CloseJob"]. '<br>
                <strong>ผู้ปิดงานซ่อม  :</strong>  ' .$row["MCJ_Leader"]. '<br>
                <strong>วันที่</strong> ' .$row["MCJ_DateTime"]. '
            </td>
        </tr>
    </table>';


    // $pdf->Cell(0, 0, 'TEST CELL STRETCH: spacing', 1, 1, 'C', 0, '', 3);

    $pdf->writeHTMLCell(0, 0, '', '', $jobwork, 0, 1, 0, true, 'M', true);

    // $pdf->writeHTMLCell(0, 0, $jobwork, 1, 1, 'C', 0, '', 3);
    $pdf->Ln(5);

    // $pdf->writeHTML($html);
    ob_end_clean();
    $pdf->Output('RP.pdf', 'I'); 

}  
?>