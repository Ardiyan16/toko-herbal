<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_api extends CI_Model
{
    //Login
    public function proses_login($username, $password, $role)
    {
        return $this->db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role='$role'")->result_array();
    }

    public function costumer_data($id_user)
    {
        return $this->db->query("SELECT * FROM customers WHERE user_id = '$id_user'")->result_array();
    }

    public function proses_regristrasi_user($email,$username,$password,$role, $date)
    {
        $data = array(
            'email' => $email,
            'username' => $username ,
            'password' => $password,
            'role' => $role,
            'register_date' => $date
        );
        return $this->db->insert('users', $data);
    }    

    public function proses_regristrasi_customer($id_user,$nama_lengkap,$no_hp,$alamat)
    {
        $data = array(
            'user_id' => $id_user,
            'name' => $nama_lengkap,
            'phone_number' => $no_hp,
            'address' => $alamat
        );
        return $this->db->insert('customers', $data);
    }

    public function cek($username, $email)
    {
        return $this->db->query("SELECT username AND email FROM users WHERE username = '$username' AND email = '$email'");
    }
}
?>