<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?
    if($this->session->flashdata('err_message')){
        echo "<script>alertify.success('".$this->session->flashdata('err_message')."')</script>";
    }
?>
    <div class="wrapper">


        <!-- Navbar -->
        <?php $this->load->view('_partials/navbar') ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view('_partials/sidebar_main.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="max-height:1200px!important;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">User Management</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>User Management</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover users_tb ">
                                        <thead>
                                            <tr>
                                                <th>fullname</th>
                                                <th>username</th>
                                                <th>password</th>
                                                <th width="5%">status active</th>
                                                <th width="5%">status lock</th>
                                                <th width="10%">#</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="data">
                                            <?$i = 1;foreach ($users as $key => $value) {?>
                                            <tr>
                                                <td><?= $value->fname . " " . $value->lname ;?></td>
                                                <td><?= $value->username;?></td>
                                                <td><?= $value->password;?></td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            onclick="changePublic(this,'<?= $value->username?>','user','auth_status')"
                                                            type="checkbox" class="custom-control-input"
                                                            id="<?= 'auth_status'.$i ;?>" name='machine_state'
                                                            <?= ($value->auth_status) ? "checked" : ""?>>
                                                        <label class="custom-control-label"
                                                            for="<?= 'auth_status'.$i ;?>">
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="form_submit" value="">
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            onclick="changePublic(this,'<?= $value->username?>','user','status_lock')"
                                                            type="checkbox" class="custom-control-input"
                                                            id="<?= 'status_lock'.$i ;?>" name='machine_state2'
                                                            <?= ($value->status_lock) ? " checked" : ""?>>
                                                        <label class="custom-control-label"
                                                            for="<?= 'status_lock'.$i ;?>">
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="form_submit" value="">
                                                </td>
                                                <td>
                                                    <button type="button" name="edit"
                                                        class="btn btn-sm btn-block btn-warning edit_data"
                                                        id="<?= $value->username; ?>"><i class="fas fa-redo"></i>
                                                        Reset pass</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger"
                                                        onclick="deleteUser('<?= $value->username ;?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?$i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('_partials/footer.php') ?>

        <!-- Control Sidebar -->
        <?php $this->load->view('_partials/sidebar_control.php') ?>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <? require_once "modal_event/reset_pass.php";?>

    <script>
    $(document).ready(() => {
        $('.users_tb').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        changePublic = (e, id, target, column) => {
            let where = "id=" + id;
            let table = target;
            let data = {};
            data['username'] = id;
            data['column'] = column;
            if ($(e).is(":checked")) {
                data[column] = 1;
            } else {
                data[column] = 0;
            }
            var baseUrl = "<?= base_url();?>";
            var submissionURL = baseUrl + 'Users/updateStatus';
            $.ajax({
                type: "POST",
                url: submissionURL,
                method: 'POST',
                dataType: 'json',
                data: {
                    data
                },
                success: function(data) {
                    console.log(data);
                },
            });
        }

        $(document).on('click', '.edit_data', function() {
            var id = $(this).attr("id");
            $('input[name="username"]').val(id);
            $('#reset_pass').modal('show');
        });

        $('#form_resetpass').on("submit", function(event) {
            event.preventDefault();
            let where = "username=" + $('input[name=username]').val();
            let table = 'user';
            let data = {};
            data['username'] = $('input[name=username]').val();
            data['password'] = $('input[name=password]').val();
            var baseUrl = "<?= base_url();?>";
            var submissionURL = baseUrl + 'Users/updatePassword';
            $.ajax({
                type: "POST",
                url: submissionURL,
                method: 'POST',
                dataType: 'json',
                data: {
                    data
                },
                success: function(data) {
                    console.log(data);
                },
            });
            location.reload();

        });
        deleteUser = (username) => {
            let data = {};
            alertify.confirm("Are you sure for delete account '" + username + "' ?",
                function() {
                    data['username'] = username;
                    var baseUrl = "<?= base_url();?>";
                    var submissionURL = baseUrl + 'Users/deleteUser';
                    $.ajax({
                        type: "POST",
                        url: submissionURL,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            data
                        },
                        success: function(data) {
                            console.log(data);
                        },
                    });
                    location.reload();
                },
                function() {
                    alertify.error('Cancel');
                });
        }
    })
    </script>
</body>

</html>