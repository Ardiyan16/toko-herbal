<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function orders()
    {
        return $this->db->query("SELECT * FROM orders");
    }

    public function customer($user_id)
    {
        return $this->db->query("SELECT * FROM customers WHERE user_id = $user_id");
    }

    public function orders_total()
    {
        return $this->db->query("SELECT SUM(total_price) AS total_price FROM orders WHERE order_status = '4' ");
    }

    public function order_item($id)
    {
        return $this->db->query("SELECT * FROM order_items WHERE order_id = $id");
    }

    public function item($product_id)
    {
        return $this->db->query("SELECT * FROM products WHERE id = $product_id");
    }
}
?>