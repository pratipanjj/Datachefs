<?php 
if (!session_id()) session_start();
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
		header('Location: index.php');
	}
}
require_once("../backend/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>หน้าสรุปรายการซ่อม</title>
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

</head>

<body>

<?php
// ---------------------------------------------20/01/63 เพิ่ม $code = $_SESSION["SU_Code"] by POP--------------------------------------
$code = $_SESSION["SU_Code"];
// ------------------------------------20/01/2020 แก้ไขผลรวมของงานค้างโดยยกเลิกการนับงานที่สำเร็จออกไป by POP----------------------------------
include("countstatus.php");
// $count_status = 0;
// $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd";
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
				<a class="nav-link active" href="leader_summary_detail.php">สรุปงานช่าง</a>
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

<div class="container col-sm-8">
	<br>
		<h3>สรุปงานซ่อมของช่างรายคน</h3><br>
</div>

<div class="container col-sm-8">

	<form name="form1" method="get" action="">
		<div class="form-group row">
			<label for="keyword" class="col-sm-1 col-form-label">
				<h5>ค้นหา</h5>
			</label>
			<div class="form-group">
				<div class="col-sm">
					<input type="text" class="form-control" name="keyword" id="keyword" placeholder="พิมพ์รหัสพนักงาน" value="<?php (isset($_GET['keyword']))?$_GET['keyword']:""?>">
				</div>
			</div>

			&nbsp; <label for="keyword" class="col-form-label"><h5> จาก </h5></label> &nbsp;

			<div class="form-group">
				<div class="col-sm">
				<input type="text" class="form-control" id="input" name="date" placeholder="<?php echo 'วัน-เดือน-ปี'; ?>" value="<?php (isset($_GET['date']))?$_GET['date']:""?>">
				</div>
			</div>


			&nbsp; <label for="keyword" class="col-form-label"><h5> ถึง </h5></label> &nbsp;
			<div class="form-group">
				<div class="col-sm">
				<input type="text" class="form-control" id="input2" name="date2" placeholder="<?php echo 'วัน-เดือน-ปี'; ?>" value="<?php (isset($_GET['date2']))?$_GET['date2']:""?>">
				</div>
			</div>

			<div class="col-sm">
				<input type="submit" class="btn btn-light-blue active" name="btn_search" id="btn_search" value="ค้นหา">
			 
				<a href="leader_summary_detail.php" class="btn btn-light-blue">ล้างค่า</a>
			

			<?php 
				// ต่อคำสั่ง sql
				$url = '';

				if(isset($_GET['keyword']) && $_GET['keyword'] != "") {
					$keyword = str_replace("'", '' ,$_GET['keyword']);
					$url = '?keyword='.$keyword;
 				}
 
				if(isset($_GET['date']) && $_GET['date2'] != "") {
					$date = $_GET['date'];
					$date2 = $_GET['date2'];

					if(isset($_GET['keyword']) && $_GET['keyword'] != "") {
						$merge = '&';
					} else {
						$merge = '?';
					}

					 $url .= $merge.'date='.$date.'&date2='.$date2;
				}
				?>

				<a href="../../PHPExcel/export-summary-detail.php<?php echo $url;?>" class="btn btn-outline-success" target="_blank">ส่งออกไฟล์ .xlsx</a>
				</div>
		</div>
	</form>

<?php
//				// query ตามเงื่อนไข
//				// สรุปเป็นจำนวนครั้ง
				$sql0 = "SELECT MJ_EngineerCode AS 'EN_Code' FROM MaintenanceJoblist ";
 
 
				if(isset($_GET['keyword']) && $_GET['keyword'] != "") {
						$keyword =  str_replace("'", "", $_GET['keyword'] );	
					$sql0 .="WHERE MJ_EngineerCode LIKE N'%{$keyword}%' 
							  UNION SELECT MJ_EngineerCode2 FROM MaintenanceJoblist WHERE MJ_EngineerCode2 LIKE N'%{$keyword}%'";
				} else { 
					$sql0 .= "UNION SELECT MJ_EngineerCode2 FROM MaintenanceJoblist";
				}

 
				if(isset($_GET['date']) && $_GET['date2'] != "") {
					$date  = $_GET['date'].':00';
					$date2 = $_GET['date2'].':00';
				}
 

	 
 
?>

	<div class="table-responsive">
		<table class="table table-striped table-sm text-center">
			<thead>
			<tr>
				<th>รหัสพนักงาน</th>
				<th>ชื่อพนักงาน</th>
				<th>จำนวนงานทั้งหมด</th>
				<th>จำนวนงานที่เสร็จ</th>
			</tr>
			</thead>
			<tbody>

				<!-- php -->
				<?php
				 #echo $sql0;


				$result0 = sqlsrv_query($conn, $sql0) or die(print_r(sqlsrv_errors(), true));

				while($row0 = sqlsrv_fetch_array($result0)) 	{
					echo "<tr>";

					if (isset($row0['EN_Code']) != "") 	{

						echo "<td>" . $row0['EN_Code'] . "</td>";
						$code = $row0['EN_Code'];

						$sql1 = "SELECT E_LocalFirstName, E_LocalLastName FROM Employee WHERE E_Code LIKE N'%{$code}%' ";
						$result1 = sqlsrv_query($conn, $sql1) or die(print_r(sqlsrv_errors(), true));
						$name = sqlsrv_fetch_array($result1);
						echo "<td>". $name["E_LocalFirstName"] . " &nbsp;&nbsp;" . $name["E_LocalLastName"] . "</td>";


						$sql = "SELECT COUNT(MRA_WorkUnitName) AS total FROM MaintenanceJoblist WHERE (MJ_EngineerCode LIKE N'%{$code}%' OR MJ_EngineerCode2 LIKE N'%{$code}%') ";
						if(isset($_GET['date']) && $_GET['date2'] != "") {
							$sql .= " AND MJ_DatetimeFinish BETWEEN '$date' AND '$date2' ";
						}
  

						$result = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));
						$row = sqlsrv_fetch_array($result);
						echo "<td>". $row['total'] . "</td>";
						

						$sql2 = "SELECT COUNT(MRA_WorkUnitName) AS total FROM MaintenanceJoblist WHERE (MJ_EngineerCode LIKE N'%{$code}%' OR MJ_EngineerCode2 LIKE N'%{$code}%') AND MJ_Status = 5 ";
						if(isset($_GET['date']) && $_GET['date2'] != "") {
							$sql2 .= " AND MJ_DatetimeFinish BETWEEN '$date' AND '$date2' ";
						}

						$result2 = sqlsrv_query($conn, $sql2) or die(print_r(sqlsrv_errors(), true));
						$row2 = sqlsrv_fetch_array($result2);
						echo "<td>". $row2['total'] . "</td>";
						
					}

					echo "</tr>";

				}

				sqlsrv_close($conn);
			?>

			</tbody>
		</table>

	</div>

</div>

<script>
	$('#input').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});


	$('#input2').datetimepicker({
		uiLibrary: 'bootstrap4',
		format: 'dd-mm-yyyy HH:MM',
		modal: true,
		footer: true
	});
</script>
</body>
</html>