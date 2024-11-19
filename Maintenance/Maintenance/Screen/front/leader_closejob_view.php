<?php 
if (!session_id()) session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
$authEPID = ['18', '21','22', '23','24','25', '26','300'];
if (isset($_SESSION['EP_ID']) && !in_array($_SESSION['EP_ID'], $authEPID)) {
	header('refresh: 0; url=index.php');
}else if(empty($_SESSION["EP_ID"]) == 1){
	header('refresh: 0; url=index.php');
}
if (isset($_SESSION['startTime']) && isset($_SESSION['limitTime'])) {
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
	<title>รายละเอียดงาน</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/tabletab_leader_closejob.css"/>
	<script src="../../js/modernizr.min.js"></script>

</head>
<body>

<?php
// ------------------------------------20/01/63 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
include("countstatus.php");
// $count_status = 0;

// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result)) {
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
				<a class="nav-link" href="leader_index.php">หน้าแรก <span class="badge badge-danger"><?php echo $count_status ?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="leader_repair_list.php">รายการแจ้งซ่อม</a>
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

<div class="container col-sm-12">
	<div class="row">
		<div class="col-sm-2">

		</div>
		<div class="col-sm-7 align-self-center">
			<h3>รายงานการแจ้งซ่อมเครื่องจักร / งานปรับปรุงเครื่องจักรและอุปกรณ์</h3>
		</div>
		<div class="col-3">
			รหัสเอกสาร : EN-F09-08<br>
			วันที่ประกาศใช้ : 16/09/19
		</div>
	</div>
	<br><h3>รายละเอียดงาน</h3><br>
</div>

<div class="container col-sm-10">
	<div class="divtable accordion-xs">
		<div class="tr headings">
			<div class="th code">ผู้ปฏิบัติงาน</div>
			<div class="th datetimestart">วันที่เริ่ม</div>
			<div class="th datetimefinish">วันที่เสร็จ</div>
			<div class="th cause">สาเหตุ</div>
			<div class="th method">วิธีการซ่อม / ปรับปรุง</div>
			<div class="th status">สถานะ</div>
		</div>

		<!-- php query -->
		<?php

		$id      = null;
		$meuid   = null;
		$status;
		$status_number;
		$image0  = null;
		$image1  = null;
		$image2  = null;
		$image3  = null;
		$image0a = null;
		$image1a = null;
		$image2a = null;
		$image3a = null;

		if (isset($_GET["id"])) 	{
			$id = (int)$_GET["id"];
		}

		// work unit name
		$sql00        = "SELECT MRA_WorkUnitName FROM MaintenanceRepairAdd WHERE MRA_ID = ?";
		$para         = array($id);
		$query00      = sqlsrv_query($conn, $sql00, $para);
		$row00        = sqlsrv_fetch_array($query00);
		$workunitname = $row00["MRA_WorkUnitName"];
		
		
		$sql          = "SELECT MEU_ID FROM MaintenanceEngineerUpdate WHERE MRA_ID = ? ORDER BY MEU_ID DESC";
		$param0       = array($id);
		$result0      = sqlsrv_query($conn, $sql, $param0);
		$row0         = sqlsrv_fetch_array($result0);
		$row0["MEU_ID"];
		
		
		$query        = "SELECT * FROM MaintenanceEngineerUpdate WHERE MRA_ID = ? AND MEU_ID = ?";
		$param        = array($id, $row0["MEU_ID"]);
		$result       = sqlsrv_query($conn, $query, $param) or die(print_r(sqlsrv_errors(), true));
		if (sqlsrv_has_rows($result) != 0)	{
			// displaying records.
			while ($row = sqlsrv_fetch_array($result)) {
 				
				switch ($row["MRA_Status"])	 {
					#case "1":		$status = '<span class="badge badge-pill badge-danger">แจ้งซ่อมใหม่</span>'; "";				$status_number = 1;				break;
					case "2":		$status = '<span class="badge badge-pill badge-info">กำลังดำเนินการ</span>'; "";			$status_number = 2;				break;
					case "3":		$status = '<span class="badge badge-pill badge-warning">ดำเนินการเสร็จ / รอตรวจงาน</span>'; "";	$status_number = 3;				break;
					case "4":		$status = '<span class="badge badge-pill badge-primary">รอปิดงาน</span>'; "";					$status_number = 4;				break;
					case "5":		$status = '<span class="badge badge-pill badge-success">ปิดงานแล้ว</span>'; "";					$status_number = 5;				break;
					default : $status = '<span class="badge badge-pill badge-success">แจ้งซ่อมใหม่</span>'; "";					$status_number = 1;				break;
				}
 

				echo '<div class="tr">';
				echo '<div class="td code accordion-xs-toggle" id="code">' . $row["MEU_EngineerCode"] . '</div>';
				echo '<div class="accordion-xs-collapse">';
				echo '<div class="inner">';
				echo '<div class="td datetimestart">' . $row["MEU_DatetimeStart"] . '</div>';
				echo '<div class="td datetimefinish">' . $row["MEU_DatetimeFinish"] . '</div>';
				echo '<div class="td cause">' . $row["MEU_Cause"] . '</div>';
				echo '<div class="td method">' . $row["MEU_Method"] . '</div>';
				echo '<div class="td status">' . $status . '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';

				$meuid = $row0["MEU_ID"];

			}
		}

		$sql1    = "SELECT * FROM MaintenanceEngineerImage WHERE MEU_ID = ?";
		$param1  = array($meuid);
		$result1 = sqlsrv_query($conn, $sql1, $param1) or die(print_r(sqlsrv_errors(), true));


		while ($row1 = sqlsrv_fetch_array($result1))	{
			$image0  = $row1["MEI_ImageBefore0"];
			$image1  = $row1["MEI_ImageBefore1"];
			$image2  = $row1["MEI_ImageBefore2"];
			$image3  = $row1["MEI_ImageBefore3"];
			$image0a = $row1["MEI_ImageAfter0"];
			$image1a = $row1["MEI_ImageAfter1"];
			$image2a = $row1["MEI_ImageAfter2"];
			$image3a = $row1["MEI_ImageAfter3"];
		}


		$sql2     = "SELECT MRC_Checker FROM MaintenanceRepairCheck WHERE MRA_ID = ?";
		$param2   = array($id);
		$result2  = sqlsrv_query($conn, $sql2, $param2) or die(print_r(sqlsrv_errors(), true));
		$row2     = sqlsrv_fetch_array($result2);
		$informer = $row2["MRC_Checker"];

		?>

	</div>
	<br>
	<div class="divtable accordion-xs">
		<div class="tr headings">
			<div class="th speed">ความเร็ว</div>
			<div class="th coordinate">การประสานงาน</div>
			<div class="th courteous">อัธยาศัยของช่าง</div>
			<div class="th cleanness">ความสะอาดของพื้นที่</div>
			<div class="th cleannessdetail">รายละเอียด</div>
			<div class="th neatness">ความเรียบร้อย</div>
			<div class="th neatnessdetail">รายละเอียด</div>
			<div class="th risk">ความเสี่ยงที่พบ</div>
			<div class="th riskdetail">รายละเอียด</div>
		</div>

		<!-- php query -->
		<?php
			
			$sql1    = "SELECT * FROM MaintenanceRepairCheck WHERE MRA_ID = ?";
			$param1  = array($id);
			$result1 = sqlsrv_query($conn, $sql1, $param1);

		// displaying records.
		while ($row1 = sqlsrv_fetch_array($result1))	{

			echo '<div class="tr">';
			echo '<div class="td speed accordion-xs-toggle">' . $row1["MRC_Speed"] . '</div>';
			echo '<div class="accordion-xs-collapse">';
			echo '<div class="inner">';
			echo '<div class="td coordinate">' . $row1["MRC_Coordinate"] . '</div>';
			echo '<div class="td courteous">' . $row1["MRC_Courteous"] . '</div>';
			echo '<div class="td cleanness">' . $row1["MRC_Cleanness"] . '</div>';
			echo '<div class="td cleannessdetail">' . $row1["MRC_CleannessDetail"] . '</div>';
			echo '<div class="td neatness">' . $row1["MRC_Neatness"] . '</div>';
			echo '<div class="td neatnessdetail">' . $row1["MRC_NeatnessDetail"] . '</div>';
			echo '<div class="td risk">' . $row1["MRC_Risk"] . '</div>';
			echo '<div class="td riskdetail">' . $row1["MRC_RiskDetail"] . '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

		}

		?>
	</div>
	<br>
</div>



<div class="container col-sm-10">
	<div class="row">
		<form class="col-sm-4" action="../backend/action_leader_closejob.php" method="post">



			<div class="form-group">
				<div>
					<b>ผู้บันทึก</b><br>
					<input type="text" class="form-control" name="leader" value="<?php echo $_SESSION["FirstName"]; ?>" readonly/>
				</div>
			</div>

			<div class="form-group">
				<div>
					<b>ผู้ประเมิน / ผู้แจ้งซ่อม</b><br>
					<input type="text" class="form-control" name="informer" value="<?php echo $informer; ?>" readonly/>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<input type="hidden" name="workunit" value="<?php echo $workunitname; ?>" />

			 
		</form>

		<div class="col-sm-1"></div>

		<div class="col-sm">
			<div>
				<b>รูปภาพ</b>
			</div>
			<div>
				<p>ก่อนทำ</p>
				<center>
					<?php

					if ($image0 != null) {
						echo '<a href="../../image_upload_engineer_before/' . $image0 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image0 . '"/></a>';
					}


					if ($image1 != null) {
						echo '<a href="../../image_upload_engineer_before/' . $imgage1 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image1 . '"/></a><br>';
					}


					if ($image2 != null) {
						echo '<a href="../../image_upload_engineer_before/' . $imgage2 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image2 . '"/></a>';
					}


					if ($image3 != null) {
						echo '<a href="../../image_upload_engineer_before/' . $imgage3 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image3 . '"/></a>';
					}

					?>
				</center>
				<p>หลังทำ</p>
				<center>
					<?php

					if ($image0a != null)  {
						echo '<a href="../../image_upload_engineer_after/' . $image0a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image0a . '"/></a>';
					}

					if ($image1a != null)  {
						echo '<a href="../../image_upload_engineer_after/' . $image1a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image1a . '"/></a><br>';
					}

					if ($image2a != null)  {
						echo '<a href="../../image_upload_engineer_after/' . $image2a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image2a . '"/></a>';
					}

					if ($image3a != null)  {
						echo '<a href="../../image_upload_engineer_after/' . $image3a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image3a . '"/></a>';
					}

					?>
				</center>
			</div>
		</div>

	</div>
</div>
<br>



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

</body>
</html>