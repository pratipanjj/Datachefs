<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
<?php require('../template/head.php') 
?>

<!-- if error 404 page redirect php or htaccess -->
<!-- Extra Large Modal -->
<form id="frmAdd" method="POST" action="" required role="form">
    <input type="hidden" name="customer" value="customer">
    <div class="modal fade" id="ModalCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-10 ">
                            </div>
                            <div class="col-sm-2">

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        value="1" checked name="BE_IsActive" id="Active">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Is Active </label>
                                </div>


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-code">
                                <font style="color:red"> * </font>Code
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="basic-default-code"
                                    name="code" tabindex="1" placeholder="" required>
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-default-code">
                                <font style="color:red"> * </font>Country
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control " id="basic-default-code" name="BE_country"
                                    value="" tabindex="1" placeholder="" required>
                            </div>

                        </div>
                        <?php $bet = $conn->prepare("select bt_id,bt_code from businesstypes where bt_active = ? ");
                        $bet->execute([1]);
                        $bets = $bet->fetchall();
                        ?>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-BusinessType">
                                <font style="color:red"> * </font> BusinessType
                            </label>
                            <div class="col-sm-4">
                                <select name="BT_ID" class="form-control form-control-sm"
                                    id="basic-default-BusinessType" required>
                                    <option value=""> -- Select -- </option>
                                    <?php foreach ($bets as $r) { ?>
                                    <option value="<?= $r['bt_id'] ?>"> <?= $r['bt_code'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-default-VAT">VAT</label>
                            <div class="col-sm-4">
                                <select name="vat" class="form-control form-control-sm" id="basic-default-VAT">
                                    <option value="" selected disabled> -- Select -- </option>
                                    <option value="1"> Include Vat </option>
                                    <option value="2"> Exclude Vat </option>
                                    <option value="3"> No Vat </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-EnglishName">
                                <font style="color:red"> * </font> Company Name
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" name="EnglishName"
                                    id="basic-default-EnglishName" tabindex="2" placeholder="" required>
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-default-LocalName">
                                <font style="color:red"> * </font> Local Name
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" name="LocalName"
                                    id="basic-default-LocalName" tabindex="5" placeholder="" required>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-BE_contact">Contact Person</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" name="BE_contact"
                                    id="basic-default-BE_contact" tabindex="2" placeholder="">
                            </div>
                            <label class="col-sm-1 col-form-label" for="basic-default-Tel1">Tel
                                1</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" name="Tel1"
                                    id="basic-default-Tel1" tabindex="3" placeholder="">
                            </div>
                            <label class="col-sm-1 col-form-label" for="basic-default-Fax1">Fax
                                1</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-sm" name="Fax1"
                                    id="basic-default-Fax1" tabindex="4" placeholder="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-address">Address</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-address" name="address"
                                    class="form-control form-control-sm" tabindex="8" placeholder="" aria-label=""
                                    aria-describedby="basic-default-WebSite">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-WebSite">WebSite</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-WebSite" name="WebSite"
                                    class="form-control form-control-sm" tabindex="9" placeholder="" aria-label=""
                                    aria-describedby="basic-default-WebSite">
                            </div>
                        </div>
                        <?php $q = $conn->prepare("select s_id,s_name from Sales where s_active = ? ");
                        $q->execute([1]);
                        $sale = $q->fetchall();
                        ?>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-Salesman">Salesman</label>
                            <div class="col-sm-4">
                                <select name="Salesman" id="Salesman" class="form-control form-control-sm">
                                    <option value="" selected disabled> -- Select -- </option>
                                    <?php foreach ($sale as $s) {
                                        echo '<option value="' . $s['s_id'] . '"> ' . $s['s_name'] . ' </option>';
                                    } ?>
                                </select>

                            </div>
                            <?php $qs = $conn->prepare("select sp_id,sp_name  from support where s_active = ? ");
                            $qs->execute([1]);
                            $sup = $qs->fetchall();
                            ?>
                            <label class="col-sm-2 col-form-label" for="basic-default-SalesSupport">Sales
                                Support</label>
                            <div class="col-sm-4">
                                <select name="support" id="support" class="form-control form-control-sm">
                                    <option value="" selected disabled> -- Select -- </option>
                                    <?php foreach ($sup as $s) {
                                        echo '<option value="' . $s['sp_id'] . '"> ' . $s['sp_name'] . ' </option>';
                                    } ?>
                                </select>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

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

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item" style="font-weight: bold;">
                                    <a href="#">Customer Information</a>
                                </li>
                            </ol>
                        </nav>
                        <div class="card">
                            <h5 class="card-header"> Customer
                                <button type="button" class="btn btn-icon btn-outline-primary float-end"
                                    data-bs-toggle="modal" data-bs-target="#ModalCustomer"><i
                                        class='bx bx-plus'></i></button>
                            </h5>
                            <?php
                            $q = $conn->prepare("select BE_ID,BE_LocalName,BE_EnglishName,BE_Code,s_name , BE_created ,BE_status, s_name , sp_name , BE_IsActive from businessentity
                                left JOIN sales on businessentity.BE_salesman = sales.s_id
                                 left JOIN support on businessentity.BE_support = support.sp_id
                                 ");
                            $q->execute();
                            $bus = $q->fetchall();
                            ?>
                            <div class="table-responsive text-nowrap" style="padding: 1%;">
                                <table id="example" class="table table-hover table-striped tablecustomer"
                                    style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Local Name</th>
                                            <th>Company Name</th>
                                            <th>SalesMan</th>
                                            <th>Sales Support</th>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <!-- connect php database sql server -->
                                    <tbody class="table-border-bottom-0">
                                        <!-- text-decoration:line-through -->
                                        <?php foreach ($bus as $b) {
                                            if($_SESSION['role'] == 1 || $_SESSION['role'] == 2){ ?>

                                        <tr <?=$b['BE_IsActive'] == 0 ? 'style="text-decoration:line-through"' : '';?>>
                                            <td>
                                                <!-- <span class="badge bg-label-primary">Erp</span> -->
                                                <a href="Customerinfo.php?be=<?= $b['BE_ID'] ?>">
                                                    <strong><?= $b['BE_LocalName'] != '' ? $b['BE_LocalName'] : $b['BE_EnglishName'] ?></strong>
                                                </a>
                                            </td>
                                            <td><?= $b['BE_EnglishName'] ?></td>
                                            <td><?= $b['s_name'] ?></td>
                                            <td><?= $b['sp_name'] ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($b['BE_created'])) ?></td>
                                            <td>
                                                <?= $b['BE_IsActive'] == 1 && $b['BE_status'] == '1' ? 'New' : ( $b['BE_IsActive'] == 1 && $b['BE_status'] == '2' ? 'On process' : 'Disabled'); ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="Customerinfo.php?be=<?= $b['BE_ID'] ?>"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <?php if($b['BE_IsActive'] == 1){ ?>
                                                        <a class="dropdown-item"
                                                            onclick="hideCustomer(<?=$b['BE_ID']?>,0)"><i
                                                                class="bx bx-hide"></i> Disabled </a>
                                                        <?php }else{ ?>
                                                        <a class="dropdown-item"
                                                            onclick="hideCustomer(<?=$b['BE_ID']?>,1)"><i
                                                                class='bx bx-show'></i> Active </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php }else{
                                            if($b['BE_IsActive'] == 1){ ?>
                                        <tr>
                                            <td>
                                                <a href="Customerinfo.php?be=<?= $b['BE_ID'] ?>">
                                                    <strong><?= $b['BE_LocalName'] != '' ? $b['BE_LocalName'] : $b['BE_EnglishName'] ?></strong>
                                                </a>
                                            </td>
                                            <td><?= $b['BE_EnglishName'] ?></td>
                                            <td><?= $b['s_name'] ?></td>
                                            <td><?= $b['sp_name'] ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($b['BE_created'])) ?></td>
                                            <td><?= $b['BE_status'] == '1' ? 'New' : 'On process'; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="Customerinfo.php?be=<?= $b['BE_ID'] ?>"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> -->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php require('../template/footer.php') ?>
</body>
<script>
$(document).ready(function() {
    $('.tablecustomer').DataTable({
        order: [
            [1, 'asc']
        ],

    });

    $("#frmAdd").submit(function(e) {

        // $("#save").on("click", function(e) {
        e.preventDefault();
        var frm = $("#frmAdd").serialize();
        $.ajax({
            url: '../controller/Customer/Customer.php',
            type: 'POST',
            data: frm,
            dataType: 'json',
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                    })
                }

            }
        })
        return false;
    })

    var i = 2;
    $('#btnAdd').click(function() {
        i++;
        var row = $('#add').closest('tr').clone();
        row.find('input').val('');
        row.find('input[type="file"]').attr('onclick', 'preview(' + i + ',this)');
        row.find('.preview').attr('id', 'imgPreview_' + i);
        $('#add').closest('tr').addClass('RemoveRow').after(row);
        if (i > 2) {
            $("#btnDel").show();
        } else {
            $("#btnDel").hide();
        }
    });

    $('#btnDel').click(function() {
        i--;
        $('.tableAdd .RemoveRow:last').remove();
        if (i > 2) {
            $("#btnDel").show();
        } else {
            $("#btnDel").hide();
        }
        console.log(i);
    });

    // $('.photo').change(function() {
    //     const file = this.files[0];
    //     if (file) {
    //         let reader = new FileReader();
    //         reader.onload = function(event) {
    //             console.log(event.target.result);
    //             $('#imgPreview').attr('src', event.target.result);
    //         }
    //         reader.readAsDataURL(file);
    //     }
    // });

});

function hideCustomer(id, status) {
    var r = confirm("ต้องการทำรายการนี้ใช่หรือไม่ ?");
    if (r === true) {
        if (status == 1) {
            var txt = 'Active Customer Success';
        } else {
            var txt = 'Disabled Customer Success';
        }
        $.ajax({
            url: '../controller/Customer/Customer.php',
            type: 'POST',
            data: {
                hideCustomer: id,
                status: status
            },
            dataType: 'json',
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: txt,
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Success',
                    })
                }

            }
        })
    }
}

function preview(x, val) {
    const file = val.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
            console.log(event.target.result);
            $('#imgPreview_' + x).attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
    }
}

var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    var filename = output.src.split('/').pop();
    $('#imgprofile').html(filename);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};
</script>

</html>