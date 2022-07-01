<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Review Saya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?php echo anchor(base_url(), 'Home'); ?></li>
                        <li class="breadcrumb-item active">Review</li>
                    </ol>
                </div>
                <br>
                <br>
                <div class="col-sm-12">
                    <!-- <?php echo anchor('customer/reviews/write', 'Tulis Review Baru'); ?> -->
                    <a href="#pilihorder" data-toggle="modal" class="btn-sm btn btn-primary"><i class="fa fa-plus"></i> Tulis Review Baru</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-body<?php echo (count($reviews) > 0) ? ' p-0' : ''; ?>">
                <?php if (count($reviews) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <tr class="bg-primary">
                                <th scope="col">No.</th>
                                <th scope="col">Name Product</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Review</th>
                            </tr>
                            <?php foreach ($reviews as $review) : ?>
                                <tr>
                                    <td><?php echo $review->id; ?></td>
                                    <td><?php echo anchor('customer/reviews/view/' . $review->id, '' . $review->name); ?></td>
                                    <td><?php echo get_formatted_date($review->review_date); ?></td>
                                    <td><?php echo $review->review_text; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                Belum ada review yang ditulis. Silahkan tulis baru.
                            </div>

                            <?php echo anchor('customer/reviews/write', 'Tulisan review baru'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($pagination) : ?>
                <div class="card-footer">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

</div>
<div class="modal fade" id="pilihorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Orderan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Customer/Reviews/write') ?>" method="post">
                    <div class="form-group">
                        <label>Pilih Orderan</label>
                        <br>
                        <select name="id" class="form-control">
                            <?php foreach ($order_number as $no) { ?>
                                <option value="<?= $no->id ?>"><?= $no->order_number ?> (<?= date('d-m-Y', strtotime($no->order_date)) ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                    <button href="" class="btn btn-primary"><i class="fa fa-check"></i> Pilih</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>