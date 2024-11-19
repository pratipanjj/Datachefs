<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
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
                <?php $q = $conn->prepare("select c_id,be_id,c_profile,c_firstname,c_lastname,c_nickname,c_position,c_tel,c_email,c_birthday,c_jobdescrip,c_information,c_preference,c_status from customer where c_id = ?");
                $q->execute([$_GET['cid']]);
                $cus = $q->fetch();
                ?>
                <?php $q = $conn->prepare("select c_id,be_id,c_firstname,c_lastname from customer where be_id = ?");
                $q->execute([$cus['be_id']]);
                $customer = $q->fetchall();
                ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item">
                                    <a href="Customer.php">Customer Information</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="Customerinfo.php?be=<?= $cus['be_id'] ?>">Customer</a>
                                </li>
                                <li class="breadcrumb-item" style="font-weight: bold;">
                                    PersonInfo
                                </li>

                            </ol>
                        </nav>



                        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="row row-bordered g-0">

                                    <div class="card-body">
                                        <form id="frmCustomer" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="editCustomer" value="<?= $_GET['cid'] ?>" id="">
                                            <input type="hidden" name="oldPic" value="<?= $cus['c_profile'] ?>">
                                            <div class="row">
                                                <div class="mt-3 col-md-4" style="text-align: center;">
                                                    <img src="../images/Customer/profile/<?= $cus['c_profile'] != '' ? $cus['c_profile'] : '149071.png'; ?>" style="max-width: 200px;" id="uploadedAvatar" alt="Avatar" class="rounded-circle" />
                                                    <br>
                                                    <br>
                                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                        <span class="d-none d-sm-block">Upload new photo</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input type="file" id="upload" value="<?= $cus['c_profile'] ?>" name="file" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                                    </label>
                                                </div>

                                                <div class="mt-3 col-md-8">
                                                    <div class="table-responsive text-nowrap" style="overflow-x: hidden;">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th style="width:14%;border-right: 1px solid black;">Position</th>
                                                                <td> <input type="text" class="form-control" name="c_position" value="<?= $cus['c_position'] ?>"> </td>
                                                                <th style="width:16%;border-right: 1px solid black;">Name</th>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <input type="text" class="form-control" name="c_firstname" value="<?= $cus['c_firstname'] ?>" placeholder="First name">
                                                                        </div>
                                                                        <div class="col">
                                                                            <input type="text" class="form-control" name="c_lastname" value="<?= $cus['c_lastname'] ?>" placeholder="Last name">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:14%;border-right: 1px solid black;">Nickname</th>
                                                                <td> <input type="text" class="form-control" name="nickname" value="<?= $cus['c_nickname'] ?>"> </td>
                                                                <th style="width:14%;border-right: 1px solid black;"></th>
                                                                <td> </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:14%;border-right: 1px solid black;">Phone No.</th>
                                                                <td> <input type="text" class="form-control" name="c_tel" value="<?= $cus['c_tel'] ?>"> </td>
                                                                <th style="width:14%;border-right: 1px solid black;">Email</th>
                                                                <td> <input type="text" class="form-control" name="c_email" value="<?= $cus['c_email'] ?>"> </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:14%;border-right: 1px solid black;"> Birth Date </th>
                                                                <td> <input type="date" class="form-control" id="" name="c_birthday" value="<?= $cus['c_birthday'] != '0000-00-00' ? date('Y-m-d', strtotime($cus['c_birthday'])) : ''; ?>"> </td>
                                                                <th style="width:14%;border-right: 1px solid black;">Preference</th>
                                                                <td> <input type="text" class="form-control" name="c_preference" value="<?= $cus['c_preference'] ?>"> </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:14%;border-right: 1px solid black;">Job Description
                                                                </th>
                                                                <td> <input type="text" class="form-control" name="c_jobdescrip" value="<?= $cus['c_jobdescrip'] ?>"> </td>
                                                                <th style="width:14%;border-right: 1px solid black;">Special Information</th>
                                                                <td> <input type="text" class="form-control" name="c_information" value="<?= $cus['c_information'] ?>"> </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                </div>
                                                <div class="mt-3 col-md-12">
                                                    <a class="btn btn-outline-secondary" href="Customerinfo.php?be=<?= $cus['be_id'] ?>">Back</a>
                                                    <button class="btn btn-primary float-end" id="frmCus" type="button"> Save </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                        $full = $cus['c_firstname'] . ' ' . $cus['c_lastname'];
                        $q = $conn->prepare("select eb_id,eb_date , eb_contact , eb_description ,eb_image , SU_Name1,eb_created
                        From eventbusiness left join systemuser on eventbusiness.eb_createby = systemuser.SU_Code where eb_contact like ? order by eb_id desc ");
                        $q->execute(['%' . $full . '%']);
                        $event = $q->fetchall();
                        ?>
                        <div class="card">
                            <h5 class="card-header"> History <button type="button" class="btn btn-icon btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#EventModal"><i class='bx bx-plus'></i></button></h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>DATE</th>
                                            <th>CONTACT PERSON</th>
                                            <th>DESCRIPTION</th>
                                            <th>Image</th>
                                            <th>USER MODIFY</th>
                                            <th>DATE / TIME MODIFY</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php
                                        $image = '';
                                        $count = count($event);
                                        foreach ($event as $e => $events) {
                                            $image = $events['eb_image'];
                                        ?>
                                            <tr>
                                                <td style="width: 3%;"><?= ($e + 1) ?></td>
                                                <td style="width: 7%;"><?= date('d/m/Y', strtotime($events['eb_date'])) ?></td>
                                                <td style="width: 12%;word-break: break-all;"><?= $events['eb_contact'] ?></td>
                                                <td style="word-break: break-all;"><?= $events['eb_description'] ?></td>
                                                <td style="width: 9%;">
                                                    <?php if ($image != '') { ?>
                                                        <button type="button" onclick="imagemodal(<?= $events['eb_id'] ?>)" class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#ImageModal">
                                                            ไฟล์แนบ
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td style="width: 12%;"><?= $events['SU_Name1'] ?></td>
                                                <td style="width: 12%;"><?= dateth($events['eb_created'], 1) ?></td>
                                            </tr>
                                        <?php
                                            $count--;
                                        }

                                        $im = explode(',', $image);
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="ImageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel3"> เหตุการณ์ </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <form id="addEvent" enctype="multipart/form-data">
                            <div class="modal fade" id="EventModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel3"> เหตุการณ์ </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="addEvent" value="<?= $customer[0]['be_id'] ?>">
                                            <div class="mb-3">
                                                <label for="formFileMultiple" class="form-label"> Image <small> ( limit 5 files ) </small></label>
                                                <input class="form-control" type="file" name="file[]" id="formFileMultiple" accept="image/*" multiple />
                                            </div>
                                            <div class="row g-2">
                                                <div class="col mb-0">
                                                    <label for="dobLarge" class="form-label">Date</label>
                                                    <input class="form-control date" type="text" name="dobLarge" value="<?= date('d/m/Y') ?>" data-date-format="DD MMMM YYYY" id="html5-date-input">
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="personLarge" class="form-label">Contact person </label>
                                                    <br><select class="form-control select2" multiple name="person[]" required>
                                                        <?php foreach ($customer as $k => $r) {
                                                            echo '<option value="' . $r['c_firstname'] . ' ' . $r['c_lastname'] . '" ' . ($r['c_id'] == $_GET['cid'] ? 'selected' : '') . ' >' . $r['c_firstname'] . ' ' . $r['c_lastname'] . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="nameLarge" class="form-label">Description</label>
                                                    <textarea name="Description" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="button" class="btn btn-primary" id="frmEvent">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- / Content -->

                    <?php require('../template/footer.php') ?>
</body>
<script>
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
    $(document).ready(function() {

        $('.select2').select2({
            width: '100%',
            height: '100%',
            dropdownParent: $('#EventModal'),
        });
        $("#frmCus").click(function() {
            var frm = $('#frmCustomer');
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
        $("#frmEvent").click(function() {
            var $fileUpload = $("input[type='file']");
            if (parseInt($fileUpload.get(0).files.length) > 5) {
                alert("You can only upload a maximum of 5 files");
                return false;
            }

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
    })
</script>

</html>