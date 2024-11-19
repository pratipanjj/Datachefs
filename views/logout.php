<?php 
require_once '../function/LogSystem.php';
session_start(); //ประกาศใช้ session
logging('Log Out', 'ออกจากระบบ : ' . $_SESSION['Name']);
session_destroy(); //เคลียร์ค่า session
 header('Location: authlogin.php'); //Logout เรียบร้อยและกระโดดไปหน้าตามที่ต้องการ
