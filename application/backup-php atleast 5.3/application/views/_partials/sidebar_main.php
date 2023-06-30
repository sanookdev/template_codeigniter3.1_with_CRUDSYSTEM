<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('./');?>" class="brand-link">
        <img src="<?= site_url('img/logo/medlogopng.png') ?>" alt="<?= $this->config->item('site_name') ?>"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $this->config->item('site_name') ?>
        </span>
        <p class="text-center font-weight-light"><?= "Welcome : ". $this->session->userdata['userName'];?></p>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            จัดการ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('./')?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายชื่อผู้ใช้งาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/add')?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มผู้ใช้งาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/upload')?>" class="nav-link">
                                <i class="fas fa-upload nav-icon"></i>
                                <p>Upload File</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
$(document).ready(function() {
    $('.nav .nav-treeview li a').click(function() {
        $('li a').removeClass("active");
        $(this).addClass("active");
    });
});
</script>