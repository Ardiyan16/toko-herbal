<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class user extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'mapi');
    }
    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $role = 'customer';

        if ($username === null && $password === null && $role === null) {
            $this->response([
                'status' => false,
                'message' => 'login gagal'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->mapi->proses_login($username,$password,$role);
            foreach ($data as $id_users) {
                $data_costumer = $this->mapi->costumer_data($id_users['id']);
            }
        }

        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Login Berhasil',
                'data_user' => $data,
                'data_costumer' => $data_costumer
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'username atau password salah'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function registrasi_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $nama_lengkap = $this->post('nama_lengkap');
        $no_hp = $this->post('no_hp');
        $email = $this->post('email');
        $alamat = $this->post('alamat');
        $role = 'customer';
        $date = date('Y-m-d H:i:s');
        
        if ($username === null && $password === null && $nama_lengkap === null && $no_hp === null && $email === null && $alamat === null && $role === null && $date === null) {
            $this->response([
                'status' => false,
                'message' => 'input data yang diperlukan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $cek = $this->mapi->cek($username,$email);
        }
        if ($cek->num_rows() == 1) {
            $this->response([
            'status' => false,
            'message' => 'username dan email sudah terdaftar'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $users = $this->mapi->proses_regristrasi_user($email,$username,$password,$role,$date);
            $data_user = $this->mapi->proses_login($username,$password,$role);
            foreach ($data_user as $id_user) {
                $costumer = $this->mapi->proses_regristrasi_customer($id_user['id'],$nama_lengkap,$no_hp,$alamat);
                $data_costumer = $this->mapi->costumer_data($id_user['id']);
            }
            if ($users) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil Registrasi',
                    'data_user' => $data_user,
                    'data_costumer' => $data_costumer
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'registrasi gagal'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}


?>