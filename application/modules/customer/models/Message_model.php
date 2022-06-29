<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_model extends CI_Model
{
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->user_id = get_current_user_id();
    }

    public function get_balasan()
    {
        $id = get_current_user_id();
        $this->db->select('*');
        $this->db->from('balasan');
        $this->db->where('id_users', $id);
        return $this->db->get()->result();
    }

    public function count_balasan()
    {
        $this->db->select('COUNT(id) as jml');
        $this->db->from('balasan');
        return $this->db->get()->row()->jml;
    }
}
