<?php
session_start();

	require_once ("config.php");

	if( $_POST["work"] == "ปิดงานซ่อมได้" )
	{
		// กรณีปิดงานได้
		if (isset($_POST["id"]))
		{
			$mraid = (int)$_POST["id"];
			$closework = $_POST["work"];
			$leader = $_POST["leader"];
			$informer = $_POST["informer"];
			$workunit = $_POST["workunit"];
		}

		$sql = "INSERT INTO MaintenanceCloseJob (MRA_ID, MCJ_CloseJob, MCJ_Leader, MRA_Informer, MCJ_WorkUnitName) VALUES (?,?,?,?,?)";
		$params = array($mraid, $closework, $leader, $informer, $workunit);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ($stmt == true)
		{
			$sql1 = "UPDATE MaintenanceRepairAdd SET MRA_Status = 5 WHERE MRA_ID = ?";
			$params1 = array($mraid);
			$stmt1 = sqlsrv_query($conn, $sql1, $params1);

			$sql2 = "UPDATE MaintenanceJoblist SET MJ_Status = 5 WHERE MRA_ID = ?";
			$params2 = array($mraid);
			$stmt2 = sqlsrv_query($conn, $sql2, $params2);

			$sql3 = "UPDATE MaintenanceEngineerUpdate SET MRA_Status = 5 WHERE MRA_ID = ?";
			$params3 = array($mraid);
			$stmt3 = sqlsrv_query($conn, $sql3, $params3);

			echo "<script language=\"JavaScript\">";
			echo "alert('ปิดงานซ่อมสำเร็จ');";
			echo "</script>";
			header("refresh:1; url=../front/leader_index.php");
		}
		else
		{
			die(print_r(sqlsrv_errors(), true));
		}
	}
	else if( $_POST["work"] == "ปิดงานซ่อมไม่ได้ / มอบหมายงานให้ช่างคนใหม่" )
	{
		//กรณีปิดงานไม่ได้
		if (isset($_POST["id"]))
		{
			$mraid = (int)$_POST["id"];
			$closework = $_POST["work"];
			$leader = $_POST["leader"];
			$informer = $_POST["informer"];
			$workunit = $_POST["workunit"];
		}

		$sql = "INSERT INTO MaintenanceCloseJob (MRA_ID, MCJ_CloseJob, MCJ_Leader, MRA_Informer, MCJ_WorkUnitName) VALUES (?,?,?,?,?)";
		$params = array($mraid, $closework, $leader, $informer, $workunit);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ($stmt == true)
		{
			$sql1 = "UPDATE MaintenanceRepairAdd SET MRA_Status = 1 WHERE MRA_ID = ?";
			$params1 = array($mraid);
			$stmt1 = sqlsrv_query($conn, $sql1, $params1);

			$sql2 = "DELETE FROM MaintenanceRepairCheck WHERE MRA_ID = ?";
			$params2 = array($mraid);
			$stmt2 = sqlsrv_query($conn, $sql2, $params2);

			$sql3 = "DELETE FROM MaintenanceJoblist WHERE MRA_ID = ?";
			$params3 = array($mraid);
			$stmt3 = sqlsrv_query($conn, $sql3, $params3);

			$sql4 = "SELECT MEU_ID FROM MaintenanceEngineerUpdate WHERE MRA_ID = ?";
			$params4 = array($mraid);
			$stmt4 = sqlsrv_query($conn, $sql4, $params4);
			$row = sqlsrv_fetch_array($stmt4);
			$meuid = $row['MEU_ID'];

			$sql5 = "DELETE FROM MaintenanceEngineerUpdate WHERE MRA_ID = ?";
			$params5 = array($mraid);
			$stmt5 = sqlsrv_query($conn, $sql5, $params5);

			$sql6 = "DELETE FROM MaintenanceEngineerImage WHERE MEU_ID = ?";
			$params6 = array($meuid);
			$stmt6 = sqlsrv_query($conn, $sql6, $params6);

			$sql7 = "DELETE FROM MaintenanceChangeItem WHERE MEU_ID = ?";
			$params7 = array($meuid);
			$stmt7 = sqlsrv_query($conn, $sql7, $params7);

			echo "<script language=\"JavaScript\">";
			echo "alert('มอบหมายงานให้ช่างคนใหม่');";
			echo "</script>";
			header("refresh:1; url=../front/leader_assign.php?id=$mraid");
		}
		else
		{
			die(print_r(sqlsrv_errors(), true));
		}
	}

sqlsrv_close($conn);

?>