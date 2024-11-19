<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
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

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item">
                                    <a href="Customer.php">Customer Information</a>
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
                                    <small class="text-muted float-end">Company Info</small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 " for="basic-default-name">ชื่อบริษัท</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-name"
                                                    value="Costco Wholesale " />
                                            </div>
                                            <label class="col-sm-2 " for="basic-default-company">ประเภทธุรกิจ</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-company"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 " for="basic-default-email">ที่อยู่บริษัท</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="" class="form-control" id="">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 " for="basic-default-name">เบอร์โทรบริษัท</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="basic-default-phone"
                                                    class="form-control phone-mask" placeholder="08 xxx xxxx"
                                                    aria-label="08 xxx xxxx" aria-describedby="basic-default-phone" />
                                            </div>
                                            <label class="col-sm-2 " for="basic-default-company">Last Update</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-company"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 " for="basic-default-email">Salesman</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="basic-default-name"
                                                    value="Choopong" />

                                            </div>
                                            <label class="col-sm-2 " for="basic-default-phone">Sales Support</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="" value="Nuanthip" class="form-control" id="">
                                            </div>
                                        </div>

                                        <br>
                                        <h5 class="card-header">
                                            <button type="button" class="btn btn-icon btn-outline-primary float-end"
                                                data-bs-toggle="modal" data-bs-target="#ModalCustomer"><i
                                                    class='bx bx-plus'></i></button>

                                        </h5>
                                        <br>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Profile</th>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Phone No.</th>
                                                        <th>Email</th>
                                                        <th>Job description</th>
                                                        <th>Birth Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <ul
                                                                class="list-unstyled users-list m-0 d-flex align-items-center">
                                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-bs-placement="top"
                                                                    class="avatar avatar-xl pull-up"
                                                                    title="Christina Parker">
                                                                    <img src="../assets/img/avatars/5.png" alt="Avatar"
                                                                        class="rounded-circle" />
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td> <a href="PersonInfo.php"> Sereen Surnria</a> </td>
                                                        <td>Assistant Buyer</td>
                                                        <td>084-365-7935</td>
                                                        <td>CustraSereen@gmail.com</td>
                                                        <td>Assistant</td>
                                                        <td>01/01/1999</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            <ul
                                                                class="list-unstyled users-list m-0 d-flex align-items-center">
                                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-bs-placement="top"
                                                                    class="avatar avatar-xl pull-up"
                                                                    title="Christina Parker">
                                                                    <img src="../assets/img/avatars/6.png" alt="Avatar"
                                                                        class="rounded-circle" />
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td> <a href="PersonInfo.php"> Joan Elisabeth</a> </td>
                                                        <td>Buyer - D18 Frozen</td>
                                                        <td>093-976-7983</td>
                                                        <td>Joan.e@gmail.com</td>
                                                        <td></td>
                                                        <td>01/01/1999</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            <ul
                                                                class="list-unstyled users-list m-0 d-flex align-items-center">
                                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-bs-placement="top"
                                                                    class="avatar avatar-xl pull-up"
                                                                    title="Christina Parker">
                                                                    <img src="../assets/img/avatars/7.png" alt="Avatar"
                                                                        class="rounded-circle" />
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td> <a href="PersonInfo.php"> Mia </a></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Mia@gmail.com</td>
                                                        <td></td>
                                                        <td>01/01/1999</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <h5 class="card-header">บันทึกเหตุการณ์

                                            <button type="button" class="btn btn-icon btn-outline-primary float-end"
                                                data-bs-toggle="modal" data-bs-target="#largeModal"><i
                                                    class='bx bx-plus'></i></button>

                                        </h5>

                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Effective Date</th>
                                                        <th>Product</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <tr>
                                                        <td></td>
                                                        <td> No Data</td>
                                                        <td></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td></td>
                                                        <td> No Data</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td> No Data</td>
                                                        <td></td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <h5 class="card-header">ข้อตกลงที่ทำให้เกิดค่าใช้จ่าย <button type="button"
                                                class="btn btn-icon btn-outline-primary float-end"
                                                data-bs-toggle="modal" data-bs-target="#largeModal"><i
                                                    class='bx bx-plus'></i></button></h5>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Effective Date</th>
                                                        <th>Product</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <tr>
                                                        <td></td>
                                                        <td>No Data</td>
                                                        <td></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td></td>
                                                        <td>No Data</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>No Data</td>
                                                        <td></td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <h5 class="card-header">เหตุการณ์ <button type="button"
                                                class="btn btn-icon btn-outline-primary float-end"
                                                data-bs-toggle="modal" data-bs-target="#largeModal"><i
                                                    class='bx bx-plus'></i></button> </h5>
                                        <div class="table-responsive text-wrap">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Effective Date</th>
                                                        <th>Contact person</th>
                                                        <th>Description</th>
                                                        <th>User Modify</th>
                                                        <th>Date / Time Modify</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <tr>
                                                        <td>01/09/2022</td>
                                                        <td> คุณ A , คุณ B</td>
                                                        <td> ลูกค้ามาถึงตั้งแต่ 8.30 มาเร็วกว่าเวลานัด วันนี้มีถ่าย
                                                            Video ของบริษัท ต้องให้ลูกค้าเดินขึ้นบันไดตรง EGV
                                                            แล้วผ่านออฟฟิศย้อนมาเข้าห้องประชุมใหญ่
                                                            ติ๋วตามมาถ่ายรูปให้ในห้องแล้วปริ้นรูปแจกลูกค้าคนละ 1 ใบ
                                                            ได้สั่งน้ำ Amazon มาให้ลูกค้า 6 แก้ว</td>
                                                        <td></td>
                                                        <td> <button type="button"
                                                                class="btn btn-icon btn-outline-warning float-end"
                                                                data-bs-toggle="modal" data-bs-target="#largeModal"><i
                                                                    class='bx bx-edit'></i></button> </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row justify-content-end">
                                            <div class="col-sm-10" style="text-align: right;">
                                                <button type="submit" class="btn btn-primary"> Save </button>
                                            </div>
                                        </div>

                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel3"> ข้อตกลงทั่วไป </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="dobLarge" class="form-label">Effective Date</label>
                                            <input type="text" id="dobLarge" class="form-control"
                                                placeholder="DD / MM / YY" />
                                        </div>
                                        <div class="col mb-0">
                                            <label for="emailLarge" class="form-label">Product</label>
                                            <input type="text" id="" class="form-control" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameLarge" class="form-label">Description</label>
                                            <textarea name="" class="form-control" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="ModalCustomer" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel3"> Add Customer </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row row-bordered g-0">
                                        <div class="col-md-4" style="text-align: center;">

                                            <div class="card-body">

                                                <img src="../assets/img/avatars/cloud-2044823.png" alt="Avatar"
                                                    class="rounded-circle" id="uploadedAvatar" height="200"
                                                    width="200" />
                                                <br>
                                                <br>
                                                <div class="button-wrapper">
                                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                        <span class="d-none d-sm-block">Upload new photo</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input type="file" id="upload" class="account-file-input" hidden
                                                            accept="image/png, image/jpeg" />
                                                    </label>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-8" style="padding: 1%;">
                                            <table class="table">
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;">Name</td>
                                                    <td> <input type="text" value="" class="form-control"> </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;">Position</td>
                                                    <td> <input type="text" value="" class="form-control"> </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;">Phone No.</td>
                                                    <td> <input class="form-control" type="tel"
                                                            placeholder="08x-xxx-xxxx" id="html5-tel-input"> </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;">Email</td>
                                                    <td> <input class="form-control" type="email"
                                                            placeholder="john@example.com" id="html5-email-input"> </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;">Job Description
                                                    </td>
                                                    <td> <input type="text" value="" class="form-control"> </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:33%;border-right: 1px solid black;"> Birth Date
                                                    </td>
                                                    <td> <input class="form-control" type="date"
                                                            placeholder="2021-06-18" id="html5-date-input"> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php require('../template/footer.php') ?>
</body>

</html>