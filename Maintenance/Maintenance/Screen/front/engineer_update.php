<?php session_start();
if($_SESSION['Status_ID'] == ""){
	header( 'refresh: 0; url=index.php' );
	exit(0);
}
$authEPID = ['25', '26',];
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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<title>หน้าบันทึกการทำงานของช่างซ่อม</title>
	<link rel="icon" href="../../img/maintenance_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css"/>
	<script src="../../assets/jquery/jquery-3.3.1.js"></script>
	<script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css">

	<!--limit file upload-->
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.common.min.css" rel="stylesheet" type="text/css" />
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.default.min.css" rel="stylesheet" type="text/css" />
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.dataviz.min.css" rel="stylesheet" type="text/css" />
	<link href="http://cdn.kendostatic.com/2012.2.710/styles/kendo.mobile.all.min.css" rel="stylesheet" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
	<script src="http://cdn.kendostatic.com/2012.2.710/js/kendo.all.min.js"></script>

	<!-- save state -->
	<script type="text/javascript" src="../../js/savestate.js"></script>

	<!--date time picker-->
	<script src="../../datetimepicker/js/gijgo.min.js"></script>
	<link rel="stylesheet" href="../../datetimepicker/css/gijgo.min.css">

	<style>
		.error {color: #FF0000;}
	</style>

</head>
<body>

<?php
require_once("../backend/config.php");
$code = $_SESSION["SU_Code"];
$count_status = 0;

$query = "SELECT COUNT(*) as 'num' FROM MaintenanceJoblist WHERE MJ_Status = '2' AND MJ_EngineerCode = '$code'";
$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

while ($row = sqlsrv_fetch_array($result))
{
	$count_status = $row['num'];
}

if(isset($_GET["id"]))
{
	$id = (int)$_GET["id"];
}
$sql = "SELECT MRA_Datetime, MRA_WorkUnitName FROM MaintenanceRepairAdd WHERE MRA_ID = '$id' ";
$result1 = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));
$row1 = sqlsrv_fetch_array($result1);
$date = $row1['MRA_Datetime'];
$workunit = $row1['MRA_WorkUnitName'];
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
				<a class="nav-link" href="engineer_index.php">หน้าแรก <span class="badge badge-danger"><?php echo $count_status ?></span></a>
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
<!-- ---------------------------------------------------------------------------------------------------------------------------------------- -->

