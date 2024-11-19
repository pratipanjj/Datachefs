<?php
require_once '../../configs/conn.php';
require_once '../../function/LogSystem.php';

if (isset($_GET['load'])) {

    $q = $conn->prepare("SELECT SU_Code,SU_Name1,SU_Name2,SU_Username,SU_Role FROM systemuser where SU_Active = ? order by SU_Username asc");
    $q->execute([1]);
    $bus = $q->fetchall();
    $arr = array();
    foreach ($bus as $r) {
        $nesData = array();
        $nesData['SU_Code'] = $r['SU_Code'];
        $nesData['SU_Name1'] = $r['SU_Name1'];
        $nesData['SU_Name2'] = $r['SU_Name2'];
        $nesData['SU_Username'] = $r['SU_Username'];
        if($_SESSION['role'] == 1){
            $nesData['Aoption'] = '
            <button onclick="evDel(' . $r['SU_Username'] . ')" class="btn btn-icon btn-outline-danger float-end"><i class="bx bx-trash"></i></button>
            <button onclick="evClick(' . $r['SU_Username'] . ')" class="btn btn-icon btn-outline-warning float-end"><i class="bx bx-edit"></i></button>
            <button onclick="ResetPW(' . $r['SU_Username'] . ')" class="btn btn-icon btn-outline-primary float-end"><i class="bx bx-refresh"></i></button>';
        }else{
            $nesData['Aoption'] = '';
        }
       
        $arr['data'][] = $nesData;
    }
    echo json_encode($arr);
}

if(isset($_POST['Add'])){
    $arr = [
         'SU_Code' => $_POST['Code'],
         'SU_Name1' => $_POST['firstname'].' '.$_POST['lastname'],
         'SU_Email' => $_POST['email'],
         'SU_Username' => $_POST['username'],
         'SU_Password' => password_hash('1234',PASSWORD_DEFAULT),
         'SU_Active' => 1,
         'SU_Role' => 3,
        ];
        $stm = $conn->prepare("insert into systemuser(SU_Code,SU_Name1,SU_Email,SU_Username,SU_Password,SU_Active,SU_Role) values ( :SU_Code,:SU_Name1,:SU_Email,:SU_Username,:SU_Password,:SU_Active,:SU_Role ) ");
        $stm->execute($arr);
        if($stm){
            logging('Member', 'Add Member username '.$_POST['Code'].' โดย : ' . $_SESSION['Name']);
            echo json_encode(1);
        }
}
if(isset($_GET['delmember'])){

    $arr = [
        'username' => $_GET['delmember'],
        'active' => 0,
        ];
        $stm = $conn->prepare("Update systemuser set SU_active = :active WHERE SU_Username = :username  ");
        $stm->execute($arr);
        if($stm){
            logging('Member', 'Disabled Member username '.$_GET['delmember'].' โดย : ' . $_SESSION['Name']);
            echo json_encode(1);
        }

}

if (isset($_GET['type'])) {
    $arr = [
    'password' => password_hash('1234',PASSWORD_DEFAULT),
    'username' => $_GET['id'],
    'active' => 1,
    ];
    $stm = $conn->prepare("Update systemuser set SU_Password = :password WHERE SU_Username = :username and SU_active = :active ");
    $stm->execute($arr);
    if($stm){
    logging('Member', 'รีเซ็ต Password username '.$_GET['id'].' โดย : ' . $_SESSION['Name']);
    echo json_encode(1);
    }

}
