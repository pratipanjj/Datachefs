<?php
session_start();
require_once("config.php");


if(isset($_POST["submit"])){
	$username = $_POST["username"];
	$password = $_POST["password"];

	$query = " SELECT SystemUser.SU_Code, Employee.EP_ID, Employee.E_LocalFirstName, Employee.E_LocalLastName, WorkGroup.WG_WorkUnitName, WorkGroup.WG_ID , Section.S_ID , 
	Employee.[E_Level] , Employee.[D_IDDepartment]
	FROM SystemUser    
	INNER JOIN Employee ON Employee.E_Code = SystemUser.SU_Code
	INNER JOIN WorkGroup ON Employee.WG_ID = WorkGroup.WG_ID
	INNER JOIN Section ON Employee.S_ID    = Section.S_ID  
	WHERE SU_Username = ? AND SU_Password = ? ";

	$params = array("$username","$password");
	$result = sqlsrv_query($conn, $query, $params) or die(print_r(sqlsrv_errors(), true));
	

	if(sqlsrv_has_rows($result) != 1) {
		//	echo "User Not Found !";
		echo "<script language=\"JavaScript\">";
		echo "alert('ไม่พบผู้ใช้ หรือกรอกรหัสผ่านผิด');";
		echo "</script>";
		header( "refresh:1; url=../front/index.php" );

	} else {
		while($row = sqlsrv_fetch_array($result)) {
			// ---------------------เพิ่ม Status_ID เพื่อเช็คสถานะการเข้าถึงในแต่ละหน้า by pop------------------------
			$_SESSION['Status_ID'] 			= session_id();
			// -----------------------------------------------------------------------------------------------
			$_SESSION["EP_ID"]           	= $row["EP_ID"];
			$_SESSION["SU_Code"]         	= $row["SU_Code"]; // รหัสพนักงาน
			$_SESSION["FirstName"]       	= $row["E_LocalFirstName"]; //ชื่อจริง
			$_SESSION["WG_WorkUnitName"] 	= $row["WG_WorkUnitName"]; // หน่วยงาน
			$_SESSION["WG_ID"]           	= $row["WG_ID"]; // รหัสหน่วยงาน
			$_SESSION['S_ID']            	= $row["S_ID"]; // รหัสสังกัดงาน
			$_SESSION['E_Level']			= $row['E_Level'];
			$_SESSION['D_IDDepartment'] 	= $row['D_IDDepartment'];
			
			setcookie("S_ID",$row['S_ID'],$expire, "/"); // Expire 1 Hour

		}

		if(isset($_POST["remember"])) {
 
			$_SESSION['startTime'] = time();
			$_SESSION['limitTime'] = 60*60*24*365; // จำผู้ใช้ในระบบ 1 year

		}



		/*
		Postition : 
		18	EN1		Engineering Director	Engineering Director		
		21	EN4		Engineer Lv.5			Engineer Lv.5	
		22	EN5		Engineer Lv.4			Engineer Lv.4		
		23	EN6		Engineer Lv.3			Engineer Lv.3
		300 ENx     Engineer Lv.3 (Acting)		
		24	EN7		Systems Coordinator	Systems Coordinator		
		25	EN9		Engineer Lv.2			Engineer Lv.2		
		26	EN10	Engineer Lv.1			Engineer Lv.1		
		*/


		if($_SESSION["EP_ID"] == 18 ) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 21) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 22) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 23) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 300) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 24) {
			header('Location: ../front/leader_index.php' );
		} elseif ($_SESSION["EP_ID"] == 25) {
			header('Location: ../front/engineer_index.php' );
		} elseif ($_SESSION["EP_ID"] == 26) {
			header('Location: ../front/engineer_index.php' );
		} else {
			header('Location: ../front/user_index.php' );
		}

	}
}

sqlsrv_close($conn);

?>