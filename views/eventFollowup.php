<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<?php require('../template/head.php') ?>

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

                <?php $q = $conn->prepare("select eb_id,eb_image , eb_date , eb_contact , eb_description , eb_createby , eb_created , SU_Name1 from eventbusiness left join systemuser on eventbusiness.eb_createby = systemuser.SU_Code where eb_id = ? ");
                $q->execute([$_GET['e']]);
                $follow = $q->fetch();
                ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">

                        <div class="card">
                            <h5 class="card-header">Follow Up</h5>
                            <div class="card-body">

                                <div class="row">

                                    <div class="mb-3 col-md-2">
                                        <label for="lastName" class="form-label">Date</label>
                                        <input class="form-control" type="text" name="lastName" id="lastName" value="<?= date('d/m/Y', strtotime($follow['eb_date'])) ?>" readonly />
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="contact" class="form-label">Contact Person </label>
                                        <input class="form-control" type="text" id="contact" name="contact" value="<?= $follow['eb_contact'] ?>" readonly />
                                    </div>

                                    <div class="mb-3 col-md-2 ">
                                        <label for="MODIFY" class="form-label">User Modify</label>
                                        <input type="text" class="form-control" id="MODIFY" name="MODIFY" value="<?= $follow['SU_Name1'] ?>" readonly />
                                    </div>
                                    <div class="mb-3 col-md-2 ">
                                        <label for="TIME_MODIFY" class="form-label">Date / Time Modify</label>
                                        <input type="text" class="form-control" id="TIME_MODIFY" name="TIME_MODIFY" value="<?= date('d/m/Y H:i', strtotime($follow['eb_created'])) ?>" readonly />
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="email" class="form-label">ไฟล์แนบ</label>
                                        <br>
                                        <button type="button" onclick="imagemodal(<?= $follow['eb_id'] ?>)" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#ImageModal">
                                            ไฟล์แนบ
                                        </button>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="DESCRIPTION" class="form-label">Description</label>
                                        <textarea  id="Description" name="Description" readonly>    <?= htmlspecialchars_decode($follow['eb_description'], ENT_NOQUOTES) ?></textarea>

                                    </div>


                                    <div class="col-md-4 "></div>
                                    <div class="col-md-4 "></div>

                                </div>

                                <hr>
                                <?php $q = $conn->prepare("select fu_issue , fu_date , fu_status , SU_Name1,fu_created from followup left join systemuser on followup.fu_createby = systemuser.SU_Code  where eb_id = ? ");
                                $q->execute([$_GET['e']]);
                                $follow = $q->fetchall();

                                ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-add">
                                        <!-- <button type="button" class="btn btn-sm btn-icon btn-outline-success" id="btnAdd"><i class='bx bx-plus'></i></button> -->
                                        <!-- <button type="button" class="btn btn-sm btn-icon btn-outline-danger" style="display:none;" id="btnDel"><i class='bx bx-minus'></i></button> -->
                                    </label>
                                    <div class="table-responsive text-nowrap">
                                        <form id="frmFollow" method="POST" autocomplete="off">
                                            <input type="hidden" name="followup" value="<?= $_GET['e'] ?>">
                                            <table class="table tableAdd table-bordered" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th>Issue</th>
                                                        <th>Date</th>
                                                        <th style="width:150px;">Status<br>(Process/Done)</th>
                                                        <th>CreateBy</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($follow as $fus) { ?>
                                                        <tr>
                                                            <td style="width: 50%;"><?= $fus['fu_issue'] ?></td>
                                                            <td><?= dateth($fus['fu_date']) ?></td>
                                                            <td><?= $fus['fu_status'] == 1 ? 'Process' : 'Done'; ?></td>
                                                            <td style="width: 15%;"><?= $fus['SU_Name1'] ?></td>
                                                            <td><?= dateth($fus['fu_created']) ?></td>
                                                        </tr>
                                                    <?php } ?>

                                                    <tr>
                                                        <td id="add" style="width: 50%;">
                                                            <textarea id="summernote" name="issue[]" readonly>  </textarea>

                                                        </td>
                                                        <td>
                                                            <input type="text" class="input-sm form-control date" name="date[]" placeholder="" value="<?=date('d/m/Y')?>" name="ShipmentDate2" />
                                                        </td>
                                                        <td>
                                                            <select name="status[]" class="form-control">
                                                                <option value="1">Process</option>
                                                                <option value="2">Done</option>
                                                            </select>
                                                        </td>
                                                        <td style="width: 15%;"><input type="text" name="CreateBy[]" value="<?= $_SESSION['Name'] ?>" class="form-control CreateBy" readonly></td>
                                                        <td><input type="text" name="Created[]" value="<?= date('d/m/Y') ?>" class="form-control Created" readonly></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="#" onclick="history.back();" class="btn btn-outline-secondary">Back</a>
                                    <button type="button" class="btn btn-primary me-2 float-end" id="save">Save changes</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
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
                    <?php require('../template/footer.php') ?>
</body>

<script>
    $(document).ready(function() {
        $("textarea").summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
            ]
        });
        $("#Description").summernote("disable");

        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '../controller/Log/Log_processing.php',
            order: [
                [3, "desc"]
            ],
        });

        var i = 2;
        $('#btnAdd').click(function() {
            var row = $('#add').closest('tr').clone();
            row.find('input').val('');
            row.find('.Created').val('<?= date('d/m/Y') ?>');
            row.find('.CreateBy').val('<?= $_SESSION['Name'] ?>');


            $('#add').closest('tr').addClass('RemoveRow').after(row);
            i++;
            if (i >= 2) {
                $("#btnDel").show();
            } else {
                $("#btnDel").hide();
            }

            $('.date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
            });

        });
        $('#btnDel').click(function() {
            $('.tableAdd .RemoveRow:last').remove();
            i--;
            if (i >= 2) {
                $("#btnDel").show();
            } else {
                $("#btnDel").hide();
            }
            console.log(i);
        });

        $("#save").click(function() {
            var frm = $("#frmFollow").serialize();
            $.ajax({
                url: '../controller/Customer/eventFollowup.php',
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

    });

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
</script>

</html>