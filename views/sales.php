<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<?php require('../template/head.php') ?>
<style>
    .unactive{
        text-decoration: line-through;
    }
</style>
<!-- Extra Large Modal -->
<form id="frmAdd">
    <div class="modal fade" id="ModalCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Add Sales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body">
                        <input type="hidden" name="sales" value="sales">
                        <input type="hidden" name="editSales" id="editSales" value="">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Username">Username</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="Username" name="username" tabindex="1" placeholder="">
                            </div>
                            <label class="col-sm-2 col-form-label" for="type">Type</label>
                            <div class="col-sm-4">
                                <select name="type" id="type" class="form-control" required>
                                    <option value="1">Sales Man</option>
                                    <option value="2">Sales Support</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Firstname">Firstname</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" tabindex="1" placeholder="">
                            </div>
                            <label class="col-sm-2 col-form-label" for="Lastname">Lastname</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="Lastname" name="lastname" tabindex="2" placeholder="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control form-control-sm" id="email" name="email" tabindex="2" placeholder="">
                            </div>
                            <label class="col-sm-2 col-form-label" for="defaultCheck3">Active</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="defaultCheck3" checked />
                                </div>
                            </div>
                        </div>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="save">Save changes</button>
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
                                    <a href="#">Sales Information</a>
                                </li>
                            </ol>
                        </nav>
                        <div class="card">
                            <h5 class="card-header"> Sales
                                <button type="button" class="btn btn-icon btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#ModalCustomer"><i class='bx bx-plus'></i></button>
                            </h5>
                            <?php
                            $q = $conn->prepare("SELECT s_username as code , s_name as name , s_email as email , 'Sales man' as type FROM sales 
                            UNION all 
                            SELECT sp_username as code , sp_name as name , sp_email as email , 'Support' as type FROM support
                                 ");
                            $q->execute();
                            $bus = $q->fetchall();
                            ?>
                            <div class="table-responsive text-nowrap" style="padding: 1%;">
                                <table id="example" class="table table-hover table-striped tableSales" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Sales </th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th style="width: 40px;">Option</th>

                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                    <?php require('../template/footer.php') ?>
</body>
<script>
    function evClick(x, v) {
        $("#ModalCustomer").modal('show');
        $.ajax({
            url: '../controller/Sales/Sales.php?id=' + x + '&type=' + v,
            dataType: 'json',
            success: function(data) {
                var name = data.name.split(' ');
                $("#exampleModalLabel4").text('Edit Sales');
                $("#Username").val(data.code);
                $("#type").val(data.option).attr('readonly', true);
                $("#firstname").val(name[0]);
                $("#Lastname").val(name[1]);
                $("#email").val(data.email);
                $("#editSales").val(data.id)
                if (data.active == 1) {
                    $("#defaultCheck3").prop('checked', true);
                } else {
                    $("#defaultCheck3").prop('checked', false);
                }

            }
        })
    }

    $(document).ready(function() {

        $('#ModalCustomer').on('hidden.bs.modal', function() {
            $("#exampleModalLabel4").text('Add Sales');
            $("#Username").val('');
            $("#type").val('').attr('readonly', false);
            $("#firstname").val('');
            $("#Lastname").val('');
            $("#email").val('');
            $("#editSales").val('')

        })

        $('.tableSales').DataTable({
            aLengthMenu: [
                [10, 40, 80, 140, -1],
                [10, 40, 80, 140, "All"]
            ],
            iDisplayLength: 10,
            ajax: '../controller/Sales/Sales.php?load=load',
            columns: [{
                    data: "code"
                },
                {
                    data: "name"
                },
                {
                    data: "email"
                },
                {
                    data: "type"
                },
                {
                    data: "Aoption",
                }
            ],
            rowCallback: function(row, data) {
                if (data.active == 0) {
                    $(row).addClass('unactive');
                }
               
            }

        });
        $("#save").click(function() {
            var frm = $("#frmAdd").serialize();
            $.ajax({
                url: '../controller/Sales/Sales.php',
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

    });
</script>

</html>