<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
<?php require('../template/head.php') ?>

<style>
.select2-container--default .select2-selection--single {
    height: 38px !important;
    width: auto !important;
    padding: 6px;
}

.select2-selection__arrow {
    height: 30px !important;
}

.select2 {
    width: 100% !important;
}

.note-editable {
    text-align: left;
}
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php require('../template/menu.php') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php require('../template/nav.php') ?>

                <!-- / Navbar -->
                <?php $q = $conn->prepare("select SU_Name1,SU_Name2,BT_ID,BET_ID,BE_Code,BE_LocalName,BE_EnglishName,BE_country,BE_contact ,BE_address,BE_Website,BE_Telephone1,BE_Telephone2,BE_salesman,BE_IsActive,BE_VatType,BE_IsShowACCStars,BE_IsShowDimension,BE_support,BE_synErp,BE_createby
                 from businessentity left join systemuser on businessentity.BE_createby = systemuser.SU_Code
                 where BE_ID = ? ");
                $q->execute([$_GET['be']]);
                $com = $q->fetch();
                $tel = explode(',', $com['BE_Telephone1']);
                ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item">
                                    <a href="Customer.php">Customer Information </a>
                                </li>
                                <li class="breadcrumb-item" style="font-weight: bold;">
                                    Customer
                                </li>
                            </ol>
                        </nav>
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Company</h5>
                                    <small class="text-muted float-end">Company Info </small>
                                </div>
                                <div class="card-body">
                                    <form autocomplete="off" method="post" id="frmCompany">
                                        <input type="hidden" name="companyID" value="<?= $_GET['be'] ?>">
                                        <div class="row mb-3">
                                            <div class="col-sm-11 ">
                                            </div>
                                            <div class="col-sm-1">
                                                <?php if($_SESSION['role'] == 1 || $_SESSION['role'] == 2){ ?>

                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input"
                                                        onchange="changeActive(<?=$com['BE_IsActive']?>,<?=$_GET['be']?>)"
                                                        type="checkbox" id="flexSwitchCheckChecked" value="1"
                                                        name="BE_IsActive" id="Active"
                                                        <?= $com['BE_IsActive'] == 1 ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Is
                                                        Active</label>
                                                </div>
                                                <?php } ?>

                                            </div>
                                            <br>
                                            <br>
                                            <label class="col-sm-2 col-form-label" for="basic-default-code">Code</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control " id="basic-default-code"
                                                    name="BE_Code" <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    value="<?= $com['BE_Code'] ?>" tabindex="1" placeholder="">
                                            </div>

                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-code">Country</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control " id="basic-default-code"
                                                    name="BE_country" <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    value="<?= $com['BE_country'] ?>" tabindex="1" placeholder="">
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="basic-default-name">Company
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-name"
                                                    name="BE_EnglishName"
                                                    <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    value="<?= $com['BE_EnglishName'] ?> " />
                                            </div>
                                            <label class="col-sm-2 col-form-label" for="basic-default-name">Local
                                                NAME</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-name"
                                                    name="BE_LocalName" <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    value="<?= $com['BE_LocalName'] ?> " />
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <?php $bet = $conn->prepare("select bt_id,bt_code from businesstypes where bt_active = ? ");
                                            $bet->execute([1]);
                                            $bets = $bet->fetchall();
                                            ?>
                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-company">BusinessType</label>
                                            <div class="col-sm-4">
                                                <select name="BT_ID" <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    class="form-control" id="basic-default-BusinessType">
                                                    <option value=""> -- Select -- </option>
                                                    <?php foreach ($bets as $r) { ?>
                                                    <option value="<?= $r['bt_id'] ?>"
                                                        <?= ($r['bt_id'] == $com['BT_ID'] ? 'selected' : '') ?>>
                                                        <?= $r['bt_code'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <label class="col-sm-2 col-form-label" for="basic-default-name">Vat</label>
                                            <div class="col-sm-4">
                                                <select name="vat" <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    class="form-control" id="basic-default-VAT">
                                                    <option value="" selected> -- Select -- </option>
                                                    <option value="1"
                                                        <?= ($com['BE_VatType'] == 1 ? 'selected' : '') ?>> Include Vat
                                                    </option>
                                                    <option value="2"
                                                        <?= ($com['BE_VatType'] == 2 ? 'selected' : '') ?>> Exclude Vat
                                                    </option>
                                                    <option value="3"
                                                        <?= ($com['BE_VatType'] == 3 ? 'selected' : '') ?>> No Vat
                                                    </option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-email">ADDRESS</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="BE_address"
                                                    <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    class="form-control" value="<?= $com['BE_address'] ?>" id="">
                                            </div>
                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-email">Website</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="BE_Website"
                                                    <?= $com['BE_synErp'] == 1 ? 'readonly' : ''; ?>
                                                    class="form-control" value="<?= $com['BE_Website'] ?>" id="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="basic-default-Update">Contact
                                                Person</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-Update"
                                                    name="BE_contact" value="<?= $com['BE_contact']  ?>"
                                                    <?= $com['BE_synErp'] == 1 ? 'readonly' : '' ?>>
                                            </div>

                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-name">Telephone</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control phone-mask" name="tel[]"
                                                        <?= $com['BE_synErp'] == 1 ? 'readonly' : '' ?>
                                                        id="basic-default-phone" value="<?= $tel[0] ?>"
                                                        placeholder="08 xxx xxxx" aria-label="08 xxx xxxx"
                                                        aria-describedby="basic-default-phone">
                                                    <button class="btn btn-sm btn-outline-success" type="button"
                                                        id="button-addon2"><i class='bx bx-plus'></i></button>
                                                </div>
                                            </div>


                                        </div>
                                        <?php for ($i = 1; count($tel) > $i; $i++) { ?>
                                        <div class="row mb-3" id="appendTel_<?= $i ?>">
                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-name">Telephone</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control phone-mask" name="tel[]"
                                                        <?= $com['BE_synErp'] == 1 ? 'readonly' : '' ?>
                                                        id="basic-default-phone" value="<?= $tel[$i] ?>"
                                                        placeholder="08 xxx xxxx" aria-label="08 xxx xxxx"
                                                        aria-describedby="basic-default-phone">
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="delTel(<?= $i ?>)" type="button" id="button-addon2"><i
                                                            class="bx bx-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div id="addTel"></div>
                                        <?php $q = $conn->prepare("select s_id,s_name from Sales where s_active = ? ");
                                        $q->execute([1]);
                                        $sale = $q->fetchall();
                                        ?>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"
                                                for="basic-default-email">Salesman</label>
                                            <div class="col-sm-2">
                                                <select name="BE_salesman" id="Salesman" class="form-control">
                                                    <option value="" selected disabled> -- Select -- </option>
                                                    <?php foreach ($sale as $s) {
                                                        echo '<option value="' . $s['s_id'] . '" ' . ($s['s_id'] == $com['BE_salesman'] ? 'selected' : '') . '> ' . $s['s_name'] . ' </option>';
                                                    } ?>
                                                </select>

                                            </div>
                                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Sales
                                                Support</label>
                                            <div class="col-sm-2">
                                                <select name="BE_support" id="Sales" class="form-control">
                                                    <option value="" selected disabled> -- Select -- </option>
                                                    <?php
                                                    $sq = $conn->prepare("select sp_id,sp_name  from support where s_active = ? ");
                                                    $sq->execute([1]);
                                                    $sup = $sq->fetchall();
                                                    foreach ($sup as $sp) {
                                                        echo '<option value="' . $sp['sp_id'] . '" ' . ($sp['sp_id'] == $com['BE_support'] ? 'selected' : '') . ' > ' . $sp['sp_name'] . ' </option>';
                                                    } ?>
                                                </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label" for="basic-default-Update">Last
                                                Update</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="basic-default-Update"
                                                    value="<?= $com['SU_Name1'] != '' ? $com['SU_Name1'] : $com['SU_Name2'] ?>"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" align="right">
                                            <button type="button" class="btn btn-primary" id="company">Save
                                                changes</button>
                                        </div>
                                    </form>
                                    <br>
                                    <h5 class="card-header">
                                        <button type="button" class="btn btn-icon btn-outline-primary float-end"
                                            data-bs-toggle="modal" data-bs-target="#ModalCustomer"><i
                                                class='bx bx-plus'></i></button>
                                    </h5>
                                    <br>
                                    <?php $q = $conn->prepare("select c_id,c_profile,c_firstname,c_lastname,c_nickname,c_position,c_tel,c_email,c_birthday,c_jobdescrip,c_status from customer where be_id = ? order by c_status asc ");
                                    $q->execute([$_GET['be'], 4]);
                                    $customer = $q->fetchall();
                                    $cus_array = array();
                                    ?>
                                    <div class="table-responsive text-wrap">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%">#</th>
                                                    <th style="width:12%">Profile</th>
                                                    <th style="width:12%">Position</th>
                                                    <th style="width:12%">Name</th>
                                                    <th style="width:12%">Phone No.</th>
                                                    <th style="width:12%">Email</th>
                                                    <th style="width:12%">Job description</th>
                                                    <th style="width:12%">Status</th>
                                                    <th style="width:12%">Birth Date</th>
                                                </tr>
                                            </thead>
                                            <?= ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) && $cus['c_status'] == '4' ? '' : (($_SESSION['role'] != 1 || $_SESSION['role'] != 2) && $cus['c_status'] == '4' ? 'style="display:none";' : '') ?>
                                            <tbody class="table-border-bottom-0">
                                                <?php foreach ($customer as $key => $cus) {
                                                    if(($_SESSION['role'] == 1 || $_SESSION['role'] == 2) && ($cus['c_status'] == 1 || $cus['c_status'] == 3) ){
                                                        $cus_array[$cus['c_id']] = $cus['c_firstname'] . ' ' . $cus['c_lastname'];
                                                ?>
                                                <tr
                                                    <?=$cus['c_status'] == '4' ? 'style="text-decoration:line-through"' : ''; ?>>
                                                    <td><?= $key + 1 ?></td>
                                                    <td>
                                                        <ul
                                                            class="list-unstyled users-list m-0 d-flex align-items-center">
                                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-bs-placement="top" class="avatar avatar-xl pull-up"
                                                                title="<?= $cus['c_firstname'] ?> <?= $cus['c_lastname'] ?>">
                                                                <a href="PersonInfo.php?cid=<?= $cus['c_id'] ?>"> <img
                                                                        src="../images/Customer/profile/<?= $cus['c_profile'] != '' ? $cus['c_profile'] : '149071.png'; ?>"
                                                                        alt="Avatar" class="rounded-circle" /> </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td><?= $cus['c_position'] ?></td>
                                                    <td> <a href="PersonInfo.php?cid=<?= $cus['c_id'] ?>">
                                                            <?= $cus['c_firstname'] ?> <?= $cus['c_lastname'] ?>
                                                            <?= $cus['c_nickname'] != '' ? '( ' . $cus['c_nickname'] . ' )' : '' ?>
                                                        </a> </td>
                                                    <td><?= $cus['c_tel'] ?></td>
                                                    <td><?= $cus['c_email'] ?></td>
                                                    <td><?= htmlspecialchars_decode($cus['c_jobdescrip']) ?></td>
                                                    <td>
                                                        <select name="status"
                                                            onchange="changestatus(<?= $cus['c_id'] ?>,this.value);"
                                                            class="form-control">
                                                            <option value="1"
                                                                <?= $cus['c_status'] == 1 ? 'selected' : ''; ?>> ทำงาน
                                                            </option>
                                                            <option value="3"
                                                                <?= $cus['c_status'] == 3 ? 'selected' : ''; ?>> พักงาน
                                                            </option>
                                                            <option value="2"
                                                                <?= $cus['c_status'] == 2 ? 'selected' : ''; ?>> ลาออก
                                                            </option>
                                                            <?= $_SESSION['role'] == 1 || $_SESSION['role'] == 2 ? '<option value="4" '.($cus['c_status'] == 4 ? 'selected' : '').' > ซ่อน </option>' : ''; ?>
                                                        </select>
                                                    </td>
                                                    <td><?= $cus['c_birthday'] != '' && $cus['c_birthday'] != '0000-00-00' ? dateTh($cus['c_birthday']) : ''; ?>
                                                    </td>
                                                </tr>
                                                <?php }elseif($cus['c_status'] <> '4'){ ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td>
                                                        <ul
                                                            class="list-unstyled users-list m-0 d-flex align-items-center">
                                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-bs-placement="top" class="avatar avatar-xl pull-up"
                                                                title="<?= $cus['c_firstname'] ?> <?= $cus['c_lastname'] ?>">
                                                                <a href="PersonInfo.php?cid=<?= $cus['c_id'] ?>"> <img
                                                                        src="../images/Customer/profile/<?= $cus['c_profile'] != '' ? $cus['c_profile'] : '149071.png'; ?>"
                                                                        alt="Avatar" class="rounded-circle" /> </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td><?= $cus['c_position'] ?></td>
                                                    <td> <a href="PersonInfo.php?cid=<?= $cus['c_id'] ?>">
                                                            <?= $cus['c_firstname'] ?> <?= $cus['c_lastname'] ?>
                                                            <?= $cus['c_nickname'] != '' ? '( ' . $cus['c_nickname'] . ' )' : '' ?>
                                                        </a> </td>
                                                    <td><?= $cus['c_tel'] ?></td>
                                                    <td><?= $cus['c_email'] ?></td>
                                                    <td><?= htmlspecialchars_decode($cus['c_jobdescrip']) ?></td>
                                                    <td>
                                                        <select name="status"
                                                            onchange="changestatus(<?= $cus['c_id'] ?>,this.value);"
                                                            class="form-control">
                                                            <option value="1"
                                                                <?= $cus['c_status'] == 1 ? 'selected' : ''; ?>> ทำงาน
                                                            </option>
                                                            <option value="3"
                                                                <?= $cus['c_status'] == 3 ? 'selected' : ''; ?>> พักงาน
                                                            </option>
                                                            <option value="2"
                                                                <?= $cus['c_status'] == 2 ? 'selected' : ''; ?>> ลาออก
                                                            </option>
                                                            <?= $_SESSION['role'] == 1 || $_SESSION['role'] == 2 ? '<option value="4" '.($cus['c_status'] == 4 ? 'selected' : '').' > ซ่อน </option>' : ''; ?>
                                                        </select>
                                                    </td>
                                                    <td><?= $cus['c_birthday'] != '' && $cus['c_birthday'] != '0000-00-00' ? dateTh($cus['c_birthday']) : ''; ?>
                                                    </td>
                                                </tr>
                                                <?php }} ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-header">Event Log
                                        <button type="button" class="btn btn-icon btn-outline-primary float-end"
                                            id="LogModal" data-bs-toggle="modal" data-bs-target="#eventlogModal"><i
                                                class='bx bx-plus'></i></button>
                                    </h5>

                                    <?php $el = $conn->prepare("select el_id,el_subject,el_branch,el_date,el_product,el_image,el_description,el_active from eventlog where be_id = ? and el_active = ? order by el_id desc ");
                                    $el->execute([$_GET['be'] , 1]);
                                    $event = $el->fetchall();
                                    ?>
                                    <div class="table-responsive text-wrap">
                                        <table class="table table-striped tableData">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="10%">Subject</th>
                                                    <th width="10%">Branch</th>
                                                    <th width="12%">Effective Date</th>
                                                    <th width="12%">CONTACT PERSON</th>
                                                    <th width="7%">Image</th>
                                                    <th width="38%">Description</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <?php foreach ($event as $k => $events) {
                                                    $image = $events['el_image'];
                                                ?>
                                                <tr>
                                                    <td><?= ($k + 1) ?></td>
                                                    <td><?= $events['el_subject'] ?></td>
                                                    <td><?= $events['el_branch'] ?></td>
                                                    <td><?= dateth($events['el_date']) ?></td>
                                                    <td><?= str_replace('/',' / ',$events['el_product']); ?></td>
                                                    <td>
                                                        <?php if ($image != '') { ?>
                                                        <button type="button"
                                                            onclick="imagemodal(<?= $events['el_id'] ?>)"
                                                            class="btn btn-sm btn-primary " data-bs-toggle="modal"
                                                            data-bs-target="#ImageModal">
                                                            ไฟล์แนบ
                                                        </button>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= htmlspecialchars_decode($events['el_description']) ?></td>
                                                    <td>
                                                        <!-- <button onclick="Clickeventlog(<?= $events['el_id'] ?>,0)" class="btn btn-icon btn-outline-info float-end">
                                                                <i class='bx bx-detail'></i>
                                                            </button> -->
                                                        <button onclick="Clickeventlog(<?= $events['el_id'] ?>,1)"
                                                            class="btn btn-icon btn-outline-warning float-end"><i
                                                                class='bx bx-edit'></i></button>
                                                        <?php if($_SESSION['role'] == 1 || $_SESSION['role'] == 2){ ?>
                                                        <button
                                                            onclick="ClickeventlogDel(<?= $events['el_id'] ?>,<?= $events['el_active'] ?>)"
                                                            class="btn btn-icon btn-outline-danger float-end">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                        <?php  } ?>
                                                        <?php //if (time() - strtotime($events['el_date']) < 604800) {  #ปุ่ม edit ข้อมูล (ภายใน 24 ชั่วโมง เผื่อพิมพ์ผิด ณ ตอนนั้น )  ?>
                                                        <?php // } ?>
                                                    </td>

                                                </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <?php $qc = $conn->prepare("select cs_date,cs_product,cs_description from costsbusiness where be_id = ? order by cs_id desc ");
                                    $qc->execute([$_GET['be']]);
                                    $cost = $qc->fetchall();
                                    ?>
                                    <h5 class="card-header">Costs <button type="button"
                                            class="btn btn-icon btn-outline-primary float-end" data-bs-toggle="modal"
                                            data-bs-target="#costsModal"><i class='bx bx-plus'></i></button></h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-striped tableData">
                                            <thead>
                                                <tr>
                                                    <th>Effective Date</th>
                                                    <th style="width: 20%;">Product</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <?php foreach ($cost as $costs) { ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($costs['cs_date'])) ?></td>
                                                    <td><?= $costs['cs_product'] ?></td>
                                                    <td><?= htmlspecialchars_decode($costs['cs_description']) ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal fade" id="eventlogModal" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel3"> Event Log </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form autocomplete="off" id="addEventlog" enctype="multipart/form-data">
                                        <input type="hidden" name="addEventlog" value="<?= $_GET['be'] ?>">
                                        <input type="hidden" name="IdEventlog" id="IdEventlog" value="">
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="dobLarge" class="form-label">Subject</label>
                                                <select name="el_subject" class="tags" id="tags" required>
                                                    <?php $q = $conn->prepare("select es_id,es_name from EventSubject order by es_name asc ");
                                                    $q->execute();
                                                    $event = $q->fetchall();
                                                    foreach ($event as $key => $es) {
                                                        if($es['es_name'] != ''){
                                                            echo '<option value="' . $es['es_name'] . '"> ' . $es['es_name'] . ' </option>';
                                                        }
                                                    } ?>
                                                </select>

                                            </div>
                                            <div class="col mb-0">
                                                <label for="personLarge" class="form-label"> Branch </label>
                                                <input type="text" id="Branch" name="el_branch" class="form-control"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="dobLarge" class="form-label">Date</label>
                                                <input class="form-control date" type="text" name="dobLarge"
                                                    value="<?= date('d/m/Y') ?>" data-date-format="DD MMMM YYYY"
                                                    id="eventDate">
                                            </div>

                                            <div class="col mb-0">
                                                <label for="personLarge" class="form-label">Contact person </label>

                                                <select class="form-control Product" id="Product" multiple
                                                    name="Product[]" required>
                                                    <?php foreach ($cus_array as $k => $r) {
                                                        echo '<option value="' . $r . '">' . $r . '</option>';
                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFileMultiple" class="form-label"> Image <small> ( limit 5
                                                    files ) </small></label>
                                            <div id="imageLink"></div>
                                            <input class="form-control" type="file" name="file[]" id="formFileMultiple"
                                                accept="image/*" multiple />
                                            <input type="hidden" id="oldfile" name="oldfile" class="form-control"
                                                placeholder="" />
                                        </div>

                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Description</label>
                                                <textarea name="Description" class="form-control" id="Description"
                                                    cols="30" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel3"> Follow up </h5>
                                        </div>
                                        <br>
                                        <button type="button" id="RemoveTrFollow"
                                            class="btn-sm btn btn-outline-danger"><i class='bx bx-minus'></i></button>
                                        <button type="button" id="AddTrFollow" class="btn-sm btn btn-outline-success"><i
                                                class='bx bx-plus'></i></button>
                                        <input type="hidden" name="followup">
                                        <table class="table-bordered tablerow"
                                            style="text-align:center;width:100%;margin-top: 8px;">
                                            <thead>
                                                <tr>
                                                    <th>Issue</th>
                                                    <th>Date</th>
                                                    <th style="width:150px;">Status<br>(Process/Done)</th>
                                                    <th>CreateBy</th>
                                                    <th>Created</th>
                                                    <?= $_SESSION['role'] == 1 || $_SESSION['role'] == 2 ? '<th>Option</th>' : '' ?>
                                                </tr>
                                            </thead>
                                            <tbody id="tableFollow">

                                            </tbody>
                                        </table>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="frmEventlog" data-type="add">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form autocomplete="off" id="addCosts" enctype="multipart/form-data">
                        <div class="modal fade" id="costsModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel3"> Costs </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="addCosts" value="<?= $_GET['be'] ?>">
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="dobLarge" class="form-label">Date</label>
                                                <input class="form-control date" type="text" name="dobLarge"
                                                    value="<?= date('d/m/Y') ?>" data-date-format="DD MMMM YYYY"
                                                    id="html5-date-input">
                                            </div>
                                            <div class="col mb-0">
                                                <label for="personLarge" class="form-label">Product </label>
                                                <input type="text" id="person" name="Product" class="form-control"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Description</label>
                                                <textarea name="Description" id="CostsDescription" class="form-control"
                                                    cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary" id="frmCosts">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal fade" id="ImageModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel3"> Expenses </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="eventimageModal">



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form autocomplete="off" id="frmCustomer" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="addcustomer" value="addcustomer">
                        <input type="hidden" name="business" value="<?= $_GET['be'] ?>">
                        <div class="modal fade" id="ModalCustomer" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel3"> Add Customer </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">


                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-12" align="center">
                                                    <img src="../assets/img/avatars/cloud-2044823.png" alt="Avatar"
                                                        class="rounded-circle" id="uploadedAvatar" height="200"
                                                        width="200" />
                                                    <br>
                                                    <br>
                                                    <div class="button-wrapper">
                                                        <label for="upload" class="btn btn-primary me-2 mb-4"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload new photo</span>
                                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                                            <input type="file" id="upload" class="account-file-input"
                                                                name="file" hidden accept="image/png, image/jpeg" />
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-firstname">Firstname</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control "
                                                        id="basic-default-firstname" name="firstname" tabindex="1"
                                                        placeholder="">
                                                </div>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-Lastname">Lastname</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control " id="basic-default-Lastname"
                                                        name="lastname" tabindex="1" placeholder="">
                                                </div>
                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-Nickname">Nickname</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control " id="basic-default-Nickname"
                                                        name="nickname" tabindex="1" placeholder="">
                                                </div>
                                                <label class="col-sm-2 col-form-label" for="basic-default-tel">Phone
                                                    No.</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control " id="basic-default-tel"
                                                        name="tel" tabindex="1" placeholder="">
                                                </div>

                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-email">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="email" class="form-control " id="basic-default-email"
                                                        name="email" tabindex="1" placeholder="john@example.com">
                                                </div>
                                                <label class="col-sm-2 col-form-label" for="basic-default-birth">Birth
                                                    Day</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control  date"
                                                        id="basic-default-birth" name="birth" tabindex="1"
                                                        placeholder="">
                                                </div>

                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-position">Position</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control " id="basic-default-position"
                                                        name="position" tabindex="1" placeholder="">
                                                </div>


                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-job">Job</label>
                                                <div class="col-sm-10">
                                                    <textarea name="job" class="form-control" cols="30"
                                                        rows="2"></textarea>
                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-private">Preference</label>
                                                <div class="col-sm-10">
                                                    <textarea name="private" class="form-control" cols="30"
                                                        rows="2"></textarea>
                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <label class="col-sm-2 col-form-label"
                                                    for="basic-default-special">Special Information</label>
                                                <div class="col-sm-10">
                                                    <textarea name="special" class="form-control" cols="30"
                                                        rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 col-md-12" style="text-align: right;">
                                            <button class="btn btn-primary " id="customer" type="button"> Save </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php require('../template/footer.php') ?>
</body>

<script>
function datepick() {
    $('.date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
    });
}

function Clickeventlog(x, set) {
    $.ajax({
        url: '../controller/Customer/Customerinfo.php',
        type: 'POST',
        data: {
            seeEvent: x
        },
        dataType: 'json',
        success: function(data) {
            $("#eventlogModal").modal('show');
            var f = new Date(data.event.el_date);
            var month = f.getMonth() < 10 ? '0' + (f.getMonth() + 1) : (f.getMonth() + 1);
            var day = f.getDate() < 10 ? '0' + f.getDate() : f.getDate();
            var formattedDate = [day, (month), f.getFullYear()].join('/');
            var append = '';
            $("#tableFollow").html('');
            if (set == 0) {
                if (data.follow.length > 0) {
                    $.each(data.follow, function(i, r) {
                        var fu_date = new Date(r.fu_date);
                        var fu_created = new Date(r.fu_created);
                        var detail = r.fu_issue.replace("<p>", "");
                        detail = r.fu_issue.replace("</p>", "");
                        // var hasName = (r.fu_status == 1) ? 'Process' : 'Done';
                        // onchange="ChangStatus('+r.fu_id+',this.value)"
                        append += '<tr id="' + r.fu_id + '">' +
                            '<td style="width:46%;" id="add"> <input name="editIDFU[]" value="' + r
                            .fu_id + '" style="display:none;" >' +
                            '<input type="text" name="issue[]" value="' + r.fu_issue +
                            '" class="form-control" placeholder="Title"> ' +
                            ' </td>' +
                            '<td style="width:13%">' + fu_date.getDate() + '/' + (fu_date
                                .getMonth() + 1) + '/' + fu_date.getFullYear() + '</td>' +
                            // '<td style="width:10%">  ' + hasName + ' </td>' +
                            '<td style="width:10%">' +
                            '    <select name="status[]" class="form-control" >' +
                            '        <option value="1" ' + (r.fu_status == 1 ? 'selected' : '') +
                            ' >Process</option>' +
                            '        <option value="2" ' + (r.fu_status == 2 ? 'selected' : '') +
                            ' >Done</option>' +
                            '    </select>' +
                            '</td>' +
                            '<td style="width:18%" style="width: 15%;">' + r.name + '</td>' +
                            '<td style="width:13%">' + fu_created.getDate() + '/' + (fu_created
                                .getMonth() + 1) + '/' + fu_created.getFullYear() + '</td>';
                        <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { ?>
                        append += '<td>  <button type="button" onclick="DeleteEventlog(' + r.fu_id +
                            ',' + set +
                            ')" class="btn btn-icon btn-outline-danger float-end"><i class="bx bx-trash"></i></button></td>';
                        <?php } ?>
                        append += '</tr>';
                        append +=
                            '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';
                        append += '<tr id="' + r.fu_id +
                            '_1"><td colspan="6"><textarea  name="editdetail[]" class="form-control eventDescription" rows="3" > ' +
                            r.fu_detail + ' </textarea></td></tr>';

                        // append += '<tr id="' + r.fu_id + '_1"><td colspan="6" style="text-align : left;padding : 5px;" ><strong> Detail : </strong> ' + detail + '</td></tr>';

                    })

                }
                append += '<tr>' +
                    '<td style="width:46%" id="add">' +
                    '  <input type="text" name="issue[]" class="form-control" placeholder="Title"> ' +
                    // '    <textarea  name="issue[]" class="form-control eventDescription">   </textarea>' +
                    '</td>' +
                    '<td style="width:13%">' +
                    '    <input type="text" class="input-sm form-control date" name="date[]" placeholder="" value="<?= date('d/m/Y') ?>" name="ShipmentDate2" />' +
                    '</td>' +
                    '<td style="width:10%">' +
                    '    <select name="status[]" class="form-control">' +
                    '        <option value="1">Process</option>' +
                    '        <option value="2">Done</option>' +
                    '    </select>' +
                    '</td>' +
                    '<td style="width:18%" style="width: 15%;"><?= $_SESSION['Name'] ?></td>' +
                    '<td style="width:13%"><?= date('d/m/Y') ?></td>';
                <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { ?>
                append += '<td> </td>';
                <?php } ?>
                append += '</tr>';
                append += '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';

                append +=
                    '<tr><td colspan="6"><textarea  name="detail[]" class="form-control eventDescription" rows="3" >  </textarea></td></tr>';
                $("#tableFollow").append(append);
                $("#eventDate").val(data.event.el_date).attr('readonly', true);
                $("#person").val(data.event.el_product).attr('readonly', true);
                $("input[name='followup']").val(data.event.el_id);
                $("#formFileMultiple").hide();
                $("#imageLink").html('<button type="button" onclick="imagemodal(' + data.event.el_id +
                    ')" class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#ImageModal">ไฟล์แนบ</button>'
                );

                var ProductOption = new Option(data.event.el_product, data.event.el_product, true, true);
                $('#Product').append(data.event.el_product).trigger('change');
                $("#Product").select2({
                    dropdownParent: $('#eventlogModal'),
                    disabled: 'readonly'
                });

                var newOption = new Option(data.event.el_subject, data.event.el_subject, true, true);
                $('#tags').append(newOption).trigger('change');
                $("#tags").select2({
                    dropdownParent: $('#eventlogModal'),
                    disabled: 'readonly'
                });
                $("#Branch").val(data.event.el_branch).attr('readonly', true);
                $("#Description").summernote("code", data.event.el_description);
                $("#Description").summernote("disable");
                $("#IdEventlog").val('')
                $("#frmEventlog").text('Add Issue');
                $("#frmEventlog").attr('data-type', 'follow');

            } else {
                $("#IdEventlog").val(data.event.el_id);
                if (data.follow.length > 0) {
                    $.each(data.follow, function(i, r) {
                        var fu_date = new Date(r.fu_date);
                        var fu_created = new Date(r.fu_created);
                        var hasName = (r.fu_status == 1) ? 'Process' : 'Done';

                        // append += '<tr id="' + r.fu_id + '">' +
                        //     '<td style="width:46%;" id="add">' + r.fu_issue + '  </td>' +
                        //     '<td style="width:13%">' + fu_date.getDate() + '/' + (fu_date.getMonth() + 1) + '/' + fu_date.getFullYear() + '</td>' +
                        //     '<td style="width:10%">' + hasName + ' </td>' +
                        //     '<td style="width:18%" style="width: 15%;">' + r.name + '</td>' +
                        //     '<td style="width:13%">' + fu_created.getDate() + '/' + (fu_created.getMonth() + 1) + '/' + fu_created.getFullYear() + '</td>';
                        // <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { ?>
                        //     append += '<td>  <button type="button" onclick="DeleteEventlog(' + r.fu_id + ',' + set + ')" class="btn btn-icon btn-outline-danger float-end"><i class="bx bx-trash"></i></button></td>';
                        // <?php } ?>
                        // append += '</tr>';
                        var fu_date = new Date(r.fu_date);
                        var fu_created = new Date(r.fu_created);
                        var detail = r.fu_issue.replace("<p>", "");
                        detail = r.fu_issue.replace("</p>", "");
                        // var hasName = (r.fu_status == 1) ? 'Process' : 'Done';
                        append += '<tr id="' + r.fu_id + '">' +
                            '<td style="width:46%;" id="add"> <input name="editIDFU[]" value="' + r
                            .fu_id + '" style="display:none;" >' +
                            '<input type="text" name="editissue[]" value="' + r.fu_issue +
                            '" class="form-control" placeholder="Title"> ' +
                            ' </td>' +
                            '<td style="width:13%">' + fu_date.getDate() + '/' + (fu_date
                                .getMonth() + 1) + '/' + fu_date.getFullYear() + '</td>' +
                            // '<td style="width:10%">  ' + hasName + ' </td>' +
                            '<td style="width:10%">' +
                            '    <select name="editstatus[]" class="form-control" >' +
                            '        <option value="1" ' + (r.fu_status == 1 ? 'selected' : '') +
                            ' >Process</option>' +
                            '        <option value="2" ' + (r.fu_status == 2 ? 'selected' : '') +
                            ' >Done</option>' +
                            '    </select>' +
                            '</td>' +
                            '<td style="width:18%" style="width: 15%;">' + r.name + '</td>' +
                            '<td style="width:13%">' + fu_created.getDate() + '/' + (fu_created
                                .getMonth() + 1) + '/' + fu_created.getFullYear() + '</td>';
                        <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { ?>
                        append += '<td>  <button type="button" onclick="DeleteEventlog(' + r.fu_id +
                            ',' + set +
                            ')" class="btn btn-icon btn-outline-danger float-end"><i class="bx bx-trash"></i></button></td>';
                        <?php } ?>
                        append += '</tr>';
                        append +=
                            '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';
                        append += '<tr id="' + r.fu_id +
                            '_1"><td colspan="6"><textarea  name="editdetail[]" class="form-control eventDescription" rows="3" > ' +
                            r.fu_detail + ' </textarea></td></tr>';
                    })

                }

                append += '<tr>' +
                    '<td style="width:46%" id="add">' +
                    '<input type="text" name="issue[]" class="form-control" placeholder="Title"> ' +
                    // '<textarea  name="issue[]" class="form-control eventDescription" readonly>  </textarea>' +
                    '</td>' +
                    '<td style="width:13%">' +
                    '    <input type="text" class="input-sm form-control date" name="date[]" placeholder="" value="<?= date('d/m/Y') ?>" name="ShipmentDate2" />' +
                    '</td>' +
                    '<td style="width:10%">' +
                    '    <select name="status[]" class="form-control">' +
                    '        <option value="1">Process</option>' +
                    '        <option value="2">Done</option>' +
                    '    </select>' +
                    '</td>' +
                    '<td style="width:18%" style="width: 15%;"><?= $_SESSION['Name'] ?></td>' +
                    '<td style="width:13%"><?= date('d/m/Y') ?></td>' +
                    '<td></td>' +
                    '</tr>';
                append += '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';

                append +=
                    '<tr><td colspan="6"><textarea  name="detail[]" class="form-control eventDescription" rows="3" >  </textarea></td></tr>';
                $("#tableFollow").append(append);
                $("#eventDate").val(data.event.el_date);
                $("#person").val(data.event.el_product);
                $("#oldfile").val(data.event.el_image);
                $("#formFileMultiple").show();
                $("#imageLink").html('');
                // console.log(data.event.el_product);
                // var ProductOption = new Option(data.event.el_product, data.event.el_product, true, true);
                $('#Product').val(data.event.el_product).trigger('change');

                $("#Product").select2({
                    dropdownParent: $('#eventlogModal'),
                    tags: true,
                    multiple: true,
                    // tokenSeparators: [','],
                });

                var newOption = new Option(data.event.el_subject, data.event.el_subject, true, true);
                $('#tags').append(newOption).trigger('change');
                $('#tags').select2({
                    dropdownParent: $('#eventlogModal'),
                    tags: true,
                    disabled: '',
                    tokenSeparators: [','],
                });

                $("#Branch").val(data.event.el_branch);
                $("#Description").summernote("code", data.event.el_description);
                $("#IdEventlog").val(data.event.el_id)
                $("#frmEventlog").text('Update');
                $("#frmEventlog").attr('data-type', 'add');
            }

            datepick();

            textsummer('.eventDescription');


        }
    })

}

function ChangStatus(x, val) {

    var r = confirm("ต้องการเปลี่ยนสถานะหรือไม่ ? ");
    if (r === true) {
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: {
                ChangStatus: x,
                Status: val,
            },
            dataType: 'json',
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                }).then((result) => {
                    // $("#EventModal").modal('hide');
                    // location.reload();
                });
            }
        })
    }

}

