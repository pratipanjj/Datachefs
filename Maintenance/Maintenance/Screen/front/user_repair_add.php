<?php
session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
if(isset($_SESSION['startTime']) && isset($_SESSION['limitTime']))
{
	if ($_SESSION['startTime'] + $_SESSION['limitTime'] <= time())
	{
		session_destroy();
		header('Location: index.php');
	}
}
?>
<html>
<head>
	<title>หน้าแจ้งซ่อม</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../datetimepicker/css/gijgo.min.css">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.1.114/styles/kendo.default-v2.min.css"/>

 	<!-- -------------------------------------------------------------------------------------------------------------------------- -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<!--star radio button-->
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<!--limit file upload-->
	<!-- <link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.common.min.css" rel="stylesheet" type="text/css"/>
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.default.min.css" rel="stylesheet" type="text/css"/>
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.dataviz.min.css" rel="stylesheet" type="text/css"/>
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.mobile.all.min.css" rel="stylesheet" type="text/css"/> -->
	<!-- -------------------------------------------------------------------------------------------------------------------------- -->

	<style>
		.error {color: #FF0000;}
	</style>

</head>

<body>

<?php
require_once("../backend/config.php");
$wg_id = $_SESSION["WG_ID"];
$code = $_SESSION["SU_Code"];
// ------------------------------------20/01/2020 แก้ไขผลรวมของงานค้างและ include file แทน by POP----------------------------------
include("countstatus.php");
// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 3 AND MRA_WorkUnitID = '$wg_id'";
// $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

// while ($row = sqlsrv_fetch_array($result))
// {
// 	$count_status = $row['num'];
// }
// -----------------------------------------------------------------------------------------------------------------------------------

$th=mktime(gmdate("H")+7,gmdate("i"),gmdate("m"),gmdate("d"),gmdate("Y"));
$format="H:i";
$timecount = date($format,$th);

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
				<a class="nav-link active" href="user_repair_add.php">แจ้งซ่อม</a>
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


<div class="container col-sm-6">
	<br>
	<h3>สร้างรายการแจ้งซ่อม</h3><br>

	<p><span class="error"><b> * </b><?php echo "จำเป็นต้องกรอกข้อมูล";?></span></p>
	<form action="../backend/action_user_repair_add.php" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="savestate">
		<div class="form-group">
			<div>
				<b>วันที่ / เวลาที่แจ้ง</b><input type="text" class="form-control" name="datetime" value="<?php echo date('d-m-Y')." ". $timecount; ; ?>" disabled/>
			</div>
		</div>

		<div class="form-group">
			<div>
				<b>วันที่ต้องการ / กำหนดการ</b><span class="error"><b> * </b></span><br>
				<input type="text" class="form-control" id="input" name="datetimefinish" placeholder="วันที่เสร็จ" required>
			</div>
		</div>


		<div class="form-group">
			<b>รหัสเครื่องจักร/ทรัพย์สิน</b><span class="error"><b> * </b>หากไม่มี ให้ใส่ " - "</span>
			<div class="input-group mb-3">
				<input type="text" class="form-control" name="machine_code" id="machine_code" required/>
				<div class="input-group-append">
					<button class="btn" type="button" id="button_qrcode" onclick="scanqr()"><img src="../../img/icon/qr-code.png"></button>
				</div>
			</div>
		</div>


		<div class="form-group">
			<div>
				<b>ชื่อเครื่องจักร/ทรัพย์สิน</b><span class="error"><b> * </b></span>
				<input type="text" class="form-control" name="machine_name" required/>
			</div>
		</div>
		<br>
		<!--<center>-->
		<div class="form-group">
			<div>
				<b>ประเภทงาน</b><span class="error"><b> * </b></span><br>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" id="defaultInline1" name="work_type" value="แจ้งซ่อม" required>
					<label class="custom-control-label" for="defaultInline1">แจ้งซ่อม</label>
				</div>

				<!-- Default inline 2-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" id="defaultInline2" name="work_type" value="งานปรับปรุง" required>
					<label class="custom-control-label" for="defaultInline2">งานปรับปรุง</label>
				</div>

				<!-- ----------------------------------เพิ่ม เมนูสร้างใหม่ by pop(1.0)------------------------------------------------------ -->
				<!-- Default inline 3-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" id="defaultInline3" name="work_type" value="อื่นๆ" required>
					<label class="custom-control-label" for="defaultInline3">งานสร้าง</label>
				</div>
				<!-- ------------------------------------------------------------------------------------------------------------------ -->
				
				<!-- Default inline 4-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" id="defaultInline4" name="work_type" value="อื่นๆ" required>
					<label class="custom-control-label" for="defaultInline4">อื่นๆ</label>
				</div>
			</div>
		</div>
		<br>

		<div class="form-group">
			<div>
				<b>ความสำคัญของงาน</b><span class="error"><b> * </b></span><br>
				<div class="stars">
					<input class="star star-5" id="star-5" type="radio" name="priority" value="5" required/>
					<label class="star star-5" for="star-5"></label>
					<input class="star star-4" id="star-4" type="radio" name="priority" value="4" required/>
					<label class="star star-4" for="star-4"></label>
					<input class="star star-3" id="star-3" type="radio" name="priority" value="3" required/>
					<label class="star star-3" for="star-3"></label>
					<input class="star star-2" id="star-2" type="radio" name="priority" value="2" required/>
					<label class="star star-2" for="star-2"></label>
					<input class="star star-1" id="star-1" type="radio" name="priority" value="1" required/>
					<label class="star star-1" for="star-1"></label>
				</div>
				<br>
			</div>
		</div>
		<!--		</center>-->

		<div class="form-group">
			<div>
				<b>รายละเอียดการชำรุด / งานปรับปรุง</b><span class="error"><b> * </b></span><br>
				<textarea class="form-control" name="description" rows="4" cols="50" required></textarea>
			</div>
		</div>


		<div class="form-group">
			<div>
				<b>ผลกระทบ</b><span class="error"><b> * </b></span><br>
				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" id="customCheck1" name="effect[]" value="คุณภาพ">
					<label class="custom-control-label" for="customCheck1">คุณภาพ</label>
				</div>

				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" id="customCheck2" name="effect[]" value="Yield">
					<label class="custom-control-label" for="customCheck2">Yield</label>
				</div>

				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" id="customCheck3" name="effect[]" value="Capacity">
					<label class="custom-control-label" for="customCheck3">Capacity</label>
				</div>

				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" id="customCheck4" name="effect[]" value="ต้นทุนการผลิด">
					<label class="custom-control-label" for="customCheck4">ต้นทุนการผลิด</label>
				</div>

				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" class="custom-control-input" id="customCheck5" name="effect[]" value="อื่นๆ">
					<label class="custom-control-label" for="customCheck5">อื่นๆ</label>
				</div>

			</div>
		</div>

		<div class="form-group">
			<div>
				<b>ผู้แจ้ง</b><br>
				<input type="text" class="form-control" name="informer" value="<?php echo $_SESSION["FirstName"]; ?>" disabled/>
			</div>
		</div>

		<div class="form-group">
			<div class="">
				<div id="wrapper">
					<b>ถ่ายภาพ : </b><span class="error"><b> * </b></span>
						<!-- <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/><br> -->
						<input name="upload_file[]" id="files" type="file" aria-label="files" onchange="preview_image();" multiple/>
					<div id="image_preview"></div>
				</div>
			</div>
		</div>

		<div class="text-right"><input type="submit" class="btn btn-light-blue" name="submit" value="แจ้งซ่อม"/></div>

	</form>
</div>
	
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="https://kendo.cdn.telerik.com/2020.1.114/js/jquery.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2020.1.114/js/kendo.all.min.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../../datetimepicker/js/gijgo.min.js"></script>

	<!-- ---------------------ปิด script เพราะซ้ำซ้อน by POP------------------------------------------------- -->
	<!-- <script src="http://code.jquery.com/jquery-1.8.0.min.js"></script> -->
	<!-- <script src="http://cdn.kendostatic.com/2012.2.710/js/kendo.all.min.js"></script> -->
	<!-- ------------------------------------------------------------------------------------------------------------- -->


	<!-- save state -->
	<script type="text/javascript" src="../../js/savestate.js"></script>

	<!-- qr code scanner -->
	<script type="text/javascript" src="../../js/instascan.min.js"></script>
	<script type="text/javascript">
		function scanqr(){
			app.scanqr();
			return false;
		}
	</script>
<!-- ---------------------ยุบ script เนื่องจากแก้ไข พารามิเตอร์ที่ใช้ by POP------------------------------------------------- -->
<!--upload photo-->
<!-- <script>
	var maxFiles = 4;
	$('#upload_file').kendoUpload({
		multiple: true,
		select: function (e)
		{
			if ($('#upload_file').parent().children('input[type=file]:not(#upload_file)').length >= maxFiles)
			{
				e.preventDefault();
				alert("สามารถอัพโหลดได้สูงสุด : " + maxFiles + " ภาพ");
			}
		}
	});

	$('#upload_file').data('kendoUpload').bind('drop', function (e)
	{
		alert("...");
	});
</script> -->
<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<script>
    $(document).ready(function() {
        $("#files").kendoUpload();
    });
</script>

<!-- save state -->
<script type="text/javascript">
	//*** restore after refresh
	$(document).ready(function() {
		$("#savestate").restoreForm();
	});

	//*** save form
	$("#savestate").on("change click", function(e) {
		$("#savestate").saveForm();
	});

	//*** clear form
	$(document).on("submit", function() {
		$("#savestate").clearForm();
	});
</script>

<script>
	$('#input').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});
</script>
</body>
</html>