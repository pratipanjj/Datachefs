<?php

	session_start();
	require_once("config.php");

//รับค่ามาจากฟอร์มตรวจรับงาน
	$id = (int)$_POST["mraid"];
	$speed = $_POST["speed"];
	$coordinate = $_POST["coordinate"];
	$courteous = $_POST["courteous"];
	$cleanness = $_POST["cleanness"];
	$cleandetail = $_POST["cleandetail"];
	$neatness = $_POST["neatness"];
	$neatdetail = $_POST["neatdetail"];
	$risk = $_POST["risk"];
	$riskdetail = $_POST["riskdetail"];
	$checker = $_SESSION["FirstName"];
	$datetime = $_POST["date"];

	$sql = 'INSERT INTO MaintenanceRepairCheck (MRA_ID, MRC_Speed, MRC_Coordinate, MRC_Courteous, MRC_Cleanness, MRC_CleannessDetail, MRC_Neatness, MRC_NeatnessDetail, MRC_Risk, MRC_RiskDetail, MRC_Checker, MRC_Datetime)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
	$params = array($id, $speed, $coordinate, $courteous, $cleanness, $cleandetail, $neatness, $neatdetail, $risk, $riskdetail, $checker, $datetime);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if ($stmt == true)
	{
		$sql1 = "UPDATE MaintenanceRepairAdd SET MRA_Status = ? WHERE MRA_ID = ?";
		$params1 = array(4, $id);
		$stmt1 = sqlsrv_query($conn, $sql1, $params1);

		$sql2 = "UPDATE MaintenanceJoblist SET MJ_Status = ? WHERE MRA_ID = ?";
		$params2 = array(4, $id);
		$stmt2 = sqlsrv_query($conn, $sql2, $params2);

		$sql3 = "UPDATE MaintenanceEngineerUpdate SET MRA_Status = ? WHERE MRA_ID = ?";
		$params3 = array(4, $id);
		$stmt3 = sqlsrv_query($conn, $sql3, $params3);

//		echo "<h1>ตรวจรับงานสำเร็จ</h1>";
		echo "<script language=\"JavaScript\">";
		echo "alert('ตรวจรับงานสำเร็จ');";
		echo "</script>";
		header("refresh:1; url=../front/user_index.php");
	}
	else
	{
		die(print_r(sqlsrv_errors(), true));
	}

sqlsrv_close($conn);

?>