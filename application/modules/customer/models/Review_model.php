<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {
    public $user_id;
    
    public function __construct()
    {
        parent::__construct();

        $this->user_id = get_current_user_id();
    }

    public function count_all_reviews()
    {
        return $this->db->where('user_id', $this->user_id)->get('reviews')->num_rows();
    }

    public function get_all_reviews($limit, $start)
    {
        $reviews = $this->db->query("
            SELECT r.*, p.name
            FROM reviews r
            JOIN products p
                ON p.id = r.product_id
            WHERE r.user_id = '$this->user_id'
            LIMIT $start, $limit
        ");

        return $reviews->result();

        // $this->db->select('reviews.*, products.name');
        // $this->db->from('reviews');
        // $this->db->join('products', 'reviews.product_id = products.id');
        // $this->db->where('reviews.id', $this->user_id);
        // $this->db->limit($start, $start);
        // return $this->db->get()->result();
    }

    public function write_review($data)
    {
        $this->db->insert('reviews', $data);

        return $this->db->insert_id();
    }

    public function is_review_exist($id)
    {
        return ($this->db->where(array('id' => $id, 'user_id' => $this->user_id))->get('reviews')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function review_data($id)
    {
        // $review = $this->db->query("
        //     SELECT r.*, o.order_number
        //     FROM reviews r
        //     JOIN orders o
        //         ON o.id = r.order_id
        //     WHERE r.id = '$id'

        // ");

        // return $review->row();
        $this->db->select('reviews.*, products.name');
        $this->db->from('reviews');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->where('reviews.id', $id);
        return $this->db->get()->row();
    }


    public function delete($id)
    {
        return $this->db->where(array('id' => $id, 'user_id' => $this->user_id))->delete('reviews');
    }
}