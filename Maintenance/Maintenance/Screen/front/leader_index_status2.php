<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
$authEPID = ['18', '21','22', '23','24', '300'];
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
		header('Location: index.php' );
	}
}
require_once("../backend/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>หน้าแรกของหัวหน้าช่าง</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css"/>
	<link rel="stylesheet" href="../../css/tabletab_leader_index_status2.css"/>
	<script src="../../js/modernizr.min.js"></script>

</head>

<body>

<?php
// ---------------------------------------------20/01/63 เพิ่ม $code = $_SESSION["SU_Code"] by POP--------------------------------------
$code = $_SESSION["SU_Code"];
// ------------------------------------20/01/63 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
include("countstatus.php");
// $count_status = 0;
// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result))
// {
// 	$count_status = $row['num'];
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
				<a class="nav-link active" href="leader_index.php">หน้าแรก <span class="badge badge-danger"><?php echo $count_status ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="leader_repair_list.php">รายการแจ้งซ่อม</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="leader_repair_index.php">หน้าของช่าง</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">เบิกของจากสโตร์</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">สร้างใบขอซื้อ</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="leader_summary.php">สรุปรายการซ่อม</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="leader_summary_detail.php">สรุปงานช่าง</a>
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

<?php
// ------------------------------------20/01/63 เปลี่ยนเป็น include file แทน (countstatus.php) by POP----------------------------------
// $count_status1 = 0;
// $count_status2 = 0;
// $count_status3 = 0;
// $count_status4 = 0;
// $count_status5 = 0;

// $query1 = "SELECT COUNT(*) as 'num1' FROM MaintenanceRepairAdd WHERE MRA_Status = 1";
// $result1 = sqlsrv_query($conn, $query1) or die(print_r(sqlsrv_errors(), true));

// $query2 = "SELECT COUNT(*) as 'num2' FROM MaintenanceRepairAdd WHERE MRA_Status = 2";
// $result2 = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));

// $query3 = "SELECT COUNT(*) as 'num3' FROM MaintenanceRepairAdd WHERE MRA_Status = 3";
// $result3 = sqlsrv_query($conn, $query3) or die(print_r(sqlsrv_errors(), true));

// $query4 = "SELECT COUNT(*) as 'num4' FROM MaintenanceRepairAdd WHERE MRA_Status = 4";
// $result4 = sqlsrv_query($conn, $query4) or die(print_r(sqlsrv_errors(), true));

// $query5 = "SELECT COUNT(*) as 'num5' FROM MaintenanceRepairAdd WHERE MRA_Status = 5";
// $result5 = sqlsrv_query($conn, $query5) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result1))
// {
// 	$count_status1 = $row['num1'];
// }
// while ($row = sqlsrv_fetch_array($result2))
// {
// 	$count_status2 = $row['num2'];
// }
// while ($row = sqlsrv_fetch_array($result3))
// {
// 	$count_status3 = $row['num3'];
// }
// while ($row = sqlsrv_fetch_array($result4))
// {
// 	$count_status4 = $row['num4'];
// }
// while ($row = sqlsrv_fetch_array($result5))
// {
// 	$count_status5 = $row['num5'];
// }

?>


<!-- Nav tabs -->
<div>

	<!--แจ้งซ่อมใหม่ , กำลังดำเนินการ , ดำเนินการแล้ว / รอตรวจงาน , รอปิดงาน , ปิดงานซ่อมแล้ว-->
	<div class="container col-sm-8"><br>
		<div class="row">
		<h3>กำลังดำเนินการ&nbsp;&nbsp;&nbsp;</h3>
		<a href="../../PHPExcel/export-excel-leader2.php" class="btn btn-outline-success" target="_blank">excel</a>
	</div><br></div>

	<div class="container-fluid">
		<ul class="nav nav-tabs">
			<hr>
			<li class="nav-item" style="display:inline-block;">
				<a class="nav-link" href="leader_index.php"><img src="../../img/icon/status1.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status1; ?></span></a>
			</li>
			<li class="nav-item" style="display:inline-block;">
				<a class="nav-link active" href="leader_index_status2.php"><img src="../../img/icon/status2.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status2; ?></span></a>
			</li>
			<li class="nav-item" style="display:inline-block;">
				<a class="nav-link" href="leader_index_status3.php"><img src="../../img/icon/status3.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status3; ?></span></a>
			</li>
			<li class="nav-item" style="display:inline-block;">
				<a class="nav-link" href="leader_index_status4.php"><img src="../../img/icon/status4.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status4; ?></span></a>
			</li>
			<li class="nav-item" style="display:inline-block;">
				<a class="nav-link" href="leader_index_status5.php"><img src="../../img/icon/status5.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status5; ?></span></a>
			</li>
			<hr>
		</ul>
	</div>


	<div class="divtable accordion-xs">

		<div class="tr headings">
			<div class="th machine_name">ชื่อทรัพย์สิน/เครื่องจักร</div>
			<div class="th machine_code">รหัสทรัพย์สิน/รหัสภายใน</div>
			<div class="th datetime">วัน/เวลาที่แจ้ง</div>
			<div class="th datetimefinish">วัน/เวลาที่เสร็จ</div>
			<div class="th worktype">ประเภทงาน</div>
			<div class="th priority">ความสำคัญ</div>
			<div class="th description">รายละเอียดการชำรุด/งานปรับปรุง</div>
			<div class="th effect">ผลกระทบ</div>
			<div class="th informer">ผู้แจ้ง</div>
			<div class="th workunitname">หน่วยงาน</div>
			<div class="th status" id="status">สถานะ</div>
			<div class="th engineer">ช่างที่รับงาน</div>

		</div>

		<?php
		require_once('../backend/pagination.php');
		include("../backend/classMySec.php");


		$total;
		$num = 0;

		$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 2";
		$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

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

		$sql = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_Status = 2 ORDER BY MRA_Priority DESC OFFSET " . $s_page . " ROWS FETCH NEXT " . $e_page . " ROWS ONLY";
		$result = sqlsrv_query($conn, $sql);

		if (sqlsrv_has_rows($result) != 0)
		{
			$classMySec = new classMySec();
			// displaying records.
			while ($row = sqlsrv_fetch_array($result))
			{
				
				switch ($row["MRA_Status"])	 {
					#case "1":		$status = '<span class="badge badge-pill badge-danger">แจ้งซ่อมใหม่</span>'; "";				$status_number = 1;				break;
					case "2":		$status = '<span class="badge badge-pill badge-info">กำลังดำเนินการ</span>'; "";			$status_number = 2;				break;
					case "3":		$status = '<span class="badge badge-pill badge-warning">ดำเนินการเสร็จ / รอตรวจงาน</span>'; "";	$status_number = 3;				break;
					case "4":		$status = '<span class="badge badge-pill badge-primary">รอปิดงาน</span>'; "";					$status_number = 4;				break;
					case "5":		$status = '<span class="badge badge-pill badge-success">ปิดงานแล้ว</span>'; "";					$status_number = 5;				break;
					default : $status = '<span class="badge badge-pill badge-success">แจ้งซ่อมใหม่</span>'; "";					$status_number = 1;				break;
				}


				$id1 = $row["MRA_ID"];
				$sql1 = "SELECT MJ_DatetimeFinish, MJ_EngineerCode, MJ_EngineerCode2 FROM MaintenanceJoblist WHERE MRA_ID = '$id1' AND MJ_Status = 2";
				$result1 = sqlsrv_query($conn, $sql1) or die(print_r(sqlsrv_errors(), true));
				$rows = sqlsrv_fetch_array($result1);

				$code1 = $rows["MJ_EngineerCode"];
				$code2 = $rows["MJ_EngineerCode2"];

				$sql2 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code1}%'";
				$result2 = sqlsrv_query($conn, $sql2) or die(print_r(sqlsrv_errors(), true));
				$name1 = sqlsrv_fetch_array($result2);

				$sql3 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code2}%'";
				$result3 = sqlsrv_query($conn, $sql3) or die(print_r(sqlsrv_errors(), true));
				$name2 = sqlsrv_fetch_array($result3);

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

				if($rows["MJ_DatetimeFinish"] != null ){
					echo '<div class="td datetimefinish">' . $rows["MJ_DatetimeFinish"] . '</div>';
				}else{
					echo '<div class="td datetimefinish"> - </div>';
				}

				echo '<div class="td worktype">' . $row["MRA_WorkType"] . '</div>';
				echo '<div class="td priority">' . $row["MRA_Priority"] . '</div>';
				echo '<div class="td description">' . $classMySec->encode($row["MRA_Description"]) . '</div>';
				echo '<div class="td effect">' . $row["MRA_Effect"] . '</div>';
				echo '<div class="td informer">' . $classMySec->encode($row["MRA_Informer"]) . '</div>';
				echo '<div class="td workunitname">' . $classMySec->encode($row["MRA_WorkUnitName"]) . '</div>';
				echo '<div class="td status">' . $status . '</div>';
				if(empty($code2) == true){
					echo '<div class="td engineer">' . $name1["E_LocalFirstName"] . '</div>';
				}else{
					echo '<div class="td engineer">' . $name1["E_LocalFirstName"] . ' , ' . $name2["E_LocalFirstName"] . '</div>';
				}

				echo "</div>";
				echo "</div>";
				echo "</div>";
				$num++;
			}
		}
		else
		{

			echo "ยังไม่มีข้อมูล..";

		}

		?>
		<div style="float: right; margin: 20px;"><?php page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET); ?></div>
	</div>


