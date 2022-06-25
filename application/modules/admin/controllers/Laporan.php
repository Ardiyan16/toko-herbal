<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model(array(
            'laporan_model' => 'laporan'
        ));
    }

    public function index()
    {
        $params['title'] = "Laporan Penjualan";

        $result['data_orders'] = $this->laporan->orders()->result_array();
        $result['orders'] = $this->laporan->orders_total()->result_array();

        $this->load->view('header', $params);
        $this->load->view('laporan/laporan', $result);
        $this->load->view('footer');
    }
}