<div class="container col-sm-6">
	<br><h3>บันทึกการซ่อม</h3><br>

	<p><span class="error"><b> * </b><?php echo "จำเป็นต้องกรอกข้อมูล";?></span></p>
		<form action="../backend/action_engineer_update.php" method="post" enctype="multipart/form-data" accept-charset="utf-8" id="savestate">
				<div class="form-group">
					<div>
						<b>ผู้ปฏิบัติงาน</b>
						<input type="text" class="form-control" id="engineer_id" name="engineer_id" value="<?php echo $_SESSION["SU_Code"]; ?>" disabled>
					</div>
				</div>

				<div class="form-group">
					<div>
						<b>วันที่แจ้ง</b>
						<input type="text" class="form-control" value="<?php echo $date; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<div>
						<b>วันที่เริ่ม</b>
						<input type="text" class="form-control" id="datestart" name="datestart" value="<?php echo date('d-m-Y H:i'); ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<div>
						<b>วันที่เสร็จ</b><span class="error"><b> * </b></span>
						<input type="text" class="form-control" id="input" name="datefinish" placeholder="วันที่เสร็จ" required>
					</div>
				</div>
				<div class="form-group">
					<div>
						<b>สาเหตุ</b><span class="error"><b> * </b></span>
						<textarea class="form-control" id="cause" name="cause" placeholder="รายละเอียด" required></textarea>
					</div>
				</div>
				<div class="form-group">
					<div>
						<b>วิธีการซ่อม / ปรับปรุง</b><span class="error"><b> * </b></span>
						<textarea class="form-control" id="method" name="method" placeholder="รายละเอียด" required></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="form-group row">
						<div class="col">
							<b>รายการอุปกรณ์ที่เปลี่ยน</b><span class="error"><b> * </b></span>
						</div>
					</div>
				</div>

				<div id="tool_fields">
					<!-- multiple field -->
				</div>
				<div class="form-group row">
					<div class="col">
						<input type="text" class="form-control" id="tool" name="tool[]" value="" placeholder="อุปกรณ์">
					</div>
					<div class="form-group">
						<div class="input-group col">
								<input type="text" style="width: 100px;" class="form-control" id="num" name="num[]" value="" placeholder="จำนวน">
							<div class="input-group-append">
								<button class="btn btn-success" type="button" onclick="tool_fields();">เพิ่ม</button>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="count" name="count">

				<div class="form-group">
					<div class="">
						<div id="wrapper">
							<b>ก่อนทำ : </b><span class="error"><b> * </b></span>
								<input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/><br>
							<div id="image_preview"></div>
						</div>
					</div>
				</div><br>

				<div class="form-group">
					<div class="">
						<div id="wrapper">
							<b>หลังทำ : </b><span class="error"><b> * </b></span>
								<input type="file" id="upload_file2" name="upload_file2[]" onchange="preview_image();" multiple/><br>
							<div id="image_preview"></div>
						</div>
					</div>
				</div><br>

			<input type="hidden" name="mra_id" value="<?php echo $id; ?>">
			<input type="hidden" name="workunit" value="<?php echo $workunit; ?>">

			<div class="text-right">
				<input type="submit" class="btn btn-light-blue" name="submit" value="บันทึก">
			</div>
		</form>
	</div>
	<br>

</body>

<!-- picture upload -->
<script>

	var maxFiles = 4;
	$('#upload_file').kendoUpload({
		multiple: true,
		select: function (e)
		{
			if ($('#upload_file').parent().children('input[type=file]:not(#upload_file)').length >= maxFiles)
			{
				e.preventDefault();
				alert("สามารถอัพโหลดได้สูงสุด : " + maxFiles +" ภาพ");
			}
		}
	});

	$('#upload_file').data('kendoUpload').bind('drop', function (e)
	{
		alert("...");
	});

	var maxFiles = 4;
	$('#upload_file2').kendoUpload({
		multiple: true,
		select: function (e)
		{
			if ($('#upload_file2').parent().children('input[type=file]:not(#upload_file2)').length >= maxFiles)
			{
				e.preventDefault();
				alert("สามารถอัพโหลดได้สูงสุด : " + maxFiles +" ภาพ");
			}
		}
	});

	$('#upload_file2').data('kendoUpload').bind('drop', function (e)
	{
		alert("...");
	});
</script>
<script>jsbinShowEdit && jsbinShowEdit({"static":"http://static.jsbin.com","root":"http://jsbin.com"});</script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-1656750-34', 'auto');
	ga('require', 'linkid', 'linkid.js');
	ga('require', 'displayfeatures');
	ga('send', 'pageview');

</script>
<!-- end picture upload-->

<script>
	$('#input').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});
</script>

<!-- dynamic form -->
<script>
	var room = 0; //count as array
	function tool_fields() {

		room++;
		$('#count').val(room);
		var objTo = document.getElementById('tool_fields')
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "form-group removeclass"+room);
		var rdiv = 'removeclass'+room;
		divtest.innerHTML = '<div class="form-group row"><div class="col"><input type="text" class="form-control" id="tool" name="tool[]" placeholder="อุปกรณ์"></div><div class="form-group"><div class="input-group col"> <input type="text" style="width: 100px;" class="form-control" id="num" name="num[]" placeholder="จำนวน"> <div class="input-group-append"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');">ลบ</button></div></div></div></div></div><div class="clear"></div>';

		objTo.appendChild(divtest)

	}
	function remove_education_fields(rid) {
		$('.removeclass'+rid).remove();
		room--;
		$('#count').val(room);
	}
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

</html>