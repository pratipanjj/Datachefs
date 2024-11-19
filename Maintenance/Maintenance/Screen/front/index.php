<?php session_start();
if (isset($_SESSION['startTime']) && isset($_SESSION['limitTime']))
{
	if ($_SESSION['startTime'] + $_SESSION['limitTime'] <= time())
	{
		session_destroy();
	}
}
?>
<!--หน้า Login เข้าสู่ระบบ-->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>MRG Maintenance Login</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<link rel="apple-touch-icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/login.css">
</head>
<body>

<!--แยกผู้ใช้ตามส่วน-->
<?php

// --------------เปลี่ยน $_SESSION["SU_Code"] เป็น $_SESSION["EP_ID"] และเพิ่ม EP_ID = 300 เข้ามา by POP---------------------------------------------
if (isset($_SESSION["EP_ID"])){
	echo $_SESSION["EP_ID"];
	if ($_SESSION["EP_ID"] == 300){
		header('Location: leader_index.php');
	}
	else if ($_SESSION["EP_ID"] == 21){
		header('Location: leader_index.php');
	}
	else if ($_SESSION["EP_ID"] == 22){
		header('Location: leader_index.php');
	}
	else if ($_SESSION["EP_ID"] == 23){
		header('Location: leader_index.php');
	}
	else if ($_SESSION["EP_ID"] == 24){
		header('Location: leader_index.php');
	}
	else if ($_SESSION["EP_ID"] == 25){
		header('Location: engineer_index.php');
	}
	else if ($_SESSION["EP_ID"] == 26){
		header('Location: engineer_index.php');
	}
	else{
		header('Location: user_index.php');
	}
}
// ---------------------------------------------------------------------------------------
?>

<div class="container col-md-6 text-center">
	<img src="../../img/logo.png" width="270" height="160">

	<form class="form-signin" action="../backend/action_login.php" method="post">
		<div class="text-right"><h3>Make it happen</h3></div>
		<div class="form-group">
			<input type="text" class="form-control" id="username" placeholder="รหัสพนักงาน" name="username" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" id="password" placeholder="รหัสผ่าน" name="password" required>
		</div>
		<div class="form-group custom-control custom-checkbox text-left">
			<input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
			<label class="custom-control-label" for="customCheck1">จำในระบบ</label>
		</div>
		<input type="submit" name="submit" class="btn btn-light-blue btn-block" value="เข้าสู่ระบบ">
	</form>
</div>

</body>
</html>