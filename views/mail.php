<?php
ini_set('display_errors', '1');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

// $mail = new PHPMailer();
// $mail->IsHTML(true);
// $mail->IsSMTP();
// $mail->SMTPAuth = true; // enable SMTP authentication
// $mail->SMTPSecure = ""; // sets the prefix to the servier
// $mail->Host = "smtp.office365.com"; // sets as the SMTP server
// $mail->Port = 587; // set the SMTP port for the server
// $mail->Username = "pratipan.jae@mrgshrimp.com"; // username
// $mail->Password = "0891469614"; // password
// $mail->From = "pratipan.jae@mrgshrimp.com"; // "name@yourdomain.local";
// $mail->FromName = "www.ThaiCreate.local";  // set from Name
// $mail->Subject = "Test sending mail.";
// $mail->Body = "Test Mail Description";
// $mail->AddAddress("loveyou26_06@hotmail.com", "Weerachai Nukitram"); // to Address
// $mail->Send(); 
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'The email message was sent.';
// }

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.live.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->CharSet = 'UTF-8';
$mail->Username = 'pratipan.jae@mrgshrimp.com';
$mail->Password = '0891469614';
$mail->setFrom('pratipan.jae@mrgshrimp.com', 'MRG');
$mail->addReplyTo('pratipan.jae@mrgshrimp.com', 'System ERP');
$mail->addAddress('pratipan.jae@mrgshrimp.com', 'test');
$mail->Subject = 'Change Password : ';
$mail->Body = 'Change Password link : <a href="http://localhost/DataChefs/views/reset.php?id=awdawd"> awdawd </a>';
$mail->IsHTML(true);
//$mail->addAttachment('attachment.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}
