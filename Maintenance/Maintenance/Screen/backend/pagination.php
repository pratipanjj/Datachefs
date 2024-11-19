<?php
function page_navi($total_item, $cur_page, $per_page=10, $query_str, $min_page=3){
	// echo "total_item => ".$total_item."<br>";
	// echo "cur_page => ".$cur_page." เลขหน้าที่อยู่ปัจจุบัน<br>";
	// echo "per_page => ".$per_page." แต่ละหน้ามีจำนวนข้อมูลทั้งหมดเท่าไหร่<br>";
	// echo "query_str => ";print_r($query_str); echo "<br>";
	// echo "min_page => ".$min_page."<br>";

	$total_page = ceil($total_item/$per_page);

	// echo "total_page => ".$total_page." จำนวนหน้าทั้งหมดที่มี<br>";

	$cur_page = (isset($cur_page))?$cur_page:1;

	$diff_page = NULL;
	if($cur_page>$min_page){
		$diff_page = $total_page-$cur_page;
	}
	// echo "diff_page => ".$diff_page." กณีหน้าที่ปัจจุบันเยอะกว่าหน้าที่บังคับให้แสดง<br>";
	
	$limit_page = $min_page;

	// echo "limit_page => ".$limit_page." จำนวนหน้าที่ต้องการให้แสดงในรอบแรก<br>";

	$f_num_page = ($cur_page<=$min_page) ? 1 :(floor($cur_page/$min_page)*$min_page)+1;

	if($diff_page>$min_page){
		$limit_page = ($min_page + $f_num_page)-1;
	}else{
		if(isset($diff_page)){
			$limit_page = $total_page;
		}else{
			$limit_page = $min_page;
		}
	}
	$show_page = ($total_page<=$min_page)?$total_page:$limit_page;
	$l_num_page = 1;
	$prev_page = $cur_page-1;
	$next_page = $cur_page+1;
	$temp_query_str = $query_str;
	$query_str = "";
	if($temp_query_str && is_array($temp_query_str) && count($temp_query_str)>0){
		array_pop($temp_query_str);
		$query_str = http_build_query($temp_query_str);
		if($query_str!=""){
			$query_str = "?".$query_str;
		}
	}
	$mark_char = ($query_str!="")?"&":"?";

	// echo "prev_page => ".$prev_page."<br>";
	// echo "f_num_page => ".$f_num_page."<br>";
	// echo "show_page => ".$show_page."<br>";
	// echo "mark_char => ".$mark_char."<br>";
	// echo "min_page => ".$min_page."<br>";


	echo '<nav>
		<ul class="pagination justify-content-center">
		<li class="page-item">
		<a class="page-link" href="'.$query_str.$mark_char.'page=1"> First</a>
		</li>
		';
	echo '
		<li class="page-item '.(($cur_page==1)?"disabled":"").'">
			<a class="page-link"  href="'.$query_str.$mark_char.'page='.$prev_page.'"> <</a> 
		</li> 
	';  
	for($i = $f_num_page; $i<=$show_page;$i++){
	echo '     
		<li class="page-item '.(($i==$cur_page)?"active":"").'"> 
			<a class="page-link" href="'.$query_str.$mark_char.'page='.$i.'"> '.$i.' </a> 
		</li>     
	';
	}
	echo '
		<li class="page-item '.(($next_page>$total_page)?"disabled":"").'"> 
			<a class="page-link"  href="'.$query_str.$mark_char.'page='.$next_page.'"> ></a> 
		</li>     
	';  
	// echo '
	// 	<li class="page-item">
	// 		<input type="number" class="form-control" min="1" max="'.$total_page.'"
	// 				style="width:80px;" onClick="this.select()" onchange="window.location=\''.$query_str.$mark_char.'page=\'+this.value"  value="'.$cur_page.'" />
	// 	</li> 
	// ';
	// echo $total_page;
	if($total_page == 0){
		$total_page = 1;
	}
	echo '
		<li class="page-item"> 
			<a class="page-link"  href="'.$query_str.$mark_char.'page='.$total_page.'"> Last</a> 
		</li>     
		</ul>
	</nav>        
  ';   


// 	echo '<div class="nav-scroller py-1 mb-2"><nav>
//       <ul class="pagination pagination-sm flex-sm-wrap">
//         <li class="page-item" style="display:inline-block;">
//         <a class="page-link" href="'.$query_str.$mark_char.'page=1"><<</a>
//         </li>
// 		';
// 	echo '
//         <li class="page-item '.(($cur_page==1)?"disabled":"").'" style="display:inline-block;">
//           <a class="page-link"  href="'.$query_str.$mark_char.'page='.$prev_page.'"><</a>
//         </li>
// 	';
// 	for($i = $f_num_page ; $i<=$show_page ; $i++){
// 			echo '
// 			<li class="page-item '.(($i==$cur_page)?"active":"").'" style="display:inline-block;">
// 			  <a class="page-link" href="'.$query_str.$mark_char.'page='.$i.'"> '.$i.' </a>
// 			</li>';
// 	}

// 	echo '
//         <li class="page-item '.(($next_page>$total_page)?"disabled":"").'" style="display:inline-block;">
//             <a class="page-link"  href="'.$query_str.$mark_char.'page='.$next_page.'">></a>
//         </li>
//     ';
// // 	echo '
// //        <li class="page-item" style="display:inline-block;">
// //          <input type="number" class="form-control" min="1" max="'.$total_page.'"
// //                  style="width:80px;" onClick="this.select()" oninput="window.location=\''.$query_str.$mark_char.'page=\'+this.value"  value="'.$cur_page.'" />
// //        </li>
// //    ';
// 	echo '
//         <li class="page-item" style="display:inline-block;">
//             <a class="page-link"  href="'.$query_str.$mark_char.'page='.$total_page.'">>></a>
//         </li>
//       </ul>
//     </nav>
//     </div>';
}
?>