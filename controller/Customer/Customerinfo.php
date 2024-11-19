<?php
require_once '../../configs/conn.php';
require_once '../../function/LogSystem.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// if($_GET['1']){
//     $s = $conn->prepare("select SU_ID,SU_Password from systemuser");
//     $s->execute();
//     $sys = $s->fetchall();
//     foreach($sys as $k ){
//       $pass = password_hash($k['SU_Password'], PASSWORD_DEFAULT);
//       $u = $conn->prepare("update systemuser set SU_Password = ? where SU_ID = ? ");
//       $u->execute([$pass,$k['SU_ID']]);
//     }
// }

if (isset($_POST['changestatus'])) {
    $q = $conn->prepare("update customer set c_status = ? where c_id = ? ");
    $insert = $q->execute([$_POST['changestatus'], $_POST['id']]);

    if ($_POST['changestatus'] == 1) {
        $status = 'ทำงาน';
    } elseif ($_POST['changestatus'] == 2) {
        $status = 'ลาออก';
    } elseif ($_POST['changestatus'] == 3) {
        $status = 'พักงาน';
    } else {
        $status = 'ลบ';
    }

    if ($insert) {
        $q = $conn->prepare("select BE_LocalName , c_firstname,c_lastname from businessentity left join customer on businessentity.BE_ID = customer.be_id where c_id = ? ");
        $q->execute([$_POST['id']]);
        $event = $q->fetch();
        logging('Customer', 'เปลี่ยนสถานะ Customer : ' . $event['c_firstname'] . ' ' . $event['c_lastname'] . ' บริษัท : ' . $event['BE_LocalName'] . ' เป็น : ' . $status . ' โดย : ' . $_SESSION['Name']);
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}

if (isset($_POST['addcustomer'])) {
    $image = '';
    if ($_FILES['file']['name']) {
        $uploads_dir = '../../images/Customer/profile/';
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = time() . '_' .  rand(10, 9999) . '.' . $ext;
        $image = time() . '_' . rand(10, 9999) . '.' . $ext;
        $move = move_uploaded_file($tmp_name, "$uploads_dir/$image");
    } else {
        $image = '1672976919_149071.png';
    }
    if ($_POST['birth'] != '') {
        $ex = explode('/', $_POST['birth']);
        $date = $ex[2] . '-' . $ex[1] . '-' . $ex[0];
    } else {
        $date = '';
    }
    $arr = [
        'be_id' => $_POST['business'],
        'c_profile' => $image,
        'c_firstname' => $_POST['firstname'],
        'c_lastname' => $_POST['lastname'],
        'c_nickname' => $_POST['nickname'],
        'c_position' => $_POST['position'],
        'c_tel' => $_POST['tel'],
        'c_email' => $_POST['email'],
        'c_birthday' => $date,
        'c_jobdescrip' => htmlspecialchars($_POST['job']),
        'c_preference' => htmlspecialchars($_POST['private']),
        'c_information' => htmlspecialchars($_POST['special']),
        'c_status' => 1,
        'c_createby' =>  $_SESSION['Code'],
        'c_created' => date('Y-m-d H:i:s'),
    ];
        // print_r($arr);exit();
    $q = $conn->prepare("insert into customer(be_id,c_profile,c_firstname,c_lastname,c_nickname,c_position,c_tel,c_email,c_birthday,c_jobdescrip,c_preference,c_information,c_status,c_createby,c_created) 
    values(
        :be_id,
        :c_profile,
        :c_firstname,
        :c_lastname,
        :c_nickname,
        :c_position,
        :c_tel,
        :c_email,
        :c_birthday,
        :c_jobdescrip,
        :c_preference,
        :c_information,
        :c_status,
        :c_createby,
        :c_created
    )");
    $insert = $q->execute($arr);
    if ($insert) {
        $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
        $q->execute([$_POST['business']]);
        $event = $q->fetch();
        logging('Customer', 'เพิ่ม Customer : ' . str_replace("'","''",$_POST['firstname']) . ' ' . str_replace("'","''",$_POST['lastname']) . ' บริษัท ' . $event['BE_LocalName'] . ' โดย : ' . $_SESSION['Name']);
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}

if (isset($_POST['addEvent'])) {
    $html = htmlspecialchars($_POST['Description']);
    $image = array();
    $uploads_dir = '../../images/Customer/';
    foreach ($_FILES['file']['tmp_name'] as $k => $r) {
        $tmp_name = $_FILES['file']['tmp_name'][$k];
        $name = time() . '_' . iconv('UTF-8', 'TIS-620', (basename($_FILES['file']['name'][$k])));
        $move = move_uploaded_file($tmp_name, "$uploads_dir/$name");
        if ($move) {
            $image[] = time() . '_' . basename($_FILES['file']['name'][$k]);
        }
    }

    $arr = [
        'be_id' => $_POST['addEvent'],
        'eb_image' => (count($image) > 0 ? implode(',', $image) : ''),
        'eb_date' => datedb($_POST['dobLarge']),
        'eb_contact' => (count($_POST['person']) > 0 ? implode(' , ', $_POST['person']) : ''),
        'eb_description' => $html,
        'eb_createby' => $_SESSION['Code'],
        'eb_created' => date('Y-m-d H:i:s'),
    ];
    //    print_r($arr);exit();
    $q = $conn->prepare("insert into eventbusiness(be_id,eb_image,eb_date,eb_contact,eb_description,eb_createby,eb_created) 
    values(
        :be_id,
        :eb_image,
        :eb_date,
        :eb_contact,
        :eb_description,
        :eb_createby,
        :eb_created
    )");
    $insert = $q->execute($arr);
    if ($insert) {
        $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
        $q->execute([$_POST['addEvent']]);
        $event = $q->fetch();
        logging('Customer', 'บันทึกข้อมูลเหตุการณ์ บริษัท ' . $event['BE_LocalName'] . ' โดย : ' . $_SESSION['Name']);
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}

if (isset($_POST['addEventlog'])) {
    if (empty($_POST['followup']) && empty($_POST['IdEventlog'])) {
        // print_r(1);exit();
        $cq = $conn->prepare("select es_name from EventSubject where es_name = ? ");
        $cq->execute([$_POST['el_subject']]);
        $event = $cq->fetch();

        $image = array();
        $uploads_dir = '../../images/Customer/';
        foreach ($_FILES['file']['tmp_name'] as $k => $r) {
            $tmp_name = $_FILES['file']['tmp_name'][$k];
            $name = time() . '_' . iconv('UTF-8', 'TIS-620', (basename($_FILES['file']['name'][$k])));
            $move = move_uploaded_file($tmp_name, "$uploads_dir/$name");
            if ($move) {
                $image[] = time() . '_' . basename($_FILES['file']['name'][$k]);
            }
        }
        if (empty($event['es_name'])) {
            $subject = [
                'es_name' => $_POST['el_subject'],
            ];
            $sq = $conn->prepare("insert into EventSubject(es_name) 
            values(
                :es_name
            )");
            $subjectinsert = $sq->execute($subject);
            $id = $conn->lastInsertId();
        } else {
            $id = $event['es_name'];
        }
        $arr = [
            'be_id' => $_POST['addEventlog'],
            'el_date' => datedb($_POST['dobLarge']),
            'el_subject' => $_POST['el_subject'],
            'el_branch' => $_POST['el_branch'],
            'el_product' => ( isset($_POST['Product']) && count($_POST['Product']) > 0 ? implode('/', $_POST['Product']) : ''),
            'el_image' => (count($image) > 0 ? implode(',', $image) : ''),
            'el_description' => htmlspecialchars($_POST['Description']),
            'el_createby' => $_SESSION['Code'],
            'el_created' => date('Y-m-d H:i:s'),
        ];
        $q = $conn->prepare("insert into eventlog(be_id,el_date,el_subject,el_branch,el_product,el_image,el_description,el_createby,el_created) 
        values(
            :be_id,
            :el_date,
            :el_subject,
            :el_branch,
            :el_product,
            :el_image,
            :el_description,
            :el_createby,
            :el_created
        )");

        $insert = $q->execute($arr);
        $Lastid = $conn->lastInsertId();
        if ($insert) {
            $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
            $q->execute([$_POST['addEventlog']]);
            $event = $q->fetch();
            logging('Customer', 'บันทึกข้อมูลบันทึกเหตุการณ์ Product : ' . (isset($_POST['Product']) && count($_POST['Product']) > 0 ? implode('/', $_POST['Product']) : '') . ' บริษัท : ' . $event['BE_LocalName'] . ' โดย : ' . $_SESSION['Name']);
        }

        $arr = array();
        $k = 0;

        if(isset($_POST['issue'])){
            foreach ($_POST['issue'] as $req) {
                if (trim($_POST['issue'][$k]) != '') {
                    $arr = [
                        'el_id' => $Lastid,
                        'fu_issue' => $_POST['issue'][$k],
                        'fu_detail' => $_POST['detail'][$k],
                        'fu_date' => datedb($_POST['date'][$k]),
                        'fu_status' => $_POST['status'][$k],
                        'fu_createby' => $_SESSION['Code'],
                        'fu_created' => date('Y-m-d H:i:s')
                    ];

                    $q = $conn->prepare("insert into followup(el_id,fu_issue,fu_detail,fu_date,fu_status,fu_createby,fu_created) 
                values(
                    :el_id,
                    :fu_issue,
                    :fu_detail,
                    :fu_date,
                    :fu_status,
                    :fu_createby,
                    :fu_created
                )");
                    $followup = $q->execute($arr);
                    $lastId = $conn->lastInsertId();

                    $k++;
                    logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $lastId . ' โดย : ' . $_SESSION['Name']);
                }
            }
        }
        // if ($insert) {
         echo json_encode(1);
        // } else {
        //  echo json_encode(0);
        // }
    } elseif (isset($_POST['IdEventlog']) && $_POST['IdEventlog'] != '') {
     
        $cq = $conn->prepare("select es_name from EventSubject where es_name = ? ");
        $cq->execute([$_POST['el_subject']]);
        $event = $cq->fetch();

        $image = array();
        $uploads_dir = '../../images/Customer/';
        foreach ($_FILES['file']['tmp_name'] as $k => $r) {
            $tmp_name = $_FILES['file']['tmp_name'][$k];
            $name = time() . '_' . iconv('UTF-8', 'TIS-620', (basename($_FILES['file']['name'][$k])));
            $move = move_uploaded_file($tmp_name, "$uploads_dir/$name");
            if ($move) {
                $image[] = time() . '_' . basename($_FILES['file']['name'][$k]);
            }
        }

        if (empty($event['es_name'])) {
            $subject = [
                'es_name' => $_POST['el_subject'],
            ];
            $sq = $conn->prepare("insert into EventSubject(es_name) 
            values(
                :es_name
            )");
            $subjectinsert = $sq->execute($subject);
            $id = $conn->lastInsertId();
        } else {
            $id = $event['es_name'];
        }
        $arr = [
            'el_date' => datedb($_POST['dobLarge']),
            'el_subject' => $_POST['el_subject'],
            'el_branch' => $_POST['el_branch'],
            'el_product' => (count($_POST['Product']) > 0 ? implode('/', $_POST['Product']) : $_POST['Product']),  
            'el_image' => (count($image) > 0 ? implode(',', $image) : $_POST['oldfile']),
            'el_description' => htmlspecialchars($_POST['Description']),
            'IdEventlog' => $_POST['IdEventlog']

        ];

        $q = $conn->prepare("update eventlog set el_date = :el_date ,el_subject = :el_subject ,el_branch = :el_branch ,el_product = :el_product ,el_image = :el_image ,el_description = :el_description
         where el_id = :IdEventlog ");
        $insert = $q->execute($arr);

        $Lastid = $conn->lastInsertId();
        if ($insert) {
            $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
            $q->execute([$_POST['addEventlog']]);
            $event = $q->fetch();
            logging('Customer', 'บันทึกข้อมูลบันทึกเหตุการณ์ Product : ' . (count($_POST['Product']) > 0 ? implode(' / ', $_POST['Product']) : $_POST['Product']) . ' บริษัท : ' . $event['BE_LocalName'] . ' โดย : ' . $_SESSION['Name']);
        }
        if(isset($_POST['editIDFU'])){
            foreach ($_POST['editIDFU'] as $k => $req) {
                if (trim($_POST['editissue'][$k]) != '') {
                    $uparr = [
                        'fu_issue' => $_POST['editissue'][$k],
                        'fu_detail' => $_POST['editdetail'][$k],
                        'fu_status' => $_POST['editstatus'][$k],
                        'fu_createby' => $_SESSION['Code'],
                        'fu_created' => date('Y-m-d H:i:s'),
                        'fu_id' => $req
                    ];
                    // print_r($uparr);exit();
                    $q = $conn->prepare(" update followup set fu_issue = :fu_issue ,fu_detail = :fu_detail  ,fu_status = :fu_status ,fu_createby = :fu_createby ,fu_created = :fu_created 
                    where fu_id = :fu_id ");
                    $insert = $q->execute($uparr);
                    $lastId = $conn->lastInsertId();
                    $k++;
                }
                if ($insert) {
                    $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
                    $q->execute([$_POST['followup']]);
                    $event = $q->fetch();
                    logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $_POST['followup'] . ' โดย : ' . $_SESSION['Name']);
                    // echo json_encode(1);
                }
            }
        }


        $arr = array();
        $k = 0;

        if(isset($_POST['issue'])){
            foreach ($_POST['issue'] as $req) {
                if (trim($_POST['issue'][$k]) != '') {
                    $arr = [
                        'el_id' => $_POST['IdEventlog'],
                        'fu_issue' => $_POST['issue'][$k],
                        'fu_detail' => $_POST['detail'][$k],
                        'fu_date' => datedb($_POST['date'][$k]),
                        'fu_status' => $_POST['status'][$k],
                        'fu_createby' => $_SESSION['Code'],
                        'fu_created' => date('Y-m-d H:i:s')
                    ];
                    // print_r($arr);

                    $q = $conn->prepare("insert into followup(el_id,fu_issue,fu_detail,fu_date,fu_status,fu_createby,fu_created) 
                values(
                    :el_id,
                    :fu_issue,
                    :fu_detail,
                    :fu_date,
                    :fu_status,
                    :fu_createby,
                    :fu_created
                )");
                    $insert = $q->execute($arr);
                    $lastId = $conn->lastInsertId();

                    $k++;
                    logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $lastId . ' โดย : ' . $_SESSION['Name']);
                }
            }
        }
        echo json_encode(1);
    } else {

        // if(isset($))
        // print_r(3);exit();
        
        if(isset($_POST['editIDFU'])){
            foreach ($_POST['editIDFU'] as $k => $req) {
                if (trim($_POST['issue'][$k]) != '') {
                    $arr = [
                        'fu_issue' => $_POST['issue'][$k],
                        'fu_detail' => $_POST['detail'][$k],
                        'fu_date' => datedb($_POST['date'][$k]),
                        'fu_status' => $_POST['status'][$k],
                        'fu_createby' => $_SESSION['Code'],
                        'fu_created' => date('Y-m-d H:i:s'),
                        'fu_id' => $req
                    ];
                    $q = $conn->prepare(" update followup set fu_issue = :fu_issue ,fu_detail = :fu_detail ,fu_date = :fu_date ,fu_status = :fu_status ,fu_createby = :fu_createby ,fu_created = :fu_created 
                    where fu_id = :fu_id ");
                    $insert = $q->execute($arr);
                    $lastId = $conn->lastInsertId();
                    $k++;
                }
                if ($insert) {
                    $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
                    $q->execute([$_POST['followup']]);
                    $event = $q->fetch();
                    logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $_POST['followup'] . ' โดย : ' . $_SESSION['Name']);
                    echo json_encode(1);
                }
            }
        }

        
        
        if(isset($_POST['issue'])){
                foreach ($_POST['issue'] as $k => $req) {
                    if (trim($_POST['issue'][$k]) != '') {
                        $arr = [
                            'el_id' => $_POST['followup'],
                            'fu_issue' => $_POST['issue'][$k],
                            'fu_detail' => $_POST['detail'][$k],
                            'fu_date' => datedb($_POST['date'][$k]),
                            'fu_status' => $_POST['status'][$k],
                            'fu_createby' => $_SESSION['Code'],
                            'fu_created' => date('Y-m-d H:i:s')
                        ];

                        $q = $conn->prepare("insert into followup(el_id,fu_issue,fu_detail,fu_date,fu_status,fu_createby,fu_created) 
                    values(
                        :el_id,
                        :fu_issue,
                        :fu_detail,
                        :fu_date,
                        :fu_status,
                        :fu_createby,  
                        :fu_created
                    )");
                        $insert = $q->execute($arr);
                        $lastId = $conn->lastInsertId();
                        $k++;
                    }
                    if ($insert) {
                        $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
                        $q->execute([$_POST['followup']]);
                        $event = $q->fetch();
                        logging('Customer', 'บันทึกข้อมูล FollowUp รายการที่ ' . $_POST['followup'] . ' โดย : ' . $_SESSION['Name']);
                        echo json_encode(1);
                    }
                }
        }
        // echo json_encode(1);
    }
}

if (isset($_POST['seeEvent'])) {
    $q = $conn->prepare("select el_id,be_id,el_subject,el_image,el_branch,el_date,el_product,el_description 
    from eventlog where el_id = ? ");
    $q->execute([$_POST['seeEvent']]);
    $event = $q->fetch();
    $event['el_product'] = explode('/',trim($event['el_product']));
    $event['el_description'] = htmlspecialchars_decode($event['el_description']);
    // $event['el_date'] = str_replace('-','/',$event['el_date']);
    $event['el_date'] = date('d/m/Y',strtotime($event['el_date']));

    $fl = $conn->prepare("select fu_id,fu_issue,fu_detail,fu_date,fu_status,fu_createby,fu_created,case when SU_Name1 = '' then SU_Name2  else  SU_Name1 end as name
    from followup left join systemuser on followup.fu_createby = systemuser.SU_Code where el_id = ? and is_active = ? ");
    $fl->execute([$event['el_id'], 1]);
    $follow = $fl->fetchall();

    echo json_encode(['event' => $event, 'follow' => $follow]);
}

if(isset($_POST['ChangStatus'])){
    
    // print_r($_POST);exit();
    $fl = $conn->prepare("update followup set fu_status = ? where fu_id = ? ");
    $fl->execute([$_POST['Status'], $_POST['ChangStatus']]);

}

if (isset($_POST['DelFollow'])) {
    $qh = $conn->prepare("update followup set is_active = ? where fu_id = ? ");
    $update = $qh->execute([0, $_POST['DelFollow']]);
    if ($update) {
        echo json_encode(1);
    }
}

if (isset($_POST['DelEvent'])) {

    $status = $_POST['status'] == 1 ? 0 : 1;
    
    $qh = $conn->prepare("update eventlog set el_active = ? where el_id = ? ");
    $update = $qh->execute([$status, $_POST['DelEvent']]);
    if ($update) {
        echo json_encode(1);
    }
}


if (isset($_POST['addCosts'])) {
    $arr = [
        'be_id' => $_POST['addCosts'],
        'cs_date' => datedb($_POST['dobLarge']),
        'cs_product' => $_POST['Product'],
        'cs_description' => htmlspecialchars($_POST['Description']),
        'cs_createby' => $_SESSION['Code'],
        'cs_created' => date('Y-m-d H:i:s'),
    ];

    $q = $conn->prepare("insert into costsbusiness(be_id,cs_date,cs_product,cs_description,cs_createby,cs_created) 
    values(
        :be_id,
        :cs_date,
        :cs_product,
        :cs_description,
        :cs_createby,
        :cs_created
    )");
    $insert = $q->execute($arr);
    if ($insert) {
        $q = $conn->prepare("select BE_LocalName from businessentity where BE_ID = ? ");
        $q->execute([$_POST['addCosts']]);
        $event = $q->fetch();
        logging('Customer', 'บันทึกข้อมูลข้อตกลงที่ทำให้เกิดค่าใช้จ่าย บริษัท ' . $event['BE_LocalName'] . ' โดย : ' . $_SESSION['Name']);
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
if (isset($_POST['editCustomer'])) {
    if ($_FILES['file']['name'] != '') {
        $image = '';
        $uploads_dir = '../../images/Customer/profile/';
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = time() . '_' .  rand(10, 9999) . '.' . $ext;
        $image = time() . '_' . rand(10, 9999) . '.' . $ext;
        $move = move_uploaded_file($tmp_name, "$uploads_dir/$image");
    } else {
        $image = $_POST['oldPic'];
    }
    $birth = ($_POST['c_birthday'] != '1970-01-01' ? $_POST['c_birthday'] : '');

    $u = $conn->prepare("update customer set c_profile = ?,c_position = ? ,c_firstname = ? ,c_lastname = ?, c_nickname = ?,c_tel = ? ,c_email = ? ,c_birthday = ? ,c_preference = ? ,c_jobdescrip = ? ,c_information = ? where c_id = ?  ");
    $u->execute([$image, $_POST['c_position'], $_POST['c_firstname'], $_POST['c_lastname'], $_POST['nickname'], $_POST['c_tel'], $_POST['c_email'], $birth, htmlspecialchars($_POST['c_preference']), htmlspecialchars($_POST['c_jobdescrip']), htmlspecialchars($_POST['c_information']), $_POST['editCustomer']]);
    if ($u) {
        echo json_encode(1);
        exit();
    } else {
        echo json_encode(0);
        exit();
    }
}

if (isset($_POST['image'])) {
    $q = $conn->prepare("select el_image From eventlog  where el_id = ?  ");
    $q->execute([$_POST['id']]);
    $event = $q->fetch();
    $im = explode(',', $event['el_image']);

?>
<div id="carouselExample" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <?php for ($i = 0; $i < count($im); $i++) {
                if ($i == 0) {
                    echo '<li data-bs-target="#carouselExample" data-bs-slide-to="' . $i . '" class="active"></li>';
                } else {
                    echo '<li data-bs-target="#carouselExample" data-bs-slide-to="' . $i . '" class="active"></li>';
                }
            } ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ($im as $k => $ims) {
                if ($k == 0) {
                    $active = 'active';
                } else {
                    $active = '';
                }
            ?>
        <div class="carousel-item <?= $active ?>">
            <img class="d-block w-100" src="../images/Customer/<?= $ims ?>" alt="<?= $k ?> slide"
                style="max-height: 680px;" />
            <div class="carousel-caption d-none d-md-block">
                <p><?= $ims ?>.</p>
            </div>
        </div>
        <?php } ?>

    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>
<?php }
if (isset($_GET['data'])) {
    $data = array();
    $q = $conn->prepare("select c_id,c_firstname,c_lastname from customer where be_id = ?");
    $q->execute([$_GET['data']]);
    $customer = $q->fetchall();
    foreach ($customer as $key => $cus) {
        $nesData = array();
        $nesData['id'] = $cus['c_id'];
        $nesData['text'] = $cus['c_firstname'] . ' ' . $cus['c_lastname'];
        $data[] = $nesData;
    }
    echo json_encode(['item' => $data]);
}

if (isset($_GET['tags'])) {
    $q = $conn->prepare("select es_id,es_name from EventSubject where es_name like ? order by es_name asc ");
    $q->execute(['%' . $_GET['tags'] . '%']);
    $event = $q->fetchall();
    foreach ($event as $key => $es) {
        $nesData = array();
        $nesData['id'] = $es['es_name'];
        $nesData['text'] = $es['es_name'];
        $data[] = $nesData;
    }
    echo json_encode($data);
}
if(isset($_POST['DelCustomer'])){
    $arr = [
     'BE_IsActive' => $_POST['DelCustomer'] == 0 ? 1 : 0,
     'BE_ID' => $_POST['be'],
    ];
    // print_r($arr);exit();
    $q = $conn->prepare("update businessentity set BE_IsActive = :BE_IsActive where BE_ID = :BE_ID
    ");
    $insert = $q->execute($arr);
    if ($insert) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}