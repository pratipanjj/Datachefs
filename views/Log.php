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

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">

                        <div class="card">
                            <h5 class="card-header">Log System</h5>
                            <div class="table-responsive text-nowrap" style="padding: 1%;">
                                <table id="example" class="table table-hover table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th> Type </th>
                                            <th> Details </th>
                                            <th> Users </th>
                                            <th> Date Time </th>
                                            <th> Code </th>
                                        </tr>
                                    </thead>

                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- / Content -->

                    <?php require('../template/footer.php') ?>
</body>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '../controller/Log/Log_processing.php',
            order: [
                [3, "desc"]
            ],
        });
    });
</script>

</html>