<?php
    require_once("config.php");
//    ค้นหาชื่อและรหัสช่าง
    $name = $_GET['name'];
    $array = array();
    $result = sqlsrv_query($conn, "select E_LocalFirstName, E_LocalLastName, E_Code from Employee where E_LocalFirstName LIKE N'%{$name}%' and (WG_ID = '94' or WG_ID = '95' or WG_ID = '96')");
    // var_dump("select E_LocalFirstName, E_LocalLastName, E_Code from Employee where E_LocalFirstName LIKE N'%{$name}%' and (WG_ID = '94' or WG_ID = '95' or WG_ID = '96')");die;
    while($row = sqlsrv_fetch_array($result))
    {
        $array[] = $row["E_Code"]." ".$row["E_LocalFirstName"]." ".$row["E_LocalLastName"];
    }
    echo json_encode($array);
?>