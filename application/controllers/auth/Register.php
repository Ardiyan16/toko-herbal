<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['form_validation', 'encryption']);
        $this->load->model('auth/Register_model', 'register');
    }

    public function index()
    {
        $this->load->view('auth/register');
    }

    public function verify()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger font-weight-bold"><small>', '</small></div>');

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[16]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('name', 'Nama lengkap', 'required');
        $this->form_validation->set_rules('phone_number', 'No. HP', 'required|min_length[9]|max_length[16]|is_unique[customers.phone_number]');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[10]');
        $this->form_validation->set_rules('address', 'Alamat', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $name = $this->input->post('name');
            $phone_number = $this->input->post('phone_number');
            $email = $this->input->post('email');
            $address = $this->input->post('address');

            $user_data = array(
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'role' => 'customer',
                'register_date' => date('Y-m-d H:i:s')
            );

            $user = $this->register->register_user($user_data);

            $customer_data = array(
                'user_id' => $user,
                'name' => $name,
                'phone_number' => $phone_number,
                'address' => $address
            );

            $this->register->register_customer($customer_data);

            $login_data = [
                'is_login' => TRUE,
                'user_id' => $user,
                'login_at' => time(),
                'remember_me' => FALSE
            ];

            $login_data = json_encode($login_data);
            $login_session = $this->encryption->encrypt($login_data);
            $this->session->set_userdata('__ACTIVE_SESSION_DATA', $login_session);

            $this->session->set_flashdata('store_flash', 'Pendaftaran akun berhasil!');

            redirect('customer');
        }
    }


    public function registration()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger font-weight-bold"><small>', '</small></div>');

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[16]', ['min_length' => 'username minmal 4 karakter']);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]', ['min_length' => 'password minimal 4 karakter']);
        $this->form_validation->set_rules('name', 'Nama lengkap', 'required', ['required' => 'nama lengkap tidak boleh kosong']);
        $this->form_validation->set_rules('phone_number', 'No. HP', 'required|min_length[9]|max_length[16]|is_unique[customers.phone_number]', ['max_length' => 'no telepon maksimal 16 karakter']);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', ['is_unique' => 'email anda telah terdaftar']);
        $this->form_validation->set_rules('address', 'Alamat', 'required', ['required' => 'alamat tidak boleh kosong']);

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $this->action_registration();
        }
    }

    private function action_registration()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
        $phone_number = $this->input->post('phone_number');
        $email = $this->input->post('email');
        $address = $this->input->post('address');

        $user_data = array(
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'customer',
            'register_date' => date('Y-m-d H:i:s'),
            'is_active' => 0
        );

        $user = $this->register->register_user($user_data);
        $customer_data = array(
            'user_id' => $user,
            'name' => $name,
            'phone_number' => $phone_number,
            'address' => $address
        );

        $token = base64_encode(random_bytes(30));
        $user_token = [
            'email' => $email,
            'token' => $token,
            'date_created' => time()
        ];
        $this->register->register_customer($customer_data);
        $this->db->insert('token', $user_token);
        $this->_sendEmail($token, 'verify');
        $this->session->set_flashdata('simpan_akun', true);
        redirect('auth/Login');
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'dtemansejati@gmail.com',
            'smtp_pass' => 'baoskjlyhktctwxb',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->load->library('email', $config);
        $this->email->from('dtemansejati@gmail.com', 'Toko Herbal');

        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Verifikasi Akun Anda');
            $this->email->message('Silahkan klik link untuk verifikasi akun anda : <a href="' . base_url() . 'auth/Register/verification?email=' . $this->input->post('email') .
                '&token=' . urlencode($token) . '">verifikasi akun anda</a>');
        }
        else if ($type == 'forgot') {
            $this->email->subject('Ganti Password Anda');
            $this->email->message('Silahkan klik link untuk mengubah password anda : <a href="' . base_url() . 'auth/Register/ganti_pass?email=' . $this->input->post('email') .
                '&token=' . urlencode($token) . '">ubah password anda</a>');
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verification()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {

            $usertoken = $this->db->get_where('token', ['token' => $token])->row_array();

            if ($usertoken) {

                if (time() - $usertoken['date_created'] < (60 * 60 * 24)) {

                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('users');

                    $this->db->delete('token', ['email' => $email]);

                    $this->session->set_flashdata('terverifikasi', true);
                    redirect('auth/Login');
                } else {

                    $this->db->delete('users', ['email' => $email]);
                    $this->db->delete('token', ['token' => $token]);

                    $this->session->set_flashdata('token_kadaluarsa', true);
                    redirect('auth/Login');
                }
            } else {
                $this->session->set_flashdata('token_salah', true);
                redirect('auth/Login');
            }
        } else {
            $this->session->set_flashdata('email_salah', true);
            redirect('auth/Login');
        }
    }


    public function forgot()
    {
        $this->load->view('auth/forgot');
    }

    public function forgot2()
    {
        $this->load->view('auth/forgot2');
    }

    public function forgot_pass()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', ['valid_email' => 'email harus valid']);
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/forgot');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {

                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('forgot_success', true);
                redirect('auth/Login');
            } else {
                $this->session->set_flashdata('message', true);
                redirect('auth/Register/forgot');
            }
        }
    }

    public function ubah_pass()
    {
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]', ['required' => 'password tidak boleh kosong']);
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password1]', ['matches' => 'konfirmasi password salah']);

        if ($this->form_validation->run() == false) {

            $this->load->view('auth/forgot2');
        } else {

            $password = $this->input->post('password1');
            $email = $this->session->userdata('ganti_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('users');

            $this->session->unset_userdata('ganti_email');

            $this->db->delete('token', ['email' => $email]);

            $this->session->set_flashdata('success_update_pass', true);
            redirect('auth/Login');
        }
    }

    public function ganti_pass()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');


        $pengguna = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($pengguna) {

            $user_token = $this->db->get_where('token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('ganti_email', $email);
                $this->ubah_pass();
            } else {
                $this->session->set_flashdata('token_salah', true);
                redirect('auth/Login');
            }
        } else {
            $this->session->set_flashdata('email_salah', true);
            redirect('auth/Login');
        }
    }
}
