<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" onclick="confirm_logout()" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<script>
$(document).ready(() => {
    confirm_logout = () => {
        alertify.confirm("You want to logout ?",
            function() {
                window.location.href = "<?= site_url('member/logout');?>";
            },
            function() {
                alertify.error('Cancel');
            }).set({
            title: '!! Are you sure ?'
        });
    }
})
</script>