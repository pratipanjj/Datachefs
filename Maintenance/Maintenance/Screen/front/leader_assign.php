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
if (isset($_SESSION['startTime']) && isset($_SESSION['limitTime']))
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
	<link rel="stylesheet" href="../../css/tabletab_leader_assign.css"/>
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

$count_status = 0;

$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

while ($row = sqlsrv_fetch_array($result))
{
	$count_status = $row['num'];
}

?>

<!-- -------------------------------------------เปลี่ยนเป็น include menu bar แทน by pop ------------------------------------------------------- -->
<?php include("leader_menubar.php"); ?>
<!-- navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="#">MRG Maintenance</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item">
				<a class="nav-link" href="leader_index.php">หน้าแรก <span class="badge badge-danger"><?php echo $count_status ?></span></a>
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

<div class="container col-sm-8">
	<br>
	<h3>มอบหมายงาน</h3><br>
</div>

<div class="container col-sm-10">
	<div class="divtable accordion-xs">
		<div class="tr headings">
			<div class="th machine_name">ชื่อเครื่องจักร/ทรัพย์สิน</div>
			<div class="th machine_code">รหัสเครื่องจักร/ทรัพย์สิน</div>
			<div class="th datetime">วัน/เวลาที่แจ้ง</div>
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
				switch ($row["MRA_Status"])	 {
					#case "1":		$status = '<span class="badge badge-pill badge-danger">แจ้งซ่อมใหม่</span>'; "";				$status_number = 1;				break;
					case "2":		$status = '<span class="badge badge-pill badge-info">กำลังดำเนินการ</span>'; "";			$status_number = 2;				break;
					case "3":		$status = '<span class="badge badge-pill badge-warning">ดำเนินการเสร็จ / รอตรวจงาน</span>'; "";	$status_number = 3;				break;
					case "4":		$status = '<span class="badge badge-pill badge-primary">รอปิดงาน</span>'; "";					$status_number = 4;				break;
					case "5":		$status = '<span class="badge badge-pill badge-success">ปิดงานแล้ว</span>'; "";					$status_number = 5;				break;
					default : $status = '<span class="badge badge-pill badge-success">แจ้งซ่อมใหม่</span>'; "";					$status_number = 1;				break;
				}

				echo '<div class="tr">';
				echo '<div class="td machine_name accordion-xs-toggle">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
				echo '<div class="accordion-xs-collapse">';
				echo '<div class="inner">';
				echo '<div class="td machine_code">' . $classMySec->encode($row["MRA_MachineCode"]) . '</div>';
				echo '<div class="td datetime">' . $classMySec->encode($row["MRA_Datetime"]) . '</div>';
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

		<form class="col-sm-4" action="../backend/action_leader_assign.php" method="post">
			<div class="form-group">
				<div>
					<b>ชื่อผู้ปฏิบัติงาน1</b>
				</div>
				<div>
					<input type="text" name="engineer_name1" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="ค้นหาชื่อช่าง" required>
				</div>
			</div>

			<div class="form-group">
				<div>
					<b>ชื่อผู้ปฏิบัติงาน2</b>
				</div>
				<div>
					<input type="text" name="engineer_name2" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="ค้นหาชื่อช่าง" required>
				</div>
			</div>

			<div class="form-group">
				<div>
					<b>วันที่เสร็จ / กำหนดการ</b>
				</div>
				<div>
					<input type="text" class="form-control" id="input" name="datetimefinish" placeholder="วันที่เสร็จ" required>
					<input type="hidden" name="mra_id" value="<?php echo $id; ?>">
					<input type="hidden" name="mra_workunit" value="<?php echo $workunit; ?>">
				</div>
			</div>
			<div class="text-right"><input type="submit" name="submit" class="btn btn-light-blue" value="มอบหมายงาน">
			</div>
		</form>

		<div class="col-sm-1"></div>

		<div class="col-sm">
			<div>
				<b>รูปภาพ</b>
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
						echo '<a href="../../image_upload_user/' . $imgage1 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_user/' . $imgage1 . '"/></a><br>';
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

			var $thisToggle = $(this),
				$targetRow = $thisToggle.parent('.tr'),
				$targetCollapse = $targetRow.find('.accordion-xs-collapse');

			if (isXS && $targetCollapse.length)
			{
				var $siblingRow = $targetRow.siblings('.tr'),
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
<!--เลือกวันที่และเวลา-->
<script>
	$('#input').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});
</script>

</html>
