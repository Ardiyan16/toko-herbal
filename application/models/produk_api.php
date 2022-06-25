<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class produk_api extends CI_Model
{
    public function dapat_data_all()
    {
        return $this->db->query("SELECT * FROM products")->result_array();
    }
    public function all_product()
    {
        return $this->db->query("SELECT * FROM products")->result_array();
    }
    public function dapat_data($product_category)
    {
        return $this->db->query("SELECT * FROM products WHERE category_id = '$product_category'")->result_array();
    }
    public function produk_detail($nama_produk)
    {
        return $this->db->query("SELECT * FROM products WHERE name = '$nama_produk'")->result_array();
    }
}
?>