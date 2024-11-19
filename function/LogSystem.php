<?php
// session_start();
ob_start();
date_default_timezone_set("Asia/Bangkok");

function Connection()
{
    $host = '192.168.1.16';
    $dbname = 'cadata';
    $username = 'ca';
    $password = 'ca1234!';
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $conn->exec("set names utf8");
    } catch (PDOException $pe) {
        die("Could not connect to the database $dbname :" . $pe->getMessage());
    }

    return $conn;
}

function logging($Type = null, $detail)
{
    $conn = Connection();
    $dateTime = date('Y-m-d H:i:s');
    $query = "INSERT INTO logsystem (Log_type, Log_detail, Log_customer, Log_create, Log_createby) VALUES (:Type, :detail, :user, :dt, :SU_Code)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':Type', $Type);
    $stmt->bindParam(':detail', $detail);
    $stmt->bindParam(':user', $_SESSION['Name']);
    $stmt->bindParam(':dt', $dateTime);
    $stmt->bindParam(':SU_Code', $_SESSION['Code']);
    $stmt->execute();
}

function datedb($val)
{
    $ex = explode('/', $val);
    $date = $ex[2] . '-' . $ex[1] . '-' . $ex[0];
    return $date;
}

function dateTh($val, $type = null)
{
    if ($val == '0000-00-00') {
        return '';
    } else {
        if ($type != null) {
            return date('d/m/Y H:i', strtotime($val));
        } else {
            return date('d/m/Y', strtotime($val));
        }
    }
}
function thai($tis)
{
    $max = strlen($tis);
    $utf8 = "";
    for ($i = 0; $i < $max; $i++) {
        $s = substr($tis, $i, 1);
        $val = ord($s);
        if ($val < 0x80) {
            $utf8 .= $s;
        } elseif ((0xA1 <= $val and $val <= 0xDA) or (0xDF <= $val and $val <= 0xFB)) {
            $unicode = 0x0E00 + $val - 0xA0;
            $utf8 .= chr(0xE0 | ($unicode >> 12));
            $utf8 .= chr(0x80 | (($unicode >> 6) & 0x3F));
            $utf8 .= chr(0x80 | ($unicode & 0x3F));
        }
    }
    return $utf8;
}
