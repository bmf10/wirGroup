<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[6]|is_unique[user.username]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            response('error', $this->form_validation->error_array(), 200);
        } else {
            if ($this->input->post('role') != 1 && $this->input->post('role') != 2) {
                response('error', 'Role only 1 and 2', 200);
            } else {
                $password = $this->input->post('password', true);
                $data = [
                    'name' => $this->input->post('name', true),
                    'username' => $this->input->post('username', true),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $this->input->post('role', true)
                ];

                $this->db->insert('user', $data);

                response('success', ['affected_rows' => $this->db->affected_rows()], 200);
            }
        }
    }


    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->db->get_where('user', ['username' => $username]);

        if ($result->num_rows() > 0) {
            if (password_verify($password, $result->row()->password) == true) {
                $key = "ynxxmglqb8r7MyMmqfpnIQZLtUljLhHcSnT4WbJKHgSpPphqtBqgq9IZFjybb34H5Nh6NnunScwbpK1mTG6uckN6wdE7fHrykMHb";
                $payload = [
                    "id" => $result->row()->id,
                    "name" => $result->row()->name,
                    "username" => $result->row()->username,
                    "role" => $result->row()->role,
                    "iat" => time(),
                    "exp" => time() + 60 * 60 * 12 //12 hours active jwt
                ];
                $data['token'] = JWT::encode($payload, $key);
                response('success', $data, 200);
            } else {
                response('error', 'Wrong password', 200);
            }
        } else {
            response('error', 'Username not found', 200);
        }
    }
}
