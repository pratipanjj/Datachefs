<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
if($_SESSION["EP_ID"] == 300) {
	header('Location: ../front/leader_index.php' );
} else if($_SESSION["EP_ID"] == 21) {
	header('Location: ../front/leader_index.php' );
} elseif($_SESSION["EP_ID"] == 22) {
	header('Location: ../front/leader_index.php' );
} elseif($_SESSION["EP_ID"] == 23) {
	header('Location: ../front/leader_index.php' );
} elseif($_SESSION["EP_ID"] == 24) {
	header('Location: ../front/leader_index.php' );
} elseif($_SESSION["EP_ID"] == 25) {
	header('Location: ../front/engineer_index.php' );
} elseif($_SESSION["EP_ID"] == 26) {
	header('Location: ../front/engineer_index.php' );
}

if(isset($_SESSION['startTime']) && isset($_SESSION['limitTime'])) {
	if ($_SESSION['startTime'] + $_SESSION['limitTime'] <= time())	{
		session_destroy();
		header('Location: index.php');
		exit;
	}
}

require_once("../backend/config.php");
require_once("../backend/pagination.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>หน้าแรก</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css">

	<link rel="stylesheet" href="../../css/tabletab_user_index.css"/>
	<script src="../../js/modernizr.min.js"></script>


</head>
<body>

<?php
	$wg_id = $_SESSION["WG_ID"];
// ------------------------------------20/01/2020 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
include("countstatus.php");
// $count_status = 0;

// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 3";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result)) {
// 	$count_status = $row['num'];
// }
// -----------------------------------------------------------------------------------------------------------------------------------
?>

<!-- -------------------------------------------เปลี่ยนเป็น include menu bar แทน by pop ------------------------------------------------------- -->
<?php 
include("leader_engineer_menubar.php"); 
?>
<!-- navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="#">MRG Maintenance</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item">
				<a class="nav-link active" href="user_index.php">หน้าแรก
					<span class="badge badge-danger"><?php echo $count_status ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="user_repair_add.php">แจ้งซ่อม</a>
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
<!-- --------------------------------------------------------------------------------------------------------------------------------------- -->
<?php include("user_header.php"); ?>
<!--แจ้งซ่อมใหม่ , กำลังดำเนินการ , ดำเนินการแล้ว / รอตรวจงาน , รอปิดงาน , ปิดงานซ่อมแล้ว-->
<div class="container col-sm-8">
	<div class="row">
	<h3>ปิดงานซ่อมแล้ว</h3>
	</div>
</div>
<div class="container-fluid">
	<ul class="nav nav-tabs">
		<hr>
		<li class="nav-item" style="display:inline-block;">
			<a class="nav-link" href="user_index.php"><img src="../../img/icon/status1.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status1; ?></span></a>
		</li>
		<li class="nav-item" style="display:inline-block;">
			<a class="nav-link" href="user_index_status2.php"><img src="../../img/icon/status2.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status2; ?></span></a>
		</li>
		<li class="nav-item" style="display:inline-block;">
			<a class="nav-link" href="user_index_status3.php"><img src="../../img/icon/status3.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status3; ?></span></a>
		</li>
		<li class="nav-item" style="display:inline-block;">
			<a class="nav-link" href="user_index_status4.php"><img src="../../img/icon/status4.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status4; ?></span></a>
		</li>
		<li class="nav-item" style="display:inline-block;">
			<a class="nav-link active" href="user_index_status5.php"><img src="../../img/icon/status5.png" width="15px" height="15px"><span class="badge badge-danger"><?php echo $count_status5; ?></span></a>
		</li>
		<hr>
	</ul>
</div><br>

<div class="container col-sm-10">

<!--	รายการแจ้งซ่อม, วันที่แจ้งซ่อม, รายละเอียด, สถานะ, จัดการ-->
	<div class="divtable accordion-xs">
			<?php
			require_once("../backend/classMySec.php");

			$total;
			$num = 0;

			// $wg_id = (isset($_GET['workgroup']) ? $_GET['workgroup'] : $_SESSION['WG_ID'] );
			// $sql = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_WorkUnitID = '$wg_id' AND MRA_Status = 5";
			if(isset($_SESSION["WG"]) || isset($_GET['workgroup'])){
				if(isset($_GET['workgroup'])){
					$wg_id = $_GET['workgroup'];
					// unset ($_SESSION["WG"]);
					$_SESSION["WG"] = $_GET['workgroup'];
				}else{
					$wg_id = $_SESSION["WG"];
					// unset ($_SESSION["WG"]);
				}
				$sql = "SELECT * FROM MaintenanceRepairAdd WHERE MRA_WorkUnitID = '$wg_id' AND MRA_Status = 5";
			}else{
				$sql = "SELECT * FROM MaintenanceRepairAdd 
				INNER JOIN WorkGroup  ON MaintenanceRepairAdd.MRA_WorkUnitID = WorkGroup.WG_ID
				INNER JOIN Department  ON WorkGroup.D_ID = Department.D_ID
				INNER JOIN Section  ON Department.S_ID = Section.S_ID 
				WHERE Section.S_ID = '$department' AND MaintenanceRepairAdd.MRA_Status = 5";
			}
			include("user_body.php");
			?>

		<div style="float: right; margin: 20px;"><?php page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET); ?></div>
	</div>

</div>


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
</body>
</html>

