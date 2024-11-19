<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Bangkok");
try {
    $hostname = '192.168.1.38';
    $username = 'appuser';
    $password = 'Password1234';
    $dbname   = 'Paradise';
    
      $PDO = new PDO( "sqlsrv:server=$hostname;Database=$dbname", $username, $password);
    echo "Connected to $dbname at $host successfully.";
    } catch (PDOException $e) {
      echo "Failed to get DB handle: " . $e->getMessage() . "\n";
      exit;
    }
    // $stmt = $PDO->prepare("select * from ExpA_stcrd ");
    // $stmt->execute();
  
    // foreach($stmt as $row){
    //   echo $row['docnum'].' -> '.$row['stkdes'].'<br>';
    // }
  
  //   unset($dbh); unset($stmt);