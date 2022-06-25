<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class order_api extends CI_Model
{
    public function input_order($user_id,$coupon_id,$order_number,$order_date,$total_price,$total_item,$payment,$delivery_data)
    {
        $data = array(
            'user_id' => $user_id,
                    'coupon_id' => $coupon_id,
                    'order_number' => $order_number,
                    'order_status' => 1,
                    'order_date' => $order_date,
                    'total_price' => $total_price,
                    'total_items' => $total_item,
                    'payment_method' => $payment,
                    'delivery_data' => $delivery_data
        );
        return $this->db->insert('orders', $data);
    }    

    public function get_data($order_number)
    {
        return $this->db->query("SELECT * FROM orders WHERE 'order_number' = '$order_number'")->result_array();
    }

    public function input_item($id,$order_qty,$product_id,$order_price)
    {
        $data = array(
                    'order_id' => $id,
                    'product_id' => $product_id,
                    'order_qty' => $order_qty,
                    'order_price' => $order_price
        );
        return $this->db->insert('order_items', $data);
    }

    public function order()
    {
        return $this->db->query("SELECT * FROM orders")->result_array();
    }
}
?>