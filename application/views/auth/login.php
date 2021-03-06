<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo get_store_name(); ?></title>

    <link href="<?php echo get_theme_uri('custom/auth/login/css/style.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_theme_uri('custom/auth/login/css/fontawesome-all.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url() ?>assets/js/sweetalert2-all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>

<body>
    <h1>Login ke <?php echo get_store_name(); ?></h1>
    <div class=" w3l-login-form">
        <h2>Login Akun</h2>
        <?php if ($flash_message) : ?>
            <div class="flash-message">
                <?php echo $flash_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($redirection) : ?>
            <div class="flash-message">
                Silahkan login untuk melanjutkan...
            </div>
        <?php endif; ?>

        <?php echo form_open('auth/login/do_login'); ?>

        <div class=" w3l-form-group">
            <label>Username:</label>
            <div class="group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" value="<?php echo set_value('username', $old_username); ?>" class="form-control" placeholder="Username" minlength="4" maxlength="16" required>
            </div>
            <?php echo form_error('username'); ?>
        </div>
        <div class=" w3l-form-group">
            <label>Password:</label>
            <div class="group">
                <i class="fas fa-unlock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <?php echo form_error('password'); ?>
        </div>
        <div class="forgot">
            <p><input type="checkbox" name="remember_me" value="1">Ingat saya</p>
            <a href="<?= site_url('auth/register/forgot') ?>" style="color: white;">Lupa Password</a>
        </div>
        <button type="submit">Login</button>
        <?php echo form_close(); ?>
    </div>

    <footer>
        <p class="copyright-agileinfo"><?php echo anchor(base_url(), get_store_name()); ?></p>
    </footer>

</body>
<script>
    <?php if ($this->session->flashdata('simpan_akun')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil mendaftarkan akun!',
            text: 'silahkan cek pesan di kotak masuk atau spam pada email anda!',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('terverifikasi')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Selamat akun anda telah terverifikasi!',
            text: 'akun anda telah terverifikasi silahkan login!',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('token_kadaluarsa')) : ?>
        Swal.fire({
            icon: 'warning',
            title: 'verifikasi anda telah lewat dari 24 jam!',
            text: 'silahkan mendaftar lagi',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('token_salah')) : ?>
        Swal.fire({
            icon: 'warning',
            title: 'token anda salah!',
            text: 'silahkan daftar lagi',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('email_salah')) : ?>
        Swal.fire({
            icon: 'warning',
            title: 'email anda salah',
            text: 'silahkan daftar lagi',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('forgot_success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Kami telah mengirimkan konfirmasi ganti password ke email anda!',
            text: 'silahkan cek email anda pada kotak masuk atau spam untuk mengubah password!',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php elseif ($this->session->flashdata('success_update_pass')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Password anda telah diubah!',
            text: 'silahkan login untuk mendapatkan akses!',
            showConfirmButton: true,
            // timer: 1500
        })
    <?php endif ?>
</script>

</html>