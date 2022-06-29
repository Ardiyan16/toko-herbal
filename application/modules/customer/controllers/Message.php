<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('customer');

        $this->load->model(array(
            // 'payment_model' => 'payment',
            // 'order_model' => 'order',
            'message_model' => 'message'
        ));
    }

    public function index()
    {
        $param['title'] = 'Balasan Pesan';
        $var['balasan'] = $this->message->get_balasan();
        $var['jumlah'] = $this->message->count_balasan();
        // var_dump($var['jumlah']);
        $this->load->view('header', $param);
        $this->load->view('message/message', $var);
        $this->load->view('footer');
    }
}