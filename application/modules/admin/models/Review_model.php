<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_model extends CI_Model
{
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
        //     SELECT r.*, p.id, c.*, r.id as id
        //     FROM reviews r
        //     JOIN orders o
        //         ON o.id = r.order_id
        //     JOIN customers c
        //         ON c.user_id = r.user_id
        // ");

        // return $reviews->result();
        $this->db->select('reviews.*, products.name nm_prd, customers.name');
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
            SELECT r.*, p.name
            FROM reviews r
            JOIN products p
                ON p.id = r.product_id
            WHERE r.id = '$id'
        ");

        return $review->row();
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('reviews');
    }
}
