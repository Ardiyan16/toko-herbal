<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pesan Balasan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?php echo anchor(base_url(), 'Home'); ?></li>
                        <li class="breadcrumb-item active">Balasan Pesan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Balasan Pesan</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($jumlah == 0) { ?>
                                <div class="alert alert-primary" role="alert">
                                    Belum ada pesan balasan
                                </div>
                            <?php } ?>
                            <?php if ($jumlah > 0) { ?>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pesan</th>
                                            <th>Waktu</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($balasan as $bls) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $bls->pesan ?></td>
                                                <td><?= $bls->waktu ?></td>
                                                <td>
                                                    <a href="<?= base_url('Pages/contact') ?>" class="badge badge-primary" title="Balas"><i class="fa fa-paper-plane"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>