<?php
require_once '../../configs/conn.php';
require_once '../../function/LogSystem.php';

if (isset($_GET['id'])) {
    if ($_GET['type'] == 1) {
        $q = $conn->prepare("SELECT s_id as id ,s_username as code , s_name as name , s_email as email , 1 as option , s_active as active FROM sales where s_id = ? ");
    } else {
        $q = $conn->prepare("SELECT sp_id as id ,sp_username as code , sp_name as name , sp_email as email  , 2 as option , s_active as active FROM support where sp_id = ? ");
    }
    $q->execute([$_GET['id']]);
    $cus = $q->fetch();
    echo json_encode($cus);
}

if (isset($_GET['load'])) {

    $q = $conn->prepare("SELECT s_id as id ,s_username as code , s_name as name , s_email as email , 'Sales Man' as type , 1 as Aoption , s_active as active FROM sales 
    UNION all 
    SELECT sp_id as id ,sp_username as code , sp_name as name , sp_email as email , 'Sales Support' as type , 2 as Aoption , s_active as active FROM support
         ");
    $q->execute();
    $bus = $q->fetchall();
    $arr = array();
    foreach ($bus as $r) {
        $nesData = array();
        $nesData['code'] = $r['code'];
        $nesData['name'] = $r['name'];
        $nesData['email'] = $r['email'];
        $nesData['type'] = $r['type'];
        $nesData['active'] = $r['active'];
        $nesData['Aoption'] = '  <button onclick="evClick(' . $r['id'] . ',' . $r['Aoption'] . ')" class="btn btn-icon btn-outline-warning float-end"><i class="bx bx-edit"></i></button>';
        $arr['data'][] = $nesData;
    }
    echo json_encode($arr);
}


if (isset($_POST['sales'])) {

    if ($_POST['editSales'] != '') {
        if ($_POST['type'] == 1) {
            $arr = [
                's_username' => $_POST['username'],
                's_name' => $_POST['firstname'] . ' ' . $_POST['lastname'],
                's_email' => $_POST['email'],
                's_active' => isset($_POST['active']) ? 1 : 0,
                's_id' => $_POST['editSales'],
            ];
            $q = $conn->prepare("update sales set s_username = :s_username ,s_name = :s_name ,s_email = :s_email , s_active = :s_active where s_id = :s_id ");
            $update = $q->execute($arr);
            if ($update) {
                logging('Sales', 'อัพเดท Sales Man: ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' โดย : ' . $_SESSION['Name']);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        } else {
            $arr = [
                'sp_username' => $_POST['username'],
                'sp_name' => $_POST['firstname'] . ' ' . $_POST['lastname'],
                'sp_email' => $_POST['email'],
                's_active' => isset($_POST['active']) ? 1 : 0,
                'sp_id' => $_POST['editSales'],
            ];
            $q = $conn->prepare("update support set sp_username = :sp_username ,sp_name = :sp_name ,sp_email = :sp_email , s_active = :s_active where sp_id = :sp_id ");
            $update = $q->execute($arr);
            if ($update) {
                logging('Sales', 'อัพเดท Sales Support : ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' โดย : ' . $_SESSION['Name']);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    } else {
        if ($_POST['type'] == 1) {
            $arr = [
                's_username' => $_POST['username'],
                's_name' => $_POST['firstname'] . ' ' . $_POST['lastname'],
                's_email' => $_POST['email'],
                's_active' => isset($_POST['active']) ? 1 : 0
            ];
            $q = $conn->prepare("insert into sales(s_username,s_name,s_email,s_active) 
                values(
                    :s_username,
                    :s_name,
                    :s_email,
                    :s_active
                )");
            $insert = $q->execute($arr);
            if ($insert) {
                logging('Sales', 'เพิ่ม Sales Man: ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' โดย : ' . $_SESSION['Name']);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        } else {
            $arr = [
                'sp_username' => $_POST['username'],
                'sp_name' => $_POST['firstname'] . ' ' . $_POST['lastname'],
                'sp_email' => $_POST['email'],
                's_active' => isset($_POST['active']) ? 1 : 0
            ];
            $q = $conn->prepare("insert into support(sp_username,sp_name,sp_email,s_active) 
                values(
                    :sp_username,
                    :sp_name,
                    :sp_email,
                    :s_active
                )");
            $insert = $q->execute($arr);
            if ($insert) {
                logging('Sales', 'เพิ่ม Sales Support : ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' โดย : ' . $_SESSION['Name']);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
}
