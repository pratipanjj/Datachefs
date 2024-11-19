<?php
require_once '../../configs/conn.php';
require_once '../../function/LogSystem.php';

if (isset($_POST['Old'])) {

    $active = 1;
    $stm = $conn->prepare("SELECT SU_Code,SU_Name1,SU_Email,SU_Username,SU_Password,SU_Signature FROM systemuser WHERE  SU_Username = :username and SU_active = :active ");
    $stm->bindParam(':username', $_SESSION['Code'], PDO::PARAM_STR);
    $stm->bindParam(':active', $active, PDO::PARAM_STR);
    $stm->execute();
    $res = $stm->fetch();
    if (password_verify($_POST['Old'], $res['SU_Password'])) {
        $pass = password_hash($_POST['New'], PASSWORD_DEFAULT);
        $u = $conn->prepare("update systemuser set SU_Password = ? where SU_Username = ? ");
        $u->execute([$pass, $_SESSION['Code']]);
        echo json_encode(1);
        exit();
    }elseif(!password_verify($_POST['Old'], $res['SU_Password'])){
        echo json_encode(2);
        exit();
    } else {
        echo json_encode(0);
        exit();
    }
}
if (isset($_POST['profile'])) {

    if ($_FILES['file']['name'] != '') {
        $image = '';
        $uploads_dir = '../../images/Profile/';
        $tmp_name = $_FILES['file']['tmp_name'];

        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = time() . '_' .  rand(10, 9999).'.'.$ext;
        $image = time() . '_' . rand(10, 9999).'.'.$ext;

        $move = move_uploaded_file($tmp_name, "$uploads_dir/$image");
    } else {
        $image = $_POST['oldPic'];
    }

    $_SESSION['SU_Profile'] = '../images/Profile/' . $image;
    $u = $conn->prepare("update systemuser set SU_Name1 = ? , SU_Name2 = ? , SU_Email = ? , SU_Tel = ? , SU_Profile = ?  where SU_Username = ? ");
    $u->execute([$_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phoneNumber'], $image, $_SESSION['Code']]);
    if ($u) {

        echo json_encode(1);
        exit();
    } else {
        echo json_encode(0);
        exit();
    }
}
