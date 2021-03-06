<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();

    }

    public function count_all_reviews()
    {
        return $this->db->get('reviews')->num_rows();
    }

    public function get_all_reviews()
    {
        // $reviews = $this->db->query("
        //     SELECT r.*, p.name nm_prd, c.*
        //     FROM reviews r
        //     JOIN products p
        //         ON p.id = r.product_id
        //     JOIN customers c
        //         ON c.user_id = r.user_id
        // ");

        // return $reviews->result();
        $this->db->select('reviews.*, products.name nm_prd, customers.*');
        $this->db->from('reviews');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->join('customers', 'customers.user_id = reviews.user_id');
        return $this->db->get()->result();
    }

    public function is_review_exist($id)
    {
        return ($this->db->where('id', $id)->get('reviews')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function review_data($id)
    {
        $review = $this->db->query("
            SELECT r.*, o.order_number
            FROM reviews r
            JOIN orders o
                ON o.id = r.order_id
            WHERE r.id = '$id'
        ");

        return $review->row();
    }
}