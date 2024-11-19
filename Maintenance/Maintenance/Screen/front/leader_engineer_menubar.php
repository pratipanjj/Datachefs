<!DOCTYPE html>
<html>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="#">MRG Maintenance</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php
                if($_SESSION["EP_ID"] == 18 || $_SESSION["EP_ID"] == 21 || $_SESSION["EP_ID"] == 22 || $_SESSION["EP_ID"] == 23 || $_SESSION["EP_ID"] == 24 || $_SESSION["EP_ID"] == 300){
					echo "
					<li class='nav-item'>
					<a class='nav-link' href='leader_index.php'>ติดตามงาน 
					<span class='badge badge-danger'>". $count_status."</span></a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='leader_repair_list.php'>รายการแจ้งซ่อม</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='engineer_index.php'>หน้าของช่าง 
						<span class='badge badge-danger'>". $count_engineer_work ."</span></a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='user_repair_add.php'>แจ้งซ่อม</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='#'>เบิกของจากสโตร์</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='#'>สร้างใบขอซื้อ</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='leader_summary.php'>สรุปรายการซ่อม</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='leader_summary_detail.php'>สรุปงานช่าง</a>
					</li>";
                }else if($_SESSION["EP_ID"] == 25 || $_SESSION["EP_ID"] == 26){
					echo "
					<li class='nav-item'>
						<a class='nav-link' href='engineer_index.php'>หน้าของช่าง 
						<span class='badge badge-danger'>". $count_engineer_work. "</span></a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='user_repair_add.php'>แจ้งซ่อม</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='#'>เบิกของจากสโตร์</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='#'>สร้างใบขอซื้อ</a>
					</li>";
				}else{
					echo "
					<li class='nav-item'>
						<a class='nav-link active' href='user_index.php'>หน้าแรก
						<span class='badge badge-danger'>".$count_status."</span></a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' href='user_repair_add.php'>แจ้งซ่อม</a>
					</li>";
				}
            ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="nav-item">
				<a class="nav-link" href=""><strong>ผู้ใช้ : <?php echo $_SESSION["FirstName"];?></strong></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="../backend/logout.php">ออกจากระบบ</a>
			</li>
		</ul>
	</div>
</nav>
</body>
</html>