</body>

<script type="text/javascript">
	$(function ()
	{
		var isXS = false,
			$accordionXSCollapse = $('.accordion-xs-collapse');

		// Window resize event (debounced)
		var timer;
		$(window).resize(function ()
		{
			if (timer)
			{ clearTimeout(timer); }
			timer = setTimeout(function ()
			{
				isXS = Modernizr.mq('only screen and (max-width: 767px)');

				// Add/remove collapse class as needed
				if (isXS)
				{
					$accordionXSCollapse.addClass('collapse');
				}
				else
				{
					$accordionXSCollapse.removeClass('collapse');
				}
			}, 100);
		}).trigger('resize'); //trigger window resize on pageload

		// Initialise the Bootstrap Collapse
		$accordionXSCollapse.each(function ()
		{
			$(this).collapse({toggle: false});
		});

		// <a href="https://www.jqueryscript.net/accordion/">Accordion</a> toggle click event (live)
		$(document).on('click', '.accordion-xs-toggle', function (e)
		{
			e.preventDefault();

			var
				$thisToggle = $(this),
				$targetRow = $thisToggle.parent('.tr'),
				$targetCollapse = $targetRow.find('.accordion-xs-collapse');

			if (isXS && $targetCollapse.length)
			{
				var
					$siblingRow = $targetRow.siblings('.tr'),
					$siblingToggle = $siblingRow.find('.accordion-xs-toggle'),
					$siblingCollapse = $siblingRow.find('.accordion-xs-collapse');

				$targetCollapse.collapse('toggle'); //toggle this collapse
				$siblingCollapse.collapse('hide'); //close siblings

				$thisToggle.toggleClass('collapsed'); //class used for icon marker
				$siblingToggle.removeClass('collapsed'); //remove sibling marker class
			}
		});
	});
</script>
</html>