function DeleteEventlog(x, set) {
    var r = confirm("ต้องการลบรายการนี้ใช่หรือไม่ ? ");
    if (r === true) {
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: {
                DelFollow: x
            },
            dataType: 'json',
            success: function(data) {
                if (data == 1) {
                    // Clickeventlog(event, set);
                    $("#" + x).fadeOut();
                    $("#" + x + '_1').fadeOut();
                }
            }
        })
    }


}

function ClickeventlogDel(id, sta) {
    if (sta == 1) {
        var r = confirm("ต้องการซ่อนรายการนี้ใช่หรือไม่ ? ");
    } else {
        var r = confirm("ต้องการโชว์รายการนี้ใช่หรือไม่ ? ");
    }
    if (r === true) {
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: {
                DelEvent: id,
                status: sta
            },
            dataType: 'json',
            success: function(data) {
                location.reload();
            }
        })
    }
}

function changeActive(x, be) {
    if (x == 1) {
        var r = confirm("ต้องการซ่อนรายการนี้ใช่หรือไม่ ? ");
    } else {
        var r = confirm("ต้องการโชว์รายการนี้ใช่หรือไม่ ? ");
    }
    if (r === true) {
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: {
                DelCustomer: x,
                be: be
            },
            dataType: 'json',
            success: function(data) {
                location.reload();
            }
        })
    }
}

