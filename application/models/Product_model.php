<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_products()
    {
        return $this->db->get('products')->result();
    }

    public function min()
    {
        $min = $this->db->query("SELECT MIN(stock) FROM products")->result_array();
        return $min;
    }

    public function best_deal_product($min_stock)
    {
        $data = $this->db->where('is_available', 1)
            ->order_by('stock', $min_stock)
            ->limit(1)
            ->get('products')
            ->row();
        // $data = $this->db->query("SELECT * FROM products WHERE is_available = 1, stock = $min_stock")->result_array();
        return $data;
    }

    public function is_product_exist($id, $sku)
    {
        return ($this->db->where(array('id' => $id, 'sku' => $sku))->get('products')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function product_data($id)
    {
        $data = $this->db->query("
            SELECT p.*, pc.name as category_name
            FROM products p
            JOIN product_category pc
                ON pc.id = p.category_id
            WHERE p.id = '$id'
        ")->row();

        return $data;
    }
    public function stock($id)
    {
        return $this->db->query("SELECT stock FROM products WHERE id = $id")->result_array();
    }
    public function related_products($current, $category)
    {
        return $this->db->where(array('id !=' => $current, 'category_id' => $category))->limit(4)->get('products')->result();
    }

    public function terlaris($id_product)
    {
        return $this->db->query("SELECT * FROM order_items WHERE product_id = $id_product")->num_rows();
    }

    public function create_order(array $data)
    {
        $this->db->insert('orders', $data);

        return $this->db->insert_id();
    }

    public function delete_stock($id_product, $order_qty)
    {
        return $this->db->query("UPDATE products SET stock = $order_qty WHERE id = $id_product");
    }

    public function create_order_items($items)
    {
        return $this->db->insert_batch('order_items', $items);
    }

    function getLastId()
    {
        $sql = $this->db->select('id');
        $sql = $this->db->from('orders');
        $sql = $this->db->order_by('id', 'desc');
        $sql = $this->db->limit(1);
        $sql = $this->db->get();

        return $sql->result();
    }
}
