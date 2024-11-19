
<div class="container col-sm-12"><br>
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
		if($level < 13) {  
	?>
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
                            <a href="../../PHPExcel/export-excel-user.php<?php echo $url;?>" class="btn btn-outline-success" target="_blank">ส่งออกไฟล์xlsx</a>
                        </div>
                    </div>
                </div>
	        </form>
        </div>
		<div class="col-md-3 text-center" style="margin:auto;"></div>
	</div><br>	
	<?php 
	} 
	if ($level >= 13) { 
		if(isset($_GET["workgroup"])){
			$workgroupdropdown = $_GET["workgroup"];
			$workgroupdropdownSQL = "SELECT WG_EnglishName FROM WorkGroup WHERE WG_ID = '$workgroupdropdown'";
			$workgroupdropdownQuery = sqlsrv_query($conn, $workgroupdropdownSQL);
			$rowworkgroup = sqlsrv_fetch_array($workgroupdropdownQuery);
			$_SESSION["WG_NAME"] = $rowworkgroup[0];
		}
		if (isset($_GET["Workgroup"])){
			unset($_SESSION["WG"]);
			unset($_SESSION["WG_NAME"]);
		}
	?>
	<div class="row">
	    <div class="col-md-3 text-center" style="margin:auto;"></div>
	    <div class="col-md-6 text-center" style="margin:auto;">
		    <form name="frmSearch" method="get" action="" class="form-inline">
 				<div class="form-group">	
 					<label for="" style="padding-top:5px;">เลือกหน่วยงาน</label> 
 					<select name="workgroup" id="" class="form-control" style="  margin-right:10px; margin-left: 5px;">
 						<option value=""><?php echo (isset($_SESSION["WG_NAME"])) ?  $_SESSION["WG_NAME"] : 'เลือกหน่วยงาน'; ?></option>
						<?php
							// --------03022020 เปลี่ยนจาก $_SESSION['D_IDDepartment'] เป็น $_SESSION['S_ID'] By pop---------------
							$department = $_SESSION['S_ID'];
							// -----------03022020 เปลี่ยนคำสั่ง Query By pop---------------
							// $workgroupSQL = "SELECT WG_ID ,WG_Code,WG_LocalName,WG_EnglishName,D_ID,WG_IsActive,WG_WorkUnitName FROM WorkGroup WHERE D_ID = '$department'";
							$workgroupSQL = "SELECT WorkGroup.WG_ID , WorkGroup.WG_Code, WorkGroup.WG_LocalName, WorkGroup.WG_EnglishName, WorkGroup.D_ID,WG_IsActive, WorkGroup.WG_WorkUnitName,Section.S_ID,WorkGroup.WG_IsActive
							FROM WorkGroup
							INNER JOIN Department  ON WorkGroup.D_ID = Department.D_ID
							INNER JOIN Section  ON Department.S_ID = Section.S_ID
							WHERE Section.S_ID = '$department' AND WorkGroup.WG_IsActive = '1'
							ORDER BY WG_EnglishName";
								
							$workgroupQuery = sqlsrv_query($conn, $workgroupSQL);
							while($workgroup = sqlsrv_fetch_array($workgroupQuery)) { 
								echo '<option value="'.$workgroup['WG_ID'].'">'.$workgroup['WG_EnglishName'].'</option>';
							} 
						?>
 					</select>
                </div>
				<div class="form-group">
					<label for="">รายการแจ้งซ่อม&nbsp;</label>
 					<input type="text" class="form-control" name="keyword" id="keyword" placeholder="พิมพ์ชื่อรายการแจ้งซ่อม" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : "" ?>" style="margin-right: 5px;">
				</div>
                <div class="form-group">
				    <button type="submit" class="btn btn-light-blue" name="btn_search" id="btn_search"><img src="../../img/icon/search_white_24dp.png" ></button>
				    <?php if(isset($_GET['keyword']) || isset($_SESSION["WG"])) { ?>
							<a href="user_index.php?Workgroup=WG"  class="btn btn-light-blue">ดูทั้งหมด</a>
 				    <?php }?>
				    <a href="../../PHPExcel/export-excel-user.php<?php echo $url;?>" class="btn btn-outline-success" target="_blank">ส่งออกไฟล์xlsx</a>
				</div>		 
		    </form>
		</div>
		<div class="col-md-3 text-center" style="margin:auto;"></div>
	</div><br>	
	<?php } ?>
</div>