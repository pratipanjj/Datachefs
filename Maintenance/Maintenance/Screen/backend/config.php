<?php

// declare set define global variable by joh
defined('ENV') or define('ENV', 'dev');

$path_dev = (ENV == 'dev') ? '/datacheflab' : '';

defined('PATH_DEV') or define('PATH_DEV', $path_dev);
// ---------------------end-----------------------------


$serverName = "192.168.1.22";
$userName = "appuser";
$userPassword = "Password1234";
$dbName = "Paradise";

//เชื่อต่อฐานข้อมูล
$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if(!$conn)
{
	die( print_r( sqlsrv_errors(), true));
} 
// else {
// 		echo 'connected';
// }

?>