<?php
$count_status = 0;
$count_status1 = 0;
$count_status2 = 0;
$count_status3 = 0;
$count_status4 = 0;
$count_status5 = 0;
$count_engineer_work = 0;

$authEPID = ['18', '21','22', '23','24', '300','25', '26',];
if (isset($_SESSION['EP_ID']) && in_array($_SESSION['EP_ID'], $authEPID)) {
    $query1 = "SELECT COUNT(*) as 'num1' FROM MaintenanceRepairAdd WHERE MRA_Status = 1";
    $result1 = sqlsrv_query($conn, $query1) or die(print_r(sqlsrv_errors(), true));

    $query2 = "SELECT COUNT(*) as 'num2' FROM MaintenanceRepairAdd WHERE MRA_Status = 2";
    $result2 = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));

    $query3 = "SELECT COUNT(*) as 'num3' FROM MaintenanceRepairAdd WHERE MRA_Status = 3";
    $result3 = sqlsrv_query($conn, $query3) or die(print_r(sqlsrv_errors(), true));

    $query4 = "SELECT COUNT(*) as 'num4' FROM MaintenanceRepairAdd WHERE MRA_Status = 4";
    $result4 = sqlsrv_query($conn, $query4) or die(print_r(sqlsrv_errors(), true));

    $query5 = "SELECT COUNT(*) as 'num5' FROM MaintenanceRepairAdd WHERE MRA_Status = 5";
    $result5 = sqlsrv_query($conn, $query5) or die(print_r(sqlsrv_errors(), true));

    if(isset($code)){
        $query6 = "SELECT COUNT(*) as 'num' FROM MaintenanceJoblist WHERE MJ_Status = 2 AND (MJ_EngineerCode = '$code' OR MJ_EngineerCode2 = '$code') ";
        $result6 = sqlsrv_query($conn, $query6) or die(print_r(sqlsrv_errors(), true));
        while ($row = sqlsrv_fetch_array($result6)){	
            $count_engineer_work = $row['num'];   
        }
    }

    while ($row = sqlsrv_fetch_array($result1)){
        $count_status1 = $row['num1'];
    }
    while ($row = sqlsrv_fetch_array($result2)){
        $count_status2 = $row['num2'];
    }
    while ($row = sqlsrv_fetch_array($result3)){
        $count_status3 = $row['num3'];
    }
    while ($row = sqlsrv_fetch_array($result4)){
        $count_status4 = $row['num4'];
    }
    while ($row = sqlsrv_fetch_array($result5)){
        $count_status5 = $row['num5'];
    }

    $count_status = $count_status1 + $count_status2 + $count_status3 + $count_status4;

    if(isset($wg_id)){
        $query = "SELECT COUNT(*) as 'num' FROM MaintenanceRepairAdd WHERE MRA_Status = 3 AND MRA_WorkUnitID = '$wg_id'";
        $result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
        while ($row = sqlsrv_fetch_array($result)){
            $count_status_workgroup = $row['num'];
        }
    }
}
else{
    $query1 = "SELECT COUNT(*) as 'num1' FROM MaintenanceRepairAdd WHERE MRA_Status = 1 AND MRA_WorkUnitID = '$wg_id'";
    $result1 = sqlsrv_query($conn, $query1) or die(print_r(sqlsrv_errors(), true));

    $query2 = "SELECT COUNT(*) as 'num2' FROM MaintenanceRepairAdd WHERE MRA_Status = 2 AND MRA_WorkUnitID = '$wg_id'";
    $result2 = sqlsrv_query($conn, $query2) or die(print_r(sqlsrv_errors(), true));

    $query3 = "SELECT COUNT(*) as 'num3' FROM MaintenanceRepairAdd WHERE MRA_Status = 3 AND MRA_WorkUnitID = '$wg_id'";
    $result3 = sqlsrv_query($conn, $query3) or die(print_r(sqlsrv_errors(), true));
 
    $query4 = "SELECT COUNT(*) as 'num4' FROM MaintenanceRepairAdd WHERE MRA_Status = 4 AND MRA_WorkUnitID = '$wg_id'";
    $result4 = sqlsrv_query($conn, $query4) or die(print_r(sqlsrv_errors(), true));

    $query5 = "SELECT COUNT(*) as 'num5' FROM MaintenanceRepairAdd WHERE MRA_Status = 5 AND MRA_WorkUnitID = '$wg_id'";
    $result5 = sqlsrv_query($conn, $query5) or die(print_r(sqlsrv_errors(), true));

    while ($row = sqlsrv_fetch_array($result1)){
        $count_status1 = $row['num1'];
    }
    while ($row = sqlsrv_fetch_array($result2)){
        $count_status2 = $row['num2'];
    }
    while ($row = sqlsrv_fetch_array($result3)){
        $count_status3 = $row['num3'];
    }
    while ($row = sqlsrv_fetch_array($result4)){
        $count_status4 = $row['num4'];
    }
    while ($row = sqlsrv_fetch_array($result5)){
        $count_status5 = $row['num5'];
    }

    $count_status = $count_status1 + $count_status2 + $count_status3 + $count_status4;
}





?>