function textsummer(x) {
    $(x).summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
        ],
        height: 100

    });
}
$(function() {



    $("#RemoveTrFollow").click(function() {
        $(".tablerow tr:last").remove();
    })
    $("#AddTrFollow").click(function() {
        //  <textarea  name="issue[]" class="form-control eventDescription" readonly>   </textarea>
        var append = '';
        append += '<tr><td colspan="6"><br></td></tr>' +
            '<tr class="addRow">' +
            '<td style="width:46%" id="add">' +
            '  <input type="text" name="issue[]" class="form-control" placeholder="Title"> ' +
            '</td>' +
            '<td style="width:13%">' +
            '    <input type="text" class="input-sm form-control date" name="date[]" placeholder="" value="<?= date('d/m/Y') ?>" name="ShipmentDate2" />' +
            '</td>' +
            '<td style="width:10%">' +
            '    <select name="status[]" class="form-control">' +
            '        <option value="1">Process</option>' +
            '        <option value="2">Done</option>' +
            '    </select>' +
            '</td>' +
            '<td style="width:18%" style="width: 15%;"><?= $_SESSION['Name'] ?></td>' +
            '<td style="width:13%"><?= date('d/m/Y') ?></td>' +
            '<td></td>' +
            '</tr>';
        append += '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';

        append +=
            '<tr><td colspan="6"><textarea  name="detail[]" class="form-control eventDescription" rows="3" >  </textarea></td></tr>';

        $("#tableFollow").append(append);
        textsummer('.eventDescription');
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    })

    $("#LogModal").click(function() {
        $("#frmEventlog").attr('data-type', 'add');
        $("#tableFollow").html('');
        $("#IdEventlog").val('');
        $("input[name='followup']").val('');
        $("#imageLink").html('');
        $("#formFileMultiple").show();

        var append = '';
        append += '<tr>' +
            '<td id="add">' +
            // '    <textarea  name="issue[]" class="form-control eventDescription" rows="3" >  </textarea>' +
            '  <input type="text" name="issue[]" class="form-control" placeholder="Title"> ' +
            '</td>' +
            '<td style="width:13%">' +
            '    <input type="text" class="input-sm form-control date" name="date[]" placeholder="" value="<?= date('d/m/Y') ?>" name="ShipmentDate2" />' +
            '</td>' +
            '<td style="width:10%">' +
            '    <select name="status[]" class="form-control">' +
            '        <option value="1">Process</option>' +
            '        <option value="2">Done</option>' +
            '    </select>' +
            '</td>' +
            '<td style="width:18%" style="width: 15%;"><?= $_SESSION['Name'] ?></td>' +
            '<td style="width:13%"><?= date('d/m/Y') ?></td>' +
            '<td></td>' +
            '</tr>';
        append += '<tr><th colspan="6" style="text-align:left; padding:8px"> Detail </th></tr>';
        append +=
            '<tr><td colspan="6"><textarea  name="detail[]" class="form-control eventDescription" rows="3" ></textarea></td></tr>';

        $("#tableFollow").append(append);
        textsummer('.eventDescription');
        datepick();
    })

    $('#tableAdd').dataTable({
        "searching": false,
        "paging": false,
    });
    textsummer('#Description');

    $('#CostsDescription').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
        ]
    });

    $('#eventlogModal').on('hidden.bs.modal', function() {
        $("#eventDate").val('').attr('readonly', false);
        $("#person").val('').attr('readonly', false);
        $("#Description").summernote("code", '');
        $("#Description").summernote("enable");
        var newOption = new Option('', '', true, true);
        $('#tags').append(newOption).trigger('change');
        $('.tags').select2({
            dropdownParent: $('#eventlogModal'),
            tags: true,
            disabled: '',
            tokenSeparators: [','],
            // ajax: {
            //     url: '../controller/Customer/Customerinfo.php?tags',
            //     dataType: 'json',
            //     type: "GET",
            //     quietMillis: 50,
            //     data: function(params) {
            //         return {
            //             q: $.trim(params.term)
            //         };
            //     },
            //     processResults: function(response) {
            //         return {
            //             results: response
            //         };
            //     },
            //     cache: true
            // },
        });
        $("#Branch").val('').attr('readonly', false);

        $("#frmEventlog").show();
    })

    $(".table").dataTable({
        aLengthMenu: [
            [5, 20, 40, 60, -1],
            [5, 20, 40, 60, "All"]
        ],
        iDisplayLength: 5,
    });

    $('.select2').select2({
        width: '100%',
        height: '100%',
        dropdownParent: $('#EventModal'),
    });

    $("#company").click(function() {

        var frmCompany = $("#frmCompany").serialize();
        $.ajax({
            url: '../controller/Customer/Customer.php',
            type: 'POST',
            data: frmCompany,
            dataType: 'json',
            success: function(data) {

                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        $("#EventModal").modal('hide');
                        // location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }
            }
        })


    })

    $("#frmEvent").click(function() {

        var frm = $('#addEvent');
        var formData = new FormData(frm[0]);
        formData.append('file', $('input[type=file]')[0]);
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {

                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        $("#EventModal").modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }
            },
            error: function(er) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                })
            }
        })
    });

    $("#frmEventlog").click(function() {
        // $('#addEventlog :select[required="required"]').each(function() {
        //     if (!this.validity.valid) {
        //         $(this).focus();
        //         // break
        //         return false;
        //     }
        // });
        var fp = $("#formFileMultiple");
        var lg = fp[0].files.length; // get length
        if (lg > 5) {
            alert("You can only upload a maximum of 5 files");
            return false;
        }

        if ($(this).attr('data-type') == 'add') {
            var frm = $('#addEventlog');
            var formData = new FormData(frm[0]);
            formData.append('file', $('input[type=file]')[0]);
            formData.append('tags', $('#tags').val());
            formData.append('Branch', $('#Branch').val());
            formData.append('eventDate', $('#eventDate').val());
            formData.append('person', $('#person').val());
            formData.append('Description', $('#Description').val());
            formData.append('IdEventlog', $('#IdEventlog').val());

        } else {
            var frm = $('#addEventlog');
            var formData = new FormData(frm[0]);
        }

        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        $("#eventlogModal").modal('hide');
                        location.reload();
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }
            },
            error: function(er) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                })
            }

        })

    });

    $("#Product").select2({
        dropdownParent: $('#eventlogModal'),
        tags: true,
        multiple: true,
        // tokenSeparators: [','],
    });
    $('.tags').select2({
        dropdownParent: $('#eventlogModal'),
        tags: true,
        tokenSeparators: [','],
        // ajax: {
        //     url: '../controller/Customer/Customerinfo.php?tags',
        //     dataType: 'json',
        //     type: "GET",
        //     quietMillis: 50,
        //     data: function(params) {
        //         return {
        //             q: $.trim(params.term)
        //         };
        //     },
        //     processResults: function(response) {
        //         return {
        //             results: response
        //         };
        //     },
        //     cache: true
        // },
    });

    $("#frmCosts").click(function() {

        var frm = $('#addCosts');
        var formData = new FormData(frm[0]);
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {

                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        $("#costsModal").modal('hide');
                        location.reload();
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }

            },
            error: function(er) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                })
            }

        })

    });

    $("#customer").click(function() {
        var frm = $('#frmCustomer');
        var formData = new FormData(frm[0]);
        formData.append('file', $('#upload')[0].files[0]);
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        $("#ModalCustomer").modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }

            },

        })
    })

    var i = 101;
    $("#button-addon2").click(function() {
        $("#addTel").append('<div class="row mb-3" id="appendTel_' + i + '">' +
            '<label class="col-sm-2 " for="basic-default-name"></label>' +
            '<div class="col-sm-4">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control phone-mask" name="tel[]" id="basic-default-phone" placeholder="08 xxx xxxx" aria-label="08 xxx xxxx" aria-describedby="basic-default-phone">' +
            '<button class="btn btn-sm btn-outline-danger" onclick="delTel(' + i +
            ')" type="button" id="button-addon2"><i class="bx bx-minus"></i></button>' +
            '</div>' +
            '</div>' +
            '</div>');
        i++;
    })

});

function changestatus(x, val) {
    var r = confirm("ต้องการเปลี่ยนสถานะใช่หรือไม่ ?");
    if (r === true) {
        $.ajax({
            url: '../controller/Customer/Customerinfo.php',
            type: 'POST',
            data: {
                id: x,
                changestatus: val,
            },
            dataType: 'html',
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'เปลี่ยนสถานะสำเร็จ',
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เปลี่ยนสถานะไม่สำเร็จ',
                    });
                }
            }
        })
    }
}

function imagemodal(x) {
    $.ajax({
        url: '../controller/Customer/Customerinfo.php',
        type: 'POST',
        data: {
            image: 'image',
            id: x,
        },
        dataType: 'html',
        success: function(data) {
            $("#eventimageModal").html(data);

        }
    })
}

function delTel(x) {
    $("#appendTel_" + x).remove();
}
</script>

</html>