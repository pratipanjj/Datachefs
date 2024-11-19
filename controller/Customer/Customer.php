<?php
require_once '../../configs/conn.php';
require_once '../../function/LogSystem.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['load'])) {
    $arr = array();
    $q = $conn->prepare("select BE_ID,BE_LocalName,BE_EnglishName,BE_Code,s_name , BE_created ,BE_status, s_name , sp_name from businessentity
    left JOIN sales on businessentity.BE_salesman = sales.s_id
     left JOIN support on businessentity.BE_support = support.sp_id
     order by BE_LocalName asc
     ");
    $q->execute();
    $bus = $q->fetchall();
    foreach ($bus as $b) {
        $nesData = array();
        $nesData[] = " <a href='Customerinfo.php?be=" . $b['BE_ID'] . "'><strong>" . $b['BE_LocalName'] . "</strong> </a>";
        $nesData[] = $b['BE_LocalName'];
        $nesData[] = $b['BE_EnglishName'];
        $nesData[] = $b['s_name'];
        $nesData[] = $b['sp_name'];
        $nesData[] = $b['BE_created'];
        $nesData[] = $b['BE_status'];
        $nesData[] = '  <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="Customerinfo.php?be=' . $b['BE_ID'] . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> -->
            </div>
        </div>';
        $arr['data'][] = $nesData;
    }
    echo json_encode($arr);
}
if (isset($_POST['customer'])) {
    
    $arr = [
        'BT_ID' => $_POST['BT_ID'],
        'BE_Code' => $_POST['code'],
        'BE_LocalName' => $_POST['LocalName'],
        'BE_EnglishName' => $_POST['EnglishName'],
        'BE_country' => $_POST['BE_country'],
        'BE_contact' => $_POST['BE_contact'],
        'BE_Telephone1' => $_POST['Tel1'],
        'BE_Fax1' => $_POST['Fax1'],
        'BE_address' => $_POST['address'],
        'BE_Website' => $_POST['WebSite'],
        'BE_IsActive' => 1,
        'BE_status' => 1,
        'BE_VatType' => $_POST['vat'],
        'BE_IsShowACCStars' => isset($_POST['ACC'][0]) ? 1 : 0,
        'BE_IsShowDimension' => isset($_POST['Dimension'][0]) ? 1 : 0,
        'BE_salesman' => $_POST['Salesman'],
        'BE_support' => $_POST['support'],
        'BE_created' => date('Y-m-d H:i'),
        'BE_createby' => $_SESSION['Code'],
    ];
    // print_r($_POST);exit();
    $q = $conn->prepare("insert into businessentity(BT_ID,BE_Code,BE_LocalName,BE_EnglishName,BE_country,BE_contact,BE_Telephone1,BE_Fax1,BE_address,BE_Website,BE_IsActive,
    BE_status,BE_VatType,BE_IsShowACCStars,BE_IsShowDimension,BE_salesman,BE_support,BE_created,BE_createby) 
    values(
        :BT_ID,:BE_Code,:BE_LocalName,:BE_EnglishName,:BE_country,:BE_contact,:BE_Telephone1,:BE_Fax1,
        :BE_address,:BE_Website,:BE_IsActive,:BE_status,:BE_VatType,:BE_IsShowACCStars,:BE_IsShowDimension,
        :BE_salesman,:BE_support,:BE_created,:BE_createby
    )");
    $insert = $q->execute($arr);
    if ($insert) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
if (isset($_POST['companyID'])) {
  
    $arr = [
        'BT_ID' => $_POST['BT_ID'],
        'BE_Code' => $_POST['BE_Code'],
        'BE_LocalName' => $_POST['BE_LocalName'],
        'BE_EnglishName' => $_POST['BE_EnglishName'],
        'BE_country' => $_POST['BE_country'],
        'BE_contact' => $_POST['BE_contact'],
        'BE_Telephone1' => implode(',', $_POST['tel']),
        'BE_address' => $_POST['BE_address'],
        'BE_Website' => $_POST['BE_Website'],
        'BE_IsActive' => 1,
        'BE_status' => 1,
        'BE_VatType' => $_POST['vat'],
        'BE_IsShowACCStars' => isset($_POST['BE_IsShowACCStars']) ? 1 : 0,
        'BE_IsShowDimension' => isset($_POST['BE_IsShowDimension']) ? 1 : 0,
        'BE_salesman' => $_POST['BE_salesman'],
        'BE_support' => $_POST['BE_support'],
        'BE_created' => date('Y-m-d H:i'),
        'BE_createby' => $_SESSION['Code'],
        'companyID' => $_POST['companyID']
    ];
    $q = $conn->prepare("update businessentity set BT_ID = :BT_ID ,BE_Code = :BE_Code ,BE_LocalName = :BE_LocalName ,BE_EnglishName = :BE_EnglishName , BE_country = :BE_country, BE_contact = :BE_contact,
        BE_Telephone1 = :BE_Telephone1 ,BE_address = :BE_address ,BE_Website = :BE_Website ,
        BE_IsActive = :BE_IsActive , BE_status = :BE_status , BE_VatType = :BE_VatType,BE_IsShowACCStars = :BE_IsShowACCStars ,
        BE_IsShowDimension = :BE_IsShowDimension ,BE_salesman = :BE_salesman ,BE_support = :BE_support ,BE_created = :BE_created ,BE_createby = :BE_createby where BE_ID = :companyID
    ");
    $insert = $q->execute($arr);
    if ($insert) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
if(isset($_POST['hideCustomer'])){

    if($_POST['status'] == 1){
        $status = 'Active';
    }else{
        $status = 'Disabled';
    }
    
    $del = $conn->prepare("update businessentity set BE_IsActive = ? where BE_ID = ?");
    $del->execute([$_POST['status'] , $_POST['hideCustomer']]);
    if($del){
        $q = $conn->prepare("select BE_LocalName , c_firstname,c_lastname from businessentity left join customer on businessentity.BE_ID = customer.be_id where businessentity.BE_ID = ? ");
        $q->execute([$_POST['hideCustomer']]);
        $event = $q->fetch();
        logging('Customer', 'เปลี่ยนสถานะ บริษัท : ' . $event['BE_LocalName'] . ' เป็น : ' . $status . ' โดย : ' . $_SESSION['Name']);
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
}
