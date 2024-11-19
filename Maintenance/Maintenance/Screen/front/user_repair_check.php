<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
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
<html lang="en">
<head>
	<title>หน้าตรวจรับงาน</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css">
	<script src="../../datetimepicker/js/gijgo.min.js"></script>
	<link rel="stylesheet" href="../../datetimepicker/css/gijgo.min.css">
	<link rel="stylesheet" href="../../css/tabletab_leader_closejob.css"/>
	<script src="../../js/modernizr.min.js"></script>
	<!--star radio button-->
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>
<body>

<?php

$count_status = 0;
$wg_id = $_SESSION["WG_ID"];

$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 3 AND MRA_WorkUnitID = '$wg_id'";
$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

while ($row = sqlsrv_fetch_array($result))
{
	$count_status = $row['num'];
}

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
				<a class="nav-link" href="user_index.php">หน้าแรก
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
<!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

<?php

require_once("../backend/config.php");

if (isset($_GET["id"]))
{
	$id = (int)$_GET["id"];
}

?>

<div class="container col-sm-8">
	<br>
	<h3>ตรวจรับงาน</h3><br>
</div>

<div class="container col-sm-10">
	<div class="divtable accordion-xs">
		<div class="tr headings">
			<div class="th code">ผู้ปฏิบัติงาน</div>
			<div class="th datetimestart">วัน/เวลาที่เริ่มซ่อม</div>
			<div class="th datetimefinish">วัน/เวลาที่ซ่อมเสร็จ</div>
			<div class="th cause">สาเหตุ</div>
			<div class="th method">วิธีการซ่อม / ปรับปรุง</div>
			<div class="th status">สถานะ</div>
		</div>

		<!-- php query -->
		<?php

		$id = null;
		$meuid = null;
		$status;
		$status_number;
		$image0 = null;
		$image1 = null;
		$image2 = null;
		$image3 = null;
		$image0a = null;
		$image1a = null;
		$image2a = null;
		$image3a = null;

		if (isset($_GET["id"]))
		{
			$id = (int)$_GET["id"];
		}

		// work unit name
		$sql00 = "SELECT MRA_WorkUnitName FROM MaintenanceRepairAdd WHERE MRA_ID = ?";
		$para = array($id);
		$query00 = sqlsrv_query($conn, $sql00, $para);
		$row00 = sqlsrv_fetch_array($query00);
		$workunitname = $row00["MRA_WorkUnitName"];

		$sql = "SELECT MEU_ID FROM MaintenanceEngineerUpdate WHERE MRA_ID = ? ORDER BY MEU_ID DESC";
		$param0 = array($id);
		$result0 = sqlsrv_query($conn, $sql, $param0);
		$row0 = sqlsrv_fetch_array($result0);
		$row0["MEU_ID"];

		$query = "SELECT * FROM MaintenanceEngineerUpdate WHERE MRA_ID = ? AND MEU_ID = ?";
		$param = array($id, $row0["MEU_ID"]);
		$result = sqlsrv_query($conn, $query, $param) or die(print_r(sqlsrv_errors(), true));
		if (sqlsrv_has_rows($result) != 0)
		{
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

		$sql1 = "SELECT * FROM MaintenanceEngineerImage WHERE MEU_ID = ?";
		$param1 = array($meuid);
		$result1 = sqlsrv_query($conn, $sql1, $param1) or die(print_r(sqlsrv_errors(), true));

		while ($row1 = sqlsrv_fetch_array($result1))
		{
			$image0 = $row1["MEI_ImageBefore0"];
			$image1 = $row1["MEI_ImageBefore1"];
			$image2 = $row1["MEI_ImageBefore2"];
			$image3 = $row1["MEI_ImageBefore3"];
			$image0a = $row1["MEI_ImageAfter0"];
			$image1a = $row1["MEI_ImageAfter1"];
			$image2a = $row1["MEI_ImageAfter2"];
			$image3a = $row1["MEI_ImageAfter3"];
		}

		?>
		<br>
	</div>



	<div class="container col-sm-10">
		<div class="row">

			<form action="../backend/action_user_repair_check.php" method="post">
				<div class="form-group">
					<p><b>ผลการซ่อม</b></p>
					<input type="hidden" name="mraid" value="<?php echo $id; ?>">
					<div class="form-group">
						<div>
							<b>ความเร็ว</b>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline1" name="speed" class="custom-control-input" value="รวดเร็ว / ทันกำหนด" required>
							<label class="custom-control-label" for="customRadioInline1">รวดเร็ว / ทันกำหนด</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline2" name="speed" class="custom-control-input" value="ช้ากว่ากำหนด" required>
							<label class="custom-control-label" for="customRadioInline2">ช้ากว่ากำหนด</label>
						</div>
					</div>

					<div class="form-group">
						<div>
							<b>การประสานงาน</b>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline3" name="coordinate" class="custom-control-input" value="รวดเร็ว / มีการประสานงานต่อเนื่อง" required>
							<label class="custom-control-label" for="customRadioInline3">รวดเร็ว / มีการประสานงานต่อเนื่อง</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline4" name="coordinate" class="custom-control-input" value="ยังไม่ดีเท่าที่ควร" required>
							<label class="custom-control-label" for="customRadioInline4">ยังไม่ดีเท่าที่ควร</label>
						</div>
					</div>

					<div class="form-group">
						<div>
							<b>อัธยาศัยของช่าง</b>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline5" name="courteous" class="custom-control-input" value="ดี ยิ้มแแย้ม เป็นมิตร" required>
							<label class="custom-control-label" for="customRadioInline5">ดี ยิ้มแย้ม เป็นมิตร</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline6" name="courteous" class="custom-control-input" value="ไม่ดี บูดบึ้ง ดูไม่เป็นมิตร" required>
							<label class="custom-control-label" for="customRadioInline6">ไม่ดี บูดบึ้ง ดูไม่เป็นมิตร</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>ผลการตรวจความสะอาดของพื้นที่</b>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline7" name="cleanness" class="custom-control-input" value="สะอาด" required>
						<label class="custom-control-label" for="customRadioInline7">สะอาด</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline8" name="cleanness" class="custom-control-input" value="ไม่สะอาด" required>
						<label class="custom-control-label" for="customRadioInline8">ไม่สะอาด &nbsp;</label>
						<textarea class="form-control col-sm-6" id="clean" name="cleandetail" placeholder="รายละเอียด"></textarea>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>ความเรียบร้อยหลังการซ่อม</b>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline9" name="neatness" class="custom-control-input" value="เรียบร้อย มีการเก็บเศษขยะไปทิ้ง" required>
						<label class="custom-control-label" for="customRadioInline9">เรียบร้อย มีการเก็บเศษขยะไปทิ้ง</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline10" name="neatness" class="custom-control-input" value="ไม่เรียบร้อย มีเศษขยะหลงเหลือหลังการซ่อมแซม" required>
						<label class="custom-control-label" for="customRadioInline10">ไม่เรียบร้อย มีเศษขยะหลงเหลือหลังการซ่อมแซม &nbsp;</label>
						<textarea class="form-control col-sm-6" id="neat" name="neatdetail" placeholder="รายละเอียด"></textarea>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>ความเสี่ยงที่พบหลังการซ่อม</b>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline11" name="risk" class="custom-control-input" value="ไม่พบความเสี่ยง" required>
						<label class="custom-control-label" for="customRadioInline11">ไม่พบความเสี่ยง</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="customRadioInline12" name="risk" class="custom-control-input" value="ตรวจพบความเสี่ยง" required>
						<label class="custom-control-label" for="customRadioInline12">ตรวจพบความเสี่ยง &nbsp;</label>
						<textarea class="form-control col-sm-6" id="risk" name="riskdetail" placeholder="รายละเอียด"></textarea>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>ให้คะแนนช่าง</b><br>
						<div class="stars">
							<input class="star star-5" id="star-5" type="radio" name="score" value="5" required/>
							<label class="star star-5" for="star-5"></label>
							<input class="star star-4" id="star-4" type="radio" name="score" value="4" required/>
							<label class="star star-4" for="star-4"></label>
							<input class="star star-3" id="star-3" type="radio" name="score" value="3" required/>
							<label class="star star-3" for="star-3"></label>
							<input class="star star-2" id="star-2" type="radio" name="score" value="2" required/>
							<label class="star star-2" for="star-2"></label>
							<input class="star star-1" id="star-1" type="radio" name="score" value="1" required/>
							<label class="star star-1" for="star-1"></label>
						</div>
						<br>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>ผู้ตรวจรับงานซ่อม / งานปรับปรุง</b>
					</div>
					<div>
						<input type="text" class="form-control" id="name" name="name" placeholder="อัตโนมัติ" value="<?php echo $_SESSION["FirstName"]; ?>" disabled>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>วันที่</b>
					</div>
					<div>
						<input type="text" class="form-control" id="input" name="date" placeholder="วันที่ตรวจรับงาน" required>
					</div>
				</div>
				<div class="text-right"><input type="submit" class="btn btn-light-blue" value="บันทึก"></div>
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
						if ($image0 != null)
						{
							echo '<a href="../../image_upload_engineer_before/' . $image0 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image0 . '"/></a>';
						}
						if ($image1 != null)
						{
							echo '<a href="../../image_upload_engineer_before/' . $imgage1 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image1 . '"/></a><br>';
						}
						if ($image2 != null)
						{
							echo '<a href="../../image_upload_engineer_before/' . $imgage2 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image2 . '"/></a>';
						}
						if ($image3 != null)
						{
							echo '<a href="../../image_upload_engineer_before/' . $imgage3 . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_before/' . $image3 . '"/></a>';
						}
						?>
					</center>
					<p>หลังทำ</p>
					<center>
						<?php
						if ($image0a != null)
						{
							echo '<a href="../../image_upload_engineer_after/' . $image0a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image0a . '"/></a>';
						}
						if ($image1a != null)
						{
							echo '<a href="../../image_upload_engineer_after/' . $image1a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image1a . '"/></a><br>';
						}
						if ($image2a != null)
						{
							echo '<a href="../../image_upload_engineer_after/' . $image2a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image2a . '"/></a>';
						}
						if ($image3a != null)
						{
							echo '<a href="../../image_upload_engineer_after/' . $image3a . '"><img style="margin:5px;" width="250" height="250" src="../../image_upload_engineer_after/' . $image3a . '"/></a>';
						}
						?>
					</center>
				</div>
			</div>

			</div>
		</div>


</div>
<br>

</body>

<script>
	$('#input').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});
</script>

</html>