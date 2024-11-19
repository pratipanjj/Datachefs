<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
if($_SESSION["EP_ID"] == 21) {
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
// ------------------------------------20/01/2020 แก้ไขผลรวมของงานค้างและ include file แทน by POP----------------------------------
include("countstatus.php");
// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 3 AND MRA_WorkUnitID = '$wg_id'";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result))
// {
// 	$count_status = $row['num'];
// }
// -----------------------------------------------------------------------------------------------------------------------------------
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


<div class="container col-sm-12">
	<br>
	<h3 class="text-center">การแจ้งเตือนล่าสุดของหน่วยงาน <?php echo $_SESSION["WG_WorkUnitName"]; ?></h3><br>

	<?php

	$url = '';
	if(isset($_GET['keyword'])) { 
		$keyword = addslashes($_GET['keyword']);
		$url .= '?keyword='.$keyword;	
	}

	if(isset($_GET['workgroup'])) {
		$workgroup = addslashes($_GET['workgroup']);
		$url .= '?workgroup='.$workgroup;
	}







	$level =  $_SESSION['E_Level'];
	if($level < 13) {  ?>
		<div class="row">
	<div class="col-md-3 text-center" style="margin:auto;"></div>
	<div class="col-md-6 text-center" style="margin:auto;">

			<form name="frmSearch" method="get" action="">
				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="keyword" id="keyword" placeholder="พิมพ์ชื่อรายการแจ้งซ่อม" value="<?php (isset($_GET['keyword'])) ? $_GET['keyword'] : "" ?>">
						<div class="input-group-append">
							<button type="submit" class="btn btn-light-blue" name="btn_search" id="btn_search">
								<img src="../../img/icon/search_white_24dp.png"></button>
								<?php if(isset($_GET['keyword'])) { ?>
								<a href="user_index.php"  class="btn btn-light-blue">ดูทั้งหมด</a>
							<?php }?>
							<a href="../../PHPExcel/export-dashboard.php<?php echo $url;?>" class="btn btn-outline-success" target="_blank">ส่งออกไฟล์ .xlsx</a>
						</div>
					</div>
				</div>
	</form>
</div>
		<div class="col-md-3 text-center" style="margin:auto;"></div>
				</div>
				<br>	

	<?php } ?>


	<?php if ($level >= 13) { ?>
<div class="row">
	<div class="col-md-3 text-center" style="margin:auto;"></div>
	<div class="col-md-6 text-center" style="margin:auto;">
		<form name="frmSearch" method="get" action="" class="form-inline">
 						<div class="form-group">	
 						<label for="" style="padding-top:5px;">เลือกหน่วยงาน</label> 
 						<select name="workgroup" id="" class="form-control" style="  margin-right:10px; margin-left: 5px;">
 							<option value="">เลือกหน่วยงาน</option>
 							<?php 
 							$department = $_SESSION['D_IDDepartment'];
 							$workgroupSQL = 
 							"
							SELECT TOP (1000) [WG_ID]
						      ,[WG_Code]
						      ,[WG_LocalName]
						      ,[WG_EnglishName]
						      ,[D_ID]
						      ,[WG_IsActive]
						      ,[WG_WorkUnitName]
						    FROM [Paradise].[dbo].[WorkGroup] WHERE D_ID = '$department'

 							";
 							$workgroupQuery = sqlsrv_query($conn, $workgroupSQL);
 							while($workgroup = sqlsrv_fetch_array($workgroupQuery)) { 
 								echo '<option value="'.$workgroup['WG_ID'].'">'.$workgroup['WG_EnglishName'].'</option>';
 							} ?>
 						</select>
</div>
						<div class="form-group">
							<label for="">รายการแจ้งซ่อม</label>
 								<input type="text" class="form-control" name="keyword" id="keyword" placeholder="พิมพ์ชื่อรายการแจ้งซ่อม" value="<?php (isset($_GET['keyword'])) ? $_GET['keyword'] : "" ?>" style="margin-right: 5px;">
						</div>

						<div class="form-group">
								<button type="submit" class="btn btn-light-blue" name="btn_search" id="btn_search"><img src="../../img/icon/search_white_24dp.png" ></button>
								<?php if(isset($_GET['keyword'])) { ?>
								<a href="user_index.php"  class="btn btn-light-blue">ดูทั้งหมด</a>
 							<?php }?>
							<a href="../../PHPExcel/export-dashboard.php<?php echo $url;?>" class="btn btn-outline-success" target="_blank">ส่งออกไฟล์ .xlsx</a>
						</div>
					
			 
		</form>
		</div>
		<div class="col-md-3 text-center" style="margin:auto;"></div>
				</div>
				<br>	
	<?php } ?>


</div>

<div class="container col-sm-10">

<!--	รายการแจ้งซ่อม, วันที่แจ้งซ่อม, รายละเอียด, สถานะ, จัดการ-->
	<div class="divtable accordion-xs">

		<div class="tr headings">
			<div class="th machine_name">รายการแจ้งซ่อม</div>
			<div class="th datetime">วัน/เวลาที่แจ้ง</div>
			<div class="th datetimefinish">วัน/เวลาที่เสร็จ</div>
			<div class="th description">รายละเอียด</div>
			<div class="th engineer">ช่างที่รับงาน</div>
			<div class="th status">สถานะ</div>
			<div class="th manage">จัดการ</div>
		</div>

			<?php
			require_once("../backend/classMySec.php");

			$total;
			$num = 0;


			$wg_id = (isset($_GET['workgroup']) ? $_GET['workgroup'] : $_SESSION['WG_ID'] );
			 
			#echo $_SESSION['S_ID'];
 			$Emp_section = $_SESSION['S_ID'];

			$sql = "SELECT * FROM MaintenanceRepairAdd 
					INNER JOIN workgroup ON workgroup.wg_id =  maintenancerepairadd.mra_workunitid
					INNER JOIN department on department.d_id = workgroup.d_id
					WHERE s_id = '$Emp_section'";
					//WHERE MRA_WorkUnitID = '$wg_id'";//

			// เงื่อนไขสำหรับ search text
			if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
				//$work_unit_name = $_SESSION["WG_WorkUnitName"];
				$wg_id = $_SESSION["WG_ID"];
				$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd 
						INNER JOIN workgroup ON workgroup.wg_id =  maintenancerepairadd.mra_workunitid
						INNER JOIN department on department.d_id = workgroup.d_id
						WHERE s_id = '$Emp_section' AND MRA_MachineName LIKE N'%" . $_GET['keyword'] . "%'";
				
				$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
				$row = sqlsrv_fetch_array($result);
				$total = $row['num'];
				 
				$classMySec = new classMySec();
				$keyword = $classMySec->encode($_GET['keyword']);
				$sql .= " AND MRA_MachineName LIKE N'%" . $keyword . "%'";

			}	else	{

				//$work_unit_name = $_SESSION["WG_WorkUnitName"];
				$wg_id = $_SESSION["WG_ID"];
				$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd
						INNER JOIN workgroup ON workgroup.wg_id =  maintenancerepairadd.mra_workunitid
						INNER JOIN department on department.d_id = workgroup.d_id
						WHERE s_id = '$Emp_section'" ;
				//WHERE MRA_WorkUnitID = '$wg_id'";
				$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
				$row = sqlsrv_fetch_array($result);
				$total = $row['num'];

			}


			$e_page = 8; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า
			$step_num = 0;

			if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1))	{
				$_GET['page'] = 1;
				$step_num     = 0;
				$s_page       = 0;
			} else {
				$s_page       = $_GET['page'] - 1;
				$step_num     = $_GET['page'] - 1;
				$s_page       = $s_page * $e_page;
			}


			$sql .= " ORDER BY MRA_ID DESC OFFSET " . $s_page . " ROWS FETCH NEXT " . $e_page . " ROWS ONLY";
			$result = sqlsrv_query($conn, $sql);

			if ($result)	 {
				$classMySec = new classMySec();
				while ($row = sqlsrv_fetch_array($result)) {
				switch ($row["MRA_Status"])	 {
						#case "1":		$status = '<span class="badge badge-pill badge-danger">แจ้งซ่อมใหม่</span>'; "";				$status_number = 1;				break;
						case "2":		$status = '<span class="badge badge-pill badge-info">กำลังดำเนินการ</span>'; "";				$status_number = 2;				break;
						case "3":		$status = '<span class="badge badge-pill badge-warning">ดำเนินการเสร็จ / รอตรวจงาน</span>'; "";	$status_number = 3;				break;
						case "4":		$status = '<span class="badge badge-pill badge-primary">รอปิดงาน</span>'; "";					$status_number = 4;				break;
						case "5":		$status = '<span class="badge badge-pill badge-success">ปิดงานแล้ว</span>'; "";				$status_number = 5;				break;
						default : 		$status = '<span class="badge badge-pill badge-success">แจ้งซ่อมใหม่</span>'; "";				$status_number = 1;				break;
					}

					$id1 = $row["MRA_ID"];
					$sql1 = "SELECT MJ_DatetimeFinish, MJ_EngineerCode, MJ_EngineerCode2, MJ_Status FROM MaintenanceJoblist WHERE MRA_ID = '$id1'";
					$result1 = sqlsrv_query($conn, $sql1) or die(print_r(sqlsrv_errors(), true));
					$date = sqlsrv_fetch_array($result1);

					$code1 = $date["MJ_EngineerCode"];
					$code2 = $date["MJ_EngineerCode2"];

					$sql2 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code1}%'";
					$result2 = sqlsrv_query($conn, $sql2) or die(print_r(sqlsrv_errors(), true));
					$name1 = sqlsrv_fetch_array($result2);

					$sql3 = "SELECT E_LocalFirstName FROM Employee WHERE E_Code LIKE N'%{$code2}%'";
					$result3 = sqlsrv_query($conn, $sql3) or die(print_r(sqlsrv_errors(), true));
					$name2 = sqlsrv_fetch_array($result3);

					echo '<div class="tr">';

					// ปิดงานแล้ว [สีเขียว]
					if($date["MJ_Status"] == 5)
					{
						echo '<div class="td machine_name accordion-xs-toggle" id="job_finish">' . $classMySec->encode($row["MRA_MachineName"]) . 's</div>';
					}
					// เกินกำหนด [สีแดง]
					elseif((date('d-m-Y H:i') > $date["MJ_DatetimeFinish"]) && ($date["MJ_DatetimeFinish"] != null))
					{
						echo '<div class="td machine_name accordion-xs-toggle" id="datetime_late">' . $classMySec->encode($row["MRA_MachineName"]) . 's</div>';
					}
					// ดำเนินการ [สีส้ม]
					elseif((date('d-m-Y H:i') < $date["MJ_DatetimeFinish"]) && ($date["MJ_DatetimeFinish"] != null))
					{
						echo '<div class="td machine_name accordion-xs-toggle" id="job_progress">' . $classMySec->encode($row["MRA_MachineName"]) . 's</div>';
					}
					// แจ้งซ่อมใหม่ [สีเทา]
					else
					{
						echo '<div class="td machine_name accordion-xs-toggle">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
					}

					echo '<div class="accordion-xs-collapse">';
					echo '<div class="inner">';
					echo '<div class="td datetime">' . $row["MRA_Datetime"] . '</div>';

					if($date["MJ_DatetimeFinish"] != null )
					{
						echo '<div class="td datetimefinish">' . $date["MJ_DatetimeFinish"] . '</div>';
					}else{
						echo '<div class="td datetimefinish"> - </div>';
					}

					echo '<div class="td description">' . $classMySec->encode($row["MRA_Description"]) . '</div>';

					if($name1["E_LocalFirstName"] == "ADMIN" )
					{
						echo '<div class="td engineer">-</div>';
					}else{
						echo '<div class="td engineer">' . $name1["E_LocalFirstName"] . ' / ' . $name2["E_LocalFirstName"] . '</div>';
					}
					echo '<div class="td status">' . $status . '</div>';

					if ($row["MRA_Status"] != 3)
					{
						echo '<div class="td manage"><button href="#" class="btn btn-light-blue btn-sm" disabled>ตรวจรับงาน</button></div>';
					}
					else
					{
						echo '<div class="td manange"><a href="user_repair_check.php?id='.$row["MRA_ID"].'" class="btn btn-light-blue btn-sm">ตรวจรับงาน</a></div>';
					}

					echo "</div>";
					echo "</div>";
					echo "</div>";
					$num++;
				}
			} else {
 					echo "ยังไม่มีข้อมูล..";
 				}


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

