<?php


function authPrivatePageLeader()
{
    $authEPID = ['18', '21','22', '23','24', '300'];
    $sess = $_SESSION;
    if (isset($sess['EP_ID']) && !in_array($sess['EP_ID'], $authEPID)) {
        header('Location: index.php');
    }
}


function dateFormat($strDate, $dateFormat = 'Y-m-d'){
    return date($dateFormat, strtotime($strDate));
}

// echo dateFormat('11-02-2020', 'F d M Y');