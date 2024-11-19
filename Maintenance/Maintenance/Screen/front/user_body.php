<?php
    echo '
				<div class="tr headings">
					<div class="th machine_name">รายการแจ้งซ่อม</div>
					<div class="th datetime">วัน/เวลาที่แจ้ง</div>
					<div class="th datetimefinish">วัน/เวลาที่เสร็จ</div>
					<div class="th description">รายละเอียด</div>
					<div class="th engineer">ช่างที่รับงาน</div>
					<div class="th status">สถานะ</div>
					<div class="th manage">จัดการ</div>
				</div>';
			// เงื่อนไขสำหรับ search text
			if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
				//$work_unit_name = $_SESSION["WG_WorkUnitName"];
				$wg_id = $_SESSION["WG_ID"];
				$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_WorkUnitID = '$wg_id' AND MRA_MachineName LIKE N'%" . $_GET['keyword'] . "%' ";
				$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
				$row = sqlsrv_fetch_array($result);
				$total = $row['num'];
				 
				$classMySec = new classMySec();
				$keyword = $classMySec->encode($_GET['keyword']);
				$sql .= " AND MRA_MachineName LIKE N'%" . $keyword . "%'";

			}	else	{

				//$work_unit_name = $_SESSION["WG_WorkUnitName"];
				$wg_id = $_SESSION["WG_ID"];
				$query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_WorkUnitID = '$wg_id'";
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
						echo '<div class="td machine_name accordion-xs-toggle" id="job_finish">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
					}
					// เกินกำหนด [สีแดง]
					elseif((date('d-m-Y H:i') > $date["MJ_DatetimeFinish"]) && ($date["MJ_DatetimeFinish"] != null))
					{
						echo '<div class="td machine_name accordion-xs-toggle" id="datetime_late">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
					}
					// ดำเนินการ [สีส้ม]
					elseif((date('d-m-Y H:i') < $date["MJ_DatetimeFinish"]) && ($date["MJ_DatetimeFinish"] != null))
					{
						echo '<div class="td machine_name accordion-xs-toggle" id="job_progress">' . $classMySec->encode($row["MRA_MachineName"]) . '</div>';
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


					// -------จัดการ---------
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