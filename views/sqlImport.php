<?php
require_once '../configs/conn.php';
if (isset($_POST['save'])) {
    //    print_r($_FILES);exit();
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

    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file, "r");
    $k = 0;
    while (($csv = fgetcsv($file_open, 1000, ",")) !== false) {
        if ($k > 0) {
            if($csv[8] == 1){
                $q = $conn->exec("insert into businessentity(BE_Code,BE_EnglishName,BE_LocalName,BE_address,BE_country,BE_contact,BE_Telephone1,BE_Fax1,BE_IsActive,BE_status,BE_synERP,BE_created,BE_createby) 
                values ('".thai($csv[0])."','".thai($csv[1])."','".thai($csv[2])."','".thai($csv[3])."','".thai($csv[4])."','".thai($csv[5])."','".thai($csv[6])."','".thai($csv[7])."',1,2,1,'".date('Y-m-d H:i')."','2010001')");
            }
           
        }
        $k++;
    }
// exit();
    // print_r($arr);exit();




    // while (($csv = fgetcsv($file_open, 1000, ",")) !== false) {
    //     echo mb_convert_encoding($csv[3], 'TLS', 'UTF-8') . "<br>";
    //     //  $data = [
    //     //     'SU_ID' => $csv[0],
    //     //     'SU_Code' => $csv[1],
    //     //     'SU_Name1' => $csv[2],
    //     //     'SU_Name2' => iconv('UTF-8', 'cp1252',$csv[3]),
    //     //     'SU_Email' => $csv[4],
    //     //     'SU_Username' => $csv[5],
    //     //     'SU_Password' => $csv[6],
    //     //     'SU_Role' => $csv[7],
    //     //     'SU_Active' => $csv[8],
    //     //     'SU_LogOn' => $csv[9],
    //     //     'SU_Remarks' => $csv[10],
    //     //     'SU_Profile' => $csv[11],
    //     //     'SU_Signature' => $csv[12],
    //     //  ];
    //     //    $q = $conn->prepare("INSERT INTO systemuser(SU_ID,SU_Code,SU_Name1,SU_Name2,SU_Email,SU_Username,SU_Password,SU_Role,SU_Active,SU_LogOn,SU_Remarks,SU_Profile,SU_Signature) 
    //     //    VALUES (:SU_ID,:SU_Code,:SU_Name1,:SU_Name2,:SU_Email,:SU_Username,:SU_Password,:SU_Role,:SU_Active,:SU_LogOn,:SU_Remarks,:SU_Profile,:SU_Signature)");
    //     //    $q->execute($data);

    // }
}
