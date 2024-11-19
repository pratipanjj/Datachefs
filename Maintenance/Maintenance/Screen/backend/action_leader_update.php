<?php
//MaintenanceEngineerUpdate
//MaintenanceEngineerImage
//MaintenanceChangeItem

// form fields : engineer_id , datestart, datefinish , cause , method , tool[] , num[] , upload_file[] , upload_file2[]

session_start();
require_once("config.php");

function resize_image($file, $width, $height)
{
	list($w, $h) = getimagesize($file);
	/* calculate new image size with ratio */
	$ratio = max($width / $w, $height / $h);
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

if (isset($_FILES['upload_file']) && isset($_FILES["upload_file2"]))
{

	$state = true;
	$image_before = array();
	$image_before[0] = null;
	$image_before[1] = null;
	$image_before[2] = null;
	$image_before[3] = null;

	$image_after = array();
	$image_after[0] = null;
	$image_after[1] = null;
	$image_after[2] = null;
	$image_after[3] = null;

	$mra_id = $_POST["mra_id"];
	$engineer_id = $_SESSION["SU_Code"];;
	$datestart = date('d-m-Y H:i');
	$datefinish = $_POST["datefinish"];
	$cause = $_POST["cause"];
	$method = $_POST["method"];
	$workunit = $_POST["workunit"];

	$tool_count = $_POST["count"];

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
			if (move_uploaded_file($file_tmp, "../../image_upload_engineer_before/" . $newName))
			{
				$image_before[$key] = $newName;
			}
		}
		else
		{
			$state = false;
		}
	}


	foreach ($_FILES['upload_file2']['tmp_name'] as $key => $tmp_name)
	{
		$file_name = $_FILES['upload_file2']['name'][$key];
		$file_size = $_FILES['upload_file2']['size'][$key];
		$file_tmp = $_FILES['upload_file2']['tmp_name'][$key];
		$file_type = $_FILES['upload_file2']['type'][$key];

		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$contents = file_get_contents($_FILES['upload_file2']['tmp_name'][$key]);
		$mime_type = $finfo->buffer($contents);

		// Check mime_type
		if ($mime_type != 'image/jpeg' && $mime_type != 'image/png' && $mime_type != 'image/bmp')
		{
			$errors[] = 'พบไฟล์ที่ไม่ใช่รูปภาพ';
		}

		if (empty($errors) == true)
		{
			resize_image($file_tmp, 600, 600);

			$new_filename = md5(microtime($file_name));
			$extention = pathinfo($file_name, PATHINFO_EXTENSION);
			$newName = $new_filename . "." . $extention;
			if (move_uploaded_file($file_tmp, "../../image_upload_engineer_after/" . $newName))
			{
				$image_after[$key] = $newName;
			}
		}
		else
		{
			$state = false;
		}
	}


// MaintenanceEngineerUpdate : MEU_ID , MRA_ID , MEU_EngineerCode, MEU_DatetimeStart , MEU_DatetimeFinish , MEU_Cause , MEU_Method , MRA_Status
// MaintenanceChangeItem : MCI_ID , MEU_ID, MCI_Item , MCI_Quantity
// MaintenanceEngineerImage : MEI_ID , MEU_ID , MEI_ImageBefore0 , MEI_ImageBefore1 ,MEI_ImageBefore2 ,MEI_ImageBefore3, MEI_ImageAfter0, MEI_ImageAfter1, MEI_ImageAfter2, MEI_ImageAfter3


	if ($state == true)
	{
		// insert all to database
		$query = "INSERT INTO MaintenanceEngineerUpdate (MRA_ID, MEU_EngineerCode, MEU_DatetimeStart, MEU_DatetimeFinish, MEU_Cause, MEU_Method, MRA_Status, MRA_WorkUnitName) VALUES (?,?,?,?,?,?,?,?); SELECT SCOPE_IDENTITY()";
		$params = array($mra_id, $engineer_id, $datestart, $datefinish, $cause, $method, "3", $workunit);
		$stmt = sqlsrv_query($conn, $query, $params);

		sqlsrv_next_result($stmt);
		sqlsrv_fetch($stmt);
		$lasted_id = sqlsrv_get_field($stmt, 0);

		if ($stmt === false)
		{
			die(print_r(sqlsrv_errors(), true));
		}
		else
		{
			for ($i = 0; $i <= $_POST["count"]; $i++)
			{
				$tool = $_POST["tool"][$i];
				$num = $_POST["num"][$i];

				$sql = 'INSERT INTO MaintenanceChangeItem(MEU_ID, MCI_Item, MCI_Quantity) VALUES (?,?,?)';
				$params = array($lasted_id, $tool, $num);
				$stmt = sqlsrv_query($conn, $sql, $params);
				if ($stmt === false)
				{
					die(print_r(sqlsrv_errors(), true));
				}
			}

			$sql = 'INSERT INTO MaintenanceEngineerImage(MEU_ID, MEI_ImageBefore0, MEI_ImageBefore1, MEI_ImageBefore2, MEI_ImageBefore3, MEI_ImageAfter0, MEI_ImageAfter1, MEI_ImageAfter2, MEI_ImageAfter3) VALUES (?,?,?,?,?,?,?,?,?)';
			$params = array($lasted_id, $image_before[0], $image_before[1], $image_before[2], $image_before[3], $image_after[0], $image_after[1], $image_after[2], $image_after[3]);
			$stmt = sqlsrv_query($conn, $sql, $params);
			if ($stmt === false)
			{
				die(print_r(sqlsrv_errors(), true));
			}

			$sql = "UPDATE MaintenanceRepairAdd SET MRA_Status = ? WHERE MRA_ID  = ?";
			$params = array(3, $mra_id);
			$stmt = sqlsrv_query($conn, $sql, $params);
			if ($stmt === false)
			{
				die(print_r(sqlsrv_errors(), true));
			}

			$sql = "UPDATE MaintenanceJoblist SET MJ_Status = ? WHERE MRA_ID  = ?";
			$params = array(3, $mra_id);
			$stmt = sqlsrv_query($conn, $sql, $params);
			if ($stmt === false)
			{
				die(print_r(sqlsrv_errors(), true));
			}

			echo "<script language=\"JavaScript\">";
			echo "alert('บันทึกสำเร็จ');";
			echo "</script>";
			header("refresh:1; url=../front/engineer_index.php");
		}
	}
	else
	{
		foreach ($errors as $value)
		{
			echo "<script language=\"JavaScript\">";
			echo "alert('$value');";
			echo "</script>";
			header("refresh:1; url=../front/engineer_index.php?id=".$mra_id);
		}
	}


}
else
{
	echo "<script language=\"JavaScript\">";
	echo "alert('กรุณาเลือกรูปภาพก่อนทำ และหลังทำอย่างน้อย 1 ภาพ');";
	echo "</script>";
	header("refresh:1; url=../front/engineer_index.php?id=".$mra_id);
}

sqlsrv_close($conn);

?>