<?php
defined('BASEPATH') or exit('No direct script access allowed');
// print_r($data_orders);
?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <!-- <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Laporan Penjualan</h6>
        </div> -->
        <!-- <div class="col-lg-6 col-5 text-right">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
            </ol>
          </nav>
        </div> -->
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
          <h3 class="mb-0">Laporan Penjualan</h3>
          <button style="float: right" type="button" onclick="window.print()"
							class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button>
        </div>

        <?php 
        if (count($data_orders) > 0) : ?>
          <div class="card-body p-0">
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">No Invoice</th>
                    <th scope="col">Nama Customer</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah Item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Jumlah Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   foreach ($data_orders as $order) : 
                   if ($order['order_status'] == "4") :
                   ?>
                    <tr>
                      <th scope="col">
                        <?php 
                        echo '#' . $order['order_number']; ?>
                      </th>
                      <td><?php
                      $data_customer = $this->laporan->customer($order['user_id'])->result_array();
                      foreach ($data_customer as $row) {
                        echo $row['name']; 
                      } 
                      ?></td>
                      <td>
                        <?php 
                        echo get_formatted_date($order['order_date']); ?>
                      </td>
                      <td>
                        <?php
                        $data_order_item = $this->laporan->order_item($order['id'])->result_array();
                        foreach ($data_order_item as $raw) {
                          $data_item = $this->laporan->item($raw['product_id'])->result_array();
                          foreach ($data_item as $rew) {
                            echo $rew['name'];
                          }
                        } ?>
                      </td>
                      <td>
                        <?php 
                        echo $order['total_items']; ?>
                      </td>
                      <td><?php 
                      echo get_order_status($order['order_status'], $order['payment_method']); ?></td>
                      <td>
                        Rp <?php 
                        echo format_rupiah($order['total_price']); ?>
                      </td>
                    </tr>
                  <?php 
                endif;
                endforeach; ?>
                <td colspan="6">Total</td>
                <?php foreach ($orders as $row) :?>
                <td>Rp <?= format_rupiah($row['total_price']) ?></td>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php else : ?>
          <div class="card-body">
            <div class="alert alert-primary">
              Belum ada order
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>