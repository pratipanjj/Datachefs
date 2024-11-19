<?php
require_once("config.php");
if (isset($_POST["submit"]))
{
	$mra_id = $_POST["mra_id"];  // ไอดีการแจ้งซ่อม
	$engineer_name1 = $_POST["engineer_name1"];  // ชื่อของช่างคนที่ 1 จากตาราง Employee
	$engineer_name2 = $_POST["engineer_name2"];  // ชื่อของช่างคนที่ 2 จากตาราง Employee

	$datetimefinish = $_POST["datetimefinish"];  // วันเวลาที่เสร็จงาน
	$employee_code1;
	$employee_code2;
	$status = 2;  // สถานะ
	$workunit = $_POST["mra_workunit"]; // หน่วยงาน

	$employee_code1 = substr($engineer_name1, 0, 7); // substring get E_Code
	$employee_code2 = substr($engineer_name2, 0, 7); // substring get E_Code


	$sql = 'INSERT INTO MaintenanceJoblist (MRA_ID, MJ_EngineerCode, MJ_EngineerCode2, MJ_DatetimeFinish, MJ_Status, MRA_WorkUnitName)
				VALUES (?,?,?,?,?,?)';
	$params = array($mra_id, $employee_code1, $employee_code2, $datetimefinish, $status, $workunit);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if ($stmt === false)
	{
		die(print_r(sqlsrv_errors(), true));
	}
	else
	{
		// อัพเดทสถานะเป็นกำลังดำเนินการ (status == 2)
		$sql = "UPDATE MaintenanceRepairAdd SET MRA_Status = ? WHERE MRA_ID  = ? ";
		$params = array(2, $mra_id);
		$stmt = sqlsrv_query($conn, $sql, $params);
		if ($stmt === false)
		{
			die(print_r(sqlsrv_errors(), true));
		}
		else
		{
			echo "<script language=\"JavaScript\">";
			echo "alert('มอบหมายงานสำเร็จ');";
			echo "</script>";
			header("refresh:1; url=../front/leader_repair_list.php");
		}
	}
}
sqlsrv_close($conn);

?>
