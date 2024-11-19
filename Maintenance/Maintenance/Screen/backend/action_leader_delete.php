<?php
require_once("config.php");
// -----------------------------------------------------
// เก็บไว้ก่อนขอเช็ค ป๊อป echo '<pre>';
// เก็บไว้ก่อนขอเช็ค ป๊อป var_dump('hi');die;
// -----------------------------------------------------
if (isset($_GET["id"]))
{
	$mra_id = $_GET["id"];  // ไอดีรายการแจ้งซ่อม
	// change condition "like" to "="(equal) by joh(1.0)
	//-- DELETE FROM MaintenanceRepairAdd WHERE MRA_ID LIKE '$mra_id' --//
	// logic ความคิดเปลี่ยนจาก delete เป็น update status เป็น delete

	$sql = "DELETE FROM MaintenanceRepairAdd WHERE MRA_ID = '$mra_id' ";
	$stmt = sqlsrv_query($conn, $sql);
	sqlsrv_close($conn);

	/*
	echo "<script language=\"JavaScript\">";
	echo "alert('ลบรายการซ่อมสำเร็จ');";
	echo "</script>";
	#header("refresh:1; url=../front/leader_repair_list.php");
	*/
	echo 'ลบรายการซ่อมสำเร็จ';

}

?>
