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
                <form id="frmPassword">
                    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Change Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Old Password</label>
                                            <input type="password" name="Old" id="Old" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="emailWithTitle" class="form-label">New Password</label>
                                            <input type="password" name="New" id="txtNewPassword" class="form-control" />
                                        </div>
                                        <div class="col mb-0">
                                            <label for="dobWithTitle" class="form-label">Confirm Password</label>
                                            <input type="password" name="Confirm" id="txtConfirmPassword" class="form-control" />
                                        </div>
                                        <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"> </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="password">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php $q = $conn->prepare("select SU_Name1,SU_Name2,SU_Email,SU_Tel,SU_Profile,SU_Username from systemuser where SU_Code = ?");
                $q->execute([$_SESSION['Code']]);
                $cus = $q->fetch();
                ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">

                        <div class="card">
                            <h5 class="card-header">Account
                                <button class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#modalCenter"> Change Password </button>
                            </h5>
                            <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <input type="hidden" name="oldPic" value="<?=$cus['SU_Profile']?>">
                                <div class="table-responsive text-nowrap" style="padding: 1%;">
                                    <div class="card mb-4">
                                        <h5 class="card-header">Profile Details</h5>
                                        <!-- Account -->
                                        <div class="card-body">
                                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                <img src="<?=$_SESSION['SU_Profile']?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                                                <div class="button-wrapper">
                                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                        <span class="d-none d-sm-block">Upload new photo</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input type="file" id="upload" name="file" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                                    </label>
                                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Reset</span>
                                                    </button>

                                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-0">
                                        <div class="card-body">
                                            <input type="hidden" name="profile" value="profile">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input class="form-control" type="text" id="username" name="username" value="<?= $cus['SU_Username'] ?>" autofocus="" readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">First Name - Last Name</label>
                                                    <input class="form-control" type="text" id="firstName" name="firstName" value="<?= $cus['SU_Name1'] ?>" autofocus="">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="lastName" class="form-label">ชื่อ - นามสกุล</label>
                                                    <input class="form-control" type="text" name="lastName" id="lastName" value="<?= $cus['SU_Name2'] ?>">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="email" id="email" name="email" value="<?= $cus['SU_Email'] ?>" placeholder="<?= $cus['SU_Email'] ?>">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?= $cus['SU_Tel'] ?>" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                                <button type="button" class="btn btn-primary me-2 float-end frmAcc">Save changes</button>
                                            </div>
                                        </div>
                                        <!-- /Account -->
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- / Content -->

                    <?php require('../template/footer.php') ?>
</body>
<script>
    function checkPasswordMatch() {
        var password = $("#txtNewPassword").val();
        var confirmPassword = $("#txtConfirmPassword").val();
        if (password != confirmPassword) {
            $("#CheckPasswordMatch").html("Passwords does not match!");
            $("#CheckPasswordMatch").css("color", "red");
            $("#password").prop("disabled", true);
        } else {
            $("#CheckPasswordMatch").css("color", "green");
            $("#CheckPasswordMatch").html("Passwords match.");
            $("#password").prop("disabled", false);
        }
    }
  
    $(document).ready(function() {
        $("#txtConfirmPassword").keyup(checkPasswordMatch);
        $("#txtNewPassword").keyup(checkPasswordMatch);
        
        $("#password").click(function() {

            var frm = $('#frmPassword');
            var formData = new FormData(frm[0]);
            $.ajax({
                url: '../controller/Profile/Profile.php',
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
                            window.location.href = 'logout.php';
                            $("#modalCenter").modal('hide');
                        });

                    } else if(data == 2){
                        Swal.fire({
                            icon: 'error',
                            title: 'รหัสผ่านเก่าของคุณไม่ถูกต้อง',
                        }).then((result) => {
                        //    location.href= 'logout.php';
                        });
                    }else {
                        Swal.fire({
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ',
                        })
                    }
                },

            })

        });

        $(".frmAcc").click(function() {
            var frm = $('#formAccountSettings');
            var formData = new FormData(frm[0]);
            formData.append('file', $('input[type=file]')[0]);
            $.ajax({
                url: '../controller/Profile/Profile.php',
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

    })
</script>

</html>