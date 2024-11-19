<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
$authEPID = ['18', '21','22', '23','24','25','26','300'];
if (isset($_SESSION['EP_ID']) && !in_array($_SESSION['EP_ID'], $authEPID)) {
	header('refresh: 0; url=index.php');
}else if(empty($_SESSION["EP_ID"]) == 1){
	header('refresh: 0; url=index.php');
}
if(isset($_SESSION['startTime']) && isset($_SESSION['limitTime']))
{
	if ($_SESSION['startTime'] + $_SESSION['limitTime'] <= time())
	{
		session_destroy();
		header('Location: index.php');
	}
}
require_once("../backend/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>หน้ามอบหมายงาน</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/tabletab_leader_assign.css">
	<script src="../../js/modernizr.min.js"></script>
	<script src="../../datetimepicker/js/gijgo.min.js"></script>
	<link rel="stylesheet" href="../../datetimepicker/css/gijgo.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/tabletab_engineer_work.css"/>
	<script src="../../js/typeahead.min.js"></script>


	<script type="text/javascript">
		$(document).ready(function ()
		{
			$('input.typeahead').typeahead({
				name: 'typeahead',
				remote: '../backend/employee_code_search.php?name=%QUERY',
				limit: 10
			});
		});
	</script>

</head>

<body>

<?php
require_once("../backend/config.php");
$code = $_SESSION["SU_Code"];

// ------------------------------------20/01/2020 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
include("countstatus.php");

// $count_status = 0;
// $count_status2 = 0;

// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result))
// {
// 	$count_status = $row['num'];
// }

// $query2 = "SELECT COUNT(*) as 'num' FROM MaintenanceJoblist WHERE MJ_Status = 2 AND (MJ_EngineerCode = '$code' OR MJ_EngineerCode2 = '$code') ";
// $result2 = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));

// while ($row2 = sqlsrv_fetch_array($result2))
// {
// 	$count_status2 = $row2['num'];
// }
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
				<a class="nav-link active" href="leader_repair_index.php">รายการที่ต้องบันทึก <span class="badge badge-danger"><?php echo $count_status2; ?></span></a>
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
<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->

<div class="container col-sm-8">
	<br>
	<h3>รายละเอียดของงาน</h3><br>
</div>

<div class="container col-sm">
	<div class="divtable accordion-xs">
		<div class="tr headings">
			<div class="th machine_name">ชื่อเครื่องจักร/ทรัพย์สิน</div>
			<div class="th machine_code">รหัสเครื่องจักร/รหัสภายใน</div>
			<div class="th datetime">วัน/เวลาที่แจ้ง</div>
			<div class="th datetimefinish">วัน/เวลาที่กำหนดเสร็จ</div>
			<div class="th worktype">ประเภทงาน</div>
			<div class="th priority">ความสำคัญของงาน</div>
			<div class="th description">รายละเอียดการชำรุด/งานปรับปรุง</div>
			<div class="th effect">ผลกระทบ</div>
			<div class="th informer">ผู้แจ้ง</div>
			<div class="th workunitname">หน่วยงาน</div>
			<div class="th status">สถานะ</div>
		</div>
		<?php require_once("../backend/config.php");
		include("../backend/classMySec.php");

		$id = null;
		$status;
		$status_number;
		$imgage0 = null;
		$imgage1 = null;
		$imgage2 = null;
		$imgage3 = null;


		if (isset($_GET["id"]))
		{
			$id = (int)$_GET["id"];
		}
		$query = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_ID = ?";
		$param = array($id);
		$result = sqlsrv_query($conn, $query, $param) or die(print_r(sqlsrv_errors(), true));
		if (sqlsrv_has_rows($result) != 0)
		{
			$classMySec = new classMySec();

			// displaying records.
			while ($row = sqlsrv_fetch_array($result))
			{
				switch ($row["MRA_Status"])
				{
					case "1":
						$status = "แจ้งซ่อมใหม่";
						$status_number = 1;
						break;
					case "2":
						$status = "กำลังดำเนินการ";
						$status_number = 2;
						break;
					case "3":
						$status = "ดำเนินการเสร็จ / รอตรวจงาน";
						$status_number = 3;
						break;
					case "4":
						$status = "รอปิดงาน";
						$status_number = 4;
						break;
					case "5":
						$status = "ปิดงานแล้ว";
						$status_number = 5;
						break;
				}
				$id1 = $row["MRA_ID"];
				$sql1 = "SELECT MJ_DatetimeFinish, MJ_EngineerCode FROM MaintenanceJoblist WHERE MRA_ID = '$id1' AND MJ_Status = 2";
				$result1 = sqlsrv_query($conn, $sql1) or die(print_r(sqlsrv_errors(), true));
				$date = sqlsrv_fetch_array($result1);

				$ref = $row["MRA_MachineCode"];
				$sqlref = "SELECT RAC_InternalCode FROM RegistrationAssetsControl WHERE RAC_ReferenceNumber = '$ref'";
				$queryref = sqlsrv_query($conn, $sqlref);
				$rowref = sqlsrv_fetch_array($queryref);

				echo '<div class="tr">';
				echo '<div class="td machine_name accordion-xs-toggle">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
				echo '<div class="accordion-xs-collapse">';
				echo '<div class="inner">';

				if(empty($rowref["RAC_InternalCode"]) == true)
				{
					echo '<div class="td machine_code">' . $classMySec->encode($row["MRA_MachineCode"]) . '</div>';
				}
				else
				{
					echo '<div class="td machine_code">' . $classMySec->encode($row["MRA_MachineCode"]) . ' / ' . $classMySec->encode($rowref["RAC_InternalCode"]) . '</div>';
				}

				echo '<div class="td datetime">' . $classMySec->encode($row["MRA_Datetime"]) . '</div>';
				echo '<div class="td datetimefinish">' . $date["MJ_DatetimeFinish"] . '</div>';
				echo '<div class="td worktype">' . $row["MRA_WorkType"] . '</div>';
				echo '<div class="td priority">' . $row["MRA_Priority"] . '</div>';
				echo '<div class="td description">' . $classMySec->encode($row["MRA_Description"]) . '</div>';
				echo '<div class="td effect">' . $row["MRA_Effect"] . '</div>';
				echo '<div class="td informer">' . $classMySec->encode($row["MRA_Informer"]) . '</div>';
				echo '<div class="td workunitname">' . $classMySec->encode($row["MRA_WorkUnitName"]) . '</div>';
				echo '<div class="td status">' . $status . '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				$imgage0 = $row["MRA_Image0"];
				$imgage1 = $row["MRA_Image1"];
				$imgage2 = $row["MRA_Image2"];
				$imgage3 = $row["MRA_Image3"];
				$workunit = $row["MRA_WorkUnitName"];
			}

		}

		?>


	</div>
	<br>


	<div class="row">

		<div class="col-sm">
			<div>
				<br>
			</div>
			<div>
				<center>
					<?php
					if ($imgage0 != null)
					{
						echo '<a href="../../image_upload_user/' . $imgage0 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_user/' . $imgage0 . '"/></a>';
					}
					if ($imgage1 != null)
					{
						echo '<a href="../../image_upload_user/' . $imgage1 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_user/' . $imgage1 . '"/></a>';
					}
					if ($imgage2 != null)
					{
						echo '<a href="../../image_upload_user/' . $imgage2 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_user/' . $imgage2 . '"/></a>';
					}
					if ($imgage3 != null)
					{
						echo '<a href="../../image_upload_user/' . $imgage3 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_user/' . $imgage3 . '"/></a>';
					}
					?>
				</center>
			</div>
		</div>

	</div>
</div>

</body>

</html>
