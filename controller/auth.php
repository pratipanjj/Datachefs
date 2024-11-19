<?php 
require_once '../configs/conn.php';
require_once '../function/LogSystem.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

error_reporting(E_ALL);
if (isset($_POST['status'])) {
  $active = 1;

  $stm = $conn->prepare("SELECT SU_Code,SU_Name1,SU_Name2,SU_Email,SU_Username,SU_Password,SU_Profile,SU_Role,SU_Signature FROM systemuser WHERE SU_Username = :username and SU_active = :active ");
  $stm->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  $stm->bindParam(':active', $active, PDO::PARAM_STR);
  $stm->execute();
  $res = $stm->fetch();

  if (password_verify($_POST['password'], $res['SU_Password'])) {
    $_SESSION['Code'] = $res['SU_Code'];
    $_SESSION['Name'] = trim($res['SU_Name1']) != '' ? $res['SU_Name1'] : $res['SU_Name2'];
    $_SESSION['Email'] = $res['SU_Email'];
    $_SESSION['Username'] = $res['SU_Username'];
    $_SESSION['Signature'] = $res['SU_Signature'];
    $_SESSION['role'] = $res['SU_Role'];
    $_SESSION['SU_Profile'] = trim($res['SU_Profile']) != '' ? '../images/Profile/' . $res['SU_Profile'] : '../images/Customer/profile/149071.png';

    logging('Log In', 'เข้าสู่ระบบ : ' . $_SESSION['Name']);
    echo json_encode(1);
  } else {
    echo json_encode(0);
  }
}
if (isset($_POST['resetPW'])) {

  $active = 1;
  $stm = $conn->prepare("SELECT SU_Code,SU_Name1,SU_Name2,SU_Email FROM systemuser WHERE SU_Username = :username and SU_active = :active ");
  $stm->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  $stm->bindParam(':active', $active, PDO::PARAM_STR);
  $stm->execute();
  $res = $stm->fetch();
  if (isset($res)) {
    $encode = password_hash($res['SU_Code'],PASSWORD_DEFAULT);
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = 'mail.mrgshrimp.local';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->Username = 'pratipan.jae@mrgshrimp.local';
    $mail->Password = 'Aa0807808921';
    $mail->setFrom('pratipan.jae@mrgshrimp.local', 'MRG');
    $mail->addReplyTo('pratipan.jae@mrgshrimp.local', 'System ERP');
    $mail->addAddress('pratipan.jae@mrgshrimp.local', $res['SU_Name1']);
    $mail->Subject = 'Change Password : '.$res['SU_Name1'];
    $mail->Body = 'Change Password link : <a href="http://localhost/DataChefs/views/reset.php?id='.$encode.'"> awdawd </a>';
    $mail->IsHTML(true);   
    //$mail->addAttachment('attachment.txt');
    if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'The email message was sent.';
    }
  }
}
