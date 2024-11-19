<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Bangkok");
$host = '192.168.1.77';
$dbname = 'DataChefsCloud';
$username = 'ca';
$password = 'Mrg1234!';
try {
    $conn = new PDO("sqlsrv:server=$host;Database=$dbname", $username, $password);
    $conn->exec("set names utf8");

    // echo "Connected to $dbname at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}


function serverSide()
{
    $host = '192.168.1.77';
    $dbname = 'DataChefsCloud';
    $username = 'ca';
    $password = 'Mrg1234!';
    $sql = array(
        'user' => $username,
        'pass' => $password,
        'db'   => $dbname,
        'host' => $host
    );
    return $sql;
}
