<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
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
                                <li class="breadcrumb-item active">Add User</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Add User</h3>
                                </div>
                                <div class="card-body">
                                    <form id="formRegisUser" action="<?= site_url('users/create');?>" method="post">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control form-control-sm" id="username"
                                                    name="username" placeholder="Ex. ASU1111 or 651111111" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control form-control-sm"
                                                    id="password" name="password" placeholder="Your Citizen ID"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row mt-2">
                                            <div class="col-md-6">
                                                <label for="fname">First Name</label>
                                                <input type="text" class="form-control form-control-sm" id="fname"
                                                    name="fname" placeholder="Enter your first name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lname">Last Name</label>
                                                <input type="text" class="form-control form-control-sm" id="lname"
                                                    name="lname" placeholder="Enter your last name" required>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="auth_status"
                                            name="auth_status" value="<?= '1'?>" hidden>
                                        <div class="form-row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button type="submit"
                                                    class="btn btn-sm btn-success float-right">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
</body>

</html>