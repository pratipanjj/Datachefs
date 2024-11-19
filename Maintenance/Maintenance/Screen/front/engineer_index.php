<?php
if (!isset($_SESSION)) { 
	session_start(); 
	if($_SESSION['Status_ID'] == ""){
		header('refresh: 0; url=index.php');
		exit(0);
	}
	$authEPID = ['18', '21','22', '23','24', '300','25', '26',];
	if (isset($_SESSION['EP_ID']) && !in_array($_SESSION['EP_ID'], $authEPID)) {
		header('refresh: 0; url=index.php');
	}else if(empty($_SESSION["EP_ID"]) == 1){
		header('refresh: 0; url=index.php');
	}
}
if(isset($_SESSION['startTime']) && isset($_SESSION['limitTime'])){
	if ($_SESSION['startTime'] + $_SESSION['limitTime'] <= time())	{
		session_destroy();
		header('Location: index.php');
	}
}
require_once("../backend/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>หน้ารายการที่ต้องบันทึก</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css">
</head>

<body>

<?php
$code = $_SESSION["SU_Code"];
// ------------------------------------20/01/63 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
// ----------20/10/63 เปลี่ยนชื่อ $count_status2 เป็น $count_engineer_status เนื่องจากชื่อตัวแปรซ้ำกับ $count_status2 ของ bar สถานะ by POP--------
include("countstatus.php");

// $count_status = 0;
// $count_engineer_work = 0;
 
// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
// while ($row = sqlsrv_fetch_array($result)) {	$count_status = $row['num'];     }


// $query2 = "SELECT COUNT(*) as 'num' FROM MaintenanceJoblist WHERE MJ_Status = 2 AND (MJ_EngineerCode = '$code' OR MJ_EngineerCode2 = '$code') ";
// $result2 = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));
// while ($row2 = sqlsrv_fetch_array($result2)) {	$count_engineer_work = $row2['num'];   }
// -------------------------------------------------------------------------------------------------------------------------------------
?>

<!-- -------------------------------------------เปลี่ยนเป็น include menu bar แทน by pop ------------------------------------------------------- -->

<?php include("leader_engineer_menubar.php"); ?>
<!-- navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="#">MRG Maintenance</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item">
				<a class="nav-link" href="leader_index.php">หน้าแรก <span class="badge badge-danger"><?php echo $count_status; ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="#">รายการที่ต้องบันทึก <span class="badge badge-danger"><?php echo $count_engineer_work; ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">เบิกของจากสโตร์</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">สร้างใบขอซื้อ</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="nav-item">
				<a class="nav-link" href="../backend/logout.php">ออกจากระบบ</a>
			</li>
		</ul>
	</div>
</nav> -->
<!--end navbar -->
<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<div class="container col-sm-6">
	<br>
	<h3>รายการที่ต้องบันทึก</h3><br>
</div>

<div class="container col-sm-6">

	<div class="table-responsive-sm">
		<table class="table table-striped table-sm text-center">
			<thead>
			<tr>
				<th>รายการแจ้งซ่อม</th>
				<th>สถานะ</th>
				<th>จัดการ</th>
			</tr>
			</thead>
			<tbody>

			<?php

			require_once("../backend/pagination.php");

			$total;
			$num = 0;

			$query = "SELECT COUNT(*) as 'num' FROM MaintenanceJoblist WHERE MJ_EngineerCode = ? OR MJ_EngineerCode2 = ? ";
			// echo $query;
			// $result = sqlsrv_query($conn, $query);
			$params = array("$code","$code");
			$result = sqlsrv_query($conn, $query, $params);

			while ($row = sqlsrv_fetch_array($result))
			{
				$total = $row['num'];
			}

			$e_page = 8; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า
			$step_num = 0;
			if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1))
			{
				$_GET['page'] = 1;
				$step_num = 0;
				$s_page = 0;
			}
			else
			{
				$s_page = (int)$_GET['page'] - 1;
				$step_num = (int)$_GET['page'] - 1;
				$s_page = $s_page * $e_page;
			}

			$statement = 'MaintenanceJoblist inner join MaintenanceRepairAdd ON MaintenanceJoblist.MRA_ID = MaintenanceRepairAdd.MRA_ID WHERE MaintenanceJoblist.MJ_EngineerCode = ? OR MaintenanceJoblist.MJ_EngineerCode2 = ?';
			$params = array("$code","$code");
			$result = sqlsrv_query($conn,"SELECT MaintenanceRepairAdd.MRA_MachineName, MaintenanceJoblist.MRA_ID, MaintenanceJoblist.MJ_Status FROM {$statement} ORDER BY MJ_ID OFFSET " . $s_page . " ROWS FETCH NEXT " . $e_page . " ROWS ONLY", $params);

			if (sqlsrv_has_rows($result) != 0)
			{
				while ($row = sqlsrv_fetch_array($result))
				{
					echo '<tr>';
					echo '<td>'.$row["MRA_MachineName"].'</td>';
					if($row["MJ_Status"] != "1" && $row["MJ_Status"] != "2")
					{
						echo '<td><span class="badge badge-pill badge-success">เสร็จงานแล้ว</span></td>';
						echo '<td><input type="button" class="btn btn-light-blue btn-sm" value="บันทึก" disabled></td>';
					}else{
						echo '<td><span class="badge badge-pill badge-warning">ยังไม่เสร็จ</span></td>';
						echo '<td><a href="leader_work_detail.php?id='.$row["MRA_ID"].'"><input type="button" class="btn btn-light-blue btn-sm" value="รายละเอียด"></a>
									<a href="leader_update.php?id='.$row["MRA_ID"].'"><input type="button" class="btn btn-light-blue btn-sm" value="บันทึก"></a></td>';
					}
					echo '</tr>';
					$num++;
				}
			}
			else
			{
				echo '<tr>';
				echo '<td>ยังไม่มีข้อมูล...</td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '</tr>';
			}
			?>
			</tbody>
		</table>
	</div>
	<div style="float: right; margin: 20px;"><?php page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET); ?></div>


</body>
</html>
