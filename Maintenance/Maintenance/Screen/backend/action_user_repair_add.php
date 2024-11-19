<?php
session_start();
require_once("config.php");

function resize_image($file, $width, $height) {
	list($w, $h) = getimagesize($file);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* read binary data from image file */
	$imgString = file_get_contents($file);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
		0, 0,
		$x, 0,
		$width, $height,
		$w, $h);
	imagejpeg($tmp, $file, 85);
	return $file;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}


if (isset($_FILES['upload_file']))
{
	$state = true;
	$image = array();
	$image[0] = null;
	$image[1] = null;
	$image[2] = null;
	$image[3] = null;

	$datetime = date('d-m-Y H:i');
	$machine_code = $_POST["machine_code"];
	$machine_name = $_POST["machine_name"];
	$work_type = $_POST["work_type"];
	$priority = $_POST["priority"];
	$description = $_POST["description"];
	$effect = implode(', ', $_POST['effect']);
	$informer = $_SESSION["FirstName"];
	$wg_workunitname = $_SESSION["WG_WorkUnitName"];
	$wg_id = $_SESSION["WG_ID"];
	$sToken='';

	$errors = array();
	foreach ($_FILES['upload_file']['tmp_name'] as $key => $tmp_name)
	{
		$file_name = $_FILES['upload_file']['name'][$key];
		$file_size = $_FILES['upload_file']['size'][$key];
		$file_tmp = $_FILES['upload_file']['tmp_name'][$key];
		$file_type = $_FILES['upload_file']['type'][$key];

		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$contents = file_get_contents($_FILES['upload_file']['tmp_name'][$key]);
		$mime_type = $finfo->buffer($contents);

		// Check mime_type
		if ($mime_type != 'image/jpeg' && $mime_type != 'image/png' && $mime_type != 'image/bmp')
		{
			$errors[] = 'พบไฟล์ที่ไม่ใช่รูปภาพ';
		}

		if (empty($errors) == true)
		{
			// resize image

			resize_image($file_tmp, 600, 600);

			$new_filename = md5(microtime($file_name));
			$extention = pathinfo($file_name, PATHINFO_EXTENSION);
			$newName = $new_filename . "." . $extention;

			if (move_uploaded_file($file_tmp, "../../image_upload_user/" . $newName))
			{
				$image[$key] = $newName;
			}
		}
		else
		{
			$state = false;
		}
	}

	if ($state == true)
	{
		// insert all to database
		$sql = 'INSERT INTO MaintenanceRepairAdd (MRA_Datetime, MRA_MachineCode, MRA_MachineName, MRA_WorkType, MRA_Priority, MRA_Description, MRA_Effect, MRA_Informer, MRA_WorkUnitName, MRA_Image0, MRA_Image1, MRA_Image2, MRA_Image3, MRA_Status, MRA_WorkUnitID)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
		$params = array($datetime, $machine_code, $machine_name, $work_type, $priority, $description, $effect, $informer, $wg_workunitname, $image[0], $image[1], $image[2], $image[3], "1", $wg_id);
		$stmt = sqlsrv_query($conn, $sql, $params);
		$messages = "\n" . 
					"ชื่อเครื่องจักร/ทรัพย์สิน : " . $machine_name . "\n" .
					"ประเภทงาน : " . $work_type . "\n" .
					"รายละเอียดการชำรุด / งานปรับปรุง : " . $description . "\n" .
					"ผู้แจ้ง : " . $informer . " ( " .$wg_workunitname. " )" ;
		
		
		
		
		
		if ($stmt === false)
		{
			die(print_r(sqlsrv_errors(), true));
		}
		else
		{
			echo "<script language=\"JavaScript\">";
			echo "alert('แจ้งซ่อมสำเร็จ');";
			echo "</script>";
			
			// -----------------------เพิ่ม notification line และปิด header by POP(1.0)------------------------------------------------
			$zone4 = ['11', '12','13'];
			if (in_array($wg_id, $zone4)) {
				$sToken = "Cj8duclSnoXZ68ogt6QPm5xUxKnaxg8dfLFn0BuuQVN";
			}
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			date_default_timezone_set("Asia/Bangkok");
			// $sToken = "Cj8duclSnoXZ68ogt6QPm5xUxKnaxg8dfLFn0BuuQVN";
			$sMessage = $messages;

			
			$chOne = curl_init(); 
			curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
			curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
			curl_setopt( $chOne, CURLOPT_POST, 1); 
			curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
			$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
			curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
			curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
			$result = curl_exec( $chOne ); 

			//Result error 
			if(curl_error($chOne)) 
			{ 
				echo 'error:' . curl_error($chOne); 
			} 
			else { 
				header("refresh:1; url=../front/user_index.php");
			} 
			curl_close( $chOne );   
			// header("refresh:1; url=../front/user_index.php");
			// -----------------------------------------------------------------------------------------------

		}
	}
	else
	{
		foreach ($errors as $value)
		{
			echo "<script language=\"JavaScript\">";
			echo "alert('$value');";
			echo "</script>";
			header("refresh:1; url=../front/user_repair_add.php");
		}
	}


}
else
{
	echo "<script language=\"JavaScript\">";
	echo "alert('กรุณาเลือกรูปภาพอย่างน้อย 1 ภาพ');";
	echo "</script>";
	header("refresh:1; url=../front/user_repair_add.php");
}

sqlsrv_close($conn);

?>