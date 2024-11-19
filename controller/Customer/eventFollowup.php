<?php
require_once '../../configs/conn.php';
require_once  '../../function/LogSystem.php';

if (isset($_POST['issue'])) {

    $arr = array();
    $k = 0;
   
    foreach ($_POST['issue'] as $req) {
        $arr = [
            'eb_id' => $_POST['followup'],
            'fu_issue' => $_POST['issue'][$k],
            'fu_date' => datedb($_POST['date'][$k]),
            'fu_status' => $_POST['status'][$k],
            'fu_createby' => $_SESSION['Code'],
            'fu_created' => date('Y-m-d H:i:s')
        ];

        $q = $conn->prepare("insert into followup(eb_id,fu_issue,fu_date,fu_status,fu_createby,fu_created) 
        values(
            :eb_id,
            :fu_issue,
            :fu_date,
            :fu_status,
            :fu_createby,
            :fu_created
        )");
        $insert = $q->execute($arr);
        $lastId = $conn->lastInsertId();
      
        $k++;
        logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $lastId . ' โดย : ' . $_SESSION['Name']);
    }
  
    if (count($_POST['issue']) == $k) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
    exit();
    // print_r(datedb($_POST['date'][1]));exit();
}
