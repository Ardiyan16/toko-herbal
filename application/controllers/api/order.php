<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class order extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_api', 'rapi');
    }
    
    public function order_input_post()
    {
        $user_id = $this->post('user_id');
        $coupon_id = $this->post('coupon_id');
        $order_number = $this->_create_order_number();
        $order_date = date('Y-m-d H:i:s');
        $total_price = $this->post('total_price');
        $total_item = $this->post('total_item');
        $payment = $this->post('payment');
        $name = $this->post('name');
        $phone = $this->post('phone');
        $address = $this->post('address');
        $note = $this->post('note');
        if ($user_id === null && $order_number === null) {
            $this->response([
                'status' => false,
                'message' => 'error'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $delivery_data = array(
                'costumer' => array(
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'note' => $note
                )
            );
            $delivery_data = json_encode($delivery_data);
            $input = $this->rapi->input_order($user_id,$coupon_id,$order_number,$order_date,$total_price,$total_item,$payment,$delivery_data);
        }

        if ($input) {
            $this->response([
                'status' => true,
                'message' => 'berhasil input'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function order_get()
    {
        $order = $this->rapi->order();
        if ($order) {
            $this->response([
                'status' => true,
                'message' => 'makanan ketemu',
                'kategori' => $order
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function _create_order_number()
    {
        $this->load->helper('string');
        $alpha = strtoupper(random_string('alpha', 3));
        $num = random_string('numeric', 5);
        
        $number = $alpha . date('j') . date('n') . date('y') . $num;
        return $number;
    }
}
?>