<?php 
require_once '../../configs/conn.php';
$table = 'logsystem';
$primaryKey = 'log_id';

$columns = array(
    array('db' => 'Log_type', 'dt' => 0),
    array('db' => 'Log_detail',  'dt' => 1),
    array('db' => 'Log_customer',   'dt' => 2),
    array(
        'db'        => 'Log_create',
        'dt'        => 3,
        'formatter' => function ($d, $row) {
            return date('d/m/Y H:i', strtotime($d));
        }
    ),
    array('db' => 'Log_createby',   'dt' => 4),

);
// SQL server connection information
$sql_details = serverSide();
require('../ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
